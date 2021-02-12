<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteProductRequest;
use App\Models\FavoriteProduct;
use App\Service\FavoriteProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function destroy($id)
    {
        try {
            $this->favoriteProductService->destroy($id);
            return response()->json([], 204);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Favorite product not found'], 404);
        }
    }

    public function index()
    {
        $favoriteProducts = $this->favoriteProductService->index();

        return response()->json($favoriteProducts, 200);
    }
}
