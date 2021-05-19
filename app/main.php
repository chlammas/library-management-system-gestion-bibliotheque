<?php
//Load config file
require_once 'config/config.php';

// Load Helpers
require_once 'helpers/session_helper.php';
require_once 'helpers/url_helper.php';
require_once 'helpers/login_helper.php';
if ($_SESSION['lang'] === 'fr') {
  require_once APPROOT . '/helpers/languages/fr.php';
} else {
  require_once APPROOT . '/helpers/languages/en.php';
}

//AutoLoad base classes
spl_autoload_register(function ($className) {
  require_once 'base/' . $className . '.php';
});

require 'helpers/statistics_helper.php';
