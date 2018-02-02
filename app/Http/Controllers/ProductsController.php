<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        $product=Product::all();
        return view('product.productlist',compact('product'));
    }
    public function create()
    {
        return view('product.productcreate');
    }
    public function store(Request $request)
    {
        $product = Product::create($request->all());


        if ($request->hasFile('picture')) {
            $file_name = $request->file('picture')->getClientOriginalName();
            $destinationPath = '/public/product';
            $request->file('picture')->storeAs($destinationPath,$file_name);

            // save new image $file_name to database
            $product->update(['picture' => $file_name]);
        }

        return redirect()->route('procreate');
    }
    public function edit($id)
    {
        $product=Product::all()->where('id',$id);
        return view('product.productedit',compact('product'));
    }
    public function update(Request $request,$id)
    {
        $product=Product::find($id);
        $product->update($request->all());
        if ($request->hasFile('picture')){
            $file_name = $request->file('picture')->getClientOriginalName();

            $destinationPath = '/public/product';
            $request->file('picture')->storeAs($destinationPath,$file_name);

            // save new image $file_name to database
            $product->update(['picture' => $file_name]);
        }

        return redirect()->route('prolist');
    }
    public function destroy($id)
    {
        $whereArray = array('id'=>$id);
        DB::table('commoditys')->where($whereArray)->delete();
        return redirect()->route('prolist');
    }
}
