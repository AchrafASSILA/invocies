<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        return view('products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::all();
        return view('products.create_product', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $productRequest)
    {
        Products::create([
            'product_name' => $productRequest->product_name,
            'product_desc' => $productRequest->product_desc,
            'section_id' => $productRequest->section_id,

        ]);
        return redirect()->route('products.index')->with([
            'success' => 'تم اضافة المنتج بنجاح'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = Products::find($id);
        $sections = Sections::all();
        return view('products.edit_product', compact('sections', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $productRequest, int $id)
    {
        $product =  Products::find($id);
        $product->update([
            'product_name' => $productRequest->product_name,
            'product_desc' => $productRequest->product_desc,
            'section_id' => $productRequest->section_id,

        ]);
        return redirect()->route('products.index')->with([
            'success' => 'تم تحديث المنتج بنجاح'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Products::destroy($id);
        return redirect()->route('products.index')->with([
            'delete' => 'تم حدف المنتج بنجاح'
        ]);
    }
}
