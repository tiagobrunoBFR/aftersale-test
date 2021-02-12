<?php


namespace App\Service;


use App\Jobs\SendEmailProduct;
use App\Models\FavoriteProduct;
use App\Service\Shopify\ShopifyService;

class FavoriteProductService
{

    public function store($request)
    {
        $favoriteProduct = FavoriteProduct::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id
        ]);

        $this->dispatchEmailFavoriteProduct();
        
        return $favoriteProduct;
    }

    public function destroy($id)
    {
        $favoriteProduct = FavoriteProduct::findOrFail($id);

        if ($favoriteProduct->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $favoriteProduct->delete();

        $this->dispatchEmailFavoriteProduct();

        return true;
    }

    public function find($id)
    {
        $favoriteProduct = FavoriteProduct::findOrFail($id);

        return $favoriteProduct;
    }

    public function index()
    {
        $shopifyService = new ShopifyService();

        $productIds = $this->mapArrayProductIds(auth()->id());

        return $shopifyService->product()->index($productIds);
    }

    public function mapArrayProductIds($user_id)
    {
        $arrayProductIds = FavoriteProduct::where('user_id', $user_id)->pluck('product_id')->toArray();

        return $arrayProductIds;
    }

    private function dispatchEmailFavoriteProduct()
    {
        SendEmailProduct::dispatch(auth()->user());
    }
}
