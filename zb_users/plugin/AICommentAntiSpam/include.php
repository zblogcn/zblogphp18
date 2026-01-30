<?php

if (version_compare(PHP_VERSION, '8.1.0', '>=')) {
    define('AICommentAntiSpam_Version',1.2);
    require_once dirname(__FILE__) . '/vendor/autoload.php';
    require_once dirname(__FILE__) . '/includes/plugin_function.php';
}

RegisterPlugin("AICommentAntiSpam","ActivePlugin_AICommentAntiSpam");