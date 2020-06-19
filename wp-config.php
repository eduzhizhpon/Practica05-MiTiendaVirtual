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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'v3GhWCQK' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'Dw swQch+2+<ZgoL|`~~r,. 1bxFxB^I3tS+o8zjeV2DDLa!,WfQ(.u.l]B/<qNi' );
define( 'SECURE_AUTH_KEY',   '[-e[#mo=-%$F<n;^pFE=8c{q(6B)k8=V%.ut8fBs SV;%6?v!sHb}rp?wx{|Zs;x' );
define( 'LOGGED_IN_KEY',     'y;h6|0dGtdw%0DoopFZ:n}X2cCv6~1}J#3~w>OOY6bW&}eLr7DV QSI. X AcTY2' );
define( 'NONCE_KEY',         '.I^M};2F3!pSeo Xo /]h{5`|U-hcBF8#^lTFAZ@q5J1*gqwlIlU2#|q4JARw[S ' );
define( 'AUTH_SALT',         '0WXo[SO2hsy+w%DK2fCCBZ]uJ_]nA?RUur53SW @~ I#_quHu@uYl.+I`fA%qk4t' );
define( 'SECURE_AUTH_SALT',  '5}%5.ShI-3u# pqcY0d7s]K`E-^ut*RVA#LWD77arQ4-`aN+T!}{TQSAuB kiU&.' );
define( 'LOGGED_IN_SALT',    'FB9#jNC_TY@vob8zinu4(L8FzAIjEg;%r_e[o@=+>RVO6a-Fn^B>8/=u&f!m;t)0' );
define( 'NONCE_SALT',        '=O;=274iASPkEdIE#zwwqNr<7;P5 0T{Y<4?=oxa<Tb^/eY&rP~XCVNV3OlXj(I9' );
define( 'WP_CACHE_KEY_SALT', 'TF^j1kXGdN[9m-^GG~S;<cvP@?g_W=Qx}LzuWI 4ztlgNg-kYjV0Nb R+;y}n,^<' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
