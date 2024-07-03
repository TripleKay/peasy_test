<?php

namespace App\Http\Resources\DailyRecord;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyRecordListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'date'           => $this->date,
            'male_count'     => $this->male_count,
            'female_count'   => $this->female_count,
            'male_avg_age'   => $this->male_avg_age,
            'female_avg_age' => $this->female_avg_age,
        ];
    }
}
