<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NotificationModel;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    // Show profile ở mục cấu hình thông tin của NPB
    public function viewUserDetails(){
        $dataUser = User::find(Auth::user()->id);
        return view("pages.Users.UserDetailsPage")->with('dataUser', $dataUser);
    }
    // Cập nhật lại thông tin cấu hình của NPB
    public function updateUserDetails(Request $request){
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required|string',
        ]);
        if($user->update($request->all())){
            return redirect("/profile")->with('message', 'Thông tin người dùng đã được cập nhật.');
        }else{
            return redirect("/profile")->with('message', 'Không thể cập nhật thông tin người dùng');
        }
    }
    // Khóa user
    public function lockUser(string $user_id)
    {
        $user = User::find($user_id);
        $user["status"] = 2;
        if($user->save()){
            if(NotificationModel::create([
                'notification_title' => "Khóa tài khoản",
                'notification_content' => "Tài khoản của bạn đã bị tạm khóa",
                'user_to' => $user_id,
                'user_from' => Auth::id(),
            ])){
                return redirect('/admin/user')->with('message', 'Đã tạm khóa người dùng.')->with('type', 'OK');
            }else{
                return redirect('/admin/user')->with('message', 'Có lỗi khi tạm khóa người dùng.')->with('type', 'ERR');
            }
            return redirect('/admin/user')->with('message', 'Đã khóa người dùng!')->with('type', 'OK');
        }
    }
    // Mở khóa user
    public function unlockUser(string $user_id)
    {
        $user = User::find($user_id);
        $user["status"] = 1;
        if($user->save()){
            if(NotificationModel::create([
                'notification_title' => "Mở khóa tài khoản",
                'notification_content' => "Tài khoản của bạn đã được mở khóa",
                'user_to' => $user_id,
                'user_from' => Auth::id(),
            ])){
                return redirect('/admin/user')->with('message', 'Đã mở khóa người dùng.')->with('type', 'OK');
            }else{
                return redirect('/admin/user')->with('message', 'Có lỗi khi mở khóa người dùng.')->with('type', 'ERR');
            }
            return redirect('/admin/user')->with('message', 'Đã mở khóa người dùng!')->with('type', 'OK');
        }
    }
    // Cấp lại mật khẩu
    public function resetPasswordUser(string $user_id)
    {
        $user = User::find($user_id);
        $userPassword = $user["password_admin"];
        if($user->save()){
            if(NotificationModel::create([
                'notification_title' => "Cấp lại mật khẩu",
                'notification_content' => "Mật khẩu của bạn là: ".$userPassword,
                'user_to' => $user_id,
                'user_from' => Auth::id(),
            ])){
                return redirect('/admin/user')->with('message', 'Đã gửi thông báo cấp lại mật khẩu.')->with('type', 'OK');
            }else{
                return redirect('/admin/user')->with('message', 'Có lỗi khi cấp lại mật khẩu.')->with('type', 'ERR');
            }
        }else{
            return redirect('/admin/user')->with('message', 'Có lỗi khi cấp lại mật khẩu.')->with('type', 'ERR');
        }
    }
}
