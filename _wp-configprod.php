<?php
define( 'WP_CACHE', true );

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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u872521440_CtWrd' );

/** Database username */
define( 'DB_USER', 'u872521440_dho06' );

/** Database password */
define( 'DB_PASSWORD', 'alkAuply21' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',          'Gc!#B@?ou;^tC)b4~*zZX+BskK3&&Zb@}%(kp}WsoN.M]98!1]oWBcT5=kq=8r~;' );
define( 'SECURE_AUTH_KEY',   ' w}I| v;TVH*h0K@{#>@qK@mGU$9,K^A2j#C!Yvjnrv+ LX}H:+<?4^uKV(EbNHM' );
define( 'LOGGED_IN_KEY',     'rNkn:cK..RFY$JQoCa5ZkV6Rg;hnTggF:`I@A$O[dr:/p-PQ!T@IlXBGXZcv0=LM' );
define( 'NONCE_KEY',         'c!d]m(3KNPH|)yYrs}2tUkf`pA0q%>Id{NzuiMNa@GP+]IPUEM=c69Vuqw{7o~hz' );
define( 'AUTH_SALT',         '//ZNBa7K^!lH:14@A?t%K+rB^>RStu @jVMhCS8.&e*7v$A!_5NMF/R3&]DQ3-A/' );
define( 'SECURE_AUTH_SALT',  'GK:+G-chp:iBy~0{eI~/*dSi4_R OLmN!NU8`Ff/x:)J~WToC>IAU=~[l4NoWDu{' );
define( 'LOGGED_IN_SALT',    '_c9ApHj_W~b[evHbn8Q|fQ[{+tbmK QR(Vs1$ZzlD?,7VkO(vcoq~l#q7b1*pT6v' );
define( 'NONCE_SALT',        'bA|~0sM-7L7HPeP8#F/7QVTjy=ZLG)dAQ/ase_wSe(&_:C,N?;#)pqMw1|k$V(B9' );
define( 'WP_CACHE_KEY_SALT', 'va,iJVHph`fmm@N!C>+q3d:Zv>8g%}FoC(OcVYkn)-[}2<!a;=(cm,Z5YcLR[mhs' );


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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '2e77a5844c1c2ad42b3bdda29b3a43eb' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
