<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DetectionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'disease_name' => $this->disease_name,
            'severity' => $this->severity?->value,
            'severity_label' => $this->severity?->label(),
            'confidence' => $this->confidence,
            'detected_area' => $this->detected_area,
            'image_url' => $this->image_path ? Storage::disk('public')->url($this->image_path) : null,
            'notes' => $this->notes,
            'detected_at' => $this->detected_at,
            'created_at' => $this->created_at,
        ];
    }
}
