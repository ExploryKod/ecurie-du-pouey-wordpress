#!/bin/bash
# Script d'initialisation Docker pour WordPress
# Fixe les permissions des dossiers critiques

set -e

echo "[Docker Init] Initialisation des permissions WordPress..."

# Attendre que le système de fichiers soit prêt
sleep 2

# Créer les dossiers nécessaires s'ils n'existent pas
echo "[Docker Init] Création des dossiers nécessaires..."
mkdir -p /var/www/html/wp-content/uploads/elementor/css
mkdir -p /var/www/html/wp-content/uploads/elementor/js
mkdir -p /var/www/html/wp-content/litespeed/debug
mkdir -p /var/www/html/wp-content/cache

# Fixer les permissions pour www-data (uniquement si on est root)
if [ "$(id -u)" = "0" ]; then
    echo "[Docker Init] Configuration des permissions..."
    chown -R www-data:www-data /var/www/html/wp-content/uploads 2>/dev/null || true
    chown -R www-data:www-data /var/www/html/wp-content/cache 2>/dev/null || true
    chown -R www-data:www-data /var/www/html/wp-content/litespeed 2>/dev/null || true
    
    # Donner les permissions d'écriture
    chmod -R 775 /var/www/html/wp-content/uploads 2>/dev/null || true
    chmod -R 775 /var/www/html/wp-content/cache 2>/dev/null || true
    chmod -R 775 /var/www/html/wp-content/litespeed 2>/dev/null || true
else
    echo "[Docker Init] Avertissement: Ne s'exécute pas en root, permissions non modifiées"
fi

echo "[Docker Init] Permissions initialisées avec succès"

# Exécuter la commande originale de WordPress
exec "$@"

