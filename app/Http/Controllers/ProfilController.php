<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'bio'  => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'bio.max'       => 'Bio maksimal 160 karakter.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus jpg, png, atau webp.',
            'foto.max'      => 'Ukuran foto maksimal 2 MB.',
            'foto.uploaded' => 'Foto gagal diunggah, kemungkinan ukurannya terlalu besar.',
        ]);

        $user=$request->user();
        $user->name=$data['name'];
        $user->bio=$data['bio']??null;

        if($request->hasFile('foto')){
            if($user->foto){
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('foto-profil', 'public');
        }
        $user->save();
        return $user->dataProfil();
    
}

}