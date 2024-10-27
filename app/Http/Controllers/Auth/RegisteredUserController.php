<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\sendMail;
use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed','regex:/[A-Z]{1,}[a-z]{1,}[0-9]{1,}\W{1,}/', Rules\Password::defaults()],
            'tel'=>['required','string'],
            'address'=> ['required','string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'phone'=> $request->tel,
            'address'=> $request->address,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $id = User::select("id")->where("email","=",$user->email)->get();

        //註冊成功後寄email歡迎新使用者
        //Mail::to($user)->send(new Welcome($user));
        sendMail::dispatch($user,new Welcome($user));
        return response()->json($id);
      // return Redirect::to(env('FRONTEND_URL'));
    }
}
