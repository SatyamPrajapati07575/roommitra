<?php

namespace App\Services;

use App\Models\Payment;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    protected $api;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->key = config('razorpay.key');
        $this->secret = config('razorpay.secret');
        $this->api = new Api($this->key, $this->secret);
    }

    /**
     * Create a Razorpay order
     *
     * @param array $data
     * @return array
     */
    public function createOrder(array $data): array
    {
        try {
            $orderData = [
                'receipt' => $data['receipt_number'],
                'amount' => $data['amount'] * 100, // Convert to paise
                'currency' => $data['currency'] ?? 'INR',
                'notes' => $data['notes'] ?? [],
            ];

            $order = $this->api->order->create($orderData);

            return [
                'success' => true,
                'order_id' => $order->id,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'order' => $order,
            ];
        } catch (Exception $e) {
            Log::error('Razorpay Order Creation Failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify payment signature
     *
     * @param array $attributes
     * @return bool
     */
    public function verifySignature(array $attributes): bool
    {
        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (Exception $e) {
            Log::error('Razorpay Signature Verification Failed', [
                'error' => $e->getMessage(),
                'attributes' => $attributes,
            ]);
            return false;
        }
    }

    /**
     * Fetch payment details
     *
     * @param string $paymentId
     * @return array|null
     */
    public function fetchPayment(string $paymentId): ?array
    {
        try {
            $payment = $this->api->payment->fetch($paymentId);
            
            return [
                'id' => $payment->id,
                'amount' => $payment->amount / 100, // Convert from paise
                'currency' => $payment->currency,
                'status' => $payment->status,
                'method' => $payment->method,
                'email' => $payment->email,
                'contact' => $payment->contact,
                'created_at' => $payment->created_at,
            ];
        } catch (Exception $e) {
            Log::error('Razorpay Payment Fetch Failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Create refund
     *
     * @param string $paymentId
     * @param float|null $amount
     * @return array
     */
    public function createRefund(string $paymentId, ?float $amount = null): array
    {
        try {
            $refundData = [];
            
            if ($amount) {
                $refundData['amount'] = $amount * 100; // Convert to paise
            }

            $refund = $this->api->payment->fetch($paymentId)->refund($refundData);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'amount' => $refund->amount / 100,
                'status' => $refund->status,
            ];
        } catch (Exception $e) {
            Log::error('Razorpay Refund Failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify webhook signature
     *
     * @param string $webhookBody
     * @param string $webhookSignature
     * @return bool
     */
    public function verifyWebhookSignature(string $webhookBody, string $webhookSignature): bool
    {
        try {
            $secret = config('razorpay.webhook_secret');
            $expectedSignature = hash_hmac('sha256', $webhookBody, $secret);
            
            return hash_equals($expectedSignature, $webhookSignature);
        } catch (Exception $e) {
            Log::error('Webhook Signature Verification Failed', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Get checkout data for frontend
     *
     * @param Payment $payment
     * @param array $options
     * @return array
     */
    public function getCheckoutData(Payment $payment, array $options = []): array
    {
        return [
            'key' => $this->key,
            'amount' => $payment->amount_in_paisa,
            'currency' => $payment->currency,
            'name' => config('razorpay.company.name'),
            'description' => $payment->description,
            'image' => config('razorpay.company.logo'),
            'order_id' => $payment->razorpay_order_id,
            'prefill' => [
                'name' => $payment->customer_name,
                'email' => $payment->customer_email,
                'contact' => $payment->customer_phone,
            ],
            'notes' => $payment->notes ?? [],
            'theme' => config('razorpay.theme'),
            'modal' => [
                'ondismiss' => $options['ondismiss'] ?? null,
            ],
        ];
    }
}
