<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cashier;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $orders_count = User::whereHas('salesOrders', function ($query) {
            $query->where('sales_order.so_status', '=', 'preparing');
        })->count();
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $users = User::query()
                        ->rightJoin('cashiers', 'cashiers.user_id', '=', 'users.id')
                            ->where('cashiers.name', 'LIKE', "%$keyword%")
                            ->orWhere('cashiers.address', 'LIKE', "%$keyword%")
                            ->orWhere('users.username', 'LIKE', "%$keyword%")
                            ->orWhere('users.email', 'LIKE', "%$keyword%")
                            ->latest('users.created_at')->fastPaginate($perPage);
        } else {
            $users = User::query()
                            ->rightJoin('cashiers', 'cashiers.user_id', '=', 'users.id')
                            ->latest('users.created_at')
                            ->fastPaginate($perPage);
        }
        return view('user.index', compact('users', 'orders_count'));
    }

    public function deleteUser($id)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Delete Permission denied!');
        }
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', "User successfully deleted.");
    }

    public function editUser($id)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect()->back()->with('warning', 'Edit Permission denied!');
        }
        $user = User::query()->rightJoin('cashiers', 'cashiers.user_id', '=', 'users.id')->where('users.id', $id)->first();
        return view('user.edit', ['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $customer = Cashier::where('user_id', $id)->first();

        $request->validate([
            'email' => 'required_without:username|string|email|unique:users,email,'.$id,
            'username' => 'required_without:email|string|min:3|max:20|unique:users,username,'.$id,
            'name' => 'required',
            'phone_number' => 'required|numeric|digits:11',
            'address' => 'required',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->phone_number = $request->phone_number;

        $user->save();
        $customer->save();
        return redirect()->back()->with('success', 'User record successfully Updated!');
    }

    public function adminSettings()
    {
        $orders_count = User::whereHas('salesOrders', function ($query) {
            $query->where('sales_order.so_status', '=', 'preparing');
        })->count();
        return view('dashboard.admin.settings', compact('orders_count'));
    }

    public function updateSettings(Request $request)
    {
        $id = auth()->id();
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required_without:username|string|email|unique:users,email,'.$id,
            'username' => 'required_without:email|string|min:3|max:20|unique:users,username,'.$id,
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        $user->save();
        return redirect()->back()->with('success', 'Admin Settings Successfully Updated!');
    }

    public function addUser()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect()->back()->with('warning', 'Add Permission denied!');
        }
        return view('user.add');
    }

    public function storeUser(Request $request)
    {
        $message = '';
        if($request->role === 'cashier') {
            $request->validate([
                'role' => 'required',
                'email' => 'required_without:username|string|email|unique:users,email',
                'username' => 'required_without:email|string|min:3|max:20|unique:users,username',
                'name' => 'required',
                'phone_number' => 'required|numeric|digits:11',
                'address' => 'required',
            ]);
            $user = User::create([
                'role' => $request->role,
                'username' => $request->username,
                'email' => $request->email,
                'password' => 'cashier',
            ]);
            Cashier::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);
            $message = '';
        }
        if($request->role === 'admin') {
            $request->validate([
                'role' => 'required',
                'email' => 'required_without:username|string|email|unique:users,email',
                'username' => 'required_without:email|string|min:3|max:20|unique:users,username',
            ]);
            $user = User::create([
                'role' => $request->role,
                'username' => $request->username,
                'email' => $request->email,
                'password' => 'admin1234',
            ]);
            $message = 'Admin';
        }

        return redirect()->back()->with("success", "User {$message} Added Successfully!");
    }

    public function resetPassword(Request $request)
    {
        $auth = new AuthController();
        $auth->logout($request);
        return $auth->forgotPassword();
    }

}
