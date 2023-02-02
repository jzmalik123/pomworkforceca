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
define( 'DB_NAME', 'pomworkf_pomworkforceca' );

/** Database username */
define( 'DB_USER', 'pomworkf_pomworkforceca' );

/** Database password */
define( 'DB_PASSWORD', '@89kYt_;ubV#' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define( 'AUTH_KEY',         '5|l}QaN@m>%eR,+  M*>_A .d=?=JIHzvfdV@]:Q;[02v_o2LR]0xN]pq3x1?N)0' );
define( 'SECURE_AUTH_KEY',  '`+xh,aZdsd18<^NtrMAy~S_N451+aM$;h>|w|a%O$0.+mr9:o5*FNWK)r9.a`bRf' );
define( 'LOGGED_IN_KEY',    '+/L!As+NLj3||Dq ?]jF9XF;/?)Ln&55W$Ai!S@q>v5^M.&kVfsbrDoufPoAJpj<' );
define( 'NONCE_KEY',        '*RiSq`RFoq[?*?ZJB>,3iN*LU+}Q0DkvB<9B8~K Z1jzH(7CpI[7#uSA%x(1$I2f' );
define( 'AUTH_SALT',        'n2L_C;q S@P/=!$wFt_QV*5ZuWim[(7.bF(%ndHXJ n!BJE!?3.XgI/]h_FOU(@W' );
define( 'SECURE_AUTH_SALT', 'l*|,tSm`+my%$RV)@$pVi$I:#ZQf=Sp^8Y,Yyq<NUpm%}s^wCHvdcyHcjNA&bg^5' );
define( 'LOGGED_IN_SALT',   'Z>kz_rb.FfufZ@<u@E32$7VS`J:pNn:?.p.@HOcPT~>UHNfkpp(<8s>@uK@ywLgM' );
define( 'NONCE_SALT',       '@%lnN}DM;yI*bXpW!~Hcid$%JL^^Y6<N&TAXR1=xxuMMxsu[{YYwHzlz]h<4; 1I' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
