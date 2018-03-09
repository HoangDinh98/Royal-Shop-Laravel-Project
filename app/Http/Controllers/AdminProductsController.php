<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Product;
use App\Photo;
use App\Promotion;
use App\Category;
use App\User;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AdminProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Product::orderBy('created_at', 'desc')->paginate(7);
        $users = User::all();
        return view('admin.products.index', compact('products', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $products = Product::findOrFail($id);

        $categories = Category::pluck('name', 'id')->all();
        $providers = Provider::pluck('name', 'id')->all();
        $promotions = Promotion::pluck('value', 'id')->all();

        return view('admin.products.edit', compact('products', 'categories', 'providers', 'promotions','photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $products = Product::findOrFail($id);
        $input = $request->all();
        $product_id = $id;


        if ($file = $request->file('product_id')) {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $sub_folder = 'products/'.$product_id.'/'. $year . '/' . $month . '/' . $day . '/';
            $upload_url = 'images/' . $sub_folder;

            if (!File::exists(public_path() . '/' . $upload_url)) {
                File::makeDirectory(public_path() . '/' . $upload_url, 0777, true);
            }

            $name = time() . $file->getClientOriginalName();

            $file->move($upload_url, $name);
            
            
            $photo = Photo::create(['path' => $upload_url . $name]);
            
            $input['product_id'] = $products->id;
        }

        $products->update($input);

        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}