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
        $image1 = "https://imgs.search.brave.com/dRa4h7ULbtiSUe0nvs0d_an56m5gniWMi7A3jXKwvho/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMucGV4ZWxzLmNv/bS9waG90b3MvNjQ3/MTkyNy9wZXhlbHMt/cGhvdG8tNjQ3MTky/Ny5qcGVnP2F1dG89/Y29tcHJlc3MmY3M9/dGlueXNyZ2ImZHBy/PTEmdz01MDA";
        $image2 = "https://imgs.search.brave.com/NrcCgk3owYjSxmPSt5_hYKytPfeOIKWiQ7xOjyudfiU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTQ1/ODU0NzU1L3Bob3Rv/L29oaW8tZmxvb2Qu/anBnP3M9NjEyeDYx/MiZ3PTAmaz0yMCZj/PVJfQ2NKM3BOdGFq/c1JVMndMLURaQlFE/UUVyZnlGV3duUGV4/ZUxwQ2VJVjA9";
        $image3 = "https://imgs.search.brave.com/2Gg46g9Ymm73-S3urvM5yrY0QI8oYOEp3mowq9D3sc4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jd2Ni/LmNvbG9yYWRvLmdv/di9zaXRlcy9jd2Ni/L2ZpbGVzLzIwMTkt/MTIvQSUyMFRhZyUy/MGhvdXNlJTIwaW4l/MjByaXZlciUyMEpv/c2h1YSUyMFBvbHNv/biUyMC0lMjBUaGUl/MjBHcmVlbGV5JTIw/VHJpYnVuZSUyMHZp/YSUyMEFQLmpwZw";
        $image4 = "https://imgs.search.brave.com/7-a8WnXsDrJdixyRjq3iCoEDmEll0awPOxMNCXqRDXg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvMTI4/MjU3OTAzMC9waG90/by9hZXJpYWwtdmll/dy1vZi1odXJyaWNh/bmUtZmxvb2Rpbmct/aW4tbG91aXNpYW5h/LmpwZz9zPTYxMng2/MTImdz0wJms9MjAm/Yz1BMENvWFZwYTFS/YlhZN1Z5MEM4XzFB/N0tudktVOTBEaDVv/WWRaNm9NWUxZPQ";
        $image5 = "https://imgs.search.brave.com/o_DX83o3tgIZQXRAsEY_ZkWqaz2xbDN678q60s__YsQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvOTk3/NDI0NjA0L3Bob3Rv/L3RvcnJlbnRpYWwt/cmFpbi1pbi1reW90/by5qcGc_cz02MTJ4/NjEyJnc9MCZrPTIw/JmM9MDRmZTNHenlk/d29EWXBQc2FBd3kz/enVXbHJRaURkNmNP/d0lsaGpOTWttQT0";
        $image6 = "https://imgs.search.brave.com/LGGSoV3q_LSvj30a0k7PE9rdRE6852mYnzpAb5BdPx4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMjE3/NjgwMDAwNS9waG90/by9odXJyaWNhbmUt/ZGViYnktZmxvb2Rl/ZC1jaXR5LXN0cmVl/dC13aXRoLXRyYXBw/ZWQtY2FyLXN1Ym1l/cmdlZC11bmRlci13/YXRlci1pbi1mbG9y/aWRhLmpwZz9zPTYx/Mng2MTImdz0wJms9/MjAmYz1SMXZXbW4x/ZmlreXJ5N3gtWW5V/dkZ6VjV2UGpDdGU0/TGJLNmlINXRWRHZV/PQ";
        $image7 = "https://imgs.search.brave.com/AhZwQOAyzKp576MEFrQQ_LTh2eELgcqRUGNYzyt0ZrU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMjE5/MDQ3NDY5OS9waG90/by9mbG9vZGVkLXJl/c2lkZW50aWFsLWFy/ZWEtd2l0aC11bmRl/cndhdGVyLWNhcnMt/YW5kLWhvdXNlcy1m/cm9tLWh1cnJpY2Fu/ZS1kZWJieS1yYWlu/ZmFsbC13YXRlci53/ZWJwP2E9MSZiPTEm/cz02MTJ4NjEyJnc9/MCZrPTIwJmM9aTk5/LXNSRWlhQm9BTVpu/cnNDZDFMUW0zV0tG/bnNIYllqUFZ0d3lL/RHA3Zz0";

        $images = [
            $image1,
            $image2,
            $image3,
            $image4,
            $image5,
            $image6,
            $image7,
        ];

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
            'image' => fake()->randomElement(array_values($images)),
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