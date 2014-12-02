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

$env = 'development';

switch ($env){
    case 'development':
        // ** MySQL settings - You can get this info from your web host ** //
        /** The name of the database for WordPress */
        define('DB_NAME', 'classcompete_wp_live');

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
        break;
    default:
        // ** MySQL settings - You can get this info from your web host ** //
        /** The name of the database for WordPress */
        define('DB_NAME', 'wordpress');

        /** MySQL database username */
        define('DB_USER', 'wordpress');

        /** MySQL database password */
        define('DB_PASSWORD', '');

        /** MySQL hostname */
        define('DB_HOST', 'localhost');

        /** Database Charset to use in creating database tables. */
        define('DB_CHARSET', 'utf8');

        /** The Database Collate type. Don't change this if in doubt. */
        define('DB_COLLATE', '');

        break;
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'lPi:kEA8H)lDQSGoI^(v!_y2SrKty*ETvXMQ|=YH4--iAoG(2nc$6K^Z@o/84v2z');
define('SECURE_AUTH_KEY',  '/c>.}Mx2ug)6FnMHKYjR7}f(m6?qCQ1t3OjZ]Rpt96{btIT%4#uc!J;"Q)k.y_j|');
define('LOGGED_IN_KEY',    'xCZv;<Z1;V@m1s|63ti$$b8r:.hs@Ar6$?C6$|t6V3.Xw,5Aj+b"})m/!DjJ%KQQ');
define('NONCE_KEY',        'z/ja.N&MR77+V@l%Xx0Uf"L>y5xad+1N%-Y6wCg+6n03}:FUqddG7YtFr1QFMf.p');
define('AUTH_SALT',        '}O;u,8f{w<Yu*2<6f0MnY^4?Eht?wkdu96YXf%TL2g^Gj3Nz3}Wp$nefFH4#2i5y');
define('SECURE_AUTH_SALT', '/c>.}Mx2ug)6FnMHKYjR7}f(m6?qCQ1t3OjZ]Rpt96{btIT%4#uc!J;"Q)k.y_j|');
define('LOGGED_IN_SALT',   '9I|/5C*wpS?9PD,s9Dae$C{2>kDZk9r.Rq-X3Z;.g(06j,[ts6I4IF7vZK:-Uk@a');
define('NONCE_SALT',       'KT8bhZ1xG111.{;j2AoL^v*D^!lx;"HCOdN6$O1iQ3(G|!128<O+htp[1Kt:F@w/');

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
define('WP_DEBUG_DISPLAY', false);

define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_CONTENT_URL', '/wp-content');
define('DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST']);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');