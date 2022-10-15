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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'quangcao' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'ShZi*iYw!ic(@cDbQN8XNpTT!d?]6GyyiF&ZfM,$RQ,ao,^5e;8dju5M+8?l8LK|' );
define( 'SECURE_AUTH_KEY',  'x{@d/ibT_u<xN%Q(`#Fr7G!:_kRvVt*JT*w9LmLgq(G!>a*JMmeRC|VS>6?erR^D' );
define( 'LOGGED_IN_KEY',    'HvG_<wip$#|($?^eJMIFoS1Bc520?)@bb:kB?4C#ri%Lnyd|V]X{x!nOt^(7WkL}' );
define( 'NONCE_KEY',        'FTS3w!08XvoPECsf2P3dc_Wbo~r{4J2!^?])nr`|Ikvb>|sD3:jYeg_2E6bbp92g' );
define( 'AUTH_SALT',        '[=?<)GP}K,BJJ_UovCP?Y;MEOX[S9)p#9km8#W!i>;)n gR9n1pCR>bkoj{1CU6z' );
define( 'SECURE_AUTH_SALT', 'xx&RxV52+px5SkY:S-vplUtD%}/GPmB,ntY1@[SM_=6zk(gFI4gdfXUYhl9+/X+A' );
define( 'LOGGED_IN_SALT',   '}Z6JI~=O,$sgLjUou6k;)lC<x[pwOjVpA#|O]] 9 >tUA6]t7t5;eo0YK3>9Qx95' );
define( 'NONCE_SALT',       'UgxrDlEenYJ?p^/Z@nvl_$s.kIdbD9z|!xf1OK]P/y37VNb7!OzB/3_4=a-rPM}8' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
// phpinfo();