<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use App\Models\Province;
use App\Models\City;
use App\Models\Village;
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

    public function getVillages(Request $request)
    {
        $villages = Village::where('city_id', $request->city_id)
            ->orderBy('name')
            ->get();
        return response()->json($villages);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:150',
            'deskripsi_singkat' => 'required|string|max:500',
            'nama_pic' => 'required|string|max:100',
            'kontak_pic' => 'required|string|max:50',
            'alamat_toko' => 'required|string',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'village_id' => 'required|exists:villages,id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:users,email|unique:sellers,email',
            'no_ktp' => 'required|string|max:20',
            'foto_pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama_toko.required' => 'Nama toko wajib diisi',
            'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi',
            'nama_pic.required' => 'Nama PIC wajib diisi',
            'rt.required' => 'RT wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'village_id.required' => 'Kelurahan wajib dipilih',
            'village_id.exists' => 'Kelurahan tidak valid',
            'no_ktp.required' => 'No. KTP PIC wajib diisi',
            'foto_pic.required' => 'Foto PIC wajib diupload',
            'foto_pic.image' => 'Foto PIC harus berupa gambar',
            'foto_pic.max' => 'Ukuran foto PIC maksimal 2MB',
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
            $fotoPicPath = $request->file('foto_pic')->store('pic', 'public');

            $user = User::create([
                'name' => $validated['nama_pic'],
                'email' => $validated['email'],
                'role' => 'seller',
                'password' => Hash::make($validated['password']),
            ]);

            Seller::create([
                'user_id' => $user->id,
                'nama_toko' => $validated['nama_toko'],
                'deskripsi_singkat' => $validated['deskripsi_singkat'],
                'nama_pic' => $validated['nama_pic'],
                'kontak_pic' => $validated['kontak_pic'],
                'alamat_toko' => $validated['alamat_toko'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'village_id' => $validated['village_id'],
                'city_id' => $validated['city_id'],
                'province_id' => $validated['province_id'],
                'nomor_hp' => $validated['nomor_hp'],
                'email' => $validated['email'],
                'no_ktp' => $validated['no_ktp'],
                'foto_pic' => $fotoPicPath,
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
