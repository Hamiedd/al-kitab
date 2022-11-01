<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParagraphResource extends JsonResource
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
            'id' => $this->id,
            'text' => $this->when(empty($this->getTranslations('text')),'{}',$this->getTranslations('text')),
            'start_from' => $this->when(empty($this->getTranslations('start_from')),'{}',$this->getTranslations('start_from')),
            'end_at' => $this->when(empty($this->getTranslations('end_at')),'{}',$this->getTranslations('end_at')),
            'content_id' => $this->content_id
        ];
    }
}
