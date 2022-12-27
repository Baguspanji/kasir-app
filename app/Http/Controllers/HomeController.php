<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $app = App::where([
            'id' => Auth::user()->app_id,
            'status' => true,
        ])->first();

        return view('home', compact('app'));
    }

    public function setting()
    {
        $post = App::where([
            'id' => Auth::user()->app_id,
            'status' => true,
        ])->first();

        return view('setting', compact('post'));
    }

    public function updateSetting(Request $request)
    {
        $app = App::where([
            'id' => Auth::user()->app_id,
            'status' => true,
        ])->first();

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            // 'email' => 'required',
            // 'logo' => 'required',
            'pr_name' => 'required',
            'messages' => 'required|array',
        ]);

        $app->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            // 'email' => $request->email,
            // 'logo' => $request->logo,
            'pr_name' => $request->pr_name,
            'messages' => $request->messages,
        ]);

        return redirect()->route('setting');
    }
}
