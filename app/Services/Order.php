<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Order  as OrderModel;
use App\OrderDetail  as OrderDetailModel;
use App\OrderContact as OrderContactModel;


use App\Services\Pizza as PizzaService;
use App\Services\Size as SizeService;
use App\Services\Parameter as ParameterService;

class Order
{
    function __construct(PizzaService $pizzaService, SizeService $sizeService, ParameterService $parameterService) {
        $this->pizza = $pizzaService->getAll();
        $this->size = $sizeService->getAll();
        $this->deliveryCost = (double)$parameterService->get("deliveryCost")->value;
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
            'order.orderContact.fullName' => 'required|string|max:100',
            'order.orderContact.phoneNumber' => 'required|string|max:50',
            'order.orderContact.fullAddress' => 'required|string|max:100',
            'order.orderContact.zipCode' => 'required|string|max:50',
            'order.orderDetail.*.idPizza' => 'required|numeric|gt:0',
            'order.orderDetail.*.idSize' => 'required|numeric|gt:0',
            'order.orderDetail.*.quantity' => 'required|numeric|gt:0'
        ];

        $messages=[
            'order.orderContact.fullName' => 'Name is required!',
            'order.orderContact.phoneNumber' => 'Name is required!',
            'order.orderContact.fullAddress' => 'Address is required!',
            'order.orderContact.zipCode' => 'Address is required!',
            'order.orderDetail.*.idPizza' => 'Pizza is required!',
            'order.orderDetail.*.idSize' => 'Size is required!',
            'order.orderDetail.*.quantity' => 'Quantity is required!',
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function getAll()
    {
        return OrderModel::with('orderContact','orderDetails')->get();
    }

    public function get($id)
    {
        return OrderModel::with('orderContact','orderDetails')
        ->where('id', $id)
        ->get();
    }

    /**
     * Create a new contact instance after a valid form.
     *
     * @param  array $data
     * @return ContactModel
     */
    public function create(array $request)
    {
        try{
            DB::beginTransaction();
            
            $order = new OrderModel;
            $order->datetime = date("Y-m-d-H:i:s");
            $order->ship_price = $this->deliveryCost;
            $order->total = $this->calculateTotalPriceOrder($request);
            $order->save();

            
            for ($i = 0; $i < count($request["order"]["orderDetail"]); $i++) 
            {
                    $itemElement = new OrderDetailModel;
                    $itemElement->order_id= $order->id;
                    $itemElement->pizza_id=$request["order"]["orderDetail"][$i]["idPizza"];
                    $itemElement->size_id=$request["order"]["orderDetail"][$i]["idSize"];
                    $itemElement->quantity=$request["order"]["orderDetail"][$i]["quantity"];

                    $price=$this->calculatePrice($itemElement->pizza_id, $itemElement->size_id);
                    $totalPrice=$price * $itemElement->quantity;

                    $itemElement->single_price=$price;
                    $itemElement->total_price=$totalPrice;
                    $itemElement->save();
                }

            $orderContact = new OrderContactModel;
            $orderContact->order_id= $order->id;
            $orderContact->full_name = $request["order"]["orderContact"]["fullName"];
            $orderContact->phone_number = $request["order"]["orderContact"]["phoneNumber"];
            $orderContact->full_address = $request["order"]["orderContact"]["fullAddress"];
            $orderContact->zip_code = $request["order"]["orderContact"]["zipCode"];
            $orderContact->save();

            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            throw $ex;
        }
    }

    function calculatePrice($pizzaId, $sizeId)
    {
        $pizzaPrice=$this->pizza->find($pizzaId)->price;
        $sizePrice=$this->size->find($sizeId)->price;
        
        return $pizzaPrice + $sizePrice;
    }

    function calculateTotalPriceOrder($request)
    {
        $totalPriceOrder=$this->deliveryCost;
        for ($i = 0; $i < count($request["order"]["orderDetail"]); $i++) 
        {
            $pizza_id=$request["order"]["orderDetail"][$i]["idPizza"];
            $size_id=$request["order"]["orderDetail"][$i]["idSize"];
            $quantity=$request["order"]["orderDetail"][$i]["quantity"];

            $price=$this->calculatePrice($pizza_id, $size_id);
            $subTotalPrice=$price * $quantity;
            $totalPriceOrder=$totalPriceOrder + $subTotalPrice;
        }

        return $totalPriceOrder;
    }
}