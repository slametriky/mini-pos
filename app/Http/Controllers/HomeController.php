<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepository;

class HomeController extends Controller
{

    protected $productRepo;

    public function __construct(ProductRepository $productRepo) {
        $this->productRepo = $productRepo;
    }
    
    public function index()
    {
        $products = $this->productRepo->data();
        
        return view('home', compact('products'));
    }
}
