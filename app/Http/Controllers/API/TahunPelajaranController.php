<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunPelajaran = TahunPelajaran::all();
      
        return $this->sendResponse(TahunPelajaranResource::collection($tahunPelajaran), 'List of Tahun Pelajaran retrieved successfully.');
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
            'institusi_id' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $tahunPelajaran = TahunPelajaran::create($input);
     
        return $this->sendResponse(new TahunPelajaranResource($tahunPelajaran), 'Tahun Pelajaran created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TahunPelajaran  $tahunPelajaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tahunPelajaran = TahunPelajaran::find($id);
    
        if (is_null($tahunPelajaran)) {
            return $this->sendError('Tahun Pelajaran not found.');
        }
     
        return $this->sendResponse(new TahunPelajaranResource($tahunPelajaran), 'Tahun Pelajaran retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TahunPelajaran  $tahunPelajaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TahunPelajaran $tahunPelajaran)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'nama' => 'required',
            'institusi_id' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $tahunPelajaran->nama = $input['nama'];
        $tahunPelajaran->save();
     
        return $this->sendResponse(new TahunPelajaranResource($tahunPelajaran), 'TahunPelajaran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunPelajaran  $tahunPelajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(TahunPelajaran $tahunPelajaran)
    {
        //
    }
}
