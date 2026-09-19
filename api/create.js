const axios = require('axios');

// Sesuaikan dengan variabel server / framework Anda (Express.js)
async function handleCreateServer(req, res) {
    try {
        // Mengambil data dari request frontend
        const username = req.body.username;
        const userId = parseInt(req.body.userId);
        const eggId = parseInt(req.body.eggId);
        const dockerImage = req.body.dockerImage;
        const startupCommand = req.body.startupCommand;
        const environment = req.body.environment || {};

        // Alokasi RAM (dalam MB). Pastikan nilai ini murni dari pilihan/spin user
        const alokasiMemory = parseInt(req.body.memory); 

        // Konfigurasi API Pterodactyl
        const PTERODACTYL_PANEL_URL = 'https://panel.domainanda.com'; // Ubah dengan URL panel Anda
        const PTERODACTYL_API_KEY = 'ptla_xxxxxx'; // Ubah dengan Application API Key Anda

        const response = await axios.post(`${PTERODACTYL_PANEL_URL}/api/application/servers`, {
            name: username,
            user: userId,
            egg: eggId,
            docker_image: dockerImage,
            startup: startupCommand,
            environment: environment,
            limits: {
                memory: alokasiMemory, // RAM mengikuti alokasi
                swap: 0,
                disk: alokasiMemory,   // DIPERBAIKI: Disk disamakan persis dengan memory (tidak dikali 10)
                io: 500,
                cpu: 0                 // 0 berarti unlimted CPU
            },
            feature_limits: {
                databases: 1,
                allocations: 1,
                backups: 1
            }
        }, {
            headers: {
                'Authorization': `Bearer ${PTERODACTYL_API_KEY}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        return res.status(200).json({
            success: true,
            message: 'Server berhasil diinisialisasi dan dideploy!',
            data: response.data
        });

    } catch (error) {
        console.error('Gagal membuat server:', error.response ? error.response.data : error.message);
        return res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan saat deploy server.',
            error: error.response ? error.response.data : error.message
        });
    }
}

module.exports = { handleCreateServer };
