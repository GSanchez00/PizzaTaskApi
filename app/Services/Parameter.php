<?php
namespace App\Services;

use App\Parameter as ParameterModel;


class Parameter
{
    public function getAll()
    {
       $parameters = ParameterModel::all();
       return $parameters;
    }
    
    public function get(string $parameter)
    {
       return ParameterModel::where('name', $parameter)->get()->first();
    }
}