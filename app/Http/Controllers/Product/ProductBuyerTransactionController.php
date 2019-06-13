<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use App\Transformers\TransactionTransformer;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-products')->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        if($product->quantity < $request->quantity){
            return $this->errorResponse('Available product quantity is less than requiested quantity', 409);
        }

        if(!$product->isAvailable()){
            return $this->errorResponse('Product not available for purchase', 409);
        }

        if($product->seller->id == $buyer->id){
            return $this->errorResponse('Seller product not be buyer owner product', 409);
        }

        if(!$product->seller->isVerified()){
            return $this->errorResponse('Seller product must be verified user', 409);
        }

        if(!$buyer->isVerified()){
            return $this->errorResponse('Buyer product must be verified user', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $data = [
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ];

            $transaction = Transaction::create($data);
            return $this->showOne($transaction, 201);
        });


    }

}
