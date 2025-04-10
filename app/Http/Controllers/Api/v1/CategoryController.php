<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\v1\Category\CategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\v1\Category\StoreCategoryRequest;
use App\Http\Requests\Api\v1\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::all();

            return response()->json([
                'message'       => 'All Categories fetched',
                'categories'    => CategoryResource::collection($categories)
            ]);
            
        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Creating Category', [
                'error' => $e->getMessage(),
            ]);
    
            return response()->json([
                'error' => 'Requested model not found',
            ], 404);
            
        }
        
        catch(\Exception $e){
            logger('Error While Creating Category',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Retrieving Categories'
            ],500);
        }
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try{
            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => $request->user()->id,

            ]);

            return response()->json([
                'message' => 'Category Created',
                'category' => new CategoryResource($category)
            ]);
            
        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Creating Category', [
                'error' => $e->getMessage(),
            ]);
    
            return response()->json([
                'error' => 'Requested model not found',
            ], 404);
            
        }
        
        catch(\Exception $e){
            logger('Error While Creating Category',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Creating Category'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $category)
    {
        try{
            $category = Category::findOrFail($category);

            return response()->json([
                'message' => 'Category fetched',
                'category' => new CategoryResource($category)
            ]);
            
        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Creating Category', [
                'error' => $e->getMessage(),
            ]);
    
            return response()->json([
                'error' => 'Requested model not found',
            ], 404);
            
        }
        
        catch(\Exception $e){
            logger('Error While Creating Category',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Updating Category'
            ],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $category)
    {
        try{
            $category = Category::findOrFail($category);

            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'updated_by' => $request->user()->id,

            ]);

            return response()->json([
                'message' => 'Category Updated',
                'category' => new CategoryResource($category)
            ]);
            
        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Creating Category', [
                'error' => $e->getMessage(),
            ]);
    
            return response()->json([
                'error' => 'Requested model not found',
            ], 404);
            
        }
        
        catch(\Exception $e){
            logger('Error While Creating Category',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Updating Category'
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try{
            $category = Category::findOrFail($id);

            if($category){
                $category->update([
                    'deleted_by' => $request->user()->id
                ]);

                $category->delete();
            }

            return response()->json([
                'message' => 'Category deleted',
                //'category' => new CategoryResource($category)
            ]);
            
        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Deleting Category', [
                'error' => $e->getMessage(),
            ]);
    
            return response()->json([
                'error' => 'Requested model not found',
            ], 404);
            
        }
        
        catch(\Exception $e){
            logger('Error While Deleting Category',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Deleting Category'
            ],500);
        }
    }
}
