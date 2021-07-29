<?php


namespace App\UseCases\Prospect;
use App\Models\Prospect;

class DeleteAction
{
    public function __invoke($id): ?bool
    {
        return Prospect::find($id)->delete();
    }
}