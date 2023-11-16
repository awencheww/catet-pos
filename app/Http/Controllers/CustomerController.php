<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Illuminate\Auth\Events\Logout;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $customers = User::query()->distinct()
                        ->rightJoin('customers', 'customers.user_id', '=', 'users.id')
                            ->where('customers.name', 'LIKE', "%$keyword%")
                            ->orWhere('customers.address', 'LIKE', "%$keyword%")
                            ->orWhere('users.username', 'LIKE', "%$keyword%")
                            ->orWhere('users.email', 'LIKE', "%$keyword%")
                            ->latest('users.created_at')->fastPaginate($perPage);
        } else {
            $customers = User::query()->distinct()
                            ->rightJoin('customers', 'customers.user_id', '=', 'users.id')
                            ->latest('users.created_at')
                            ->fastPaginate($perPage);
        }
        return view('customer.index', compact('customers'));
    }

    public function updateCustomer(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $customer = Customer::where('user_id', $id)->first();

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
        return redirect()->back()->with('success', 'Profile successfully Updated!');
    }

    public function saveCustomer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $customer = Customer::where('user_id', $id)->first();

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
        return redirect()->back()->with('success', 'Customer record successfully Updated!');
    }

    public function addCustomer()
    {
        return view('customer.add');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'email' => 'unique:users,email',
            'username' => 'required_without:email|string|min:3|max:20|unique:users,username',
            'name' => 'required',
            'phone_number' => 'required|numeric|digits:11',
            'address' => 'required',
        ]);
        $email =
        $user = User::create([
            'username' => $request->username,
            'email' => (blank($request->email) ? '' : $request->email),
            'password' => 'customer',
        ]);
        Customer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
        return redirect()->back()->with("success", "Customer Added Successfully!");
    }

    public function resetPassword(Request $request)
    {
        $auth = new AuthController();
        $auth->logout($request);
        return $auth->forgotPassword();
    }

    public function deleteCustomer($id)
    {
        User::query()->where('id', '=', $id)->delete();
        abort_unless(Auth::user()->role === 'admin', 403);
        return redirect()->back()->with('success', "Customer successfully deleted.");
    }

    public function editCustomer($id)
    {
        $user = User::query()->rightJoin('customers', 'customers.user_id', '=', 'users.id')->where('users.id', $id)->first();
        abort_unless(Auth::user()->role === 'admin', 403);
        return view('customer.edit', ['user' => $user]);
    }

    public function profile()
    {
        $customer = User::query()->rightJoin('customers', 'customers.user_id', '=', 'users.id')->where('users.id', auth()->user()->id)->first();
        return view('customer.profile', compact('customer'));
    }
}
