<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DecorativeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewArrivalsApiController extends Controller
{
    /**
     * Get new arrival products grouped by parent category
     */
    public function index(Request $request)
    {
        try {
            // Check if is_new_arrival column exists
            $hasNewArrivalColumn = \Schema::hasColumn('decorative_products', 'is_new_arrival');
            
            $query = DecorativeProduct::with(['categories.parent', 'primaryImage'])
                ->where('status', 'active');
            
            // If is_new_arrival column exists, use it
            if ($hasNewArrivalColumn) {
                $products = (clone $query)
                    ->where('is_new_arrival', 1)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
                
                // If no products marked as new arrival, get recent products
                if ($products->isEmpty()) {
                    $products = $query
                        ->orderBy('created_at', 'desc')
                        ->limit(20)
                        ->get();
                }
            } else {
                // If column doesn't exist, just get recent products
                $products = $query
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
            }

            // Group products by parent category
            $groupedProducts = [];

            foreach ($products as $product) {
                foreach ($product->categories as $category) {
                    // Get parent category (if exists) or use the category itself if it's a parent
                    $parentCategory = $category->parent_id 
                        ? $category->parent 
                        : $category;

                    if ($parentCategory) {
                        $parentName = $parentCategory->name;

                        if (!isset($groupedProducts[$parentName])) {
                            $groupedProducts[$parentName] = [
                                'id' => $parentCategory->id,
                                'name' => $parentName,
                                'slug' => $parentCategory->slug,
                                'products' => []
                            ];
                        }

                        // Check if product already added to this parent category
                        $productExists = collect($groupedProducts[$parentName]['products'])
                            ->contains('id', $product->id);

                        if (!$productExists) {
                            // Get primary image
                            $imageUrl = null;
                            if ($product->primaryImage && $product->primaryImage->image) {
                                // Images are stored in storage/app/public/decorative_products/
                                $imageUrl = url('storage/decorative_products/' . $product->primaryImage->image);
                            }

                            // Get child category name for display
                            $childCategoryName = $category->name;

                            $groupedProducts[$parentName]['products'][] = [
                                'id' => $product->id,
                                'name' => $product->title, // Using 'title' field
                                'slug' => $product->slug,
                                'category' => $childCategoryName,
                                'parent_category' => $parentName,
                                'image_url' => $imageUrl,
                                'price' => $product->price ?? null,
                                'description' => $product->short_description ?? $product->description
                            ];
                        }
                    }
                }
            }

            // Convert to indexed array
            $result = array_values($groupedProducts);

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'New arrival products fetched successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch new arrival products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
