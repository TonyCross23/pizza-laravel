<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
   

  
    //direct category page
    public function category () {
        $data = Category::select('categories.*', DB::raw('COUNT(pizzas.category_id) as count'))
                ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                ->groupBy('categories.category_id')
                ->paginate(7);
       
        return view ('admin.category.list')->with(['category'=>$data]);
    }

    //add category
    public function addCategory () {
        return view ('admin.category.addCategory');
    }

    // add => create category page
    public function createCategory (Request $request) {
        //validation message 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = [
            'category_name' => $request->name
        ];
        Category::create($data);
        return redirect()->route('admin#category')->with(['categorySuccess'=>"Category Added."]);
    }

    //delete Category
    public function deleteCategory ($id) {
        Category::where('category_id',$id)->delete();
        return back()->with(['deleteSuccess' => "Category Deleted!"]);
    }

    //update category(editCategory)
    public function editCategory ($id) {
        $data = Category::where('category_id',$id)->first();
        return view('admin.category.Update')->with(['category'=>$data]);
    }

    //edit to update category
    public function updateCategory (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $updateData = [
            'category_name' => $request->name
        ];

        Category::where('category_id',$request->id)->update($updateData);
        return redirect()->route('admin#category')->with(['updateSuccess'=>'Category Updated!']);
        
    }


    //searchCategory
    public function searchCategory (Request $request) {
        // dd($request->searchData);
         $data = Category::where('category_name','like','%'.$request->searchData.'%')->paginate(7);
         $data->appends($request->all());
        return view('admin.category.list')->with(['category'=>$data]);
    }



  
}
