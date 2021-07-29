<?php
namespace App\UseCases\Property;

use App\Models\Property;

class StoreAction
{
    public function __invoke($request)
    {
        $property_instance =new Property;
        $property_instance->fill($request->all())->save();
    }
}