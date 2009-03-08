<?php

define('APP_ENV', 'test');

require_once realpath(dirname(__FILE__) . '/../application/Setup.php');

/* Start the bootstrap process */
Setup::startBootstrap();

require_once realpath(dirname(__FILE__) . '/../application/Initializer.php');