<?php

namespace App\Http\Controllers\Client;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::check()) {
            $wishlistItems = Wishlist::with('product')
                ->where('user_id', Auth::user()->id)
                ->paginate(5);
        } else {
            // Nếu người dùng chưa đăng nhập, lấy wishlist từ localStorage
            // $wishlistItems = collect(json_decode(request()->cookie('wishlist', '[]'), true));
            $wishlistItems = [];
        }
        return view('client.pages.wishlist', compact('wishlistItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productId = $request->input('product_id');

        // Kiểm tra đã tồn tại trong wishlist chưa
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Sản phẩm đã có trong danh sách yêu thích.');
        }

        // Nếu chưa có, thì thêm vào
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wishlistItem = Wishlist::find($id);
        // Kiểm tra xem sản phẩm có trong wishlist của người dùng hiện tại không
        // Nếu không có hoặc không phải của người dùng hiện tại, trả về lỗi
        if (!$wishlistItem || $wishlistItem->user_id !== Auth::id()) {
            return back()->with('error', 'Không tìm thấy sản phẩm trong danh sách yêu thích.');
        }
        // Xoá sản phẩm khỏi wishlist
        // Chỉ xoá nếu sản phẩm thuộc về người dùng hiện tại
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $wishlistItem->product_id)
            ->delete();

        return back()->with('success', 'Đã xoá khỏi danh sách yêu thích.');
    }


    public function sync(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để đồng bộ wishlist.');
        }

        // Kiểm tra xem dữ liệu wishlist có được gửi qua request hay không
        $data = json_decode($request->input('wishlist'), true);

        // Nếu không có dữ liệu hoặc dữ liệu không hợp lệ, trả về lỗi
        if (!is_array($data)) {
            return redirect()->back()->with('error', 'Dữ liệu truyền vào wishlist không hợp lệ.');
        }

        // Xử lý dữ liệu để chèn vào bảng wishlist
        // Lọc ra các sản phẩm có id và chuẩn bị dữ liệu để chèn vào bảng wishlist
        $insertData = [];
        foreach ($data as $item) {
            if (isset($item['id'])) {
                $insertData[] = [
                    'user_id' => Auth::id(),
                    'product_id' => $item['id'],
                    'created_at' => now(),
                ];
            }
        }

        // Chèn hoặc cập nhật dữ liệu vào bảng wishlist
        Wishlist::insertOrIgnore($insertData);

        return response()->json([
            'success' => true,
            'message' => 'Đồng bộ wishlist thành công.'
        ]);
    }
}
