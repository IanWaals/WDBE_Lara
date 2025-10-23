<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'songs' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/album-cover'), $imageName);
        }

        // Generate random sold amount between 200 and 1800
        $soldAmount = rand(200, 1800);

        // Insert into database
        DB::table('products')->insert([
            'productName' => $validated['title'],
            'Artist' => $validated['artist'],
            'genre' => $validated['category'],
            'Price' => $validated['price'],
            'songAmount' => $validated['songs'],
            'stock' => $validated['stock'],
            'sold' => $soldAmount,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'songs' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
        ]);

        // Update the product in database
        DB::table('products')
            ->where('id', $id)
            ->update([
                'productName' => $validated['title'],
                'Artist' => $validated['artist'],
                'genre' => $validated['category'],
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
        // Delete the product from database
        DB::table('products')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ]);
    }
}