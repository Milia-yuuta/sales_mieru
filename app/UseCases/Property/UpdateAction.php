<?php


namespace App\UseCases\Property;
use App\Models\Property;

class UpdateAction
{
    public function __invoke($request)
    {
        $property_instance = Property::find($request->property_id);
        $property_instance->client_id = $request->input('client_id');
        $property_instance->save();
    }

}