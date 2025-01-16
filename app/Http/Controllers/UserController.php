<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    public function index(){
        $data = [
            'title' => 'User Page',
            'users' => User::all()
        ];
        return view('user',$data);
    }
    public function store(Request $request){
        $validated = $request->validate(([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]));
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->back()->with([
                'alert' => 'Email already used, use another email',
                'icon' => 'error',
            ]);
        }
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect()->route('user')->with([
            'alert'   => 'User add successfully',
            'icon'    => 'success'
        ]);
    }
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user')->with([
            'alert'   => 'User has been deleted',
            'icon'    => 'success'
        ]);
    }
    public function update(Request $request, $id){
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);
        // Update data user
        $user->name = $request->input('name');
        $user->save(); // Simpan perubahan
        return redirect()->route('user')->with([
            'alert'   => 'User updated successfully',
            'icon'    => 'success'
        ]);
    }
}