<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 14.10.15
 * Time: 14:54
 */

class Raystar
{
    public $filename = "RayStar.ini";

    public $color = array(
        "2" => array(
            "name" => "red",
            "wave" => "660",
            "sort" => "2",
            "color" => "red",
        ),
        "3" => array(
            "name" => "green",
            "wave" => "520",
            "sort" => "5",
            "color" => "green",
        ),
        "4" => array(
            "name" => "blue",
            "wave" => "470",
            "sort" => "7",
            "color" => "blue",
        ),
        "5" => array(
            "name" => "white",
            "wave" => "all",
            "sort" => "1",
            "color" => "#C5C5C5",
        ),
        "6" => array(
            "name" => "amber",
            "wave" => "610",
            "sort" => "3",
            "color" => "orange",
        ),
        "7" => array(
            "name" => "cyan",
            "wave" => "500",
            "sort" => "6",
            "color" => "cyan",
        ),
        "8" => array(
            "name" => "royal",
            "wave" => "450",
            "sort" => "8",
            "color" => "blue",
        ),
        "9" => array(
            "name" => "royal",
            "wave" => "440",
            "sort" => "9",
            "color" => "blue",
        ),
        "10" => array(
            "name" => "uv",
            "wave" => "420",
            "sort" => "10",
            "color" => "#7900FF",
        ),
        "11" => array(
            "name" => "uv",
            "wave" => "???",
            "sort" => "11",
            "color" => "#7900FF",
        ),
        "12" => array(
            "name" => "uv",
            "wave" => "???",
            "sort" => "12",
            "color" => "#7900FF",
        ),
        "13" => array(
            "name" => "uv",
            "wave" => "390",
            "sort" => "13",
            "color" => "#9433FF",
        ),
        "14" => array(
            "name" => "yellow",
            "wave" => "580",
            "sort" => "4",
            "color" => "yellow",
        ),
    );

    public $presetNameTable;
    public $origanalStringForForm;
    public $timePresetData;
    public $presetValues;
    public $origanalNameForForm;
    public $presetName;
    public $respond;

    public function readFile($editPresetName = 'factory'){

        $datafile = file($this->filename);

        while (list($key0, $marr) = each($datafile)) {

            $mdata = explode("=", $marr);
            $findData = preg_match('/^[UserPreset]+([0-9]+)$/', $mdata[0], $matches, PREG_OFFSET_CAPTURE);

            if ($findData) {

                $originalString = str_replace('"', '', $mdata[1]);
                $data = explode(";", $originalString);

                $originalName = '';
                while (list ($key, $val) = each($data)) {

                    if ($key == 0) {
                        $originalName = $val;
                        $dataName = explode(",", $val);
                        $this->presetName[$key0] = $dataName[0];
                    }

                    if ($editPresetName != null and $this->presetName[$key0] == $editPresetName and $key > 0 and $key < 21) {

                        $this->presetNameTable = $this->presetName[$key0];
                        $this->origanalStringForForm = $originalString;
                        $this->origanalNameForForm = $originalName;
                        $valueData = explode(",", $val);

                        $countTimePreset = '';
                        while (list ($key2, $val2) = each($valueData)) {
                            if ($key2 == 0) {
                                $countTimePreset = $val2;
                            }
                            if ($key2 == 1) {
                                $this->timePresetData[$countTimePreset] = $val2;
                            }
                            if ($key2 > 1) {
                                $this->presetValues[$key][$key2] = $val2;
                            }
                        }
                    }

                }
            }
        }

        return $this;

    }

    public function updateFile()
    {
            $timeData = $_POST['time'];
            $levelData = $_POST['level'];
            $updatedData = $_POST['originalname'];

            for ($i = 1; $i <= 20; $i++) {
                $updatedData = $updatedData . ";" . $i . "," . $timeData[$i];
                $levelPeriod = $levelData[$i];
                ksort($levelPeriod);
                foreach ($levelPeriod as $value) {
                    $valueData = round(255 * $value / 100, 0);
                    if ($valueData > 255) {
                        $valueData = 255;
                    }
                    $updatedData = $updatedData . "," . $valueData;
                }
            }

            $updatedData = $updatedData . ";";


            if (trim($_POST['originaldata']) == trim($updatedData)) {
                $this->respond = "Nothing is changed";
            } else {
                $fp = fopen($this->filename, 'r');
                $contents = fread($fp, filesize($this->filename));
                fclose($fp);

                $contentsUpdated = str_replace(trim($_POST['originaldata']), trim($updatedData), $contents);

                $fp = fopen($this->filename, 'w');
                fwrite($fp, $contentsUpdated);
                fclose($fp);

                $this->respond = "Data was changed";
            }

        return $this->respond;
    }

    public function sortColor()
    {
        uasort($this->color, array($this, 'compare'));
        return $this->color;
    }

    public function compare($a, $b)
    {
        if ($a['sort'] == $b['sort']) {
            return 0;
        }
        return ($a['sort'] < $b['sort']) ? -1 : 1;
    }
}