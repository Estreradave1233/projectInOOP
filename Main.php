<?php
require_once 'EmployeeRoster.php';

class Main {
    private EmployeeRoster $roster;
    private $size;
    private $repeat=true;


    public function start() {
        $this->clear();
        $this->size = (int) readline("Enter the size of the roster: ");
        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            $this->start();
        }
        $this->roster = new EmployeeRoster($this->size);
        $this->entrance();
    }


    public function entrance() {
        while ($this->repeat) {
             $this->clear();
            echo "Size of the Roster: " . $this->size . "\n";
            echo "Available Space in the Roster: " . ($this->size - $this->roster->count()) . "\n";        
            $this->menu();
            $choice = readline("Choose from the Menu:") ;
            switch ($choice) {
                case 1:    
                    $this->clear();
                    if ($this->roster->count() < $this->size) {  
                        $this->addMenu();
                    } else {
                        echo "Roster is full. Cannot add more employees.\n";
                        readline("Press \"Enter\" key to continue...");
                    $this->clear();
                    }
                    break;
                case 2:
                    $this->clear();
                    if ($this->roster->count() > 0) {  
                    $this->deleteMenu();
                } else {
                    echo "Roster is Empty. No employee to delete.\n";
                    readline("Press \"Enter\" key to continue...");
                    $this->clear();
                }
                    
                    break;
                case 3:
                    $this->clear();
                    $this->otherMenu(); 
                    break;
                case 0:
                    $this->clear();
                    $this->repeat = false; 
                    echo "Exiting the program.\n";
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    $this->clear();
                    $this->entrance();
                    break;
            }
        }
        echo "Process terminated.\n";
        exit;
    }

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
         $this->clear();  
    echo "--- Add New Employee ---\n";
    
    $name = readline("Enter employee name: ");
    $address = readline("Enter employee address: ");
    $age = (int) readline("Enter employee age: ");
    $cName = readline("Enter company name: ");


    $this->empType($name, $address, $age, $cName);
    }

    public function empType($name, $address, $age, $cName) {
        echo "[1] Commission Employee       [2] Hourly Employee       [3] Piece Worker";
        $type = readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $cName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $cName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $cName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->clear();
                $this->empType($name, $address, $age, $cName);
                break;
        }
    }



    public function addOnsCE($name, $address, $age, $cName) {   
        $regularSalary = (float) readline("Enter regular salary: ");
        $itemsSold = (int) readline("Enter number of items sold: ");
        $commissionRate = (float) readline("Enter commission rate (as a decimal): ");
 
        if ($this->roster->addCommissionEmployee($name, $address, $age, $cName, $regularSalary, $itemsSold, $commissionRate)) {
            echo "Commission Employee added successfully!\n";
        } else {
            echo "Failed to add Commission Employee.\n";
        }
        $this->repeat();
    }

    public function addOnsHE($name, $address, $age, $cName) {
        $hoursWorked = (int) readline("Enter hours worked: ");
        $rate = (float) readline("Enter hourly rate: ");
 
        if ($this->roster->addHourlyEmployee($name, $address, $age, $cName, $hoursWorked, $rate)) {
            echo "Hourly Employee added successfully!\n";
        } else {
            echo "Failed to add Commission Employee.\n";
        }
        $this->repeat();
    }

    public function addOnsPE($name, $address, $age, $cName) {

        $numberItems = (int) readline("Enter number of items produced: ");
        $wagePerItem = (float) readline("Enter wage per item: ");
        
        if ($this->roster->addPieceWorker($name, $address, $age, $cName, $numberItems, $wagePerItem)) {
            echo "Piece Worker Employee added successfully!\n";
        } else {
            echo "Failed to add Piece Worker Employee.\n";
        }
        $this->repeat();
    }

    public function deleteMenu() {
         $this->clear();
        echo "--- Delete an Employee ---\n";
        
        $this->roster->displayAll();
    
        $employeeId = (int) readline("Enter the Employee ID to delete (or 0 to return): ");
    
        if ($employeeId === 0) {
            return; 
        }
    
        if ($this->roster->deleteEmployeeById($employeeId)) {
            echo "Employee with ID $employeeId has been deleted successfully.\n";
        } else {
            echo "Failed to delete employee. Please check the ID and try again.\n";
        }
        if (empty(array_filter($this->roster->getRoster(), fn($employee) => $employee !== null))) {  
            echo "Roster is Empty. No employee to delete.\n";
            readline("Press \"Enter\" key to continue...");
            $this->clear();
            $this->entrance();
        } else {
             $deleteAnother = readline("Do you want to delete another employee? (y/n): ");
        if (strtolower($deleteAnother) == 'y') {
            $this->deleteMenu(); 
        }
        }
        $this->clear();
    }
    

    public function otherMenu() {
         $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->clear();
                $this->displayMenu();
                break;
            case 2:
                $this->clear();
                $this->countMenu();
                break;
            case 3:
                $this->clear();
                $this->payrollMenu();
                break;
            case 0:
                $this->clear();
                $this->entrance();
                break;

            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->clear();
                $this->otherMenu();
                break;
        }
        $this->clear();
    }
    public function payrollMenu() {
         $this->clear();
        echo "--- Payroll for All Employees ---\n";
        $this->roster->payroll(); 
        readline("\nPress \"Enter\" key to return to the previous menu...");
        $this->clear();
    }

    public function displayMenu() {
         $this->clear();
        echo "[1] Display All Employee\n";
        echo "[2] Display Commission Employee\n";
        echo "[3] Display Hourly Employee\n";
        echo "[4] Display Piece Worker\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 0: 
                $this->clear();
                $this->otherMenu();
                break;
            case 1:
                 $this->clear();
                $this->roster->displayAll(); 
                break;
            case 2:
                 $this->clear();
                $this->roster->displayCE(); 
                break;
            case 3:
                 $this->clear();
                $this->roster->displayHE(); 
                break;
            case 4:
                 $this->clear();
                $this->roster->displayPE(); 
                break;
            default:
                $this->clear();
                echo "Invalid Input!";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
        $this->clear();
        $this->displayMenu();
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

    public function countMenu() {
         $this->clear();
        echo "[1] Count All Employee\n";
        echo "[2] Count Commission Employee\n";
        echo "[3] Count Hourly Employee\n";
        echo "[4] Count Piece Worker\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 0:
                 $this->clear();
                $this->OtherMenu();
                break;
            case 1:
                 $this->clear();
                $this->roster->countAll();
                break;
            case 2:
                 $this->clear();
                $this->roster->countCE();
                break;
            case 3:
                 $this->clear();
                $this->roster->countHE();
                break;
            case 4:
                 $this->clear();
                $this->roster->countPE();
                break;
            default:
                echo "Invalid Input!";
                break;
        }


        readline("\nPress \"Enter\" key to continue...");
        $this->clear();
        $this->countMenu();
    }

 
    public function repeat() {
        $this->clear();
        echo "Employee Added!\n";
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more ? (y to continue): ");
            if (strtolower($c) == 'y')
                $this->addMenu();
            else
                $this->entrance();

        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
            $this->clear();
            $this->entrance();
        }
    }
}
?>
