<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;

class AdminController extends Controller
{
    public function insertCSV(Request $request)
    {
        //foreach($array as $item){
        for($i=0;$i<count($request->prices);$i++) {
            $price = Price::create([
                'barcode' => $request->prices[$i]['barcode'],
                'product_name' => $request->prices[$i]['product_name'],
                'shop_name' => $request->prices[$i]['shop_name'],
                'price' => $request->prices[$i]['price']
             ]); 
          }
        
         return response()->json([
            'status' => 200,
            'message'=>'Registered Successfully',
            'prices' => $request->prices
        ]);
    }
}
