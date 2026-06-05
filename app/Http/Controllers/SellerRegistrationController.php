<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SellerRegistrationController extends Controller
{
    public function showForm()
    {
        $provinces = Province::orderBy('name')->get();
        return view('seller.register', compact('provinces'));
    }

    public function getCities(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)
            ->orderBy('name')
            ->get();
        return response()->json($cities);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:150',
            'nama_pic' => 'required|string|max:100',
            'kontak_pic' => 'required|string|max:50',
            'alamat_toko' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:users,email|unique:sellers,email',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama_toko.required' => 'Nama toko wajib diisi',
            'nama_pic.required' => 'Nama PIC wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'foto_ktp.required' => 'Foto KTP wajib diupload',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.max' => 'Ukuran file maksimal 2MB',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            DB::beginTransaction();

            $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');

            $user = User::create([
                'name' => $validated['nama_pic'],
                'email' => $validated['email'],
                'role' => 'seller',
                'password' => Hash::make($validated['password']),
            ]);

            Seller::create([
                'user_id' => $user->id,
                'nama_toko' => $validated['nama_toko'],
                'nama_pic' => $validated['nama_pic'],
                'kontak_pic' => $validated['kontak_pic'],
                'alamat_toko' => $validated['alamat_toko'],
                'city_id' => $validated['city_id'],
                'province_id' => $validated['province_id'],
                'nomor_hp' => $validated['nomor_hp'],
                'email' => $validated['email'],
                'foto_ktp' => $fotoKtpPath,
                'status' => 'pending',
                'activation_token' => Str::random(60),
            ]);

            DB::commit();

            return redirect()->route('seller.register.success')
                ->with('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi dari platform.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.');
        }
    }

    public function success()
    {
        return view('seller.register-success');
    }

    public function activate($token)
    {
        $seller = Seller::where('activation_token', $token)->first();

        if (!$seller) {
            return redirect()->route('login')
                ->with('error', 'Token aktivasi tidak valid.');
        }

        $seller->update([
            'is_active' => true,
            'verified_at' => now(),
            'activation_token' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil diaktivasi! Silakan login.');
    }
}
