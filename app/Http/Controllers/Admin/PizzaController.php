<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    //direct pizza page
    public function pizza () {
        $data = Pizza::paginate(7);
      return view ('admin.pizza.list')->with(['pizza' => $data]);
  }

  //direct create pizza page
  public function createPizza () {
     $category = Category::get();
      return view('admin.pizza.create')->with(['category'=>$category]);
  }


   //delete pizza
   public function deleatePizza ($id) {
      Pizza::where('pizza_id',$id)->delete();
      return back()->with(['deleteSuccess'=>'Deleate Success']);
  }


  //insert [pizza]
  public function insertPizza (Request $request) {

      $validator = Validator::make($request->all(), [
          'name' =>'required',
          'image' =>'required',
          'price' => 'required',
          'publish' => 'required',
          'category' => 'required',
          'discount' => 'required',
          'BuyOneGetOne'=> 'required',
          'waitingTime' => 'required',
          '>description' => 'required',
      ]);
      if ($validator->fails()) {
          return back()
                      ->withErrors($validator)
                      ->withInput();
      }
      // dd($request->all());
     $data = $this->requestPizzaData($request);
     Pizza::create($data);
     return view('admin.pizza.list')->with(['createSuccess' => 'Pizza Created!']);
  }

 

  //insert pizza request data
  private function requestPizzaData($request) {

      return[
          
          'pizza_name' => $request->name,
          'image' => $request->image,
          'price' => $request->price,
          'pubilc_status' => $request->publish,
          'category_id' => $request->category,
          'discount_price' => $request->discount,
          'buy_one_get_one_status'=> $request->BuyOneGetOne,
          'waiting_time' => $request->waitingTime,
          'description' => $request->description,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
      ];
  }

}
