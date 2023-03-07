<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Auth;

class ConfigurasiUserController extends Controller
{
    public function index(){
        return view('myauth.settings');
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'profil' => 'mimes:png,jpg,jpeg|file|max:5024',
            'name' => 'required',
            'email' =>  ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)]
        ]);

        if ($request->file('profil')) {
            if (Auth::user()->profil != '/img/profil.png') {
                Storage::delete(Auth::user()->profil);
            }
            $validatedData['profil'] = $request->file('profil')->store('profil');
        }
        
        Auth::user()->update($validatedData);

        if (Auth::user()->hasRole('siswa')) {
            Auth::user()->profile_siswa->update($validatedData);
        }else{
            Auth::user()->profile_user->update($validatedData);
        }

        if ($request->email != Auth::user()->email) {
            \Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
        }

        return TahunAjaran::redirectWithTahunAjaranManual('/profil', $request, 'Profil Berhasil Diupdate');
    }

    public function ubahPassword(){
        return view('myauth.ubahpassword');
    }

    public function reset_password(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => \Hash::make($request->password)
        ]);

        \Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
