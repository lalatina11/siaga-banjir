<?php

namespace Database\Factories;

use App\Models\Flood;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flood>
 */
class FloodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Batas koordinat Purwokerto/Banyumas
        $minLat = -7.4500;  // Batas selatan
        $maxLat = -7.3800;  // Batas utara
        $minLng = 109.2000; // Batas barat
        $maxLng = 109.3500; // Batas timur

        $image = "https://imgs.search.brave.com/dRa4h7ULbtiSUe0nvs0d_an56m5gniWMi7A3jXKwvho/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMucGV4ZWxzLmNv/bS9waG90b3MvNjQ3/MTkyNy9wZXhlbHMt/cGhvdG8tNjQ3MTky/Ny5qcGVnP2F1dG89/Y29tcHJlc3MmY3M9/dGlueXNyZ2ImZHBy/PTEmdz01MDA";

        $descriptions = [
            "Banjir melanda Jl. Sudirman, air setinggi 1 meter, warga mulai mengungsi ke tempat aman.",
            "Jalan utama terendam, kendaraan tidak bisa melintas, warga meminta bantuan segera.",
            "Rumah warga di pinggir sungai terendam, air masuk hingga ke ruang tamu.",
            "Sekolah ditutup sementara, siswa belajar dari rumah, banjir belum surut.",
            "Pasar tradisional terendam, pedagang kehilangan stok, kerugian mencapai jutaan rupiah.",
            "Jembatan darurat dibangun, warga bisa lewat meski harus berjalan kaki.",
            "Listrik padam di beberapa wilayah, warga menggunakan genset untuk penerangan.",
            "Banjir disebabkan hujan deras semalaman, debit sungai meluap ke pemukiman.",
            "Warga gotong royong membersihkan lumpur, alat berat dikerahkan untuk bantu evakuasi.",
            "Korban luka ringan, tim medis sudah di lokasi, obat-obatan cukup tersedia.",
            "Tiga rumah roboh, warga dievakuasi ke balai desa, bantuan makanan mulai datang.",
            "Jalan akses ke rumah sakit terputus, ambulans harus cari rute alternatif.",
            "Anak-anak tidak bisa sekolah, orang tua khawatir dengan pendidikan jangka panjang.",
            "Banjir membawa sampah dan limbah, warga khawatir akan wabah penyakit.",
            "Pompa air dikerahkan, namun debit air masih tinggi, evakuasi terus berjalan.",
            "Warga meminta tenda darurat, banyak yang tidur di atap rumah karena air naik.",
            "Kendaraan terendam, pemilik tidak bisa mengambil mobil, asuransi belum aktif.",
            "Air mulai surut, warga mulai membersihkan rumah, butuh bantuan alat bersih-bersih.",
            "Banjir kedua minggu ini, warga sudah siap logistik, tapi tetap waspada.",
            "Jembatan rusak, akses ke desa terpencil terputus, bantuan sulit masuk.",
        ];

        $userIds = User::get('id')->pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement(array_values($userIds)),
            'lat' => fake()->randomFloat(7, $minLat, $maxLat),
            'lng' => fake()->randomFloat(7, $minLng, $maxLng),
            'description' => fake()->randomElement(array_values($descriptions)),
            'image' => $image,
            'status' => fake()->randomElement(array_values(Flood::STATUSES())),
            'province' => 'Jawa Tengah',
            'regency' => 'Banyumas',
            'district' => fake()->randomElement([
                'Purwokerto Utara',
                'Purwokerto Selatan',
                'Purwokerto Barat',
                'Purwokerto Timur',
                'Ajibarang',
                'Banyumas',
            ]),
            'village' => fake()->city(),
        ];
    }
}