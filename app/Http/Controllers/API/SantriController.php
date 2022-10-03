<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Santri;
use Validator;
use App\Http\Resources\SantriResource;

class SantriController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $santri = Santri::all();
      
        return $this->sendResponse(SantriResource::collection($santri), 'Santri retrieved successfully.');
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
            'nomor_induk' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'aktif' => 'required',
            'kelas_id' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $santri = Santri::create($input);
     
        return $this->sendResponse(new SantriResource($santri), 'Santri created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $santri = Santri::findOrFail($id);
    
        if (is_null($santri)) {
            return $this->sendError('Santri not found.');
        }
     
        return $this->sendResponse(new SantriResource($santri), 'Santri retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Santri  $kela
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $santri = Santri::findOrFail($id);
     
        $validator = Validator::make($input, [
            'nomor_induk' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'aktif' => 'required',
            'kelas_id' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $santri->jenjang = $input['jenjang'];
        $santri->ruang = $input['ruang'];
        $santri->save();
     
        return $this->sendResponse(new SantriResource($santri), 'Santri updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();
   
        return $this->sendResponse([], 'Santri Deleted Successfully.');
    }
}
