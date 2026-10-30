#!/bin/bash
# ============================================================
# deploy.sh — Self-Healing Deployment Script untuk Shared Hosting
# talentgroup.cloud / flowacademy.fun
# 
# CARA PAKAI di SSH hosting:
#   chmod +x deploy.sh && ./deploy.sh
# ============================================================

set -e

echo "=========================================="
echo "  🚀 Memulai Deployment flowacademy / talentgroup"
echo "=========================================="

# 1. Tarik pembaruan terbaru dari GitHub
echo ""
echo "📥 [1/9] Mengambil code terbaru dari GitHub..."
git fetch origin main
git reset --hard FETCH_HEAD
echo "✅ Code berhasil diperbarui ke commit: $(git rev-parse --short HEAD)"

# 2. Pastikan file root entry point (.htaccess & index.php) selalu ada
echo ""
echo "🌐 [2/9] Memverifikasi root entry point (.htaccess & index.php)..."

cat << 'EOF' > index.php
<?php
/**
 * Shared Hosting Root Entry Point
 * Meneruskan request ke folder public/index.php
 */
require_once __DIR__ . '/public/index.php';
EOF
chmod 644 index.php
echo "✅ Root index.php siap"

cat << 'EOF' > .htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # 1. Blokir akses HTTP langsung ke direktori internal storage yang sensitif
    RewriteRule ^storage/(logs|framework|private)/ - [F,L]

    # 2. Arahkan semua request /storage dan /storage-file langsung ke Laravel Front Controller
    RewriteRule ^(storage|storage-file)(/.*)?$ /public/index.php [L]

    # 3. Sajikan file fisik statis dari public/ jika file-nya ada (CSS, JS, gambar, dsb)
    RewriteCond %{DOCUMENT_ROOT}/public/$1 -f
    RewriteRule ^(.*)$ /public/$1 [L]

    # 4. Arahkan semua request lainnya ke folder public/
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>

<FilesMatch "^\.(env|git|env\..*)$">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core.c>
        Order deny,allow
        Deny from all
    </IfModule>
</FilesMatch>
EOF
chmod 644 .htaccess
echo "✅ Root .htaccess siap"

# 3. Pastikan public/.htaccess siap untuk routing storage tanpa symlink
echo ""
echo "🔒 [3/9] Memverifikasi public/.htaccess..."
cat << 'EOF' > public/.htaccess
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # CRITICAL: Route ALL /storage dan /storage-file requests through Laravel (bypass symlink)
    # Menghindari error 403 Forbidden pada shared hosting
    RewriteRule ^(storage|storage-file)(/.*)?$ index.php [L]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} !^/public/p/
    RewriteCond %{REQUEST_URI} !^/p/
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF
chmod 644 public/.htaccess
echo "✅ public/.htaccess siap"

# 4. Bersihkan broken symlink public/storage jika ada
echo ""
echo "🔗 [4/9] Memeriksa link public/storage..."
if [ -L "public/storage" ]; then
    rm -f "public/storage"
    echo "✅ Broken symlink public/storage dihapus (tidak lagi dibutuhkan)"
elif [ -d "public/storage" ]; then
    echo "ℹ️  public/storage adalah folder fisik, dibiarkan"
else
    echo "ℹ️  Tidak ada broken symlink public/storage"
fi

# 5. Pastikan folder direktori storage & cache ada serta memiliki permission yang benar
echo ""
echo "📁 [5/9] Mempersiapkan folder storage dan cache..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Hapus cache bootstrap lama secara langsung dari filesystem
rm -f bootstrap/cache/*.php 2>/dev/null || true
rm -rf storage/framework/cache/data/* 2>/dev/null || true
rm -rf storage/framework/views/* 2>/dev/null || true

chmod -R 775 storage 2>/dev/null || chmod -R 755 storage 2>/dev/null || true
chmod -R 775 bootstrap/cache 2>/dev/null || chmod -R 755 bootstrap/cache 2>/dev/null || true
echo "✅ Permission storage dan cache diperbaiki"

# 6. Sinkronkan dependency PHP sesuai composer.lock
echo ""
echo "📦 [6/9] Menyinkronkan dependency Composer..."
if ! command -v composer >/dev/null 2>&1; then
    echo "❌ Composer tidak tersedia di server. Aktifkan Composer dari hPanel atau hubungi penyedia hosting."
    exit 1
fi
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
echo "✅ Dependency Composer siap"

# 7. Terapkan migration database terbaru
echo ""
echo "🗃️  [7/9] Menjalankan migration database..."
php artisan migrate --force
echo "✅ Migration database selesai"

# 8. Sinkronkan bank latihan yang aman dan idempotent
echo ""
echo "📝 [8/9] Menyinkronkan bank latihan Figma dan Web..."
php artisan db:seed --class=FigmaPracticeSeeder --force
php artisan db:seed --class=WebFundamentalsPracticeSeeder --force
php artisan db:seed --class=TalentGroupHimaUpnvjModuleSeeder --force
echo "✅ Bank latihan dan modul mentoring berhasil disinkronkan"

# 9. Jalankan pembersihan cache Laravel
echo ""
echo "🧹 [9/9] Membersihkan cache Laravel via artisan..."
php artisan optimize:clear 2>/dev/null || echo "ℹ️  Clear via artisan dilewati (cache filesystem sudah dibersihkan manual)"

echo ""
echo "=========================================="
echo "  🎉 DEPLOYMENT SUKSES & SELESAI!"
echo "=========================================="
echo "  ✓ Root .htaccess & index.php aktif"
echo "  ✓ Bypass symlink storage aktif"
echo "  ✓ Dependency Composer telah disinkronkan"
echo "  ✓ Migration database telah diterapkan"
echo "  ✓ Bank latihan telah disinkronkan"
echo "  ✓ Modul mentoring TalentGroup.id x HIMA UPNVJ telah disinkronkan"
echo "  ✓ Cache sistem telah disegarkan"
echo "=========================================="
