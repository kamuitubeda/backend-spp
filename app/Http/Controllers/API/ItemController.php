<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Item;
use Validator;
use App\Http\Resources\SantriResource;
use Illuminate\Http\Request;

class ItemController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Item::all();
      
        return $this->sendResponse(ItemResource::collection($item), 'Item retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'nama' => 'required',
            'harga' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $item = Item::create($input);
     
        return $this->sendResponse(new ItemResource($item), 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
    
        if (is_null($item)) {
            return $this->sendError('Item not found.');
        }
     
        return $this->sendResponse(new ItemResource($item), 'Item retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'nama' => 'required',
            'harga' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $item->nama = $input['nama'];
        $item->harga = $input['harga'];
        $item->save();
     
        return $this->sendResponse(new ItemResource($item), 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
     
        return $this->sendResponse([], 'Item deleted successfully.');
    }
}
