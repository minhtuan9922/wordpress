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
define('DB_NAME', 'wordpress');

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
define('AUTH_KEY',         'ALLLs)po|I4GT$Seyd7eAys-+L+mZ>)L`,o^k+,=@</xR&S?yLz(G+U/rT*{6i&W');
define('SECURE_AUTH_KEY',  'i1;lzj~*BT`#OSHh|,z2k&z&lUED8Mq.DHO&F8P2AH~VicK{o`A)U}+1yp08g9q=');
define('LOGGED_IN_KEY',    '|{8W~!ic;7T2Z?kVE_.25}w!y.5?M6>5}g/OcfyEl[XaYU!Uvv!niTntRY@jeWu_');
define('NONCE_KEY',        'lA~N/h4rRm-!u.BU(D%.h,4Yf[OP#e)1m-+VVwMb!9~VmX||96,QSn3iUhHi{I_3');
define('AUTH_SALT',        'g]pH/{Alj3fqgLG:Vw*I#F#T#CPax4Z51MQa<0NpWC5&2ohRKI*$%Wl&F$cB <l~');
define('SECURE_AUTH_SALT', '2c6~3f $L..7iZKW1FTBLUYo#{J*AS?bs%Dc6t6N`jFj5QU3d60FRa7KA9]H2Z?R');
define('LOGGED_IN_SALT',   'qgO,)k6@vEGRC%Q7e|NKX }b4t{DO[VMW;AhChMk8$d71a *TyGYh)Fg&+s^I_Rr');
define('NONCE_SALT',       '|%1#adnNU[^][K63FMa:)7[b_Dz5iVe2euoW1g^3nc{R%;Buvbp=#@RyEr MZpL2');

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
