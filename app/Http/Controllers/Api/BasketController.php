<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Shop;
use App\Http\Resources\BasketResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $baskets = Basket::get();
        return BasketResource::collection($baskets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $basket = new Basket();
        $basket->quantity = $request->get('quantity');
        $basket->product_id= $request->get('product_id');

        if ($basket->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Basket created with id '.$basket->id,
                'basket_id' => $basket->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Basket creation failed'
        ], Response::HTTP_BAD_REQUEST);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function show(Basket $basket)
    {
        return new BasketResource($basket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Basket $basket)
    {
        if($request->has('quantity'))$basket->quantity = $request->get('quantity');
        if($request->has('product_id'))$basket->product_id= $request->get('product_id');
        if ($basket->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Basket updated with id '.$basket->id,
                'basket_id' => $basket->id
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Basket update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Basket $basket)
    {
        $id = $basket->id;
        if($basket->delete()){
            return respone()->json([
                'success' => true,
                'message' => "Basket id{$id} with deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Basket id{$id} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $baskets = Basket::where('id', 'LIKE', "%{$q}%")
                         ->get();
        return $baskets;
    }
}