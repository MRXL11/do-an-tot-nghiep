<?php 
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateAccountClientRequest;

class AccountController extends Controller
{   
    public function show()
    {
        return view('client.pages.account'); // Đường dẫn tới view hiển thị form
    }
    
   public function update(UpdateAccountClientRequest $request)
{
    $user = Auth::user();

    $user->name = $request->name;
    $user->address = $request->address;
    $user->phone_number = $request->phone_number;

    if (!$user->google_id && $request->filled('new_password')) {
            if (!$request->filled('old_password')) {
                return back()->withErrors(['old_password' => 'Vui lòng nhập mật khẩu cũ khi thay đổi mật khẩu.']);
            }
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng']);
            }
            $user->password = Hash::make($request->new_password);
        }

    $user->save();
   
    return redirect()->back()->with('success', '✅ Cập nhật tài khoản thành công!');
        
    
    }
}