<?php
namespace App\Http\Composers;

use App\Category;
use Illuminate\Contracts\View\View;


class CategoryWidgetComposer{
    public function compose(View $view){
       $categories = Category::where('parent_id', 0)->where('is_active', 1)->get();
       $view->with('categories', $categories);
    }
}


