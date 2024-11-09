<?php
require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private $hoursWorked;
    private $rate;

    public function __construct($name, $address, $age, $companyName, $hoursWorked, $rate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hoursWorked = $hoursWorked;
        $this->rate = $rate;
    }

    public function earnings() {
        return $this->hoursWorked <= 40 ? $this->hoursWorked * $this->rate : 
               (40 * $this->rate) + (($this->hoursWorked - 40) * $this->rate * 1.5);
    }

    public function toString() {
        return parent::toString() . "\nType of Employee: Hourly Employee \nHours Worked: $this->hoursWorked\nRate: $this->rate \nSalary: " . $this->earnings();;
    }
}
?>

