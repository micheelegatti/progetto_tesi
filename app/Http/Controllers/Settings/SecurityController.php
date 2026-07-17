<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PasswordUpdateRequest;
use App\Http\Requests\Settings\TwoFactorAuthenticationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View; // <-- Importa la View di Blade

class SecurityController extends Controller
{
    /**
     * Mostra la pagina della sicurezza (Blade).
     */
    public function edit(TwoFactorAuthenticationRequest $request): View
    {
        $props = [
            'passwordRules' => Password::defaults()->toPasswordRulesString(),
        ];

        // Ritorna la vista Blade situata in resources/views/settings/security.blade.php
        return view('settings.security', $props);
    }

    /**
     * Aggiorna la password dell'utente.
     */
    public function update(PasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => $request->password,
        ]);

        // Sostituito Inertia::flash con il flash session nativo
        return back()->with('toast', [
            'type' => 'success', 
            'message' => __('Password updated.')
        ]);
    }
}