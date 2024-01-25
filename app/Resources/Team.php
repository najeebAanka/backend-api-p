<?php

namespace App\Resources;

use App\Model\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => getImageURL($this->image),
            'description' => $this->description
        ];
    }

}
