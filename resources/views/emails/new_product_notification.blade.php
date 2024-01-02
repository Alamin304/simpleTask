@component('mail::message')
# New Product Added

A new product has been added:
- Name: {{ $product->name }}
- Price: {{ $product->price }}
- Quantity: {{ $product->quantity }}

Thank you,
{{ config('Alamin') }}
@endcomponent