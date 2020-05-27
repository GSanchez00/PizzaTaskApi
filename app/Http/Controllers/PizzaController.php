<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\Pizza as PizzaService;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
   public function __construct(PizzaService $pizzaService)
   {
       $this->_pizzaService  = $pizzaService;
   }

   public function index()
   {
       return $this->_pizzaService->getAll();
   }

    /**Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $v = $this->_pizzaService->validator($request->all());
         if ($v->fails())
         {
            return response()->json($v->errors(), 400);
         }
         return $this->_pizzaService->create($request);
    }

     /*Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
         return $this->_pizzaService->get($id);
     }

     /*Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
     {
      return $this->_pizzaService->update($request);
        
     }

    /*Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
      return $this->_pizzaService->delete($id);
     }
}

