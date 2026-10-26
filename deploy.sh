#!/bin/bash
# ============================================================
# deploy.sh — Script Deployment untuk Shared Hosting
# talentgroup.id / flowacademy.fun
# 
# CARA PAKAI di SSH hosting:
#   chmod +x deploy.sh && ./deploy.sh
#
# ⚠️  Script ini TIDAK memerlukan storage:link
#     File diakses via route /storage/{path} → HomeController
# ============================================================

set -e

echo "=========================================="
echo "  🚀 Deploying flowacademy.fun"
echo "=========================================="

# 1. Tarik pembaruan terbaru dari GitHub
echo ""
echo "📥 [1/6] Pulling latest code..."
git fetch origin main
git reset --hard FETCH_HEAD
echo "✅ Code updated successfully"

# 2. Hapus broken symlink public/storage (jika ada)
#    Ini mencegah error 403 dari Apache yang mencoba follow broken symlink
echo ""
echo "🔗 [2/6] Cleaning broken symlinks..."
if [ -L "public/storage" ]; then
    rm -f "public/storage"
    echo "✅ Removed broken symlink public/storage"
elif [ -d "public/storage" ]; then
    echo "ℹ️  public/storage is a real directory, skipping"
else
    echo "ℹ️  No public/storage found, skipping"
fi

# 3. Install/update dependencies (jika ada perubahan composer)
echo ""
echo "📦 [3/6] Checking composer dependencies..."
if [ -f "composer.lock" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction 2>/dev/null || echo "⚠️  Composer install skipped"
fi

# 4. Clear semua cache Laravel
echo ""
echo "🧹 [4/6] Clearing Laravel caches..."
php artisan optimize:clear 2>/dev/null || true

# 5. Pastikan folder storage ada dan writable
echo ""
echo "📁 [5/6] Ensuring storage directories exist..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
chmod -R 775 storage 2>/dev/null || true
chmod -R 775 bootstrap/cache 2>/dev/null || true

# 6. Rebuild cache untuk production
echo ""
echo "⚡ [6/6] Optimizing for production..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

echo ""
echo "=========================================="
echo "  ✅ Deployment selesai!"
echo ""
echo "  ℹ️  Storage link TIDAK diperlukan."
echo "  ℹ️  File diakses via route /storage/{path}"
echo "  ℹ️  Handled oleh HomeController::streamFile()"
echo "=========================================="
