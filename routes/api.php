<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit'] ]);

/* Buyer controllers */
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['show', 'index'] ]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index'] ]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index'] ]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index'] ]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index'] ]);


/** Category Controllers */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
Route::resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);


/** Seller Controllers */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['show', 'index'] ]);
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'edit', 'show']]);

Route::resource('products', 'Product\ProductController', ['only' => ['show', 'index'] ]);
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['show', 'index'] ]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index'] ]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index'] ]);

