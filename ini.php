<?php

/* --------------------------------------------------
 * DOMAIN
 * --------------------------------------------------
**/

if( !defined( 'DOMAIN' ) )
    define( 'DOMAIN', ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . ( !empty( $_SERVER['SERVER_PORT'] ) ? ':' . $_SERVER['SERVER_PORT'] : '' ) . dirname( $_SERVER['PHP_SELF'] ) . '/' );

// /* --------------------------------------------------
//  * BDD
//  * --------------------------------------------------
/**/
if( !defined( 'SGBD' ) )
    define( 'SGBD', 'mysql' );
if( !defined( 'HOST' ) )
    define( 'HOST', 'localhost' );
if( !defined( 'DBNAME' ) )
    define( 'DBNAME', 'nains' );
if( !defined( 'USER' ) )
    define( 'USER', 'root' );
if( !defined( 'PWD' ) )
    define( 'PWD', '' );