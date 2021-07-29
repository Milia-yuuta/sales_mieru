<?php


namespace App\UseCases\Property;

use App\Models\PropertyFavorite;

class PinDeleteAction
{
    public function __invoke($request)
    {
        $property = PropertyFavorite::find($request->pinReviewId)->property_id;
        PropertyFavorite::destroy($request->pinReviewId);
        return $property;
    }
}