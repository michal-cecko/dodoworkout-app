{{-- @formatter:off --}}
@extends('email.layouts.default-markdown-email')

@section("body")
<!-- Thank You Message -->
<p style="margin: 0 0 16px">
    @if($formSubmission?->fields->isNotEmpty())
        {{ __('ord_email_thank_you_event') . " " . $event->order_item_name . '.' }}
    @else
        {{ __('ord_email_thank_you') . '.' }}
    @endif
</p>

<!-- Custom Confirmation Content -->
@if($content)
<p style="margin: 0 0 16px">
{!! $content !!}
</p>
@endif

<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #f9fafb; border-radius: 8px">
<!-- Order Header -->
<h2 style="font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 16px;">{{ __('ord_email_detail_heading') }}</h2>

<!-- Order Information -->
<div style="margin-bottom: 20px;">
<p style="margin: 0 0 8px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{ __('ord_email_order_number') }}:</span> {{ $order->fullOrderNumber }}
</p>
<p style="margin: 0 0 8px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{__("ord_email_date")}}</span> {{ $order->created_at->translatedFormat('F j, Y') }}
</p>
</div>

<!-- Billing Information -->
<div style="margin-bottom: 20px;">
<h3 style="font-size: 16px; font-weight: bold; color: #1f2937; margin-bottom: 12px;">{{ __('ord_email_billing_heading') }}</h3>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">
        @if($order->is_company)
            {{__("ord_fld_company_name")}}
        @else
            {{__("ord_fld_billing_full_name")}}
        @endif
    </span>{{ $order->fullBillingName }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_billing_address")}}</span> {{ $order->billing_address }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_billing_city")}}</span> {{ $order->billing_city }}, {{ $order->billing_zip }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_billing_country")}}</span> {{ $order->billing_country->translation() }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_billing_phone")}}</span> {{ $order->billing_phone }}
</p>
@if ($order->is_company)
@if ($order->business_id)
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{__("ord_fld_business_id")}}:</span> {{ $order->business_id }}
</p>
@endif
@if ($order->tax_id)
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{__("ord_fld_tax_id")}}:</span> {{ $order->tax_id }}
</p>
@endif
@if ($order->vat_id)
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{__("ord_fld_vat_id")}}:</span> {{ $order->vat_id }}
</p>
@endif
@endif
</div>

<!-- Shipping Information (if different) -->
@if ($order->is_shipping_address)
<div style="margin-bottom: 20px;">
<h3 style="font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 12px;">{{ __('ord_email_shipping_heading') }}</h3>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_shipping_full_name")}}</span> {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_shipping_address")}}</span> {{ $order->shipping_address }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_shipping_city")}}</span> {{ $order->shipping_city }}, {{ $order->shipping_zip }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_billing_country")}}</span> {{ $order->shipping_country->translation() }}
</p>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">
    <span style="font-weight: bold;">{{__("ord_fld_shipping_phone")}}</span> {{ $order->shipping_phone }}
</p>
</div>
@endif

<!-- Event-Specific Form Submission Fields -->
@if ($formSubmission?->fields->isNotEmpty())
<div style="margin-bottom: 20px;">
<h3 style="font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 12px;">{{ __('ord_email_event_heading') }}</h3>
@foreach ($formSubmission->fields as $field)
<p style="margin: 0 0 8px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{ $field->formField->label ?? "N/A" }}:</span>
@if (is_array($field->value))
{{ implode(', ', $field->value) }}
@else
{{ $field->value }}
@endif
</p>
@endforeach
</div>
@endif

<!-- Order Items Table -->
<div style="margin-bottom: 20px;">
<table style="width: 100%; border-collapse: collapse;">
<thead>
<tr style="background-color: #e5e7eb; color: #1f2937;">
<th style="padding: 10px; text-align: left; font-weight: bold;">{{ __('ord_email_item_tbl_item_h') }}</th>
<th style="padding: 10px; text-align: right; font-weight: bold;">{{ __('ord_email_item_tbl_quantity_h') }}</th>
<th style="padding: 10px; text-align: right; font-weight: bold;">{{ __('ord_email_item_tbl_price_h') }}</th>
<th style="padding: 10px; text-align: right; font-weight: bold;">{{ __('ord_email_item_tbl_total_h') }}</th>
</tr>
</thead>
<tbody>
@foreach ($order->orderItems as $item)
<tr style="border-bottom: 1px solid #e5e7eb;">
<td style="padding: 10px; color: #4b5563;">{{ $item->name }}</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">{{ $item->quantity }}</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
{{ number_format($item->price_per_unit, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
{{ number_format($item->total_no_vat, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
@endforeach
</tbody>
<tfoot>
<tr>
<td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; color: #1f2937;">{{ __('ord_email_subtotal') }}:</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
{{ number_format($order->subtotal, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
@if ($order->discount_amount > 0)
<tr>
<td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; color: #1f2937;">{{ __('ord_email_discount') }}:</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
-{{ number_format($order->discount_amount, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
@endif
@if ($order->shipping_type_price > 0)
<tr>
<td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; color: #1f2937;">{{ __('ord_email_shipping') }}:</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
{{ number_format($order->shipping_type_price, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
@endif
@if ($order->payment_type_price > 0)
<tr>
<td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; color: #1f2937;">{{ __('ord_email_payment') }}:</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
{{ number_format($order->payment_type_price, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
@endif
@if ($order->shouldPayVat)
<tr>
<td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; color: #1f2937;">
{{ __('vat') }} ({{ $order->vat_percentage }}%):
</td>
<td style="padding: 10px; text-align: right; color: #4b5563;">
{{ number_format($order->vat_amount, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
@endif
<tr>
<td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; color: #1f2937;">{{ __('ord_email_total') }}:</td>
<td style="padding: 10px; text-align: right; font-weight: bold; color: #10b981;">
{{ number_format($order->total_with_vat, 2) }} {{ $order->currency ?? 'EUR' }}
</td>
</tr>
</tfoot>
</table>
</div>

<!-- Payment and Shipping Methods -->
<div style="margin-bottom: 20px;">
<p style="margin: 0 0 8px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{ __('ord_email_payment_type') }}:</span> {{ $order->payment_type_label ?? $order->paymentType->name ?? 'N/A' }}
</p>
<p style="margin: 0 0 8px; color: #4b5563; font-size: 14px">
<span style="font-weight: bold;">{{ __('ord_email_shipping_type') }}:</span> {{ $order->shipping_type_label ?? $order->shippingType->name ?? 'N/A' }}
</p>
</div>

<!-- Customer Notes (if provided) -->
@if ($order->note)
<div>
<h3 style="font-size: 16px; font-weight: bold; color: #1f2937; margin-bottom: 12px;">{{ __('ord_email_note') }}</h3>
<p style="margin: 0 0 4px; color: #4b5563; font-size: 14px">{{ $order->note }}</p>
</div>
@endif
</div>

<!-- Questions Prompt -->
<p style="margin: 20px 0 16px; color: #4b5563;">
{{ __('ord_email_any_questions') }}
</p>

<!-- Salutation -->
<!-- Questions Prompt -->
<p style="margin: 20px 0 16px; color: #4b5563;">
    {{ __('best_regards') }},<br>
    Mgr. Dominik Klimek
</p>
@endsection
{{-- @formatter:on --}}
