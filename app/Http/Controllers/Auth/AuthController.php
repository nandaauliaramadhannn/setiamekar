<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Dapartemen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

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

    public function edit()
    {
        return view('profile_edit', [
            'user' => Auth::user()

        ]);
    }
    public function update(Request $request)


{
    try {
        // Validasi input pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'password' => 'nullable|string|min:8|confirmed',
            'departemen_id' => 'nullable|exists:departemen,id',
        ]);

        // Ambil pengguna yang sedang login
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diubah, hash password baru
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Update departemen jika ada
        if ($request->has('departemen_id')) {
            $user->departemen_id = $request->departemen_id;
        }

        // Simpan perubahan di database
        $user->save();

        // Menampilkan notifikasi sukses
        Alert::toast('Profil berhasil diperbarui', 'success');

        // Redirect ke halaman edit profil
        return redirect()->route('profile.edit');

    } catch (QueryException $e) {
        // Jika terjadi error database (misal, constraint violation)
        Alert::toast('Terjadi kesalahan dalam database. Coba lagi nanti.', 'error');
        return back()->withInput();
    } catch (Exception $e) {
        // Untuk kesalahan lain, misalnya error umum
        Alert::toast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        return back()->withInput();
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
