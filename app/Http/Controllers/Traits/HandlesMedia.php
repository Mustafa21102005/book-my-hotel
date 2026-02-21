<?php

namespace App\Http\Controllers\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HandlesMedia
{
    /**
     * Delete the specified media.
     *
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMedia(Media $media)
    {
        $media->delete();

        return response()->json(['success' => true]);
    }
}
