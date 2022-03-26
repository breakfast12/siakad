<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
// use Validator;
// use File;
use Response;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
// use App\Http\Resources\Jurusan as JurusanResource;

class JurusancomboController extends BaseController
{
    public function combo() {
        $query = DB::table('jurusan')
        ->select('id_jurusan as id',
                'nama_jurusan as text')
        ->get();
        
        $response = array();
        foreach($query as $jrsn){
            $response[] = array(
                'id' => $jrsn->id,
                'text' => $jrsn->text
            );
        }
        // return response()->json($response);
        return $this->sendResponse($response, 'Sukses');   
    }
}
