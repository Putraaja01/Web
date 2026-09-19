<?php
require_once 'config.php';
$config = get_config();

$update_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_owner'])) {
    $config['domain'] = trim($_POST['domain']);
    $config['plta'] = trim($_POST['plta']);
    $config['pltc'] = trim($_POST['pltc']);
    $config['egg_id'] = trim($_POST['egg_id']);
    $config['nest_id'] = trim($_POST['nest_id']);
    $config['whatsapp_token'] = trim($_POST['whatsapp_token']);
    $config['whatsapp_target'] = trim($_POST['whatsapp_target']);
    $config['theme_color'] = trim($_POST['theme_color']);
    
    save_config($config);
    $update_msg = "Pengaturan owner dan tampilan berhasil diperbarui!";
}
$theme = $config['theme_color'] ?? 'indigo';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Owner Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-<?= $theme ?>-400">⚙️ Dashboard Khusus Owner</h1>
            <a href="index.php" class="text-sm bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg border border-slate-700">Kembali ke Beranda</a>
        </div>

        <?php if($update_msg): ?>
            <div class="bg-emerald-600/20 border border-emerald-500 text-emerald-300 p-4 rounded-xl mb-4 text-sm">
                <?= $update_msg ?>
            </div>
        <?php endif; ?>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <form action="" method="POST" class="space-y-4">
                <h2 class="text-lg font-semibold border-b border-slate-700 pb-2">1. Konfigurasi Panel & API</h2>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Domain Panel Pterodactyl</label>
                    <input type="text" name="domain" value="<?= $config['domain'] ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">PLTA (Application API Key)</label>
                        <input type="text" name="plta" value="<?= $config['plta'] ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">PLTC (Client API Key)</label>
                        <input type="text" name="pltc" value="<?= $config['pltc'] ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">ID Egg</label>
                        <input type="text" name="egg_id" value="<?= $config['egg_id'] ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">ID Nest</label>
                        <input type="text" name="nest_id" value="<?= $config['nest_id'] ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                    </div>
                </div>

                <h2 class="text-lg font-semibold border-b border-slate-700 pt-4 pb-2">2. Pengaturan WhatsApp Bot (Struk Otomatis)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Token WA Gateway / Fonnte</label>
                        <input type="text" name="whatsapp_token" value="<?= $config['whatsapp_token'] ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Target Nomor / ID Grup WhatsApp</label>
                        <input type="text" name="whatsapp_target" value="<?= $config['whatsapp_target'] ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                    </div>
                </div>

                <h2 class="text-lg font-semibold border-b border-slate-700 pt-4 pb-2">3. Ubah Tampilan Web</h2>
                <div>
                    <label class="block text-sm font-medium mb-1">Tema Warna Utama</label>
                    <select name="theme_color" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2 text-sm">
                        <option value="indigo" <?= $theme == 'indigo' ? 'selected' : '' ?>>Indigo (Default)</option>
                        <option value="blue" <?= $theme == 'blue' ? 'selected' : '' ?>>Blue Modern</option>
                        <option value="emerald" <?= $theme == 'emerald' ? 'selected' : '' ?>>Emerald Green</option>
                        <option value="purple" <?= $theme == 'purple' ? 'selected' : '' ?>>Purple Neon</option>
                    </select>
                </div>

                <button type="submit" name="update_owner" class="w-full bg-<?= $theme ?>-600 hover:bg-<?= $theme ?>-500 font-semibold py-3 rounded-xl transition duration-200 mt-4">
                    Simpan Perubahan Pengaturan
                </button>
            </form>
        </div>
    </div>
</body>
</html>
