<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Jurusan extends JsonResource
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
            'id'    => $this->id_jurusan,
            'nama_jurusan' => $this->nama_jurusan,
            'created_at' => $this->created_at->format('m/d//Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
