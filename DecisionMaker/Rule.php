<?php

namespace DecisionMaker;

class Rule
{
    public $conditions;
    public $result;

    public function __construct($conditions, $result)
    {
        $this->conditions = $conditions;
        $this->result = $result;
    }

    public function get_rule()
    {
        return $this;
    }

    public function get_conditions(){
        return $this->conditions;
    }

    public function get_result(){
        return $this->result;
    }
}
