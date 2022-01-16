<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $produtcts=\App\Models\Product::factory()->count(10)->make()->toArray();
         foreach($produtcts AS $k){
             $produtct=new Product();
             $produtct->name=$k['name'];
             $produtct->price=$k['price'];
             $produtct->status=$k['status'];
             $produtct->upc=$k['upc'];
             $produtct->image=$k['image'];
             $produtct->save();
         }
    }
}
