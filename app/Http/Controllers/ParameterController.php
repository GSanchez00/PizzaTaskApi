<?php

namespace App\Http\Controllers;
use App\Services\Parameter as ParameterService;
use App\Http\Controllers\Controller;

class ParameterController extends Controller
{
    public function __construct(ParameterService $parameterService)
    {
        $this->_parameterService  = $parameterService;
    }

    public function index()
    {
        return $this->_parameterService->getAll();
    }
}
