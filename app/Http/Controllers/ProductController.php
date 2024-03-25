<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Jobs\NewProductEmail; 
use Illuminate\Support\Facades\Mail;
use App\Events\ProductPurchased;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;


class ProductController extends Controller
{


 public function __construct()
    {
        $this->middleware('CheckAdmin')->except(['index', 'show']); 
    }

    public function index(Request $request)
{
    $products = Product::latest();

    if (!empty($request->get('keyword'))) {
        $products = $products->where('name', 'like', '%' . $request->get('keyword') . '%');
    }

    $products = $products->paginate(5);


    return view('admin.products.list', compact('products'));
}


    public function create()
    {
         $category = Category::orderBy('name', 'ASC')->get();
         $data['category'] = $category;
        return view('admin.products.create',$data);
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            
        ]);

         if ($validator->passes()){

            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category;
            $product->save();

           // NewProductEmail::dispatch($product);
        event(new ProductPurchased($product));
        
            $request->session()->flash('success', 'Product successfully created');
             return response()->json(['success' =>true,
             'message' => 'Product successfully created'
            ]);
            
         }
         else{
            return response()->json(['success' =>false,
             'errors' =>$validator->errors()
            ]);
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $category = Category::orderBy('name', 'ASC')->get();
         $data['category'] = $category;

        if (empty($product)){
            return redirect()->route('products.list');
        }
        return view('admin.products.edit', compact('product','data'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
      if (empty($product)){
            $request->session()->flash('error', 'Products Not Found');
            
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Products not found'
            ]);
        }
        
          $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            
        ]);

         if ($validator->passes()){
            
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category;
            
            $product->save();

            $request->session()->flash('success', 'Product successfully updated.');
             return response()->json(['success' =>true,
             'message' => 'Product successfully updates.'
            ]);
            
         }
         else{
            return response()->json(['success' =>false,
             'errors' =>$validator->errors()
            ]);
        }
    }

    public function destroy(Request $request,$id)
    {
        $product = Product::find($id);

        if (empty($product)){
            $request->session()->flash('error', 'Product Not Found');
            return response()->json(['success' =>true,
             'message' => 'Product Not Found'
            ]);
        }
        $product->delete();

      $request->session()->flash('success', 'Product successfully Deleted');

         return response()->json(['success' =>true,
             'message' => 'Product successfully Deleted'
            ]);
    }

    
public function importProducts(Request $request)
{
    $file = $request->file('file');

    Excel::import(new ProductsImport, $file);

    return redirect()->back()->with('success', 'Products imported successfully.');
}

public function exportProducts()
{
    return Excel::download(new ProductsExport, 'products.xlsx');
}

public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            Excel::import(new ProductsImport(), $file);

            return redirect()->back()->with('success', 'Products imported successfully!');
        }

        return redirect()->back()->with('error', 'Please select a file to import.');
    }

    public function export()
    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }

}