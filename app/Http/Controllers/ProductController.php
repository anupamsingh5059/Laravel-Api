<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(){
        // ensure user is authenticated for all actions
        $this->middleware('auth'); // session-based
        // index & show available to admin+employee, create/update/delete guarded by policy
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);
        $products = Product::orderBy('id','desc')->paginate(10);
        // If AJAX request return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($products);
        }
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric',
        ]);
        $product = Product::create($data);
        return response()->json(['message'=>'Product created','product'=>$product], 201);
    }

    public function show(Request $request, Product $product)
    {
        $this->authorize('view', $product);
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        $data = $request->validate([
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'sometimes|required|numeric',
        ]);
        $product->update($data);
        return response()->json(['message'=>'Product updated','product'=>$product]);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return response()->json(['message'=>'Product deleted']);
    }
}
