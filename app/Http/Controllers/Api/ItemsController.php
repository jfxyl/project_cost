<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class ItemsController extends Controller
{
    public function items()
    {
        return Category::with('items')->get();
    }
}
