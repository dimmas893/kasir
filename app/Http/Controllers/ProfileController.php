<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.profile', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user_route = Auth::user();
        try {
            $user = User::findOrFail($id);

            if ($request->hasFile('foto')) {
                $user->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'foto' => $request->hasFile('foto') ? $foto->hashName() : $user->foto,
                ]);
            } elseif ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            } else {
                $user->update([
                    'nama' => $request->nama,
                    'email' => $request->email
                ]);
            }

            return redirect('/' . $user_route->level . '/profile' . '/' .  $id)->with('sukses', 'Data Berhasil di Edit');
        } catch (\Exception $e) {
            return redirect('/' . $user_route->level . '/profile' . '/' .  $id)->with('gagal', 'Data Tidak Berhasil di Edit. Pesan Kesalahan: ' . $e->getMessage());
        }
    }
}
