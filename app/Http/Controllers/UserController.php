<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.index', compact('datas'));
    }

    public function create()
    {
        return view('user.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            // 'phone' => 'string',
        ]);

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
            'password' => Hash::make('password'),
        ]);

        User::create($dataCreated);

        Session::flash('success', 'Berhasil membuat data!');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = User::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();
        return view('user.form', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'phone' => 'string',
        ]);

        $user = User::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();
        $user->update($request->all());

        Session::flash('success', 'Berhasil mengubah data!');
        return redirect()->route('user.index');
    }

    public function status($id)
    {
        $user = User::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        Session::flash('success', 'Berhasil mengubah data!');
        return redirect()->back();
    }
}
