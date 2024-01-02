<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
          $product = $event->product;
        $purchasedQuantity = 1; 
        
        if ($product->quantity >= $purchasedQuantity) {
            $product->quantity -= $purchasedQuantity;
            $product->save();
        } else {
          
        }
    }
}