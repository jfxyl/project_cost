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

    public function catalogs(Request $request)
    {
        if(!$item = Item::find($request->item_id)){
            return formError('分项不存在！');
        }
        return $item->catalogs;
    }
}
