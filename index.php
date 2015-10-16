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
use Knp\Menu\MenuFactory;

Debug::enable();

$ray = new Raystar();

if (isset($_GET['q']) == "update") {
    $ray->updateFile();
    echo "<b>Procesing save</b><br />";
    echo $ray->respond . "<br />";
}

$editPresetName = (isset($_GET['preset']) != "") ? $_GET['preset'] : "";
$ray->readFile($editPresetName);

$loader = new Twig_Loader_Filesystem('app/templates');
$twig = new Twig_Environment($loader, array('debug' => true));


$factory = new MenuFactory();
$menu = $factory->createItem('My menu');

$url = '';
foreach ($ray->presetName as $url) {
    $menu->addChild($url, array('uri' => '?preset=' . $url));
}
$itemMatcher = new \Knp\Menu\Matcher\Matcher();
$renderer = new \Knp\Menu\Renderer\ListRenderer($itemMatcher);


$template = $twig->loadTemplate('index.twig');
echo $template->render(array(
        'presetNameTable' => $ray->presetNameTable,
        'presetNameArray' => $ray->presetName,
        'timePresetData' => $ray->timePresetData,
        'colorArray' => $ray->sortColor(),
        'presetValuesData' => $ray->presetValues,
        'origanalStringForForm' => $ray->origanalStringForForm,
        'origanalNameForForm' => $ray->origanalNameForForm,
        'renderer' => $renderer,
        'menu' => $menu,
    )
);