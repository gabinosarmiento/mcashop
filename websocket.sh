#!/bin/bash

# ANSI Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

echo -e "${CYAN}=========================================${NC}"
echo -e "${GREEN}  Starting WebSocket development environment...${NC}"
echo -e "${CYAN}=========================================${NC}"

# Start Vite in the background
echo -e "${YELLOW}→ Launching Vite in the background...${NC}"
npx vite &

# Start Laravel WebSockets in the foreground (to view logs)
echo -e "${YELLOW}→ Starting Laravel WebSockets...${NC}"
php artisan websockets:serve
