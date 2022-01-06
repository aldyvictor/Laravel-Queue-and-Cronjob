<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        try {
            $original_size_image = $request->file('image')->store('images', 's3');
            $original_url_image = Storage::disk('s3')->url($original_size_image);
            // Resize to Large
            $image_resize_large = Image::make($request->image)->resize(1280, 720 )->stream();
            $image_resize_large_name = $request->file('image')->hashName();
            $image_resize_large = Storage::disk('s3')->put('images/large/'.$image_resize_large_name, $image_resize_large);
            $image_url_large = Storage::disk('s3')->url('images/large/'.$image_resize_large_name);

            // Resize to Medium
            $image_resize_medium = Image::make($request->image)->resize(852, 480  )->stream();
            $image_resize_medium_name = $request->file('image')->hashName();
            $image_resize_medium = Storage::disk('s3')->put('images/medium/'.$image_resize_medium_name, $image_resize_medium);
            $image_url_medium = Storage::disk('s3')->url('images/medium/'.$image_resize_medium_name);

            // Resize to Small
            $image_resize_small = Image::make($request->image)->resize(480, 360 )->stream();
            $image_resize_small_name = $request->file('image')->hashName();
            $image_resize_small = Storage::disk('s3')->put('images/small/'.$image_resize_small_name, $image_resize_small);
            $image_url_small = Storage::disk('s3')->url('images/small/'.$image_resize_small_name);

            $product = Product::create([
                'name' => $request->product_name,
                'price' => $request->product_price,
                'product_image_original_name' => basename($original_size_image),
                'product_image_original_url' => $original_url_image,
                'product_image_large_name' => basename($image_resize_large_name),
                'product_image_large_url' => $image_url_large,
                'product_image_medium_name' => basename($image_resize_medium_name),
                'product_image_medium_url' => $image_url_medium,
                'product_image_small_name' => basename($image_resize_small_name),
                'product_image_small_url' => $image_url_small,
            ]);

            return response()->json([
                'message' => 'Success to Store',
                'data' => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to Store'
            ], 404);
        }
    }
}
