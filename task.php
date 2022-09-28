<?php

define("ABSPATH", __DIR__);

require 'helpers.php';
require 'DecisionMaker/DecisionMaker.php';

use DecisionMaker\DecisionMaker;

// Read data file
$flights = readFlightsData();

$decision = new DecisionMaker($flights);

$decision->get_results();
