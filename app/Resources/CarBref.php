<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarBref extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        if ($this->price_offer == 0) {
            $this->price_offer = $this->price;
        }
        $rate = ($this->price-$this->price_offer)*100/$this->price;

        return [
            'id' => $this->id,
            'brand' => Brand::make($this->brand),
            'interior_images' => getImagesURL($this->interior_images),
            'exterior_images' => getImagesURL($this->exterior_images),
            'status' => $this->car_status ? $this->car_status->name : '',
            'price' => round((double)$this->price,2),
            'price_offer' => round((double)$this->price_offer,2),
            'rate' => round((double)$rate,2),
            'title' => $this->title,
            'slug' => $this->slug,
            'name' => $this->name,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'facebook' => $this->facebook,
            'engine' => $this->engine,
            'fuel' => Fuel::collection($this->fuel),
            'speed' => $this->speed,
            'seats' => $this->seats,
            'description' => $this->description,
            'other_show_room' => $this->other_show_room,
            'popular' => $this->popular,
            'export' => $this->export,
        ];
    }
}
