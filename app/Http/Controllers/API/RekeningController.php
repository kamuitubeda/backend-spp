<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Rekening;
use Validator;
use App\Http\Resources\RekeningResource;
use Illuminate\Http\Request;

class RekeningController extends BaseController
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
        $rekening = Rekening::findOrFail($id);
    
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
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rekening = Rekening::findOrFail($id);
     
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
    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();
     
        return $this->sendResponse([], 'Rekening deleted successfully.');
    }

    public function getItemByRekening($id)
    {
        $rekening = Rekening::join('rincian_rekenings', 'rincian_rekenings.rekening_id', '=', 'rekenings.id')
                        ->join('items', 'items.id', '=', 'rincian_rekenings.item_id')
                        ->where('rekenings.id', $id)
                        ->get(['rekenings.*', 'items.nama as nama_item', 'items.harga']);

        return $this->sendResponse(new RekeningResource($rekening), 'Rekening retrieved successfully.');
    }

    public function getKelasByRekening($id)
    {
        $rekening = Rekening::join('penagihans', 'penagihans.rekening_id', '=', 'rekenings.id')
                        ->join('kelas', 'kelas.id', '=', 'penagihans.kelas_id')
                        ->where('rekenings.id', $id)
                        ->get(['rekenings.*', 'kelas.nama as nama_kelas']);

        return $this->sendResponse(new RekeningResource($rekening), 'Rekening retrieved successfully.');
    }

    public function getRekeningWithTotal()
    {
        $rekening = Rekening::select("rekenings.*")
                            ->selectRaw("ifnull(sum(items.harga),0) as total")
                            ->leftJoin('rincian_rekenings', 'rincian_rekenings.rekening_id', '=', 'rekenings.id')
                            ->leftJoin('items', 'items.id', '=', 'rincian_rekenings.item_id')
                            ->groupBy("rekenings.id")
                            ->get();

        return $this->sendResponse(new RekeningResource($rekening), 'Rekening retrieved successfully.');
    }

    public function getTotalRekening($id)
    {
        $rekening = Rekening::selectRaw("ifnull(sum(items.harga),0) as total")
                            ->leftJoin('rincian_rekenings', 'rincian_rekenings.rekening_id', '=', 'rekenings.id')
                            ->leftJoin('items', 'items.id', '=', 'rincian_rekenings.item_id')
                            ->groupBy("rekenings.id")
                            ->where("rekenings.id", $id)
                            ->first();

        return $this->sendResponse(new RekeningResource($rekening), 'Rekening retrieved successfully.');
    }
}
