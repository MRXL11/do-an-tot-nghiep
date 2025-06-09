<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreUserRequest; 
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    // Hiển thị danh sách người dùng, có thể tìm kiếm theo tên hoặc email
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::withTrashed() // => Lấy cả người dùng đã xóa mềm
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            
            ->paginate(10)
            ->withQueryString();

        $newUsers = User::latest()->take(6)->get(); // 6 người dùng mới nhất (không lấy user đã xóa mềm)

        return view('admin.users.users', compact('users', 'search', 'newUsers'));
    }


    // Trả về view để hiển thị form tạo người dùng mới
    public function create()
    {
        
        $roles = \App\Models\Role::all(); // Lấy danh sách tất cả vai trò
        return view('admin.users.create', compact('roles'));
    }

    // Xử lý lưu người dùng mới vào database
    public function store(StoreUserRequest $request)
    {
        $data = $request->only(['name', 'email', 'phone_number', 'address', 'status', 'role_id']);
        $data['password'] = bcrypt($request->password); // Mã hóa mật khẩu

        // Nếu có upload ảnh đại diện
        if ($request->hasFile('avatar')) {
            // Lưu ảnh vào thư mục public/storage/users

            $path = $request->file('avatar')->store('users', 'public');
            $data['avatar'] = $path;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo!');
    }

    // Hiển thị chi tiết người dùng
    public function show(User $user)
    {
        $user->load('role'); 
        return view('admin.users.show', compact('user'));
    }

    // Trả về view để chỉnh sửa thông tin người dùng
    public function edit(User $user)
    {
        $roles = \App\Models\Role::all(); 
        return view('admin.users.update', compact('user', 'roles'));
    }

    // Xử lý cập nhật thông tin người dùng
    public function update(UpdateUserRequest $request, User $user)
    {
        // Lấy các trường cần cập nhật
        $data = $request->only(['name', 'email', 'phone_number', 'address', 'status', 'role_id']);
        
        // Nếu có upload ảnh đại diện mới
        if ($request->hasFile('avatar')) {
            // Nếu đã có ảnh cũ, xóa nó khỏi thư mục lưu trữ

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Lưu ảnh mới và cập nhật đường dẫn
            $path = $request->file('avatar')->store('users', 'public');
            $data['avatar'] = $path;
        }

        // Cập nhật thông tin người dùng

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được cập nhật!');
    }

    // Xóa người dùng 

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa!');
    }
    // Khôi phục người dùng bị xóa
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được khôi phục!');
    }

}
