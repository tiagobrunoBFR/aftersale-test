<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteProductRequest;
use App\Models\FavoriteProduct;
use App\Service\FavoriteProductService;
use Illuminate\Http\Request;

class FavoriteProductController extends Controller
{
    private $favoriteProductService;

    public function __construct(FavoriteProductService $favoriteProductService)
    {
        $this->favoriteProductService = $favoriteProductService;
    }

    public function store(FavoriteProductRequest $request)
    {
        $favoriteProduct = $this->favoriteProductService->store($request);

        return response()->json(['favorite_product' => $favoriteProduct], 201);
    }
}
