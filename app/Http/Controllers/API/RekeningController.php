<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekening = Rekening::all();
      
        return $this->sendResponse(RekeningResource::collection($rekening), 'Rekening retrieved successfully.');
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
            'jenis' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $rekening = Rekening::create($input);
     
        return $this->sendResponse(new RekeningResource($rekening), 'Rekening created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekening  $rekening
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rekening = Rekening::find($id);
    
        if (is_null($rekening)) {
            return $this->sendError('Rekening not found.');
        }
     
        return $this->sendResponse(new RekeningResource($rekening), 'Rekening retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rekening  $rekening
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rekening $rekening)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'nama' => 'required',
            'jenis' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $rekening->nama = $input['nama'];
        $rekening->jenis = $input['jenis'];
        $rekening->save();
     
        return $this->sendResponse(new RekeningResource($rekening), 'Rekening updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekening  $rekening
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
     
        return $this->sendResponse([], 'Rekening deleted successfully.');
    }
}
