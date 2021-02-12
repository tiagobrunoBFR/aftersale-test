<?php

namespace App\Jobs;

use App\Mail\FavoriteProductMail;
use App\Models\User;
use App\Service\FavoriteProductService;
use App\Service\Shopify\ShopifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 220;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $shopifyService = new ShopifyService();

        $products = $shopifyService->product()->convertCollection($this->user->id);

        if ($products) {
            Mail::to($this->user)->send(new FavoriteProductMail($products));
        }

    }
}
