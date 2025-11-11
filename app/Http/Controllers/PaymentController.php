<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Room;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentController extends Controller
{
    protected $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    /**
     * Create payment order (AJAX endpoint for checkout page)
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'amount' => 'required|numeric|min:1',
            'booking_id' => 'nullable|exists:bookings,booking_id',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            
            // Check if user is authenticated
            if (!$user) {
                throw new Exception('User not authenticated');
            }
            
            $room = Room::findOrFail($request->room_id);
            $receiptNumber = Payment::generateReceiptNumber();

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $request->booking_id,
                'user_id' => $user->user_id, // Use user_id instead of id
                'room_id' => $request->room_id,
                'amount' => $request->amount,
                'currency' => 'INR',
                'status' => 'created',
                'transaction_id' => 'SPTXN-' . strtoupper(uniqid()) . '-' . time(), // Generate unique transaction ID
                'receipt_number' => $receiptNumber,
                'description' => 'Payment for ' . $room->room_title,
                'customer_name' => $user->full_name ?? $user->name ?? 'Guest',
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? $user->mobile ?? '',
                'notes' => [
                    'room_id' => $room->room_id,
                    'room_title' => $room->room_title,
                ],
                'razorpay_order_id' => 'pending', // Temporary
            ]);

            // Create Razorpay order
            $orderData = [
                'amount' => $request->amount,
                'currency' => 'INR',
                'receipt_number' => $receiptNumber,
                'notes' => [
                    'payment_id' => $payment->id,
                    'room_title' => $room->room_title,
                ],
            ];

            $razorpayOrder = $this->razorpayService->createOrder($orderData);

            if (!$razorpayOrder['success']) {
                throw new Exception($razorpayOrder['error']);
            }

            // Update payment with Razorpay order ID
            $payment->update([
                'razorpay_order_id' => $razorpayOrder['order_id'],
            ]);

            DB::commit();

            // Get checkout data
            $checkoutData = $this->razorpayService->getCheckoutData($payment);

            return response()->json([
                'success' => true,
                'payment_id' => $payment->id,
                'checkout_data' => $checkoutData,
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment Order Creation Failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::user() ? Auth::user()->user_id : null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment order. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify payment after successful payment
     */
    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        try {
            // Find payment by order ID
            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)
                ->firstOrFail();

            // Verify signature
            $attributes = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $isValid = $this->razorpayService->verifySignature($attributes);

            if (!$isValid) {
                $payment->markAsFailed('Invalid signature');
                
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed',
                ], 400);
            }

            // Fetch payment details from Razorpay
            $paymentDetails = $this->razorpayService->fetchPayment($request->razorpay_payment_id);

            // Update payment status
            $payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'success',
                'payment_method' => $paymentDetails['method'] ?? null,
                'razorpay_response' => json_encode($paymentDetails),
                'paid_at' => now(),
            ]);

            // Update booking status if exists
            if ($payment->booking_id) {
                $payment->booking->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'payment_id' => $payment->id,
                'redirect_url' => route('payment.success', $payment->id),
            ]);

        } catch (Exception $e) {
            Log::error('Payment Verification Failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.',
            ], 500);
        }
    }

    /**
     * Payment success page
     */
    public function success($paymentId)
    {
        $payment = Payment::with(['room', 'user', 'booking'])
            ->where('id', $paymentId)
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        return view('payments.success', compact('payment'));
    }

    /**
     * Payment failed page
     */
    public function failed(Request $request)
    {
        $orderId = $request->query('order_id');
        
        $payment = null;
        if ($orderId) {
            $payment = Payment::where('razorpay_order_id', $orderId)
                ->where('user_id', Auth::user()->user_id)
                ->first();
                
            if ($payment) {
                $payment->markAsFailed('User cancelled or payment failed');
            }
        }

        return view('payments.failed', compact('payment'));
    }

    /**
     * Show payment history
     */
    public function history()
    {
        $payments = Payment::with(['room', 'booking'])
            ->where('user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('payments.history', compact('payments'));
    }

    /**
     * Webhook handler for Razorpay
     */
    public function webhook(Request $request)
    {
        try {
            $webhookSignature = $request->header('X-Razorpay-Signature');
            $webhookBody = $request->getContent();

            // Verify webhook signature
            $isValid = $this->razorpayService->verifyWebhookSignature($webhookBody, $webhookSignature);

            if (!$isValid) {
                Log::warning('Invalid Webhook Signature', ['body' => $webhookBody]);
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $payload = json_decode($webhookBody, true);
            $event = $payload['event'];

            // Handle different webhook events
            switch ($event) {
                case 'payment.captured':
                    $this->handlePaymentCaptured($payload['payload']['payment']['entity']);
                    break;

                case 'payment.failed':
                    $this->handlePaymentFailed($payload['payload']['payment']['entity']);
                    break;

                case 'refund.created':
                    $this->handleRefundCreated($payload['payload']['refund']['entity']);
                    break;
            }

            return response()->json(['status' => 'success']);

        } catch (Exception $e) {
            Log::error('Webhook Processing Failed', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle payment captured webhook
     */
    protected function handlePaymentCaptured(array $paymentData)
    {
        $payment = Payment::where('razorpay_order_id', $paymentData['order_id'])->first();

        if ($payment && !$payment->isSuccessful()) {
            $payment->markAsSuccess($paymentData['id']);
            
            if ($payment->booking_id) {
                $payment->booking->update(['payment_status' => 'paid', 'status' => 'confirmed']);
            }

            Log::info('Payment Captured via Webhook', ['payment_id' => $payment->id]);
        }
    }

    /**
     * Handle payment failed webhook
     */
    protected function handlePaymentFailed(array $paymentData)
    {
        $payment = Payment::where('razorpay_order_id', $paymentData['order_id'])->first();

        if ($payment && !$payment->isFailed()) {
            $payment->markAsFailed($paymentData['error_description'] ?? 'Payment failed');
            
            Log::info('Payment Failed via Webhook', ['payment_id' => $payment->id]);
        }
    }

    /**
     * Handle refund created webhook
     */
    protected function handleRefundCreated(array $refundData)
    {
        $payment = Payment::where('razorpay_payment_id', $refundData['payment_id'])->first();

        if ($payment && !$payment->isRefunded()) {
            $payment->markAsRefunded();
            
            if ($payment->booking_id) {
                $payment->booking->update(['payment_status' => 'refunded']);
            }

            Log::info('Refund Created via Webhook', ['payment_id' => $payment->id]);
        }
    }
}
