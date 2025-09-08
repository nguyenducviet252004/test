<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\StatisticsService;

class AdminController extends Controller
{


    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm trong các bảng cần thiết (Ví dụ tìm kiếm trong bảng products)
        $results = Product::where('name', 'like', '%' . $query . '%')->get();

        return response()->json([
            'results' => $results
        ]);
    }

    public function admin(Request $request)
    {
        // Lấy tham số thời gian từ request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Nếu không có ngày cụ thể, sử dụng tháng hiện tại
        if (!$startDate || !$endDate) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } else {
            // Chuyển đổi string thành Carbon object
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        // Tính tổng số user (tất cả thời gian)
        $totalUsers = User::where('role', 0)->count();

        // Tính tổng đơn hàng đã hoàn thành theo khoảng thời gian
        $completedOrdersQuery = Order::where('status', 3);
        if ($startDate && $endDate) {
            $completedOrdersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $completedOrders = $completedOrdersQuery->count();

        // Tính tổng đơn hàng chưa xử lý (tất cả thời gian)
        $pendingOrders = Order::where('status', 0)->count();

        // Tính tổng doanh thu theo khoảng thời gian
        $totalRevenueQuery = Order::where('status', 3);
        if ($startDate && $endDate) {
            $totalRevenueQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $totalRevenue = $totalRevenueQuery->sum('total_amount');

        // Tính dữ liệu so sánh với khoảng thời gian trước đó (cùng độ dài)
        $periodLength = $startDate->diffInDays($endDate);
        $previousStartDate = $startDate->copy()->subDays($periodLength + 1);
        $previousEndDate = $startDate->copy()->subDay();
        
        $previousRevenue = Order::where('status', 3)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->sum('total_amount');
        $previousOrders = Order::where('status', 3)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        // Tính phần trăm thay đổi
        $revenueChange = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : ($totalRevenue > 0 ? 100 : 0);
        $ordersChange = $previousOrders > 0 ? (($completedOrders - $previousOrders) / $previousOrders) * 100 : ($completedOrders > 0 ? 100 : 0);

        // Format ngày để hiển thị
        $formattedStartDate = $startDate->format('d/m/Y');
        $formattedEndDate = $endDate->format('d/m/Y');

        return view('admin.dashboard', compact(
            'totalUsers', 
            'completedOrders', 
            'totalRevenue', 
            'pendingOrders',
            'revenueChange',
            'ordersChange',
            'formattedStartDate',
            'formattedEndDate',
            'startDate',
            'endDate'
        ));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('admin.update', compact('user'));
    }

    public function update(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $request->validate([
            'fullname' => 'nullable|string|max:255',
            'birth_day' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image',
        ]);

        $user->fullname = $request->input('fullname');
        $user->birth_day = $request->input('birth_day');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->address = $request->input('address');

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
            // Lưu ảnh mới và cập nhật đường dẫn vào cột avatar
            $user['avatar'] = Storage::put('AdminAvatar', $request->file('avatar'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Thông tin tài khoản đã được cập nhật thành công.');
    }

    public function changepass()
    {
        return view('admin.changepass');
    }

    public function changepass_(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        /**
         * @var User $user
         */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
