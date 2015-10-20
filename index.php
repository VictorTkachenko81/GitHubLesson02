<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 14.10.15
 * Time: 15:39
 */

require_once 'vendor/autoload.php';

use Raystar\Raystar;
use Symfony\Component\Debug\Debug;

Debug::enable();

$ray = new Raystar();
$ray->run();
