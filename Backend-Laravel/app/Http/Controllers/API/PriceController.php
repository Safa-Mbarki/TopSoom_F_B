<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Http\Resources\PriceResource;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        if(!empty($request->barcode)){
            $price= Price::where('barcode',$request->barcode)->get();
        }
        elseif(!empty($request->product_name)){
            $price= Price::where('product_name',$request->product_name)->get();
            }else{
                $price= Price::all();
            }

        if (is_null($price)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json(PriceResource::collection($price));
    }

    public function store(Request $request)
    {
        $price = Price::create([
            'barcode' => $request->barcode,
            'product_name' => $request->product_name,
            'shop_name' => $request->shop_name,
            'price' => $request->price
         ]);
        
        return response()->json( new PriceResource($price));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price= Price::find($id);
        $price->delete();

        return response()->json('Price deleted successfully');
    }
}