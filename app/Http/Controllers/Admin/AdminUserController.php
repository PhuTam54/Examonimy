<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\User;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{

    // User
    public function user() {
        $users = User::orderBy("id","desc")->get();
        return view("pages.admin.user.admin-user", compact("users"));
    }

    public function userAdd() {
        $classes = Classes::all();
        return view("pages.admin.user.user-add",
            compact("classes"));
    }

    public function userStore(Request $request) {
        $request->validate([
            "name"=> "required | min:3",
            "email"=> "required",
            "password"=> "required | min:6",
            "avatar" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "role"=> "required",
            "class"=> "nullable",
            "full_name"=> "nullable",
            "date_of_birth"=> "nullable",
            "address" => "nullable",
            "phone_number"=> "nullable | numeric | min:9",
        ]);
        try {
            $avatar = null;
            // Xử lí upload file
            if ($request->hasFile("avatar")) {
                $path = public_path("uploads");
                $file = $request->file("avatar");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $avatar = "/uploads/".$file_name;
            }

            // get status
            $status = 1;

            // create new user
            User::create([
                "name" => $request->get("name"),
                "email"=>$request->get("email"),
                "password"=>$request->get("password"),
                "role"=>$request->get("role"),
                "avatar"=>$avatar,
                "full_name"=>$request->get("full_name"),
                "date_of_birth"=>$request->get("date_of_birth"),
                "address"=>$request->get("address"),
                "phone_number"=>$request->get("phone_number"),
                "class_id"=>$request->get("class_id"),
                "user_status"=>$status,
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]);

            return redirect()->to("admin/admin-user")->with("add-success", "Add new user successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function userEdit(User $user)
    {
        $classes = Classes::all();
        return view("pages.admin.user.user-edit",
            compact("classes", "user"));
    }

    public function userUpdate(Request $request, User $user) {
        $request->validate([
            "name"=> "required | min:3",
            "email"=> "required",
            "avatar" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "role"=> "required",
            "class"=> "nullable",
            "full_name"=> "nullable",
            "date_of_birth"=> "nullable",
            "address" => "nullable",
            "phone_number"=> "nullable | numeric | min:9",
        ]);
        try {
            // Xử lí upload file
            if ($request->hasFile("avatar")) {
                $path = public_path("uploads");
                $file = $request->file("avatar");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $avatar = "/uploads/".$file_name;

                $user->avatar = $avatar;
            }

            // update user
            $user->update([
                "name" => $request->get("name"),
                "email"=>$request->get("email"),
                "role"=>$request->get("role"),
                "full_name"=>$request->get("full_name"),
                "date_of_birth"=>$request->get("date_of_birth"),
                "address"=>$request->get("address"),
                "phone_number"=>$request->get("phone_number"),
                "class_id"=>$request->get("class_id"),
            ]);

            return redirect()->to("admin/admin-user")->with("edit-success", "Edit user successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function userDelete(User $user) {
        try {
            // delete user
            $to_delete_user = User::find($user->id);
            $to_delete_user->delete();
            return redirect()->to("admin/admin-user")->with("delete-success", "Delete user successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function userTrash() {
        $users = User::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.user.admin-user", compact("users"))->with("userTrash");
    }

    public function userRecover(User $user) {
        try {
            // recover user
            $user->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-user")->with("recover-success", "Recover user $user->user_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
