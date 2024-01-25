<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Car extends JsonResource
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
        $rate = ($this->price - $this->price_offer) * 100 / $this->price;

        return [
            'id' => $this->id,
            'brand' => Brand::make($this->brand),
            'model' => Model::make($this->model),
            'status' => $this->car_status ? $this->car_status->name : '',
            'price' => round((double)$this->price, 2),
            'price_offer' => round((double)$this->price_offer, 2),
            'rate' => round((double)$rate, 2),
            'title' => $this->title,
            'slug' => $this->slug,
            'name' => $this->name,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'facebook' => $this->facebook,
            'engine' => $this->engine,
            'fuel' => Fuel::collection($this->fuel),
            'transmission' => Transmission::collection($this->transmissions),
            'speed' => $this->speed,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'specs' => $this->specs,
            'doors' => $this->doors,
            'seats' => $this->seats,
            'drive' => $this->drive,
            'source' => $this->source,
            'description' => $this->description,
            'exterior_features' => ExteriorFeature::collection($this->exterior_features),
            'security_environments' => SecurityEnvironment::collection($this->security_environments),
            'interior_designs' => InteriorDesign::collection($this->interior_designs),
            'other_show_room' => $this->other_show_room,
            'popular' => $this->popular,
            'export' => $this->export,
            'interior_images' => getImagesURL($this->interior_images),
            'exterior_images' => getImagesURL($this->exterior_images),
            'videos' => getFilesURL($this->videos),
            'car_front_picture' => getImageURL($this->car_front_picture),
            'car_back_picture' => getImageURL($this->car_back_picture),
            'car_object' => $this->car_object,
            'car_colors' => CarColor::collection($this->car_colors),
            'similar_cars' => CarBref::collection(\App\Models\Car::where([
                'brand_id' => $this->brand_id
            ])->skip(0)->take(8)->get())
        ];
    }
}
