<?php


namespace App\Service;


use App\Models\FavoriteProduct;

class FavoriteProductService
{
   private $favoriteProduct;

   public function __construct(FavoriteProduct $favoriteProduct)
   {
       $this->favoriteProduct = $favoriteProduct;
   }

    public function store($request)
   {
      return $this->favoriteProduct->create([
          'user_id' => auth()->id(),
          'product_id' => $request->product_id
      ]);
   }
}
