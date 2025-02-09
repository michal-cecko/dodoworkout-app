<?php

namespace App\Models;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'email',

        'company_name',
        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_zip',
        'billing_country',
        'billing_phone',

        'is_company',
        'business_id',
        'tax_id',
        'vat_id',

        'status',
        'order_number',

        'subtotal',
        'discount_amount',
        'shipping_type_price',
        'payment_type_price',
        'total_no_vat',
        'vat_percentage',
        'vat_amount',
        'total_with_vat',

        'user_id',
        'shipping_type_id',

        'is_shipping_address',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_city',
        'shipping_zip',
        'shipping_country',
        'shipping_phone',

        'note',

        'payment_type_label',
        'payment_type_id',
        'shipping_type_label',
        'shipping_type_id',

        'canceled_at',
        'paid_at',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function shippingType(): BelongsTo
    {
        return $this->belongsTo(ShippingType::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function fullBillingName(): Attribute
    {
        return Attribute::make(
            get: fn(array $attributes) => $attributes['billing_first_name'] . ' ' . $attributes['billing_last_name'],
        );
    }

    protected function shouldPayVat(): Attribute
    {
        return Attribute::make(
            get: fn(array $attributes) => !empty($attributes['vat_id']) && strtolower(config("order.base_billing_country")) !== strtolower($attributes['billing_country']),
        );
    }

    protected function fullOrderNumber(): Attribute
    {
        return Attribute::make(
            get: function (array $attributes) {
                $year = $attributes['created_at']->format('Y');
                $paddedOrderNumber = str_pad($attributes['order_number'], 4, '0', STR_PAD_LEFT);
                return "{$year}{$paddedOrderNumber}";
            },
        );
    }
}
