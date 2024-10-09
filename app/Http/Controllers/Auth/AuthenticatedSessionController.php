<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ILLuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $id = User::select("id")->where("email","=",$request->email)->get();

        return response()->json($id);
      // return Redirect::to(env('FRONTEND_URL'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
       // return Redirect::to(env('FRONTEND_URL'));
    }
    public function getUser(Request $request)
    {
      $id = $request->id;
      $user = User::select(['name','email','phone','address'])->where('id','=',$id)->get();
      return $user;
    }
}
