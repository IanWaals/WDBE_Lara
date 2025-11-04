<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'songs' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get or create genre
        $genre = DB::table('genres')->where('genreName', $validated['category'])->first();
        if (!$genre) {
            $genreId = DB::table('genres')->insertGetId([
                'genreName' => $validated['category'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $genreId = $genre->id;
        }

        $soldAmount = rand(200, 1800);

        // Insert product
        $productId = DB::table('products')->insertGetId([
            'productName' => $validated['title'],
            'description' => $validated['description'],
            'Artist' => $validated['artist'],
            'genre' => $validated['category'],
            'genre_id' => $genreId,
            'Price' => $validated['price'],
            'songAmount' => $validated['songs'],
            'stock' => $validated['stock'],
            'sold' => $soldAmount,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/album-cover'), $imageName);
                
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'image_path' => 'images/album-cover/' . $imageName,
                    'is_primary' => $index === 0, // First image is primary
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'songs' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
        ]);

        // Get or create genre
        $genre = DB::table('genres')->where('genreName', $validated['category'])->first();
        if (!$genre) {
            $genreId = DB::table('genres')->insertGetId([
                'genreName' => $validated['category'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $genreId = $genre->id;
        }

        DB::table('products')
            ->where('id', $id)
            ->update([
                'productName' => $validated['title'],
                'description' => $validated['description'],
                'Artist' => $validated['artist'],
                'genre' => $validated['category'],
                'genre_id' => $genreId,
                'Price' => $validated['price'],
                'songAmount' => $validated['songs'],
                'stock' => $validated['stock'],
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        // Get all images for this product
        $images = DB::table('product_images')
            ->where('product_id', $id)
            ->get();

        // Delete images from server
        foreach ($images as $image) {
            $imagePath = public_path($image->image_path);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        // Delete image records from database (cascade should handle this, but being explicit)
        DB::table('product_images')->where('product_id', $id)->delete();

        // Delete the product
        DB::table('products')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product and all associated images deleted successfully!'
        ]);
    }
}