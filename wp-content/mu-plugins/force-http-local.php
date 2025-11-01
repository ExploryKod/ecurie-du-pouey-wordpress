<?php
/**
 * Plugin Name: Force HTTP en Local
 * Description: Force toutes les URLs à utiliser HTTP au lieu de HTTPS en environnement local
 * Version: 1.0.0
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Seulement en environnement local
if (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local') {
    
    // Forcer les URLs de site à être en HTTP
    add_filter('site_url', function($url, $path, $scheme) {
        if ($scheme === 'https' || strpos($url, 'https://') === 0) {
            return str_replace('https://', 'http://', $url);
        }
        return $url;
    }, 10, 3);
    
    // Forcer les URLs home à être en HTTP
    add_filter('home_url', function($url, $path, $scheme) {
        if ($scheme === 'https' || strpos($url, 'https://') === 0) {
            return str_replace('https://', 'http://', $url);
        }
        return $url;
    }, 10, 3);
    
    // Forcer les URLs des médias à être en HTTP
    add_filter('wp_get_attachment_url', function($url) {
        return str_replace('https://localhost:10004', 'http://localhost:10004', $url);
    }, 10, 1);
    
    // Forcer les URLs dans le contenu des posts
    add_filter('the_content', function($content) {
        return str_replace('https://localhost:10004', 'http://localhost:10004', $content);
    }, 10, 1);
    
    // Forcer les URLs dans les widgets
    add_filter('widget_text', function($content) {
        return str_replace('https://localhost:10004', 'http://localhost:10004', $content);
    }, 10, 1);
    
    // Forcer les URLs dans les métadonnées Elementor
    add_filter('elementor/frontend/builder_content_data', function($data) {
        if (is_array($data)) {
            array_walk_recursive($data, function(&$value) {
                if (is_string($value)) {
                    $value = str_replace('https://localhost:10004', 'http://localhost:10004', $value);
                }
            });
        }
        return $data;
    }, 10, 1);
    
    // Forcer les URLs dans les options WordPress
    add_filter('option_upload_url_path', function($value) {
        if ($value && strpos($value, 'https://') === 0) {
            return str_replace('https://', 'http://', $value);
        }
        return $value;
    }, 10, 1);
}

