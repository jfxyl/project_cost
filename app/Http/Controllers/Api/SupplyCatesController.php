<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SupplyCate;

class SupplyCatesController extends Controller
{
    public function supplyCates()
    {
        return SupplyCate::all();
    }
}
