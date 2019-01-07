<?php

use Illuminate\Database\Seeder;
use App\Models\SupplyCate;

class SupplyCatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplyCates = [
            '木材','水泥','石材'
        ];
        
        collect($supplyCates)->each(function ($item) {
            SupplyCate::create(['supply_cate' => $item]);
        });
    }
}
