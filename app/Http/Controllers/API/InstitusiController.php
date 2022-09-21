<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Institusi;
use Validator;
use App\Http\Resources\InstitusiResource;

class InstitusiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institusis = Institusi::all();
      
        return $this->sendResponse(InstitusiResource::collection($institusis), 'Institusis retrieved successfully.');
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
            'name' => 'required',
            'detail' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $institusi = Institusi::create($input);
     
        return $this->sendResponse(new InstitusiResource($institusi), 'Institusi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function show(Institusi $institusi)
    {
        $institusi = Institusi::find($id);
    
        if (is_null($institusi)) {
            return $this->sendError('Institusi not found.');
        }
     
        return $this->sendResponse(new InstitusiResource($institusi), 'Institusi retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institusi $institusi)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $institusi->name = $input['name'];
        $institusi->detail = $input['detail'];
        $institusi->save();
     
        return $this->sendResponse(new InstitusiResource($institusi), 'Institusi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institusi $institusi)
    {
        $institusi->delete();
     
        return $this->sendResponse([], 'Institusi deleted successfully.');
    }
}
