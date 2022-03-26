<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use File;
use App\Models\Dosen;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Dosen as DosenResource;

class DosenController extends BaseController
{
    public function index() {
        $dosen = Dosen::with('matkul')->get();
        return $this->sendResponse(DosenResource::collection($dosen), 'Berhasil Menampilkan Keseluruhan Data Dosen');
    }

    public function store(Request $request) {

        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_dosen' => 'required',
            'nip'   => 'required',
            'matkul_id'   => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'images' => 'required|image|file|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $image = $request->file('images');
            $new_image = 'photo-'.date('d-m-Y').'-'.rand().'.'.$image->getClientOriginalExtension();

            $request->file('images')->storeAs('foto/',$new_image);
            
            $input['images'] = $new_image;
            $input['matkul_id'] = implode("",$request->matkul_id);

        $dosen = Dosen::create($input);
        return $this->sendResponse(new DosenResource($dosen), 'Data Berhasil Disimpan');

    }

    public function show($id){
        $dosen = Dosen::find($id);
        if (is_null($dosen)) {
            return $this->sendError('Data Tidak Ada');
        }
        return $this->sendResponse(new DosenResource($dosen), 'Data Ditampilkan');
    }

    public function update(Request $request, $id) {
        $dosen = $request->all();

        $validator = Validator::make($dosen, [
            'nama_dosen' => 'required',
            'nip'   => 'required',
            'matkul_id'   => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'images' => 'image|file|max:2048'
        ]);

        $dosen = Dosen::find($id);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }


        $destination = 'storage/foto/' . $dosen->images;
        if ($request->hasFile('images')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $image = $request->file('images');
            $filename = 'photo-'.date('d-m-Y').'-'.rand().'.'.$image->getClientOriginalExtension();
            $request->file('images')->storeAs('foto/',$filename);
            $dosen->images = $filename;
        }else{
            $filename = $request->images;
        }

        $dosen['matkul_id'] = implode("",$request->matkul_id);

        $dosen->nama_dosen = $request->nama_dosen;
        $dosen->nip            = $request->nip;
        $dosen->tempat_lahir   = $request->tempat_lahir;
        $dosen->tanggal_lahir   = $request->tanggal_lahir;
        $dosen->jenis_kelamin = $request->jenis_kelamin;
        $dosen->save();

        // $mahasiswa->update($request->all());
        return $this->sendResponse(new DosenResource($dosen), 'Data Terupdate');
    }

    public function destroy($id) {

       $dosen = Dosen::find($id);

       $destination = 'storage/foto/' . $dosen->images;
       if (File::exists($destination)) {
           File::delete($destination);       
        }

        $mahasiswa->delete();
        return $this->sendResponse([], 'Data Dihapus');
    }

    public function search($keyword) {
        $result = Dosen::where('nama_dosen', 'LIKE', '%'.$keyword.'%')->get();

        if (count($result)) {
            return $this->sendResponse($result, 'Pencarian Sukses');
        }else{
            return $this->sendError([], 'Pencarian Tidak Ditemukan');
        }
    }
}
