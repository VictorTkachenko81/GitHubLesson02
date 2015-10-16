<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 14.10.15
 * Time: 15:39
 */

require_once 'vendor/autoload.php';
require_once 'app/scr/raystar.php';

use Symfony\Component\Debug\Debug;
Debug::enable();

$ray = new Raystar();
$ray->run();
