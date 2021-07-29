<?php


namespace App\UseCases\Property;
use App\Models\Property;

class SearchByCodeAction
{
    public function __invoke($property_id)
    {
        return Property::find($property_id)->property_name;
    }
}