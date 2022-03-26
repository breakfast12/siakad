<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Matkul as MatkulResource;

class Dosen extends JsonResource
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
            'id'    => $this->id_dosen,
            'matkul' => MatkulResource::make($this->matkul),
            'nama_dosen' => $this->nama_dosen,
            'nip'   => $this->nip,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'images' => $this->images,
            'created_at' => $this->created_at->format('m/d//Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
