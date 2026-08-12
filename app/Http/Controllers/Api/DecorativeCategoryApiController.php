<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DecorativeCategory;
use Illuminate\Http\Request;

class DecorativeCategoryApiController extends Controller
{
    /**
     * Get all decorative categories (for menu)
     */
    public function index(Request $request)
    {
        try {
            // Get only parent categories (no parent_id) for main menu with their children
            $categories = DecorativeCategory::with(['children' => function($query) {
                    $query->where('status', 'active')
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
                }])
                ->where('status', 'active')
                ->whereNull('parent_id')
                ->orderBy('sort_order', 'ASC')
                ->orderBy('name', 'ASC')
                ->get();
            
            $categories = $categories->map(function ($category) {
                $children = $category->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'slug' => $child->slug,
                        'image_url' => $child->image ? asset('storage/' . $child->image) : null,
                        'sort_order' => $child->sort_order,
                    ];
                });

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->image ? asset('storage/' . $category->image) : null,
                    'sort_order' => $category->sort_order,
                    'children' => $children,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $categories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get category with subcategories
     */
    public function show($slug)
    {
        try {
            $category = DecorativeCategory::where('status', 'active')
                ->where('slug', $slug)
                ->firstOrFail();
            
            $subcategories = DecorativeCategory::where('status', 'active')
                ->where('parent_id', $category->id)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('name', 'ASC')
                ->get()
                ->map(function ($subcat) {
                    return [
                        'id' => $subcat->id,
                        'name' => $subcat->name,
                        'slug' => $subcat->slug,
                        'image_url' => $subcat->image ? asset('storage/' . $subcat->image) : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->image ? asset('storage/' . $category->image) : null,
                    'subcategories' => $subcategories,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
