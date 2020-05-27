<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pizza as PizzaModel;


class Pizza
{
    public function getAll()
    {
       $pizzas = PizzaModel::all();
       return $pizzas;
    }

    public function create(Request $request)
    {
       $pizza = new PizzaModel;
       $pizza->name = $request->name;
       $pizza->price = $request->price;
       $pizza->save();
    }

    public function get($id){
        return PizzaModel::where('id', $id)->get();
    }

    public function update($request)
    {
        $pizza = PizzaModel::findOrFail($request->id);
        $pizza->name = $request->name;
        $pizza->save();
        return $pizza;
    }

    public function delete($id)
    {
        $pizza = PizzaModel::destroy($id);
        return $pizza;
    }

    /**
     * Get a validator for a order.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $rules=[
            'name' => 'required|string|max:100',
            'price' => 'required|max:11|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/'
        ];

        $messages=[
            'name' => 'Name is required!',
            'price' => 'Price is required!'
        ];

        return Validator::make($data, $rules, $messages);
    }
}