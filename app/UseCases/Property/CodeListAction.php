<?php


namespace App\UseCases\Property;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;

class CodeListAction
{
    public function __invoke($request)
    {
        return (new Property)->PropertyCodeListSelect2;
    }

}