@component('mail::message')
# Favorite Products List

@foreach($products as $i => $product)

    {{$i+1}} - {{$product->title}}

@endforeach
    
@endcomponent
