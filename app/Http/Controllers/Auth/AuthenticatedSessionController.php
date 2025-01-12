<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Checando se o user e admin para redirecionar para o dashboard correto
        if(Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));

            // caso for vendedor redireciona para o dashboard do vendedor
        } elseif(Auth::user()->role === 'vendor') {
            return redirect()->intended(route('vendor.dashboard'));

            // caso for usuario redireciona para o dashboard do usuario
        }  elseif(Auth::user()->role === 'user') {
            return redirect()->intended(route('dashboard'));
            
        }  else {
            return redirect('login')->with('error', 'Seus dados estão incorretos');
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
