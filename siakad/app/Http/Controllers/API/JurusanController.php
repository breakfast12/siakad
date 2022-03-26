<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
// use File;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Jurusan as JurusanResource;

class JurusanController extends BaseController
{
    public function index() {
        $jurusan = Jurusan::all();
        return $this->sendResponse(JurusanResource::collection($jurusan), 'Berhasil Menampilkan Keseluruhan Data Jurusan');
    }

    public function store(Request $request) {

        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_jurusan' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $jurusan = Jurusan::create($input);
        return $this->sendResponse(new JurusanResource($jurusan), 'Data Berhasil Disimpan');

    }

    public function show($id){
        $jurusan = Jurusan::find($id);
        if (is_null($jurusan)) {
            return $this->sendError('Data Tidak Ada');
        }
        return $this->sendResponse(new JurusanResource($jurusan), 'Data Ditampilkan');
    }

    public function update(Request $request, $id) {
        $jurusan = $request->all();

        $validator = Validator::make($jurusan, [
            'nama_jurusan' => 'required',
        ]);

        $jurusan = Jurusan::find($id);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        

        $jurusan->nama_jurusan = $request->nama_jurusan;
        $jurusan->save();

        // $mahasiswa->update($request->all());
        return $this->sendResponse(new JurusanResource($jurusan), 'Data Terupdate');
    }

    public function destroy($id) {

       $jurusan = Jurusan::find($id);

        $jurusan->delete();
        return $this->sendResponse([], 'Data Dihapus');
    }

    public function search($keyword) {
        $result = Jurusan::where('nama_jurusan', 'LIKE', '%'.$keyword.'%')->get();

        if (count($result)) {
            return $this->sendResponse($result, 'Pencarian Sukses');
        }else{
            return $this->sendError([], 'Pencarian Tidak Ditemukan');
        }
    }
}
