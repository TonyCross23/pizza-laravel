<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
   

    //direct admin profile
    public function profile() {
        $id = auth()->user()->id;
        $userData = User::where ('id',$id)->first();
       
        return view ('admin.profile.index')->with(['user' => $userData]);
    }
  
    //direct category page
    public function category () {

        $data = Category::paginate(7);
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

    //deleate Category
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
        return view('admin.category.list')->with(['category'=>$data]);
    }



  
}
