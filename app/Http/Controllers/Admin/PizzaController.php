<?php

namespace App\Http\Controllers\Admin;


use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    //direct pizza page
    public function pizza () {
        $data = Pizza::paginate(7);

        if (count($data) == 0) {
           $emptyStatus = 0;
        }else{
          $emptyStatus = 1;
        }

      return view ('admin.pizza.list')->with(['pizza'=>$data, 'status' => $emptyStatus]);
  }

  //direct create pizza page
  public function createPizza () {
     $category = Category::get();
      return view('admin.pizza.create')->with(['category'=>$category]);
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
        'description' => 'required',
    ]);
    if ($validator->fails()) {
        return back()
                    ->withErrors($validator)
                    ->withInput();
    } 

    $file = $request->file('image');
    $fileName = uniqid().'_'.$file->getClientOriginalName();
    $file->move(public_path().'/uploads/',$fileName);

    $data = $this->requestPizzaData($request,$fileName);
    Pizza::create($data);
    return redirect()->route('admin#pizza')->with(['createSuccess' => 'Pizza Created!']);
  }


   //delete pizza
   public function deletePizza ($id) {
     $data = Pizza::select('image')->where('pizza_id',$id)->first();
     $fileName = $data['image'];
    Pizza::where('pizza_id',$id)->delete();  //dd deleate

    //project deleate
    if(File::exists(public_path().'/uploads/'.$fileName));
       File::delete(public_path().'/uploads/'.$fileName);
    return back()->with(['deleteSuccess'=>'Deleate Success']);
}
 

  //insert pizza request data
  private function requestPizzaData($request,$fileName) {

    return[
          
        'pizza_name' => $request->name,
        'image' => $fileName,
        'price' => $request->price,
        'publish_status' => $request->publish,
        'category_id' => $request->category,
        'discount_price' => $request->discount,
        'buy_one_get_one_status'=> $request->BuyOneGetOne,
        'waiting_time' => $request->waitingTime,
        'description' => $request->description,
      
    ];
  }

}
