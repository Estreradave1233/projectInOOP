<?php
require_once 'Employee.php';

class CommissionEmployee extends Employee {
    private $regularSalary=12168;
    private $itemsSold;
    private $commissionRate;

    public function __construct($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemsSold = $itemsSold;
        $this->commissionRate = $commissionRate;
    }

    public function earnings() {
        return $this->regularSalary + ($this->itemsSold * $this->commissionRate);
    }

    public function toString() {
        return parent::toString() . "\nType of Employee: Commission Employee \nRegular Salary: $this->regularSalary \nItems Sold: $this->itemsSold \nCommission Rate: $this->commissionRate \nSalary: " . $this->earnings();;
    }
}
?>
