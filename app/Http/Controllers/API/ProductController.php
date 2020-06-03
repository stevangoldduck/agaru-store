<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    protected $successStatus = 200;

    public function index()
    {
        $data = Product::with(['category'])->get();

        return response()->json($data, $this->successStatus);
    }
}
