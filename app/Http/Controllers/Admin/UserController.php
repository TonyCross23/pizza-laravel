<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\CssSelector\Node\FunctionNode;

class UserController extends Controller
{
    //direct user list page
    public function userList() {
        $userData = User::where('role','user')->paginate(7);
        return view('admin.user.userList')->with(['user' => $userData]);
    }

    //direct admin list
    public function adminList () {
        $userData = User::where('role','admin')->paginate(7);
        return view('admin.user.adminList')->with(['admin' => $userData]);
    }

    //user account Search
    public function userSearch (Request $request) {
        $response = $this->search($request->searchData,'user',$request);

        return view('admin.user.userList')->with(['user' => $response]);
    }

    //user account delete
    public function userDelete ($id) {
        User::where('id',$id)->delete();

        return back()->with(['userDelete' => 'User Account Deleted!']);
    }

    //admin search
    public function adminSearch (Request $request) {
         $response = $this->search($request->searchData,'admin',$request);
       
        return view('admin.user.adminList')->with(['admin' => $response]);
} 

   //admin account delete
   public function adminDelete ($id) {
        User::where('id',$id)->delete();
        return back()->with(['adminDelete' => 'Admin Account Deleted!']);
   }
  
    //command data searching
   private function search ($key,$role,$request) {
        $searchData = User::where('role',$role)
                          ->where(function($query) use ($request) {
                    $query->orWhere('name','like','%'.$request->searchData.'%')
                          ->orWhere('name','like','%'.$request->searchData.'%')
                          ->orWhere('name','like','%'.$request->searchData.'%')
                          ->orWhere('name','like','%'.$request->searchData.'%');
                })->paginate(7);
    $searchData->appends($request->all());
    return $searchData;

   }


}
