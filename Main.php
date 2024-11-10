<?php
require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {
    private EmployeeRoster $roster;

    public function start() {
        $rosterSize = (int) readline("Enter the size of the roster: ");
        $this->roster = new EmployeeRoster($rosterSize);
        $this->entrance();
    }

    public function entrance() {
        while (true) {
            $this->clear();  // Clears the screen
            $this->menu();
            $choice = (int) readline("Pick from the menu: ");
            
            switch ($choice) {
                case 1:
                    $this->clear();  // Clears the screen
                    $this->addEmployee();
                    readline('Press "Enter" to continue...');
                    $this->clear(); 
                    break;
                case 2:
                    $this->clear();  // Clears the screen
                    echo "[-- Employee Roster --]\n";
                    $this->roster->displays();  // Display all employees
                    $this->clear();  // Clear after displaying
                    break;
                case 3:
                    $this->clear();  // Clears the screen
                    echo "[1] Display Employees\n";
                    echo "[2] Payroll\n";
                    echo "[3] Count\n";
                    echo "[0] Return to Main Menu\n";
                    $multipleChoice = (int) readline("Pick from the menu: ");
                    switch ($multipleChoice) {
                        case 1:
                            $this->clear();  // Clears the screen
                            $this->roster->display();
                            readline('Press "Enter" to continue...');
                            $this->clear(); 
                            break;
                        case 2:
                            $this->clear();  // Clears the screen
                            $this->roster->payroll();
                            readline('Press "Enter" to continue...');
                            $this->clear(); 
                            break;
                        case 3:
                            $this->clear();
                            $this->roster->countEmployeeTypes();
                            readline('Press "Enter" to continue...');
                            $this->clear(); 
                            break;
                        case 0:
                            break 2;
                        default:
                            echo "Invalid input. Please try again.\n";
                    }
                    break;
                case 0:
                    echo "Process terminated.\n";
                    return;  // Exit the entire function, ending the program
                default:
                    echo "Invalid input. Please try again.\n";
            }
        }
    }

    private function menu() {
        $this->clear();
        echo "Available space from the roster: " . $this->roster->getRemainingSlots() . "\n";
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    private function addEmployee() {
        do {
            echo "--Employee Details--\n";
            
            // Loop to get a unique name
            do {
                $name = readline("Enter name: ");
                if ($this->roster->hasEmployeeWithName($name)) {
                    echo "Employee '$name' already exists. Please use a unique name.\n";
                }
            } while ($this->roster->hasEmployeeWithName($name));
            
            $address = readline("Enter address: ");
            $companyName = readline("Enter company name: ");
            $age = (int) readline("Enter age: ");
            
            // Prompt for employee type
            $type = (int) readline("[1] Commission Employee, [2] Hourly Employee, [3] Piece Worker. Type of Employee: ");
            switch ($type) {
                case 1:
                    $salary = (float) readline("Enter regular salary: ");
                    $itemsSold = (int) readline("Enter # of Items: ");
                    $commissionRate = (float) readline("Enter commission (%): ");
                    $employee = new CommissionEmployee($name, $address, $age, $companyName, $salary, $itemsSold, $commissionRate);
                    break;
                case 2:
                    $hoursWorked = (int) readline("Enter hours worked: ");
                    $rate = (float) readline("Enter rate per hour: ");
                    $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
                    break;
                case 3:
                    $itemsProduced = (int) readline("Enter items produced: ");
                    $wagePerItem = (float) readline("Enter wage per item: ");
                    $employee = new PieceWorker($name, $address, $age, $companyName, $itemsProduced, $wagePerItem);
                    break;
                default:
                    echo "Invalid input.\n";
                    return;
            }
    
            // Add employee to the roster
            $this->roster->add($employee);
    
            // Ask if the user wants to add another employee
            $addMore = strtolower(readline("Do you want to add another employee? (yes/no): "));
        } while ($addMore === "yes");
    }
    
    public function clear(){
        if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
            // Windows operating system
            popen('cls', 'w');
        } else {
            // Unix-based operating system (Linux, macOS)
            system('clear');
        }
        echo str_repeat("\n", 50); 
    }
}
?>
