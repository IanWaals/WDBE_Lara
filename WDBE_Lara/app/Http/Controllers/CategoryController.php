<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('genres')
            ->select('genres.*', DB::raw('COUNT(products.id) as product_count'))
            ->leftJoin('products', 'genres.id', '=', 'products.genre_id')
            ->groupBy('genres.id', 'genres.genreName', 'genres.created_at', 'genres.updated_at')
            ->orderBy('genres.genreName', 'asc')
            ->get();

        return view('categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:genres,genreName',
        ]);

        DB::table('genres')->insert([
            'genreName' => $validated['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:genres,genreName,' . $id,
        ]);

        $oldGenre = DB::table('genres')->where('id', $id)->first();

        DB::table('genres')
            ->where('id', $id)
            ->update([
                'genreName' => $validated['name'],
                'updated_at' => now()
            ]);

        // Update all products with this genre
        DB::table('products')
            ->where('genre', $oldGenre->genreName)
            ->update([
                'genre' => $validated['name'],
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        // Get all products in this category
        $products = DB::table('products')
            ->where('genre_id', $id)
            ->get();

        // Delete all images for products in this category
        foreach ($products as $product) {
            $images = DB::table('product_images')
                ->where('product_id', $product->id)
                ->get();

            foreach ($images as $image) {
                $imagePath = public_path($image->image_path);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // Delete image records
            DB::table('product_images')->where('product_id', $product->id)->delete();
        }

        // Delete all products in this category
        DB::table('products')->where('genre_id', $id)->delete();

        // Delete the category
        DB::table('genres')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category and all associated products deleted successfully!'
        ]);
    }
}