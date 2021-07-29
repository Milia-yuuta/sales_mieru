<?php
namespace App\UseCases\Prospect;

use App\Models\ProspectFavorite;
use Auth;

class PinAction
{
    public function __invoke($request)
    {
        if (ProspectFavorite::query()->where('prospect_id',$request->pinReviewId)->get()->isNotEmpty()){
            return response()->json();
        }
        $propertyFavoriteInstance =new ProspectFavorite;
        $propertyFavoriteInstance->fill(['prospect_id' => $request->pinReviewId ,'user_id' => Auth::user()->id])->save();
        return $propertyFavoriteInstance;
    }
}