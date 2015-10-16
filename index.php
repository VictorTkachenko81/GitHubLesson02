<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 14.10.15
 * Time: 15:39
 */
require_once 'vendor/autoload.php';




require_once 'app/scr/raystar.php';
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
$template = $twig->loadTemplate('index.twig');

echo $template->render(array(
        'presetNameTable' => $ray->presetNameTable,
        'presetNameArray' => $ray->presetName,
        'timePresetData' => $ray->timePresetData,
        'colorArray' => $ray->sortColor(),
        'presetValuesData' => $ray->presetValues,
        'origanalStringForForm' => $ray->origanalStringForForm,
        'origanalNameForForm' => $ray->origanalNameForForm,
    )
);