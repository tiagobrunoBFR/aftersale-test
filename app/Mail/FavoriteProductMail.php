<?php

namespace App\Mail;

use App\Service\Shopify\ShopifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FavoriteProductMail extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Favorite Products List')
            ->markdown('emails.favorite-product');
    }
}
