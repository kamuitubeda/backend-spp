<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Pegawai;
use Validator;
use App\Http\Resources\SantriResource;
use Illuminate\Http\Request;

class PegawaiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::all();
      
        return $this->sendResponse(PegawaiResource::collection($pegawai), 'Pegawai retrieved successfully.');
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
            'aktif' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $pegawai = Pegawai::create($input);
     
        return $this->sendResponse(new PegawaiResource($pegawai), 'Pegawai created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pegawai = Pegawai::find($id);
    
        if (is_null($pegawai)) {
            return $this->sendError('Pegawai not found.');
        }
     
        return $this->sendResponse(new PegawaiResource($pegawai), 'Pegawai retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'nama' => 'required',
            'aktif' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $pegawai->nama = $input['nama'];
        $pegawai->jabatan = $input['jabatan'];
        $pegawai->aktif = $input['aktif'];
        $pegawai->save();
     
        return $this->sendResponse(new PegawaiResource($pegawai), 'Pegawai updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
     
        return $this->sendResponse([], 'Pegawai deleted successfully.');
    }
}
