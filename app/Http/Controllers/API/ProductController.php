<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storeName = $request->query('store_name');
        $perPage = 4;
        $page = $request->query('page', 1); 

        $totalItems = Product::where('store_name', $storeName)->count();

        $totalPages = ceil($totalItems / $perPage);
    
        $skip = ($page - 1) * $perPage; 
    
        $products = Product::where('store_name', $storeName)
            ->skip($skip)
            ->take($perPage)
            ->get();
            
            $formattedProducts = $products->map(function ($product, $index) use ($skip) {
                return [
                    'id' => $index + 1 + $skip,
                    'store_name' => $product->store_name,
                   'product' => $product
                ];
            });
      
        $response = [
            'data' => $formattedProducts,
            'totalItems' => $totalItems,
            'totalPages' => $totalPages,
        ];
    
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $product = Product::create([
            'store_name' => $data['dataCreate']['store_name'],
            'product_id' => Str::random(10),
            'description' => $data['dataCreate']['description'],
            'image_product1' => $data['dataCreate']['imageUrl1'],
            'image_product2' => $data['dataCreate']['imageUrl2'],
            'name' => $data['dataCreate']['name'],
            'price_main' => $data['dataCreate']['priceMain'],
            'price_sale' => $data['dataCreate']['priceSale'],
        ]);
    

        return response()->json(['message' =>'Product created successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product_id)
    {
        $product = Product::where('product_id', $product_id)->first();
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function showProducts(Request $request)
    {
        $storeName = $request->query('store_name');
        $perPage = 12;
        $page = $request->query('page', 1); 

        $totalItems = Product::where('store_name', $storeName)->count();

        $totalPages = ceil($totalItems / $perPage);
    
        $skip = ($page - 1) * $perPage; 
    
        $products = Product::where('store_name', $storeName)
            ->skip($skip)
            ->take($perPage)
            ->get();
            
          
    
        return response()->json([
            'data' => $products,
            'totalItems' => $totalItems,
            'totalPages' => $totalPages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
        $data = $request->all();

        $product = Product::where('product_id', $product_id)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if (isset($data['dataEdit']['name'])) {
            $product->name = $data['dataEdit']['name'];
        }
        if (isset($data['dataEdit']['description'])) {
            $product->description  = $data['dataEdit']['description'];
        }
        if (isset($data['dataEdit']['imageUrl1'])) {
            $product->image_product1  = $data['dataEdit']['imageUrl1'];
        }
        if (isset($data['dataEdit']['imageUrl2'])) {
            $product->image_product2 = $data['dataEdit']['imageUrl2'];
        }
        if (isset($data['dataEdit']['price_main'])) {
            $product->price_main = $data['dataEdit']['price_main'];
        }
        if (isset($data['dataEdit']['price_sale'])) {
            $product->price_sale = $data['dataEdit']['price_sale'];
        }

        $product->save();

        return response()->json(['message' => 'Product updated successfully'], 200);
    
    

    }

    public function analyzeProductsByDate(Request $request)
    {
        $data = $request->all();
        $storeName = $data['store_name'];
    
        $startDate = Carbon::now()->subDays(30);
$endDate = now(); 

       
    
        $dateRange = [];
       
        
        $productsByDate = Product::where('store_name', $storeName)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        ->groupBy('date')
        ->pluck('count', 'date') 
        ->all();
    
        
    // dd(  $productsByDate);
     while ($startDate <= $endDate) {
            $dateRange[] = $startDate->format('Y-m-d');
            $startDate->addDay();
        }
    
        $productStats = [];
        foreach ($dateRange as $date) {
            $count = isset($productsByDate[$date]) ? $productsByDate[$date] : 0;
            $productStats[] = [
                'date' => $date,
                'product' => $count,
            ];
        }
    
        return response()->json(['data' => $productStats]);
    }
    public function delete(Request $request)
    
    {
        $data = $request->all();

        $product_ids = $data['product_ids'];
       
        Product::whereIn('product_id', $product_ids)->delete();

        return response()->json(['message' => 'Products deleted successfully'], 200);
    
    }
}