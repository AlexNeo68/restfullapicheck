<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProductTransformer;

class SellerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . ProductTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $newProduct = Product::create($data);
        return $this->showOne($newProduct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {

        $rules = [
            'image' => 'image',
            'quantity' => 'integer|min:1',
            'status' => 'in:'.Product::UNAVAILABLE_PRODUCT.','.Product::AVAILABLE_PRODUCT
        ];

        $this->validate($request, $rules);

        $this->checkSeller($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));

        if($request->has('status')){
            $product->status = $request->status;
            if($product->isAvailable() && $product->categories()->count() === 0){
                return $this->errorResponse('Not possible to activate product if it not related categories', 409);
            }
        }

        if($request->hasFile('image')){
            if($product->image){
                Storage::delete($product->image);
                $product->image = $request->image->store('');
            }
        }

        if($product->isClean()){
            return $this->errorResponse('Need a specific data for update product', 422);
        }

        $product->save();
        return $this->showOne($product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);
        $product->delete();
        Storage::delete($product->image);
        return $this->showOne($product);
    }

    public function checkSeller(Seller $seller, Product $product)
    {
        if($seller->id !== $product->seller_id)
            throw new HttpException(422, 'Product may modify only it owner');
    }
}
