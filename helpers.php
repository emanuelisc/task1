<?php

require 'DecisionMaker/Flight.php';

use DecisionMaker\Flight;

function readFlightsData($data_file = false)
{
    // If not specified, use example data file
    if (!$data_file) {
        $data_file = ABSPATH . "/data.csv";
    }

    $array = [];
    if (($open = fopen($data_file, "r")) !== FALSE) {

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = new Flight(trim($data[0]), trim($data[1]), trim($data[2]));
        }

        fclose($open);
    }
    return $array;
}
