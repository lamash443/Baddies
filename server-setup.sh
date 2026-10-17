#!/bin/bash
# =============================================================================
# Kenyan Baddies Club — Truehost Server Setup Script
# Run this via cPanel Terminal or SSH ONCE after each deployment.
# Path: /home/kenyanba/laravel-app/
# =============================================================================

set -e
APP_DIR="/home/kenyanba/laravel-app"
cd "$APP_DIR"

echo "============================================="
echo " Step 1: Verify/fix storage symlink"
echo "============================================="
# The .cpanel.yml already does this, but run manually if needed
if [ ! -L "/home/kenyanba/public_html/storage" ]; then
    rm -rf /home/kenyanba/public_html/storage
    ln -sfn /home/kenyanba/laravel-app/storage/app/public /home/kenyanba/public_html/storage
    echo "  ✅ Symlink created: public_html/storage → laravel-app/storage/app/public"
else
    echo "  ✅ Symlink already exists"
fi

echo ""
echo "============================================="
echo " Step 2: Check/update .env APP_URL"
echo "============================================="
# Ensure APP_URL is set to the correct production URL (NOT localhost)
if grep -q "APP_URL=http://127.0.0.1" "$APP_DIR/.env"; then
    sed -i 's|APP_URL=http://127.0.0.1:8000|APP_URL=https://www.kenyanbaddies.com|g' "$APP_DIR/.env"
    echo "  ✅ APP_URL updated to https://www.kenyanbaddies.com"
else
    echo "  ℹ️  Current APP_URL: $(grep APP_URL $APP_DIR/.env)"
fi

# Ensure PAYHERO_CALLBACK_URL points to the live domain
if grep -q "trycloudflare" "$APP_DIR/.env" || ! grep -q "PAYHERO_CALLBACK_URL" "$APP_DIR/.env"; then
    if grep -q "PAYHERO_CALLBACK_URL" "$APP_DIR/.env"; then
        sed -i 's|PAYHERO_CALLBACK_URL=.*|PAYHERO_CALLBACK_URL=https://kenyanbaddies.com/webhook/payhero|g' "$APP_DIR/.env"
    else
        echo 'PAYHERO_CALLBACK_URL=https://kenyanbaddies.com/webhook/payhero' >> "$APP_DIR/.env"
    fi
    echo "  ✅ PAYHERO_CALLBACK_URL set to https://kenyanbaddies.com/webhook/payhero"
fi

echo ""
echo "============================================="
echo " Step 3: Ensure SESSION_DRIVER=database"
echo "============================================="
if ! grep -q "SESSION_DRIVER=database" "$APP_DIR/.env"; then
    sed -i 's|SESSION_DRIVER=.*|SESSION_DRIVER=database|g' "$APP_DIR/.env"
    echo "  ✅ SESSION_DRIVER set to database"
else
    echo "  ✅ SESSION_DRIVER=database already set"
fi

echo ""
echo "============================================="
echo " Step 4: Ensure SESSION_DOMAIN=null"
echo "============================================="
# Remove any SESSION_DOMAIN=.kenyanbaddies.com which causes cookie mismatch
sed -i 's|SESSION_DOMAIN=.*|SESSION_DOMAIN=null|g' "$APP_DIR/.env"
echo "  ✅ SESSION_DOMAIN set to null"

echo ""
echo "============================================="
echo " Step 5: Ensure FILESYSTEM_DISK=public"
echo "============================================="
if ! grep -q "FILESYSTEM_DISK=public" "$APP_DIR/.env"; then
    sed -i 's|FILESYSTEM_DISK=.*|FILESYSTEM_DISK=public|g' "$APP_DIR/.env"
    echo "  ✅ FILESYSTEM_DISK set to public"
else
    echo "  ✅ FILESYSTEM_DISK=public already set"
fi

echo ""
echo "============================================="
echo " Step 6: Clear all Laravel caches"
echo "============================================="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo "  ✅ All caches cleared"

echo ""
echo "============================================="
echo " Step 7: Run migrations (creates sessions table)"
echo "============================================="
php artisan migrate --force
echo "  ✅ Migrations complete"

echo ""
echo "============================================="
echo " Step 8: Set storage directory permissions"
echo "============================================="
chmod -R 775 storage bootstrap/cache
chown -R $(whoami):$(whoami) storage bootstrap/cache
echo "  ✅ Permissions set"

echo ""
echo "============================================="
echo " Step 9: Re-cache config & routes for production"
echo "============================================="
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "  ✅ Production caches built"

echo ""
echo "============================================="
echo " Step 10: Final verification"
echo "============================================="
echo "  APP_URL    : $(grep APP_URL $APP_DIR/.env)"
echo "  APP_ENV    : $(grep APP_ENV $APP_DIR/.env)"
echo "  SESSION    : $(grep SESSION_DRIVER $APP_DIR/.env)"
echo "  FILESYSTEM : $(grep FILESYSTEM_DISK $APP_DIR/.env)"
echo "  Symlink    : $(ls -la /home/kenyanba/public_html/storage)"
echo ""
echo "✅ Server setup complete! Try logging in now."
