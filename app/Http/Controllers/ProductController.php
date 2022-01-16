<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepo;


    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo=$productRepo;
    }

    public function getAll(){
        return $this->productRepo->getAllProducts();
    }

    public function create(array $productArr){

    }
}
