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
define('DB_NAME', 'portofolio');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'ng_)x)%#EYE~gzuTH[.2Ie6ql-WsV/;r?3!SHj8Bt0J<rtzs}tHuWUvW[9Mh-Q^f');
define('SECURE_AUTH_KEY',  'hv4jrxFP-R]B0Cv403z/X`:~N31tvE1[K6m^?:)gF@s?ckEDs{Ot* YR#wI=}VP>');
define('LOGGED_IN_KEY',    's @>xqNJ+P&Tt#RJ>vM1v*P}*j&,Xq<?Ko+;2)`u]ls<kA-Q2j|Q+CyLDzE~X1q;');
define('NONCE_KEY',        '+gbC5WxEe@PU`Oov65%Y>J(,2b{=5G9$@fOwRloEL[*~(PJW;tV1.u0^Lq,+XM04');
define('AUTH_SALT',        'E?*x69(WK~;L=] zfi{)OHeC*A@uPrW;/vQ_]-E|e@#TNy.n#zo>-o.OT,|}#{yH');
define('SECURE_AUTH_SALT', 'Ek]LlmbGe}P?V>hHvPz&xvtj02#D<DIcKm@xy0y.5/0RA3e<5y+y+Agsk7dg2Kxe');
define('LOGGED_IN_SALT',   'FjZZll$g,+hF$G-NM[O<T&MSh4Uj4>g:2:;Kr}c-&@BPf!(cpCh#V+6S{@@|HqkU');
define('NONCE_SALT',       'MPq>)V 7R$wHG2s|oy,s6l%Bvbt=uzqFih5/{v/%B#TK{d(XLsT._~.gPS cx?dr');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
