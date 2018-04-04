<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 31/3/18
 * Time: 1:38 AM
 */

// check xdebug is installed
if (!extension_loaded('xdebug')) {
    echo "xdebug is not loaded" . PHP_EOL;
    exit(E_ERROR);
}