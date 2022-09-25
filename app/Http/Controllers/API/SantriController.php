<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
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
        $santri = Santri::find($id);
    
        if (is_null($santri)) {
            return $this->sendError('Santri not found.');
        }
     
        return $this->sendResponse(new SantriResource($santri), 'Santri retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Santri $santri)
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
     
        $santri->nomor_induk = $input['nomor_induk'];
        $santri->nama = $input['nama'];
        $santri->alamat = $input['alamat'];
        $santri->telepon = $input['telepon'];
        $santri->nama_wali = $input['nama_wali'];
        $santri->aktif = $input['aktif'];
        $santri->kelas_id = $input['kelas_id'];
        $santri->save();
     
        return $this->sendResponse(new SantriResource($santri), 'Santri updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Http\Response
     */
    public function destroy(Santri $santri)
    {
        $santri->delete();
     
        return $this->sendResponse([], 'Santri deleted successfully.');
    }
}
