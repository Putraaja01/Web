<?php
require_once 'config.php';
$config = get_config();
$theme = $config['theme_color'] ?? 'indigo';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_panel'])) {
    $username = trim($_POST['username']);
    $package_id = intval($_POST['package_id']);
    $duration_index = intval($_POST['duration_index']);

    if (empty($username)) {
        $error_message = "Username tidak boleh kosong!";
    } else {
        // Cari paket dan durasi
        $selected_pkg = null;
        foreach ($config['packages'] as $pkg) {
            if ($pkg['id'] === $package_id) $selected_pkg = $pkg;
        }

        $selected_dur = $config['durasi'][$duration_index] ?? null;

        if ($selected_pkg && $selected_dur) {
            $final_price = ceil($selected_pkg['base_price'] * $selected_dur['multiplier']);
            
            // 1. Logika Pembuatan Akun & Panel Pterodactyl via API (PLTA/PLTC)
            // [Simulasi Pembuatan User Pterodactyl]
            $email = $username . "@panel.com";
            $password = "P@ss" . rand(1000, 9999);
            
            // Aksi cURL ke Pterodactyl Application API untuk Create User & Server bisa diletakkan di sini.
            // Contoh Endpoint: $config['domain'] . "/api/application/users" & /servers
            
            // 2. Kirim Struk Otomatis ke WhatsApp
            $wa_token = $config['whatsapp_token'];
            $wa_target = $config['whatsapp_target'];
            
            $wa_text  = "📦 *STRUK PEMBELIAN PANEL BERHASIL* 📦\n\n";
            $wa_text .= "👤 Username: {$username}\n";
            $wa_text .= "🛠️ Paket: {$selected_pkg['name']}\n";
            $wa_text .= "⏳ Durasi: {$selected_dur['label']}\n";
            $wa_text .= "💰 Total Harga: Rp " . number_format($final_price, 0, ',', '.') . "\n";
            $wa_text .= "🔗 Domain: {$config['domain']}\n";
            $wa_text .= "🔑 Password Temp: {$password}\n\n";
            $wa_text .= "Terima kasih telah order! Panel aktif otomatis.";

            // Kirim via cURL WhatsApp API (Contoh menggunakan Fonnte / Wablas / Lainnya)
            if (!empty($wa_token) && !empty($wa_target)) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'target' => $wa_target,
                        'message' => $wa_text,
                    ),
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: $wa_token"
                    ),
                ));
                curl_exec($curl);
                curl_close($curl);
            }

            $success_message = "Panel berhasil dibuat! Detail login dan struk telah dikirimkan ke WhatsApp Channel.";
        } else {
            $error_message = "Pilihan paket atau durasi tidak valid!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Panel Pterodactyl Murah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between">
    <div class="max-w-xl mx-auto p-6 w-full mt-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-<?= $theme ?>-400">⚡ Order Panel Pterodactyl</h1>
            <a href="admin.php" class="text-sm bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg border border-slate-700">Login Owner</a>
        </div>

        <?php if($success_message): ?>
            <div class="bg-emerald-600/20 border border-emerald-500 text-emerald-300 p-4 rounded-xl mb-4 text-sm">
                <?= $success_message ?>
            </div>
        <?php endif; ?>

        <?php if($error_message): ?>
            <div class="bg-rose-600/20 border border-rose-500 text-rose-300 p-4 rounded-xl mb-4 text-sm">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Username Panel</label>
                    <input type="text" name="username" required placeholder="cth: putrahosting" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-<?= $theme ?>-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Paket Spesifikasi</label>
                    <select name="package_id" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-<?= $theme ?>-500">
                        <?php foreach($config['packages'] as $pkg): ?>
                            <option value="<?= $pkg['id'] ?>"><?= $pkg['name'] ?> (Base: Rp <?= number_format($pkg['base_price']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Durasi</label>
                    <select name="duration_index" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-<?= $theme ?>-500">
                        <?php foreach($config['durasi'] as $idx => $dur): ?>
                            <option value="<?= $idx ?>"><?= $dur['label'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <p class="text-xs text-slate-400">*Tarif harga bervariasi mulai dari Rp 1.000 hingga Rp 20.000 berdasarkan paket dan durasi yang dipilih.</p>

                <button type="submit" name="buy_panel" class="w-full bg-<?= $theme ?>-600 hover:bg-<?= $theme ?>-500 font-semibold py-3 rounded-xl transition duration-200">
                    Proses Pembelian & Buat Panel
                </button>
            </form>
        </div>
    </div>
    
    <footer class="text-center py-6 text-xs text-slate-500">
        Powered by Pterodactyl Panel &bull; <?= parse_url($config['domain'], PHP_URL_HOST) ?>
    </footer>
</body>
</html>
