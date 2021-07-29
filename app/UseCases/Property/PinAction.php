<?php
namespace App\UseCases\Property;

use App\Models\PropertyFavorite;
use Auth;

class PinAction
{
    public function __invoke($request)
    {
//        if (PropertyFavorite::query()->where('property_id',$request->pinReviewId)->get()->isNotEmpty()){
//            return response()->json();
//        }
        $propertyFavoriteInstance =new PropertyFavorite;
        $propertyFavoriteInstance->fill(['property_id' => $request->pinReviewId ,'user_id' => Auth::user()->id])->save();
        return $propertyFavoriteInstance;
    }
}