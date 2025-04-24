<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Dapartemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'reCAPTCHA harus diisi.',
        ]);

        // Verifikasi reCAPTCHA
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $recaptcha = $recaptchaResponse->json();

        if (!($recaptcha['success'] ?? false)) {
            Alert::toast('Verifikasi reCAPTCHA gagal', 'error');
            return back()->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            Alert::toast('Login berhasil', 'success');
            return redirect()->route('dashboard');
        }

        Alert::toast('Login gagal, periksa email atau password', 'error');
        return back()->withInput();
    }

    public function userindex ()
    {
        $user =  User::latest()->get();
        return view('backend.user.index', compact('user'));
    }

    public function  createform()
    {
        $departemens = Dapartemen::all();
        return view('backend.user.create', compact('departemens'));
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,superadmin,user',
            'departemen_id' => 'nullable|exists:departemen,id',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'departemen_id' => $request->departemen_id,
            ]);

            Alert::toast('User berhasil ditambahkan', 'success');
            return redirect()->route('admin.backend.user.index');
        } catch (\Exception $e) {
            Alert::toast('Gagal menambahkan user: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departemen  = Dapartemen::all();
        return view('backend.user.edit', compact('user', 'departemen'));
    }
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'role' => 'required|in:admin,superadmin,user',
        'departemen_id' => 'nullable|exists:departemen,id',
    ]);

    try {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'departemen_id' => $request->departemen_id,
        ]);

        Alert::toast('User berhasil diperbarui', 'success');
        return redirect()->route('backend.user.index');
    } catch (\Exception $e) {
        Alert::toast('Gagal update user: ' . $e->getMessage(), 'error');
        return redirect()->back()->withInput();
    }
}
public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();

        Alert::toast('User berhasil dihapus', 'success');
        return redirect()->back();
    } catch (\Exception $e) {
        Alert::toast('Gagal menghapus user: ' . $e->getMessage(), 'error');
        return redirect()->back();
    }
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::toast('berhasil logout', 'success');
        return redirect()->route('login');
    }
}
