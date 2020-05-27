<?php
namespace App\Services;

use App\Size as SizeModel;

class Size
{
    public function getAll()
    {
       $sizes = SizeModel::all();
       return $sizes;
    }
}