<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Jurusan as JurusanResource;

class Matkul extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id_matkul,
            'nama_mata_kuliah' => $this->nama_mata_kuliah,
            'jurusan' => JurusanResource::make($this->jurusan),
            // 'jurusan' => [
            //    'id' => $this->jurusan_id,
            //    'nama_jurusan' => $this->jurusan->nama_jurusan
            // ],
            'created_at' => $this->created_at->format('m/d//Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    //     $data = collect([]);
    //     return [
    //         'data' => $this->collection->map(function($data){
    //             return [
    //                 'id'    => $data->id_matkul,
    //                 'nama_mata_kuliah' => $data->nama_mata_kuliah,
    //                 'created_at' => $data->created_at->format('m/d//Y'),
    //                 'updated_at' => $data->updated_at->format('m/d/Y'),
    //             ];
    //         })
    //     ];
    }

    // public function with($request) {
    //     return [
    //         'success' => true,
    //         'status' => 200
    //     ];
    // }
}
