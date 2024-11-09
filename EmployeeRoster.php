<?php
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {
    private $roster;
    private $nextId;
    private $deletedIds = [];
    public function __construct($rosterSize) {
        $this->roster = array_fill(0, $rosterSize, null);
        $this->nextId = 1;
    }
    
    public function add($employee) {
        $availableId = $this->getAvailableId(); 
        
        for ($i = 0; $i < count($this->roster); $i++) {
            if ($this->roster[$i] === null) {
                if (method_exists($employee, 'setEmployeeId')) {
                    $employee->setEmployeeId($availableId); 
                    $this->roster[$i] = $employee;
                    return true;  
                } else {
                    echo "Error: Employee class does not support setting an ID.\n";
                    return false;
                }
            }
        }
        echo "Roster is full. Cannot add more employees.\n";
        return false; 
    }
    private function getAvailableId() {
        if (!empty($this->deletedIds)) {
            return array_shift($this->deletedIds); 
        }
        return $this->nextId++; 
    }

    
public function deleteEmployeeById(int $employeeId) {
    foreach ($this->roster as $index => $employee) {
        if ($employee !== null && $employee->getEmployeeId() === $employeeId) {
            $this->roster[$index] = null; 
            $this->deletedIds[] = $employeeId; 
            sort($this->deletedIds); 
            return true;
        }
    }
    echo "Employee ID not found.\n";
    return false; // Employee ID not found
}
    
    
    public function getRoster() {
        return $this->roster;
    }

    public function addCommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate) {
        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate);
        return $this->add($employee);
    }


    public function addHourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate) {
        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        return $this->add($employee);
    }

    public function addPieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem) {
        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        return $this->add($employee);
    }

    public function countAll() {
        echo "Hourly Employee: " .count(array_filter($this->roster));
    }

    public function countCE() {
        echo "Hourly Employee: " .count(array_filter($this->roster, fn($e) => $e instanceof CommissionEmployee));
    }

    public function countHE() {
        echo "Hourly Employee: ".count(array_filter($this->roster, fn($e) => $e instanceof HourlyEmployee));
    }

    public function countPE() {
        echo "Piece Worker Employee: ".count (array_filter($this->roster, fn($e) => $e instanceof PieceWorker));
    }

    public function clear(){
        // popen('cls','w');
        if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
            // Windows operating system
            popen('cls', 'w');
        } else {
            // Unix-based operating system (Linux, macOS)
            system('clear');
        }
        echo str_repeat("\n", 50); 
    }
    public function displayAll() {
        $this->clear();
        $this->clear();
        $this->clear();
        $found = false; 
        echo "**Display of All of the Employee**\n";
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo $employee->toString(). "\n"; 
                $found = true; 
            }
        }
        if (!$found) {
            echo "\n";
        }
    }

    public function displayCE() {
        $this->clear();
        $found = false; 
        echo "Commission Employee: \n" ;
    foreach ($this->roster as $employee) {
        if ($employee !== null && $employee instanceof CommissionEmployee) {
            echo $employee->toString();
            $found = true;
        }
    }
    if (!$found) {
        echo "There are no Commission Employees added or all have been deleted.\n";
    }
    }

    


    public function displayHE() {
        $this->clear();
        $found = false; 
        echo "Hourly Employee:\n" ;
        foreach ($this->roster as $key => $employee) {
            if ($employee !== null && $employee instanceof HourlyEmployee) {
                echo $employee->toString();
                $found = true; 
            }
        }
            if (!$found) {
                echo "There are no Hourly Employees added or all have been deleted.\n";
            }       
    }

    public function displayPE() {
        $this->clear();
        $found = false;
        echo "Piece Worker:\n" ;
        foreach ($this->roster as $key => $employee) {
            if ($employee !== null && $employee instanceof PieceWorker) {
                echo $employee->toString();
                $found = true;
            }           
        }
        if (!$found) {
            echo "There are no Piece Worker Employees added or all have been deleted.\n";
        }  
    }

    public function calculateTotalPayroll() {
        $totalPayroll = 0;
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                $totalPayroll += $employee->earnings();
            }
        }
        return $totalPayroll;
    }
    
    public function count() {
        return count(array_filter($this->roster));
    }

    public function payroll() {
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                $this->displayAll();
            }
        }
    }
}
?>
