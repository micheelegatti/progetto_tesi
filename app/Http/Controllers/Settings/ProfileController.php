<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileDeleteRequest;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // <-- Importa la View di Blade

class ProfileController extends Controller
{
    /**
     * Mostra la pagina delle impostazioni del profilo (Blade).
     */
    public function edit(Request $request): View
    {
        // Ritorna la vista Blade situata in resources/views/settings/profile.blade.php
        return view('settings.profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Aggiorna le informazioni del profilo.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Sostituito Inertia::flash con il flash di sessione standard di Laravel
        return to_route('profile.edit')->with('toast', [
            'type' => 'success', 
            'message' => __('Profile updated.')
        ]);
    }

    /**
     * Elimina il profilo dell'utente.
     */
    public function destroy(ProfileDeleteRequest $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}