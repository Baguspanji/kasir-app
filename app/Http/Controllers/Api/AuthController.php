<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            $respon = [
                'message' => 'Validator error',
                'errors' => $validate->errors(),
            ];
            return response()->json($respon, 200);
        } else {
            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $credentials = [
                $fieldType => $request->input('username'),
                // 'password' => $request->input('password'),
                'status' => true,
            ];

            if (User::where($credentials)->first()) {
                $user = User::where($credentials)->first();
                $role = 'admin';
            } else {
                $respon = [
                    'message' => 'Unathorized',
                    'errors' => null,
                ];
                return response()->json($respon, 401);
            }

            if (!Hash::check($request->input('password'), $user->password, [])) {
                $respon = [
                    'message' => 'Unathorized',
                    'errors' => null,
                ];
                return response()->json($respon, 401);
            }

            $tokenResult = $user->createToken('api-auth')->plainTextToken;
            $respon = [
                'message' => 'Login berhasil',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'role' => $role,
                // 'data' => [
                //     'user' => $user,
                // ],
            ];
            return response()->json($respon, 200);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $respon = [
            'status' => 'success',
            'message' => 'Logout berhasil',
        ];
        return response()->json($respon, 200);
    }

    public function user()
    {
        $user = static::findUser();
        $user->app = $user->app;

        $respon = [
            'status' => 'success',
            'message' => 'Data user',
            'data' => $user,
        ];

        return response()->json($respon, 200);
    }

    public function changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validate->fails()) {
            $respon = [
                'message' => 'Validator error',
                'errors' => $validate->errors(),
            ];
            return response()->json($respon, 422);
        }

        try {
            DB::beginTransaction();
            $user = static::findUser();
            if (!Hash::check($request->input('old_password'), $user->password, [])) {
                $respon = [
                    'message' => 'Old password is wrong',
                    'errors' => [
                        "old_password" => [
                            "old password salah.",
                        ],
                    ],
                ];
                return response()->json($respon, 422);
            }

            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            DB::commit();

            $respon = [
                'message' => 'Update password berhasil',
                'errors' => null,
            ];
            return response()->json($respon, 200);
        } catch (\Exception$e) {
            DB::rollBack();
            $respon = [
                'message' => 'Update profile gagal',
                'errors' => [
                    'message' => $e->getMessage(),
                ],
            ];
            return response()->json($respon, 422);
        }
    }

    public function changeProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        if ($validate->fails()) {
            $respon = [
                'message' => 'Validator error',
                'errors' => $validate->errors(),
            ];
            return response()->json($respon, 422);
        }

        try {
            DB::beginTransaction();
            $user = static::findUser();
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->image = $request->input('image');
            $user->save();
            DB::commit();

            $respon = [
                'message' => 'Update profile berhasil',
                'errors' => null,
            ];
            return response()->json($respon, 200);
        } catch (\Exception$e) {
            DB::rollBack();
            $respon = [
                'message' => 'Update profile gagal',
                'errors' => [
                    'message' => $e->getMessage(),
                ],
            ];
            return response()->json($respon, 422);
        }
    }

    private function findUser()
    {
        $credentials = [
            'username' => Auth::user()->username,
            'email' => Auth::user()->email,
            'app_id' => Auth::user()->app_id,
            'status' => true,
        ];
        if (User::where($credentials)->first()) {
            $user = User::where($credentials)->first();
        } else {
            $user = null;
        }

        return $user;
    }
}
