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

/**
 * Fonction load_env
 * 
 * Fonction personnalisée pour charger les variables 
 * d'environnement du fichier .env
 * 
 * @author Valentin FORTIN <contact@valentin-fortin.pro>
 * 
 * @return void - Aucune valeur de retour
 */
function load_env(): void
{
  $env = __DIR__ . '/.env';

  if (!file_exists($env)) {
    return;
  }

  $lines = file($env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) {
      continue;
    }

    list($name, $value) = explode('=', $line, 2);

    $name = trim($name);
    $value = trim($value);

    if (!defined($name)) {
      define($name, $value);
    }
  }
}

load_env();

// // ** Database settings - You can get this info from your web host ** //
// /** The name of the database for WordPress */
// define('DB_NAME', 'local');

// /** Database username */
// define('DB_USER', 'root');

// /** Database password */
// define('DB_PASSWORD', 'root');

// /** Database hostname */
// define('DB_HOST', 'localhost');

// /** Database charset to use in creating database tables. */
// define('DB_CHARSET', 'utf8');

// /** The database collate type. Don't change this if in doubt. */
// define('DB_COLLATE', '');

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
define('AUTH_KEY', 'Ze]pF`5t<?2+MUR{RUt$}LkGsQL%*q)9ur9H(B7NZ46U=6gPO=F*9WAHD]lEK<:~');
define('SECURE_AUTH_KEY', '0++wDk>CEz)x+OGmWgHTU[hyA|HYv&Ju!GtA5YGiAug:Tdyl9SOWNp*:mk[<|?Nv');
define('LOGGED_IN_KEY', 'ej1js%EU:If.jEW{*k/HWkc=XX5wn; {F; Wt nreYq3bQt{v`xmmCzn[mg,S7=G');
define('NONCE_KEY', '2I?zE)|~E_zAJ}i%<RN+xW0%6v8Q+.cU;W0L^(/>9SZcb@3!hwm~=f=g<v:swip)');
define('AUTH_SALT', 'mVJ41^%9#EdABkS87Qa%:u:%DE-O(`t^j96gi)#T]hk!>m[.z/)@}*;7cUi1,bk;');
define('SECURE_AUTH_SALT', '([EjonD}t1fQzur]e+%MVQSH2c&pqjN%ruv~FR vLVjZ-XbTUx&@`9O49a2lkah+');
define('LOGGED_IN_SALT', 'y]i-yhlW6Ts0;-rtc}<gXs5be@&vt=E,5oq|7zq+<C]blXz@G$]EKX;b;3e[p} :');
define('NONCE_SALT', 'WJ^o[zjxy!<+QoSX7V^c+S4f|oW]WfLE&`)Zq}kgG++!JAIfbUsU>77]$$`(:d$q');
define('WP_CACHE_KEY_SALT', 'z^&]IOc<W<)7Gv!_=d~M(8HqyVu.Z]`3w@NUB%Pq7pHOm7~C=X55_@fYs11n8s9<');


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
  define('WP_DEBUG', false);
}

define('WP_ENVIRONMENT_TYPE', 'local');
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
