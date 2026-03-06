<?php

namespace App\Http\Controllers;

use App\Models\PermohonanAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermohonanAkunController extends Controller
{
    public function create()
    {
        return view('form-permohonan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:20',
            'deskripsi' => 'required|string',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        PermohonanAkun::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('form-permohonan')
            ->with('success', 'Permohonan Anda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
