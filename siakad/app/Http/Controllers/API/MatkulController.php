<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
// use File;
use Illuminate\Support\Facades\DB;
use App\Models\Matkul;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Matkul as MatkulResource;

class MatkulController extends BaseController
{
    public function index() {
        // $matkul = Matkul::join('jurusan', 'jurusan_id', '=', 'jurusan.id_jurusan')
        // ->get();

        $matkul = Matkul::with('jurusan')->get();
        // $matkul = Matkul::all();
        return $this->sendResponse(MatkulResource::collection($matkul), 'Berhasil Menampilkan Keseluruhan Data Mata Kuliah');
    }

    public function store(Request $request) {

        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_mata_kuliah' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        // // $input['jurusan_id'] = json_encode($request->jurusan_id);
        // $input['jurusan_id'] = implode(",",$request->jurusan_id);
        // $input['jurusan_id'] = explode(",",$request->jurusan_id);
        // $input['jurusan2_id'] = implode(",",$request->jurusan2_id);
        // $input['jurusan4_id'] = implode(",",$request->jurusan4_id);

        // $matkul = Matkul::join('jurusan', 'jurusan1_id', '=', 'jurusan.id_jurusan')
        // ->get(['matkul.*', 'jurusan.nama_jurusan']);

        // $x ;
        // foreach ($matkul->id_jurusan as $val) {
        //     $x .= $val .",";
        // }


        $matkul = Matkul::create($input);
        return $this->sendResponse(new MatkulResource($matkul), 'Data Berhasil Disimpan');

    }

    public function show($id){
        $matkul = Matkul::find($id);
        if (is_null($matkul)) {
            return $this->sendError('Data Tidak Ada');
        }
        return $this->sendResponse(new MatkulResource($matkul), 'Data Ditampilkan');
    }

    public function update(Request $request, $id) {
        $matkul = $request->all();

        $validator = Validator::make($matkul, [
            'nama_mata_kuliah' => 'required'
        ]);

        $matkul = Matkul::find($id);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        // $matkul['jurusan_id'] = json_encode($request->jurusan_id);
        // $matkul['jurusan_id'] = json_decode($request->jurusan_id);
        // $matkul['jurusan_id'] = str_replace('"', "", $request->jurusan_id);
        $matkul['jurusan_id'] = implode("",$request->jurusan_id);
        // $matkul['jurusan_id'] = explode(" ",$request->jurusan_id);
        

        $matkul->nama_mata_kuliah = $request->nama_mata_kuliah;
        // $matkul->jurusan_id    = $request->jurusan_id;
        $matkul->save();

        // $mahasiswa->update($request->all());
        return $this->sendResponse(new MatkulResource($matkul), 'Data Terupdate');
    }

    public function destroy($id) {

       $matkul = Matkul::find($id);

        $matkul->delete();
        return $this->sendResponse([], 'Data Dihapus');
    }

    public function search($keyword) {
        $result = Matkul::where('nama_mata_kuliah', 'LIKE', '%'.$keyword.'%')->get();

        if (count($result)) {
            return $this->sendResponse($result, 'Pencarian Sukses');
        }else{
            return $this->sendError([], 'Pencarian Tidak Ditemukan');
        }
    }
}
