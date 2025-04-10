<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Events\EventResource;
use App\Http\Requests\Api\v1\Events\StoreEventRequest;
use App\Http\Requests\Api\v1\Events\UpdateEventRequest;
use App\Http\Resources\Api\v1\Category\CategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $events = Event::all();

            return response()->json([
                'message' => 'All Events fetched Successfully',
                'event' => EventResource::collection($events)
            ]);

        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Fetching all Events', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Requested model not found',
            ], 404);

        }

        catch(\Exception $e){
            logger('Error While Fetching all Events',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Fetching all Events'
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
    public function store(StoreEventRequest $request)
    {
        try{
            $event = Event::create($request->all());

            if($event){
                $event->update([
                    'created_by' => $request->user()->id
                ]);
            }

            return response()->json([
                'message' => 'Event Created Successfully',
                'event' => new EventResource($event)
            ]);

        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Creating Event', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Requested model not found',
            ], 404);

        }

        catch(\Exception $e){
            logger('Error While Creating Event',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Creating Event'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $event = Event::findOrFail($id);

            return response()->json([
                'message' => 'Individual Event fetched Successfully',
                'event' => new EventResource($event)
            ]);

        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Fetching an Event', context: [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Requested model not found',
            ], 404);

        }

        catch(\Exception $e){
            logger('Error While Fetching an Event',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Fetching an Event'
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
    public function update(UpdateEventRequest $request, string $id)
    {
        try{
            $event = Event::findOrFail($id);

            if($event){
                $request['updated_by'] = $request->user()->id;
            }

            $event->update($request->all());

            $updatedEvent = $event->refresh();

            return response()->json([
                'message' => 'Event Updated Successfully',
                'event' => new EventResource($updatedEvent)
            ]);

        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Updating Event', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Requested model not found',
            ], 404);

        }

        catch(\Exception $e){
            logger('Error While Updating Event',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Updating Event'
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        try{
            $event = Event::findOrFail($id);

            if($event){
                $event->update([
                    'deleted_by' => $request->user()->id
                ]);
            }

            $event->delete();

            return response()->json([
                'message' => 'Event Deleted'
            ]);

        }

        catch (ModelNotFoundException $e) {
            // Handle model not found exception if you're looking for a specific model
            logger('Model Not Found Error While Deleting an Event', context: [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Requested model not found',
            ], 404);

        }

        catch(\Exception $e){
            logger('Error While Deleting an Event',[
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Something Went Wrong While Deleting an Event'
            ],500);
        }
    }

    //Get Events By Category

    public function getByCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $events = Event::where('category_id', $categoryId)->get();

            return response()->json([
                'message' => 'Events for Category fetched successfully',
                'data' => [
                    'category' => new CategoryResource($category),
                    'events' => EventResource::collection($events),
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Category not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong while fetching events by category',
            ], 500);
        }
    }

}
