<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Order as OrderService;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->_orderService  = $orderService;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->_orderService->getAll();
    }

    /**
    * Store a newly created resource in order.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request)
    {
        $v = $this->_orderService->validator($request->all());
        if ($v->fails())
        {
            return response()->json($v->errors(), 400);
        }
        
        $this->_orderService->create($request->all());
        return response()->json("Order Created", 200);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        return $this->_orderService->get($id);
    }
}
