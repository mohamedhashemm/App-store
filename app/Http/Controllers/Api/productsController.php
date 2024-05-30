<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class productsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Product::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Product $product)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            'category_id'=>'nullable|exists:categories,id',
            'price'=>'required|min:0',
            'compare_price'=>'nullable|gt:price',

        ]);
        // return  Product::create($request->all());
        // or
        $product->create($request->all());

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
       return $product
       ->load('category:id,name','store:id,name','tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string|max:255',
            'category_id'=>'nullable|exists:categories,id',
            'price'=>'sometimes|required|nummerc|min:0',
            'compare_price'=>'nullable|nummerc|gt:price',

        ]);
        // return  Product::create($request->all());
        // or
        $product->update($request->all());

        return FacadesResponse::json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return[
            "messsage"=>"product deleted succcessfully"

        ];
    }
}
