<?php
/**
 * Standalone Storage Symlink Creator for cPanel / Shared Hosting
 * talentgroup.id - Akademi Pemrograman Indonesia
 */

header('Content-Type: text/html; charset=utf-8');

echo '<body style="font-family: Arial, sans-serif; background: #05080f; color: #f1f5f9; padding: 30px; line-height: 1.6;">';
echo '<div style="max-width: 650px; margin: 0 auto; background: #0c1220; border: 1px solid #1e2d40; padding: 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">';
echo '<h2 style="color: #9b78e0; margin-top: 0; border-bottom: 2px solid #1e2d40; padding-bottom: 12px;">talentgroup.id — Symlink Generator</h2>';

// 1. Definisikan kemungkinan lokasi folder privat storage/app/public
$possibleTargets = [
    // Standard structure (Laravel folder outside public_html, and public contents in public_html)
    realpath(__DIR__ . '/../storage/app/public'),
    realpath($_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public'),
    realpath($_SERVER['DOCUMENT_ROOT'] . '/../flowcode/storage/app/public'),
    // If everything is inside public_html directly
    realpath(__DIR__ . '/storage/app/public'),
];

// Find first existing target
$target = null;
foreach ($possibleTargets as $pt) {
    if ($pt && is_dir($pt)) {
        $target = $pt;
        break;
    }
}

// 2. Definisikan folder tujuan link (folder public/storage Anda)
$link = __DIR__ . '/storage';

echo '<p><b>Hasil Deteksi Jalur Server:</b></p>';
echo '<ul>';
echo '<li>Folder Publik Saat Ini: <code>' . __DIR__ . '</code></li>';
echo '<li>Target (Storage Asli): <code>' . ($target ? $target : '<span style="color: #fb923c;">Tidak terdeteksi otomatis</span>') . '</code></li>';
echo '<li>Link (Folder Publik Baru): <code>' . $link . '</code></li>';
echo '</ul>';

if (!$target) {
    echo '<div style="background: #ef444422; border-left: 4px solid #ef4444; padding: 12px; border-radius: 4px; margin-bottom: 20px;">';
    echo '<strong>Error:</strong> Folder <code>storage/app/public</code> asli tidak dapat ditemukan secara otomatis di server Anda.<br>';
    echo 'Pastikan folder proyek Laravel utama Anda sudah diunggah dengan benar.';
    echo '</div>';
    echo '</div>';
    exit;
}

// Tindakan penghapusan jika link lama sudah ada
if (file_exists($link)) {
    if (is_link($link)) {
        if (@unlink($link)) {
            echo '<p style="color: #38bdf8;">✓ Berhasil menghapus symlink lama yang rusak.</p>';
        } else {
            echo '<p style="color: #fb923c;">⚠️ Gagal menghapus symlink lama secara otomatis.</p>';
        }
    } else {
        // Jika berupa folder asli, backup untuk menghindari kehilangan data
        $backupName = $link . '_backup_' . time();
        if (@rename($link, $backupName)) {
            echo '<p style="color: #38bdf8;">✓ Berhasil mencadangkan folder storage fisik ke <code>' . basename($backupName) . '</code>.</p>';
        } else {
            echo '<p style="color: #ef4444;">❌ Gagal mem-backup folder storage fisik yang sudah ada.</p>';
        }
    }
}

// Membuat Symlink
if (@symlink($target, $link)) {
    echo '<div style="background: #10b98122; border-left: 4px solid #10b981; padding: 15px; border-radius: 4px; margin: 20px 0;">';
    echo '<h3 style="color: #34d399; margin-top: 0;">✓ KONEKSI SYMLINK SUKSES!</h3>';
    echo 'Folder penyimpanan berhasil dihubungkan. Gambar, audio, dan sertifikat di website Anda sekarang sudah bisa terbaca secara sempurna!';
    echo '</div>';
    
    echo '<p style="color: #94a3b8; font-size: 13px;"><b>PENTING:</b> Demi keamanan website Anda, silakan <b>HAPUS</b> file <code>symlink.php</code> ini dari folder hosting publik Anda setelah proses sukses.</p>';
} else {
    echo '<div style="background: #ef444422; border-left: 4px solid #ef4444; padding: 15px; border-radius: 4px; margin: 20px 0;">';
    echo '<h3 style="color: #f87171; margin-top: 0;">❌ KONEKSI SYMLINK GAGAL</h3>';
    echo 'Fungsi <code>symlink()</code> diblokir atau dinonaktifkan oleh pengaturan PHP hosting Anda (safe_mode/disable_functions).';
    echo '</div>';
    
    echo '<p><b>Solusi Alternatif Tercepat:</b></p>';
    echo '<ol>';
    echo '<li>Hubungi Admin hosting Anda untuk mengaktifkan fungsi PHP <code>symlink</code> sementara waktu.</li>';
    echo '<li>Atau gunakan SSH CMD dengan mengetikkan perintah berikut di terminal server: <br>';
    echo '<code style="background: #1a2436; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-top: 8px;">php artisan storage:link</code></li>';
    echo '</ol>';
}

echo '</div>';
echo '</body>';
