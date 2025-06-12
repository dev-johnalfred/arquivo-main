<?php

namespace Modules\Auth\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Auth\Data\LoginData;
use Modules\Auth\Actions\AuthenticateAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        protected AuthenticateAction $authenticateAction
    ) {}

    public function create(): Response
    {
        return Inertia::render('Login', [
            'canResetPassword' => route('password.request'),
            'status' => session('status'),
        ]);
    }


    public function store(LoginData $data): RedirectResponse
    {
        $this->authenticateAction->execute($data);

        request()->session()->regenerate();

        return redirect()->intended('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
