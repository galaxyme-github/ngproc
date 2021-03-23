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
define( 'DB_NAME', 'ngproc_wp450' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Ja6hEcQWhh%mG@$2$EITBBr3' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '55d9ki01o6kyo83qihsr0xywqvur2djw6iuassrlgnbwtlqkyqoqez1axt2sceez' );
define( 'SECURE_AUTH_KEY',  'yamwrkngmn1vm0p0deelew3t0fwgfw3bp7qcd6707hz1x9ob0u7m9ebyvsdb3qp0' );
define( 'LOGGED_IN_KEY',    'ym85hsebolynl4228u54kggi8q5pyx5gxmmbhd7475uis47hbuijnl1gvsjo4zry' );
define( 'NONCE_KEY',        'quqyctma8eluhvytfqzzb2hbnykgjlo3gucnmuozkiwe61jlxv8jzsj2vzhhjtlp' );
define( 'AUTH_SALT',        'sjsrqaqqiq6sk4356j80cpoubyeeokis9pfoxscvtws1idzvwo3fsbgdqxwrfa0g' );
define( 'SECURE_AUTH_SALT', '8hxziqpuhyyghf2pyc6aciysocgmv5nnztohm7fblccwwfewfo7f8u1wmlu5mylv' );
define( 'LOGGED_IN_SALT',   'jsqf5k4vplvjboiljajgfxcmqlu1lpxvoxndzcp18gzilcddugjowvapqkwgndcs' );
define( 'NONCE_SALT',       '9knfham2w6xualrqhm2tqbc4spkvccvqw5kjlx0pann1bfk9udsnl3vhfg2bcsel' );
define('CONCATENATE_SCRIPTS', false);
define( 'SCRIPT_DEBUG', true );
define( 'WP_DEBUG', true );
define( 'FS_METHOD', 'direct' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp7u_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
