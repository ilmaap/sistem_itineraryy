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
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (\App\Models\User::where('email', $value)->exists()) {
                        return $fail('Akun telah terdaftar.');
                    }

                    $permohonan = PermohonanAkun::where('email', $value)->first();
                    if ($permohonan) {
                        if ($permohonan->status === PermohonanAkun::STATUS_MENUNGGU) {
                            return $fail('Email tersebut sudah mengajukan permohonan dan sedang menunggu proses verifikasi.');
                        } elseif ($permohonan->status === PermohonanAkun::STATUS_DISETUJUI) {
                            return $fail('Akun telah terdaftar.');
                        }
                    }
                },
            ],
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

        $permohonan = PermohonanAkun::where('email', $request->email)->first();

        if ($permohonan && $permohonan->status === PermohonanAkun::STATUS_DITOLAK) {
            $permohonan->update([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'deskripsi' => $request->deskripsi,
                'status' => PermohonanAkun::STATUS_MENUNGGU,
            ]);
        } else {
            PermohonanAkun::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'deskripsi' => $request->deskripsi,
                'status' => PermohonanAkun::STATUS_MENUNGGU,
            ]);
        }

        return redirect()->route('form-permohonan')
            ->with('success', 'Permohonan Anda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
