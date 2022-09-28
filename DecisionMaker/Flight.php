<?php

namespace DecisionMaker;

class Flight
{
    public $country;
    public $status;
    public $details;

    public function __construct($country, $status, $details)
    {
        $this->country = $country;
        $this->status = $status;
        $this->details = $details;
    }

    public function get_flight()
    {
        return $this;
    }
}
