<?php
//Load config file
require_once 'config/config.php';

// Load Helpers
require 'helpers/session_helper.php';
require 'helpers/url_helper.php';
require 'helpers/login_helper.php';

//AutoLoad base classes
spl_autoload_register(function ($className) {
  require_once 'base/' . $className . '.php';
});

require 'helpers/statistics_helper.php';
