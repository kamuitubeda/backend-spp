<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Kelas;
use Validator;
use App\Http\Resources\KelasResource;

class KelasController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all();
      
        return $this->sendResponse(KelasResource::collection($kelas), 'Kelas retrieved successfully.');
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
            'nama' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $kela = Kelas::create($input);
     
        return $this->sendResponse(new KelasResource($kela), 'Kelas created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kela
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kela)
    {
        $kela = Kelas::find($id);
    
        if (is_null($kela)) {
            return $this->sendError('Kelas not found.');
        }
     
        return $this->sendResponse(new KelasResource($kela), 'Kelas retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kela
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kela)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'nama' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $kela->nama = $input['nama'];
        $kela->kode = $input['kode'];
        $kela->alamat = $input['alamat'];
        $kela->website = $input['website'];
        $kela->telepon = $input['telepon'];
        $kela->save();
     
        return $this->sendResponse(new KelasResource($kela), 'Kelas updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kela
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();
     
        return $this->sendResponse([], 'Kelas deleted successfully.');
    }
}
