<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use Yajra\DataTables\DataTables;

class ProductRepository implements ProductInterface 
{
    public function data(){

        $products = Product::with('category')->get();

        return $products;
    }    

    public function datatable(){

        $products = Product::with('category')->get();

        return Datatables::of($products)->make(true);
    }    
}


