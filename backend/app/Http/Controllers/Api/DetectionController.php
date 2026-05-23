<?php

namespace App\Http\Controllers\Api;

use App\Enums\Severity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetectionRequest;
use App\Http\Resources\DetectionResource;
use App\Models\Detection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class DetectionController extends Controller
{
    /**
     * Paginated detection history for the authenticated user (newest first).
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $detections = $request->user()
            ->detections()
            ->paginate(15);

        return DetectionResource::collection($detections);
    }

    /**
     * Store a new (dummy) detection result for the authenticated user.
     */
    public function store(StoreDetectionRequest $request): DetectionResource
    {
        $data = $request->validated();

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('detections', 'public')
            : null;

        $detection = $request->user()->detections()->create([
            'disease_name' => $data['disease_name'],
            'severity' => $data['severity'] ?? Severity::Mild->value,
            'confidence' => $data['confidence'] ?? 0,
            'detected_area' => $data['detected_area'] ?? null,
            'image_path' => $imagePath,
            'notes' => $data['notes'] ?? null,
            'detected_at' => now(),
        ]);

        return new DetectionResource($detection);
    }

    /**
     * Show a single detection (only the owner may view it).
     */
    public function show(Detection $detection): DetectionResource
    {
        Gate::authorize('view', $detection);

        return new DetectionResource($detection);
    }

    /**
     * Delete a detection (only the owner may delete it).
     */
    public function destroy(Detection $detection): Response
    {
        Gate::authorize('delete', $detection);

        $detection->delete();

        return response()->noContent();
    }
}
