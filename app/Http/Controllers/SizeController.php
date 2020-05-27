<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\Size as SizeService;

class SizeController extends Controller
{
    public function __construct(SizeService $sizeService)
    {
        $this->_sizeService  = $sizeService;
    }

    public function index()
    {
        return $this->_sizeService->getAll();
    }
}
