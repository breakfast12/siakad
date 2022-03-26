<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use File;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Mahasiswa as MahasiswaResource;

class MahasiswaController extends BaseController
{
    public function index() {
        $mahasiswa = Mahasiswa::all();
        return $this->sendResponse(MahasiswaResource::collection($mahasiswa), 'Berhasil Menampilkan Keseluruhan Data Mahasiswa');
    }

    public function store(Request $request) {

        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_mahasiswa' => 'required',
            'nim'   => 'required',
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

        $mahasiswa = Mahasiswa::create($input);
        return $this->sendResponse(new MahasiswaResource($mahasiswa), 'Data Berhasil Disimpan');

    }

    public function show($id){
        $mahasiswa = Mahasiswa::find($id);
        if (is_null($mahasiswa)) {
            return $this->sendError('Data Tidak Ada');
        }
        return $this->sendResponse(new MahasiswaResource($mahasiswa), 'Data Ditampilkan');
    }

    public function update(Request $request, $id) {
        $mahasiswa = $request->all();

        $validator = Validator::make($mahasiswa, [
            'nama_mahasiswa' => 'required',
            'nim'   => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'images' => 'image|file|max:2048'
        ]);

        $mahasiswa = Mahasiswa::find($id);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }


        $destination = 'storage/foto/' . $mahasiswa->images;
        if ($request->hasFile('images')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $image = $request->file('images');
            $filename = 'photo-'.date('d-m-Y').'-'.rand().'.'.$image->getClientOriginalExtension();
            $request->file('images')->storeAs('foto/',$filename);
            $mahasiswa->images = $filename;
        }else{
            $filename = $request->images;
        }

        
        

        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->nim            = $request->nim;
        $mahasiswa->tempat_lahir   = $request->tempat_lahir;
        $mahasiswa->tanggal_lahir   = $request->tanggal_lahir;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->save();

        // $mahasiswa->update($request->all());
        return $this->sendResponse(new MahasiswaResource($mahasiswa), 'Data Terupdate');
    }

    public function destroy($id) {

       $mahasiswa = Mahasiswa::find($id);

       $destination = 'storage/foto/' . $mahasiswa->images;
       if (File::exists($destination)) {
           File::delete($destination);       
        }

        $mahasiswa->delete();
        return $this->sendResponse([], 'Data Dihapus');
    }

    public function search($keyword) {
        $result = Mahasiswa::where('nama_mahasiswa', 'LIKE', '%'.$keyword.'%')->get();

        if (count($result)) {
            return $this->sendResponse($result, 'Pencarian Sukses');
        }else{
            return $this->sendError([], 'Pencarian Tidak Ditemukan');
        }
    }
}
