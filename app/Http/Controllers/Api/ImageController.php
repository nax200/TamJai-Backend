<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->file('image')))
            return response()->json([
                'success' => false,
                'message' => 'Image upload fail'
            ], Response::HTTP_BAD_REQUEST);
        if ($request->has('review_id')) return $this->storeReviewImage($request);
        if ($request->has('shop_id')) return $this->storeShopImage($request);
        $path = $request->file('image')->store('public/images');
        $path = trim(strstr($path,"images"));
        $product = Product::find($request->get('product_id'));
        $product->image_path = $path;
        $product->save();
        return response()->json([
            'success' => true,
            'path' => $path
        ], Response::HTTP_OK);
    }

    public function storeReviewImage(Request $request)
    {
        $path = $request->file('image')->store('public/images');
        $path = trim(strstr($path,"images"));
        $review = Review::where('product_id', $request->get('product_id'))->where('user_id', $request->get('user_id'))->first();
        $review->image_path = $path;
        $review->save();
        return response()->json([
            'success' => true,
            'path' => $path
        ], Response::HTTP_OK);
    }

    public function storeShopImage(Request $request) {
        Log::info($request);
        $path = $request->file('image')->store('public/images');
        $path = trim(strstr($path,"images"));
        $shop = Shop::where('id', $request->get('shop_id'))->first();
        $shop->image_path = $path;
        $shop->save();
        return response()->json([
            'success' => true,
            'path' => $path
        ], Response::HTTP_OK);
    }

    public function search(Request $request) {
        $product_id = $request->query('product_id');
        $path = Product::find($product_id);
        if ($request->has('user_id'))
            $path = Review::where('product_id', $request->get('product_id'))->where('user_id', $request->get('user_id'));
        if ($request->has('shop_id'))
            $path = Shop::where('id', $request->get('shop_id'))->first();

        try {
            $path = $path->image_path ?? 'images/product-default.png';
        } catch (\Exception $e) {
            $path = 'images/product-default.png';
        }
        return response()->file("storage/".$path);
    }
}
