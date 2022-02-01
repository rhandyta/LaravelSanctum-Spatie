<?php

namespace App\Http\Controllers;

use App\Http\Resources\RolesResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return view('home');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 409);
        }

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($newUser) {
            $token = $newUser->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success' => true, 'user' => $newUser, 'token' => $token, 'type_token' => 'Bearer'
            ], 201);
        }

        return response()->json(['success' => false, 'message' => 'register failed'], 409);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()],  401);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => false, 'message' => 'you unathorized'], 401);
        }
        User::where('email', $request->email)->firstOrFail();

        $user = RolesResource::make($request->user());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token, 'type_token' => 'Bearer'], 200);
    }

    // public function logout()
    // {
    //     auth()->user()->tokens()->delete();
    //     return response()->json(['success' => true, 'message' => 'you are loggout'], 200);
    // }
}
