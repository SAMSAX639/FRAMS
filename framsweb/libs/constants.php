<?php
// dont add a trailing / at the end
define('HTTP_SERVER', 'http://localhost');
// add slash / at the end
define('SITE_DIR', '/FRAMS/');

// database prefix if you use
define('DB_PREFIX', 'mp_');

define('DB_DRIVER', 'mysql');
define('DB_HOST', 'frams');
define('DB_HOST_USERNAME', 'user');
define('DB_HOST_PASSWORD', 'user123@FRAMS');
define('DB_DATABASE', 'information');

define('SITE_NAME', 'FRAMS');

// define database tables
define('TABLE_PAGES', DB_PREFIX.'pages');
define('TABLE_TAGLINE', DB_PREFIX.'tagline');
?>
