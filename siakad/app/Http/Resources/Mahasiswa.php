<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Mahasiswa extends JsonResource
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
            'id'    => $this->id,
            'nama_mahasiswa' => $this->nama_mahasiswa,
            'nim'   => $this->nim,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'images' => $this->images,
            'created_at' => $this->created_at->format('m/d//Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
