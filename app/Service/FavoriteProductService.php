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

   public function destroy($id)
   {
       $favoriteProduct = $this->favoriteProduct->findOrFail($id);

       if($favoriteProduct->user_id!=auth()->id()){
         abort(403, 'Unauthorized');
       }

       $favoriteProduct->delete();

       return true;
   }

   public function find($id)
   {
       $favoriteProduct = $this->favoriteProduct->findOrFail($id);

       return $favoriteProduct;
   }
}
