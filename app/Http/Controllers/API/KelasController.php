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
     
        $kelas = Kelas::create($input);
     
        return $this->sendResponse(new KelasResource($kelas), 'Kelas created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::find($id);
    
        if (is_null($kelas)) {
            return $this->sendError('Kelas not found.');
        }
     
        return $this->sendResponse(new KelasResource($kelas), 'Kelas retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kela
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'jenjang' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $kelas->jenjang = $input['jenjang'];
        $kelas->ruang = $input['ruang'];
        $kelas->nama = $input['nama'];
        $kelas->save();
     
        return $this->sendResponse(new KelasResource($kelas), 'Kelas updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
     
        return $this->sendResponse([], 'Kelas deleted successfully.');
    }
}
