<?php

namespace DecisionMaker;

require 'Condition.php';
require 'Rule.php';

class DecisionMaker
{
    public $rules = array();
    public $flights = array();

    public function __construct($flights)
    {
        $this->flights = $flights;
        $this->set_predefined_rules();
    }

    public function get_results()
    {
        foreach ($this->flights as $flight) {
            echo $flight->country . ' ' . $flight->status . ' ' . $flight->details . ' ' . $this->check_flight($flight) . PHP_EOL;
        }
    }

    // Predefine rules
    // TODO: add method which reads custom rules from file
    private function set_predefined_rules()
    {
        // Set condition which repeats a lot
        $country_yes = new Condition('Country', '=', 'EU', true);

        // Set rules
        $this->rules[] = new Rule(array($country_yes, new Condition('Cancel', '<=', '14', true)), 'Y');
        $this->rules[] = new Rule(array($country_yes, new Condition('Delay', '>=', '3', true)), 'Y');
        $this->rules[] = new Rule(array($country_yes, new Condition('Cancel', '<=', '14', false)), 'N');
        $this->rules[] = new Rule(array($country_yes, new Condition('Delay', '>=', '3', false)), 'N');
        $this->rules[] = new Rule(array(new Condition('Country', '=', 'EU', false)), 'N');
    }

    public function get_rules()
    {
        return $this->rules;
    }

    public function get_flights()
    {
        return $this->flights;
    }

    // Check if flight has applicable rules
    private function check_flight($flight)
    {
        foreach ($this->rules as $rule) {
            $results = $this->compare_flight($flight, $rule);
            // if found rule, return results
            if ($results) {
                return $results;
            }
        }
    }

    // If either one condition fails, skip and compare another rule
    private function compare_flight($flight, $rule)
    {
        foreach ($rule->get_conditions() as $condition) {
            if ($condition->condition == 'Country') {
                if ($this->check_eur_countries($flight->country) != $condition->result) {
                    return false;
                }
            } else if ($flight->status == $condition->condition) {
                if ($condition->result != $this->string_to_operator_compare($flight->details, $condition->operator, $condition->value)) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return $rule->get_result();
    }

    // Check if country is in EU
    private function check_eur_countries($country)
    {
        $eu = array('BE', 'BG', 'CZ', 'DK', 'DE', 'EE', 'IE', 'EL', 'ES', 'FR', 'HR', 'IT', 'CY', 'LV', 'LT', 'LU', 'HU', 'MT', 'NL', 'AT', 'PL', 'PT', 'RO', 'SI', 'SK', 'FI', 'SE');
        return in_array($country, $eu);
    }

    private function string_to_operator_compare($value1, $operator, $value2)
    {
        switch ($operator) {
            case "==":
            case "=":
                return $value1 == $value2;
            case ">=":
                return $value1 >= $value2;
            case "<=":
                return $value1 <= $value2;
            case "<":
                return $value1 < $value2;
            case ">":
                return $value1 > $value2;
        }
    }
}
