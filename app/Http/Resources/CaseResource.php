<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->_id,
            "date" => $this->date,
            "new_confirmed" => $this->new_confirmed,
            "acc_confirmed" => $this->acc_confirmed,
            "acc_negative" => $this->acc_negative,
            "positive_rate" => $this->positive_rate,
        ];
    }
}
