<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// Configuration PHP pour éviter les erreurs "headers already sent"
@ini_set('output_buffering', '4096');
@ini_set('implicit_flush', '0');
@ob_start();

/**
 * Fonction load_env
 * 
 * Fonction personnalisée pour charger les variables 
 * d'environnement du fichier .env (local) ou .env.production (production)
 * 
 * @author Valentin FORTIN <contact@valentin-fortin.pro>
 * 
 * @return void - Aucune valeur de retour
 */
function load_env(): void
{
  // Priorité 1: .env (local/Docker)
  // Priorité 2: .env.production (production) seulement si .env n'existe pas
  $envLocal = __DIR__ . '/.env';
  $envProduction = __DIR__ . '/.env.production';
  
  // Charge .env en priorité (local), sinon .env.production (production)
  $envFile = file_exists($envLocal) ? $envLocal : (file_exists($envProduction) ? $envProduction : null);
  
  if (!$envFile) {
    return;
  }

  $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) {
      continue;
    }

    list($name, $value) = explode('=', $line, 2);

    $name = trim($name);
    $value = trim($value);
    
    // Retire les guillemets simples ou doubles si présents
    $value = trim($value, '"\'');
    // Retire les espaces en début/fin après avoir retiré les guillemets
    $value = trim($value);

    if (!defined($name)) {
      define($name, $value);
    }
  }
}

load_env();

// ** Database settings - You can get this info from your web host ** //
// Configuration: utilise les variables d'environnement (.env) si disponibles, sinon utilise les valeurs de production (commentées)

/** The name of the database for WordPress */
if (!defined('DB_NAME')) {
  // PRODUCTION (Hostinger) - Commenté pour utilisation locale
  // define('DB_NAME', 'u872521440_CtWrd');
  
  // LOCAL - Valeur par défaut si .env n'est pas configuré
  define('DB_NAME', 'wordpress_local');
}

/** Database username */
if (!defined('DB_USER')) {
  // PRODUCTION (Hostinger) - Commenté pour utilisation locale
  // define('DB_USER', 'u872521440_dho06');
  
  // LOCAL - Valeur par défaut si .env n'est pas configuré
  define('DB_USER', 'wordpress_user');
}

/** Database password */
if (!defined('DB_PASSWORD')) {
  // PRODUCTION (Hostinger) - Commenté pour utilisation locale
  // define('DB_PASSWORD', 'Terrador#788!');
  
  // LOCAL - Valeur par défaut si .env n'est pas configuré
  define('DB_PASSWORD', 'wordpress_password');
}

/** Database hostname */
if (!defined('DB_HOST')) {
  // PRODUCTION (Hostinger) - Commenté pour utilisation locale
  // define('DB_HOST', 'srv2060.hstgr.io');
  
  // LOCAL - Docker Compose utilise 'db' comme hostname
  define('DB_HOST', 'db');
}

/** Database charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
  define('DB_CHARSET', 'utf8');
}

/** The database collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
  define('DB_COLLATE', '');
}

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
// Utilise les clés du .env si disponibles, sinon utilise les clés de production (commentées)
if (!defined('AUTH_KEY')) {
  // PRODUCTION - Commenté pour utilisation locale
  // define('AUTH_KEY', 'Ze]pF`5t<?2+MUR{RUt$}LkGsQL%*q)9ur9H(B7NZ46U=6gPO=F*9WAHD]lEK<:~');
  define('AUTH_KEY', 'put your unique phrase here');
}
if (!defined('SECURE_AUTH_KEY')) {
  // define('SECURE_AUTH_KEY', '0++wDk>CEz)x+OGmWgHTU[hyA|HYv&Ju!GtA5YGiAug:Tdyl9SOWNp*:mk[<|?Nv');
  define('SECURE_AUTH_KEY', 'put your unique phrase here');
}
if (!defined('LOGGED_IN_KEY')) {
  // define('LOGGED_IN_KEY', 'ej1js%EU:If.jEW{*k/HWkc=XX5wn; {F; Wt nreYq3bQt{v`xmmCzn[mg,S7=G');
  define('LOGGED_IN_KEY', 'put your unique phrase here');
}
if (!defined('NONCE_KEY')) {
  // define('NONCE_KEY', '2I?zE)|~E_zAJ}i%<RN+xW0%6v8Q+.cU;W0L^(/>9SZcb@3!hwm~=f=g<v:swip)');
  define('NONCE_KEY', 'put your unique phrase here');
}
if (!defined('AUTH_SALT')) {
  // define('AUTH_SALT', 'mVJ41^%9#EdABkS87Qa%:u:%DE-O(`t^j96gi)#T]hk!>m[.z/)@}*;7cUi1,bk;');
  define('AUTH_SALT', 'put your unique phrase here');
}
if (!defined('SECURE_AUTH_SALT')) {
  // define('SECURE_AUTH_SALT', '([EjonD}t1fQzur]e+%MVQSH2c&pqjN%ruv~FR vLVjZ-XbTUx&@`9O49a2lkah+');
  define('SECURE_AUTH_SALT', 'put your unique phrase here');
}
if (!defined('LOGGED_IN_SALT')) {
  // define('LOGGED_IN_SALT', 'y]i-yhlW6Ts0;-rtc}<gXs5be@&vt=E,5oq|7zq+<C]blXz@G$]EKX;b;3e[p} :');
  define('LOGGED_IN_SALT', 'put your unique phrase here');
}
if (!defined('NONCE_SALT')) {
  // define('NONCE_SALT', 'WJ^o[zjxy!<+QoSX7V^c+S4f|oW]WfLE&`)Zq}kgG++!JAIfbUsU>77]$$`(:d$q');
  define('NONCE_SALT', 'put your unique phrase here');
}
if (!defined('WP_CACHE_KEY_SALT')) {
  // define('WP_CACHE_KEY_SALT', 'z^&]IOc<W<)7Gv!_=d~M(8HqyVu.Z]`3w@NUB%Pq7pHOm7~C=X55_@fYs11n8s9<');
  define('WP_CACHE_KEY_SALT', 'put your unique phrase here');
}


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if (!defined('WP_DEBUG')) {
  // PRODUCTION - false pour la production
  // define('WP_DEBUG', false);
  
  // LOCAL - true pour le développement local
  define('WP_DEBUG', true);
}

// Enable logging to wp-content/debug.log
if (!defined('WP_DEBUG_LOG')) {
  define('WP_DEBUG_LOG', true);
}

// Disable display of errors on screen (errors will still be logged)
if (!defined('WP_DEBUG_DISPLAY')) {
  define('WP_DEBUG_DISPLAY', false);
}

// Ensure errors are not shown to end users
@ini_set('display_errors', 0);

if (!defined('WP_ENVIRONMENT_TYPE')) {
  // PRODUCTION - 'production' pour la production
  // define('WP_ENVIRONMENT_TYPE', 'production');
  
  // LOCAL - 'local' pour le développement local
  define('WP_ENVIRONMENT_TYPE', 'local');
}

// Forcer HTTP en local (désactiver la détection automatique HTTPS)
if (!defined('FORCE_SSL_ADMIN')) {
  define('FORCE_SSL_ADMIN', false);
}

// Désactiver la détection automatique HTTPS pour les URLs
if (!defined('FORCE_SSL')) {
  define('FORCE_SSL', false);
}

// Forcer WordPress à utiliser HTTP au lieu de HTTPS en local
if (WP_ENVIRONMENT_TYPE === 'local') {
  // Désactiver la détection HTTPS via les en-têtes
  $_SERVER['HTTPS'] = 'off';
  
  if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'http';
  }
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
