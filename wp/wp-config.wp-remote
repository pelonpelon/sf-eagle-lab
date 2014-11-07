<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sfeaglewp');

/** MySQL database username */
define('DB_USER', 'sfeaglewp');

/** MySQL database password */
define('DB_PASSWORD', 'S@nFrancisc0');

/** MySQL hostname */
define('DB_HOST', 'sfeaglewp.db.9803620.hostedresource.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Allow WP to repair database */
/** define('WP_ALLOW_REPAIR', true); */

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'g>+gJGwI(}e3rMTLl SH}vZ~WL|0Nt83AMz7r0u]~19&2ZlQ>Ll&(LMV+-_8uHn;');
define('SECURE_AUTH_KEY',  '*y6t`_#2A@t lhFasy=9DC +p2C#U*d3(@HkKZix^Xp3=.npFMn|Ra|6G9fN@sJ*');
define('LOGGED_IN_KEY',    'NhinFB-C3LlS!hQqNzD<AUAxB~f6Wx%ZR.lLp*RTKTlE&[g!!+noZ&sQbaXzh6TK');
define('NONCE_KEY',        'u /T*#E!BIl~_UX;/JAPU%|^fIC$U9<PtXvx=X5P6 ,k/w-Oli4;7zNUCn=S(/-p');
define('AUTH_SALT',        'c*_xr-s$z<Fk=y8sRWeR?YJ;0XkYF$(.G#= |A_R0PNt?^f*K{~>KL6N!F4G_MMw');
define('SECURE_AUTH_SALT', 'KfT{<w]6270qHrR2NyNb7&5S<=vhVJoDdBGLH[vqTR,*B6<}w+E@n.l%8Q^O_z{T');
define('LOGGED_IN_SALT',   '|w{u+9!sLhDsWXl:PW!k5}d.X@l?|Eq!ivMQ`eKd~L{t$Qb?t:N@AQ@OPGUp@zW=');
define('NONCE_SALT',       'b7$d65~!Qw^z,eYnyp.J_om* -&*sHn5eT(Y1lHV)u607yDAC6<QQEmXnDaH3P1~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
