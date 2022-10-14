<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\RincianRekening;
use Validator;
use App\Http\Resources\RincianRekeningResource;
use Illuminate\Http\Request;

class RincianRekeningController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rincianRekening = RincianRekening::all();
      
        return $this->sendResponse(RincianRekeningResource::collection($rincianRekening), 'Rincian Rekening retrieved successfully.');
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
            'rekening_id' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $rincianRekening = RincianRekening::create($input);
     
        return $this->sendResponse(new RincianRekeningResource($rincianRekening), 'Rincian Rekening created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RincianRekening  $rincianRekening
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rincianRekening = RincianRekening::find($id);
    
        if (is_null($rincianRekening)) {
            return $this->sendError('Rincian Rekening not found.');
        }
     
        return $this->sendResponse(new RincianRekeningResource($rincianRekening), 'Rincian Rekening retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RincianRekening  $rincianRekening
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rekening = Rekening::findOrFail($id);
     
        $validator = Validator::make($input, [
            'rekening_id' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $rincianRekening->rekening_id = $input['rekening_id'];
        $rincianRekening->item_id = $input['item_id'];
        $rincianRekening->save();
     
        return $this->sendResponse(new RincianRekeningResource($rincianRekening), 'Rincian Rekening updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RincianRekening  $rincianRekening
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rincian = RincianRekening::findOrFail($id);
        $rincian->delete();
     
        return $this->sendResponse([], 'Rincian Rekening deleted successfully.');
    }

    public function removeByRekeningIdAndItem($rekeningId, $itemId)
    {
        RincianRekening::where('rekening_id', $rekeningId)->where('item_id', $itemId)->delete();

        return $this->sendResponse([], 'Rincian Rekening deleted successfully.');
    }
}
