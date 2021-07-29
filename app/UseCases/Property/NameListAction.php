<?php


namespace App\UseCases\Property;
use App\Models\Property;

class NameListAction
{
    public function __invoke($request):array
    {
        return (new Property)->PropertyNameListSelect2;
    }
}