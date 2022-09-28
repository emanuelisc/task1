<?php

namespace DecisionMaker;

class Condition
{
    public $condition;
    public $operator;
    public $value;
    public $result;
    
    public function __construct($condition, $operator, $value, $result)
    {
        $this->condition = $condition;
        $this->operator = $operator;
        $this->value = $value;
        $this->result = $result;
    }
}
