<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
// use Validator;
// use File;
// use Response;
use App\Models\Matkul;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
// use App\Http\Resources\Jurusan as JurusanResource;

class MatkulcomboController extends BaseController
{
    public function combo(Request $request) {

        if ($request->has('q')) {
            $search = $request->q;
            $query = DB::table('matkul')
            ->leftJoin('jurusan', 'matkul.jurusan_id', '=', 'jurusan.id_jurusan')
            ->select('matkul.id_matkul as id',
                    DB::raw('CONCAT(matkul.nama_mata_kuliah, " - ", jurusan.nama_jurusan) as text'))
            ->where('matkul.nama_mata_kuliah', 'like', '%'.$search.'%')
            // ->orWhere('jurusan.nama_jurusan', 'like', '%'.$param['q'].'%')
            ->get();

            $response = array();
            foreach($query as $matkul){
                $response[] = array(
                    'id' => $matkul->id,
                    'text' => $matkul->text
                );
            }
        }else{
            $query = DB::table('matkul')
            ->leftJoin('jurusan', 'matkul.jurusan_id', '=', 'jurusan.id_jurusan')
            ->select('matkul.id_matkul as id',
                    DB::raw('CONCAT(matkul.nama_mata_kuliah, " - ", jurusan.nama_jurusan) as text'))
            ->get();

            $response = array();
            foreach($query as $matkul){
                $response[] = array(
                    'id' => $matkul->id,
                    'text' => $matkul->text
                );
            }
        }
        
        // return response()->json($response);
        return $this->sendResponse($response, 'Sukses');   
    }
}
