<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '3p3');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '2w5Sw.lVI{ZMv@29W%)?J9RO6n6f,%:#_nOWpxT9}8pOW_0Mp24@9cm=Q99fhH5h');
define('SECURE_AUTH_KEY',  '0VX;u)Bo<q+xJiFu2{L[{Xx(oWUjNli(/^j~8)r{u7eENW_N<=pwUpL1@n:=.I-@');
define('LOGGED_IN_KEY',    'Q2V0TX[U~Dp]D^/Fk~)L8A 2jzF,8LopLc5f_YPv9TIC~z&ak~,,x!q=e{puh`Yi');
define('NONCE_KEY',        '8U#`13V^h[3 e [zdkPj]hR-t^oV>:6[e1[dl_uXAz||^t7G:Iuo_{7s_Q%l+9G(');
define('AUTH_SALT',        '&CJks =|X-T6clCQpx-(+PF&s(ZyO?ql.d4}UY<D{a[t@+70(S/>cr|4)0 6ed|r');
define('SECURE_AUTH_SALT', 'Cm6-)N}+Up{wU6Z{*UlbaXhq8@v/f V|TyEJF$oO+k.^Vudy+~k4=JrB?)GVv7!i');
define('LOGGED_IN_SALT',   '9&PdX-yv/[llH52W!F%T}=(`0L5x`5@!;D(@ADU8nco%|$W7H6eE^$%Z6Q]l:WW,');
define('NONCE_SALT',       '8db,EtvPQZZ_SPfzI~Nbc/><9t4}/d?jxKe92`(ZS7Z.vGJB(ywymyF?E1dU`VtY');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
