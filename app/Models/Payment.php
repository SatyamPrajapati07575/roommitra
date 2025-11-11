<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'booking_id',
        'user_id',
        'room_id',
        'transaction_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount',
        'currency',
        'status',
        'payment_method',
        'payment_method_details',
        'description',
        'notes',
        'receipt_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'razorpay_response',
        'error_description',
        'paid_at',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'notes' => 'array',
        'payment_method_details' => 'array',
    ];

    /**
     * Relationships
     */
    
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    /**
     * Scopes
     */
    
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['created', 'pending']);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Accessors & Mutators
     */
    
    protected function amountInPaisa(): Attribute
    {
        return Attribute::make(
            get: fn () => (int) ($this->amount * 100),
        );
    }

    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => '₹' . number_format($this->amount, 2),
        );
    }

    /**
     * Helper Methods
     */
    
    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['created', 'pending']);
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    public function markAsSuccess($razorpayPaymentId = null, $razorpaySignature = null): void
    {
        $this->update([
            'status' => 'success',
            'razorpay_payment_id' => $razorpayPaymentId ?? $this->razorpay_payment_id,
            'razorpay_signature' => $razorpaySignature ?? $this->razorpay_signature,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed($errorDescription = null): void
    {
        $this->update([
            'status' => 'failed',
            'error_description' => $errorDescription,
        ]);
    }

    public function markAsRefunded(): void
    {
        $this->update([
            'status' => 'refunded',
            'refunded_at' => now(),
        ]);
    }

    /**
     * Generate unique receipt number
     */
    public static function generateReceiptNumber(): string
    {
        return 'RCPT-' . strtoupper(uniqid()) . '-' . time();
    }
}
