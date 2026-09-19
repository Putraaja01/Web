<?php
// config.php
$db_file = 'database.json';

// Konfigurasi Owner (Berdasarkan data Anda)
$default_config = [
    'domain' => 'https://thepanel.putranasution.web.id',
    'plta' => 'ptla_ClbL66HqYT3U2BfcUsQwydERZiW5yzgSVjFxBBBRVZO',
    'pltc' => 'ptlc_ckhIlQlYIPOqVWxv9a5jH2b5Ov6Mkw3TCqGAFNLzJ3i',
    'egg_id' => '16',
    'nest_id' => '5',
    'location_id' => '1', // Ditambahkan sesuai data location Anda
    'whatsapp_token' => '', // Isi token Fonnte/WA Gateway Anda jika ingin struk otomatis aktif
    'whatsapp_target' => '', // Nomor atau ID Group WhatsApp tujuan struk
    'theme_color' => 'indigo', // Pilihan tema: indigo, blue, emerald, purple
    
    // Durasi dan pengali harga panel
    'durasi' => [
        ['label' => '3 Hari', 'days' => 3, 'multiplier' => 0.2],
        ['label' => '7 Hari', 'days' => 7, 'multiplier' => 0.5],
        ['label' => '2 Minggu', 'days' => 14, 'multiplier' => 0.8],
        ['label' => '1 Bulan', 'days' => 30, 'multiplier' => 1.0],
    ],
    
    // Pilihan Paket / Spesifikasi Panel (Tarif mulai dari Rp 1.000 s/d Rp 20.000)
    'packages' => [
        ['id' => 1, 'name' => 'Panel 1GB / 1 vCPU', 'ram' => 1024, 'cpu' => 100, 'disk' => 1024, 'base_price' => 2000],
        ['id' => 2, 'name' => 'Panel 2GB / 2 vCPU', 'ram' => 2048, 'cpu' => 200, 'disk' => 2048, 'base_price' => 5000],
        ['id' => 3, 'name' => 'Panel 4GB / 3 vCPU', 'ram' => 4096, 'cpu' => 300, 'disk' => 4096, 'base_price' => 10000],
        ['id' => 4, 'name' => 'Panel 8GB / Max vCPU', 'ram' => 8192, 'cpu' => 0, 'disk' => 8192, 'base_price' => 20000],
    ]
];

// Inisialisasi file database.json jika belum ada
if (!file_exists($db_file)) {
    file_put_contents($db_file, json_encode($default_config, JSON_PRETTY_PRINT));
}

function get_config() {
    global $db_file;
    return json_decode(file_get_contents($db_file), true);
}

function save_config($data) {
    global $db_file;
    file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
}
