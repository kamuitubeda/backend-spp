<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Penagihan;
use Validator;
use App\Http\Resources\PenagihanResource;
use Illuminate\Http\Request;

class PenagihanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penagihan = Penagihan::all();
      
        return $this->sendResponse(PenagihanResource::collection($penagihan), 'Penagihan retrieved successfully.');
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
     
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
     
        $penagihan = Penagihan::create($input);
     
        return $this->sendResponse(new PenagihanResource($penagihan), 'Penagihan created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penagihan  $penagihan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penagihan = Penagihan::find($id);
    
        if (is_null($penagihan)) {
            return $this->sendError('Penagihan not found.');
        }
     
        return $this->sendResponse(new PenagihanResource($penagihan), 'Penagihan retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penagihan  $penagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $penagihan = Rekening::findOrFail($id);
     
        $validator = Validator::make($input, [
            'rekening_id' => 'required'
        ]);
     
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
     
        $penagihan->rekening_id = $input['rekening_id'];
        $penagihan->kelas_id = $input['kelas_id'];
        $penagihan->save();
     
        return $this->sendResponse(new PenagihanResource($penagihan), 'Penagihan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penagihan  $penagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rincian = Penagihan::findOrFail($id);
        $rincian->delete();
     
        return $this->sendResponse([], 'Penagihan deleted successfully.');
    }

    public function removeByRekeningIdAndKelas($rekeningId, $kelasId)
    {
        Penagihan::where('rekening_id', $rekeningId)->where('kelas_id', $kelasId)->delete();

        return $this->sendResponse([], 'Penagihan deleted successfully.');
    }
}
