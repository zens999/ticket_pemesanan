<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('name')->get();
        $transportasi = Transportasi::with('category')->orderBy('kode')->orderBy('name')->get();
        return view('server.transportasi.index', compact('category', 'transportasi'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('server.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'level' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->level = $request->level;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Success Update User!');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    // app/Http/Controllers/UserController.php






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Success Delete User!');
    }

    public function name(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        User::find(Auth::user()->id)->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Nama anda berhasil diperbarui!');
    }

    public function password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->password_lama == true) {
            if (Hash::check($request->password_lama, $user->password)) {
                if ($request->password_lama == $request->password) {
                    return redirect()->back()->with('error', 'Maaf password yang anda masukkan sama!');
                } else {
                    $user_password = [
                        'password' => Hash::make($request->password),
                    ];
                    $user->update($user_password);
                    return redirect()->back()->with('success', 'Password anda berhasil diperbarui!');
                }
            } else {
                return redirect()->back()->with('error', 'Tolong masukkan password lama anda dengan benar!');
            }
        } else {
            return redirect()->back()->with('error', 'Tolong masukkan password lama anda terlebih dahulu!');
        }
    }
}
