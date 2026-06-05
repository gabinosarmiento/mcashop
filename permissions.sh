#!/bin/bash

APP_DIR="/var/www/laravel"

WRITABLE_DIRS=(
  "$APP_DIR/storage"
  "$APP_DIR/bootstrap/cache"
  "$APP_DIR/public/images"
)

echo
echo "Laravel permission setup will be applied:"
echo "  Project: $APP_DIR"
echo "  Writable directories:"
for d in "${WRITABLE_DIRS[@]}"; do
  echo "    - $d"
done
echo

read -p "Continue? (yes/no): " confirm

if [[ "$confirm" != "yes" ]]; then
  echo "Operation cancelled."
  exit 1
fi

echo
echo "[1/6] Setting project owner..."
sudo chown -R gabino:www-data "$APP_DIR"

echo "[2/6] Applying base permissions..."
sudo find "$APP_DIR" -type f -exec chmod 644 {} \;
sudo find "$APP_DIR" -type d -exec chmod 755 {} \;

echo "[3/6] Fixing node/npm permissions..."
if [ -d "$APP_DIR/node_modules" ]; then
  sudo chown -R gabino:www-data "$APP_DIR/node_modules"
  sudo find "$APP_DIR/node_modules" -type d -exec chmod 775 {} \;
  sudo find "$APP_DIR/node_modules" -type f -exec chmod 664 {} \;

  if [ -f "$APP_DIR/node_modules/.bin/vite" ]; then
    sudo chmod +x "$APP_DIR/node_modules/.bin/vite"
  fi

  if [ -f "$APP_DIR/node_modules/@esbuild/linux-x64/bin/esbuild" ]; then
    sudo chmod +x "$APP_DIR/node_modules/@esbuild/linux-x64/bin/esbuild"
  fi
fi

echo "[4/6] Preparing writable directories..."
for d in "${WRITABLE_DIRS[@]}"; do
  sudo mkdir -p "$d"

  # owner = gabino
  # group = www-data
  sudo chown -R gabino:www-data "$d"

  # setgid para heredar grupo
  sudo chmod g+s "$d"
done

echo "[5/6] Applying write permissions..."
for d in "${WRITABLE_DIRS[@]}"; do
  sudo find "$d" -type d -exec chmod 775 {} \;
  sudo find "$d" -type f -exec chmod 664 {} \;
done

echo "[6/6] Clearing Laravel cache..."
php "$APP_DIR/artisan" optimize:clear

echo
echo "Laravel permissions applied successfully."
echo
echo "Recommended:"
echo "  - php-fpm user      : www-data"
echo "  - supervisor user   : www-data"
echo "  - deploy user       : gabino"
echo
echo "IMPORTANT: Do not use sudo with npm. Always run npm as gabino."