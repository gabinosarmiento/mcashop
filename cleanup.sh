#!/bin/bash

# Colores ANSI
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
RED='\033[0;31m'
NC='\033[0m' # Sin color

echo -e "${CYAN}It's time for the magic, are you ready? (y/n)${NC}"
read -r response

if [[ "$response" != "Y" && "$response" != "y" ]]; then
    echo -e "${RED}Alright, maybe next time! ;)${NC}"
    exit 1
fi

echo -e "${YELLOW}First of all, clearing the cache... Iuk!${NC}"
php artisan cache:clear

echo -e "${YELLOW}Now clearing the views... So old!${NC}"
php artisan view:clear

echo -e "${YELLOW}Refreshing the config cache... Let's go!${NC}"
php artisan config:cache

echo -e "${YELLOW}Clearing the config cache... Fresh start!${NC}"
php artisan config:clear

echo -e "${YELLOW}Optimizing the route cache... Fast lane!${NC}"
php artisan route:cache

echo -e "${YELLOW}Clearing the route cache... Reset!${NC}"
php artisan route:clear

echo -e "${GREEN}Done, papi! Your Laravel is fresh and clean! ;)${NC}"
