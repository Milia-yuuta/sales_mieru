<?php


namespace App\UseCases\Prospect;


use App\Models\ProspectFavorite;

class PinDeleteActon
{
    public function __invoke($request)
    {
        $id = ProspectFavorite::find($request->pinReviewId)->prospect_id;
        ProspectFavorite::destroy($request->pinReviewId);
        return $id;
    }
}