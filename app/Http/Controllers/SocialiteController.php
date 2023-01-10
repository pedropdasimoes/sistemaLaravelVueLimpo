<?php

namespace App\Http\Controllers;

use App\Models\Dominios;
use App\Models\LoginsUsuarios;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\BuscaDados;

class SocialiteController extends Controller
{
    private $objUser;

    public function __construct()
    {
        $this->objUser = new User();
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();
        $findUser = $this->objUser->where('email', $user->email)->first();
        if ($findUser) {
            Auth::login($findUser);
            return redirect()->route('dashboard');
        } else {
                return redirect()->route('erro');
            
        }
    }
}
