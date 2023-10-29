<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Query\JoinClause;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $users = DB::table('users')->distinct()
                        ->rightJoin('cashiers', 'cashiers.user_id', '=', 'users.id')
                            ->where('cashiers.name', 'LIKE', "%$keyword%")
                            ->orWhere('cashiers.address', 'LIKE', "%$keyword%")
                            ->orWhere('users.username', 'LIKE', "%$keyword%")
                            ->orWhere('users.email', 'LIKE', "%$keyword%")
                            ->latest('users.created_at')->paginate($perPage);
        } else {
            $users = DB::table('users')->distinct()
                        ->rightJoin('cashiers', 'cashiers.user_id', '=', 'users.id')
                        ->paginate($perPage);
        }
        return view('user.index', compact('users'));
    }

    public function deleteUser($id)
    {
        // DB::delete('delete from users where id = ?', [$id]);
        DB::table('users')->where('id', '=', $id)->delete();
        return redirect('users.index')->with('success', 'User successfully deleted!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', ['user' => $user]);
    }
}
