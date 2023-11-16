<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cashier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index(Request $request)
    {
        // return view('cashier.index');
        $keyword = $request->get('search');
        $perPage = 5;
        if(!empty($keyword)) {
            $cashier = Cashier::where('name', 'LIKE', "%$keyword%")
                                ->orWhere('address', 'LIKE', "%$keyword%")
                                ->orWhere('phone_number', 'LIKE', "%$keyword%")
                                ->latest()->paginate($perPage);
        } else {
            $cashier = Cashier::latest()->paginate($perPage);
        }
        return view('cashier.index', ['cashier' => $cashier])->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function updateCashier(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $cashier = Cashier::where('user_id', $id)->first();

        $request->validate([
            'email' => 'required_without:username|string|email|unique:users,email,'.$id,
            'username' => 'required_without:email|string|min:3|max:20|unique:users,username,'.$id,
            'name' => 'required',
            'phone_number' => 'required|numeric|digits:11',
            'address' => 'required',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $cashier->name = $request->name;
        $cashier->address = $request->address;
        $cashier->phone_number = $request->phone_number;

        $user->save();
        $cashier->save();
        return redirect()->back()->with('success', 'User Profile successfully Updated!');
    }

    public function forgotPassword(Request $request)
    {
        $auth = new AuthController();
        $auth->logout($request);
        return $auth->forgotPassword();
    }

    public function profile()
    {
        $cashier = User::query()->rightJoin('cashiers', 'cashiers.user_id', '=', 'users.id')->where('users.id', auth()->user()->id)->first();
        return view('user.edit-cashier', compact('cashier'));
    }
}
