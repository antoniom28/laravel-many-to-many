<?php

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['cinema','motori','cibo','sport'];
        foreach ($categories as $key => $category) {
            $new_category = new Category();
            $new_category->name = $category;
            $new_category->slug = Str::of($category)->slug('-');
            $new_category->save();
        }
    }
}
