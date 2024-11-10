<?php
class EmployeeRoster {
    private array $roster;
    private int $capacity;

    public function __construct($rosterSize) {
        $this->roster = array();
        $this->capacity = $rosterSize;
    }
    

    public function add(Employee $employee) {
        // Check if there's space in the roster
        if ($this->count() >= $this->capacity) {
            echo "Roster is full. Cannot add more employees.\n";
            return;
        }

        // Check for duplicate names before adding
        if ($this->hasEmployeeWithName($employee->getName())) {
            echo "An employee with the name '{$employee->getName()}' already exists.\n";
        } else {
            $this->roster[] = $employee;
            echo "Employee added successfully.\n";
        }
    }

    public function hasEmployeeWithName($name): bool {
        foreach ($this->roster as $employee) {
            if ($employee->getName() === $name) {
                return true;
            }
        }
        return false;
    }

    public function remove($index) {
        if (isset($this->roster[$index])) {
            unset($this->roster[$index]);
            $this->roster = array_values($this->roster); // Re-index array
            echo "Employee removed.\n";
        } else {
            echo "Invalid index.\n";
        }
    }
    
    public function count(): int {
        return count($this->roster);
    }

    public function getRemainingSlots(): int {
        return $this->capacity - $this->count();
    }

    public function getCapacity(): int {
        return $this->capacity;
    }

    public function displays() {
        if (empty($this->roster)) {
            echo "No employees in the roster.\n";
        } 
            // Display all employees in the roster
            foreach ($this->roster as $index => $employee) {
                echo "Employee #" . ($index + 1) . "\n"; // Display index (1-based)
                echo "Name: " . $employee->getName() . "\n";
                echo "Address: " . $employee->getAddress() . "\n";
                echo "Age: " . $employee->getAge() . "\n";
                echo "Company: " . $employee->getCompanyName() . "\n";
                echo "Type of Worker: " . get_class($employee) . "\n";
            }
            
            // Prompt the user to select an employee to remove after displaying the entire list
            $index = (int) readline("Select Employee to Remove (use the assigned #): ");
            $index = $index - 1; // Adjust for 0-based index
            
            // Remove the selected employee if the index is valid
            if (isset($this->roster[$index])) {
                $this->remove($index);
            } else {
                echo "Invalid employee number.\n";
            }
        
        readline('Press "Enter" to continue...');
    }
    
    public function display() {
        // Check if there are any employees in the roster
        if (empty($this->roster)) {
            echo "No employees in the roster.\n";
            return;
        }
        
        while (true) {  // Loop until the user chooses to return to the main menu
            echo "\033[2J\033[;H";  // Clears the screen
            echo "[1] Display All Employees\n";
            echo "[2] Display Commission Employees\n";
            echo "[3] Display Hourly Employees\n";
            echo "[4] Display Piece Worker Employees\n";
            echo "[0] Return to Main Menu\n";
            
            $choice = (int) readline("Enter your choice: ");
            
            switch ($choice) {
                case 1:
                    echo "Displaying All Employees:\n";
                    foreach ($this->roster as $employee) {
                        $this->displayEmployeeDetails($employee);
                    }
                    readline("Press 'Enter' to continue...");
                    break;
                    
                case 2:
                    if (empty($this->roster)) {
                        echo "No Commission Employees in the roster.\n";
                        return;
                    }else {
                        echo "Displaying Commission Employees:\n";
                        foreach ($this->roster as $employee) {
                            if ($employee instanceof CommissionEmployee) {
                                $this->displayEmployeeDetails($employee);
                            }
                        }
                    }
                    readline("Press 'Enter' to continue...");
                    break;
                    
                case 3:
                    if (empty($this->roster)) {
                        echo "No Hourly Employees in the roster.\n";
                        return;
                    }else {
                        echo "Displaying Hourly Employees:\n";
                        foreach ($this->roster as $employee) {
                            if ($employee instanceof HourlyEmployee) {
                                $this->displayEmployeeDetails($employee);
                            }
                        }
                    }
                    readline("Press 'Enter' to continue...");
                    break;
                    
                case 4:
                    if (empty($this->roster)) {
                        echo "No Piece Worker Employees in the roster.\n";
                        return;
                    }else {
                        echo "Displaying Piece Worker Employees:\n";
                        foreach ($this->roster as $employee) {
                            if ($employee instanceof PieceWorker) {
                                $this->displayEmployeeDetails($employee);
                            }
                        }
                    }
                    readline("Press 'Enter' to continue...");
                    break;
                    
                case 0:
                    return;  // Exit the loop and return to the main menu
                    
                default:
                    echo "Invalid choice. Please try again.\n";
            }
        }
    }
    
    // Helper function to display employee details
    private function displayEmployeeDetails($employee) {
        echo "Name: " . $employee->getName() . "\n";
        echo "Address: " . $employee->getAddress() . "\n";
        echo "Age: " . $employee->getAge() . "\n";
        echo "Company: " . $employee->getCompanyName() . "\n";
        echo "Type of Worker: " . get_class($employee) . "\n\n";
    }
    

    public function payroll() {
        foreach ($this->roster as $employee) {
            echo $employee->getName() . " - Earnings: $" . $employee->earnings() . "\n";
        }
    }

    // New method to count employees based on their type
    public function countEmployeeTypes() {
        while (true) {  // Loop until the user chooses to return to the main menu
            echo "\033[2J\033[;H";  // Clears the screen
            echo "[1] Count All Employees\n";
            echo "[2] Count Commission Employees\n";
            echo "[3] Count Hourly Employees\n";
            echo "[4] Count Piece Worker Employees\n";
            echo "[0] Return to Main Menu\n";
            
            $choice = (int) readline("Enter your choice: ");
            
            switch($choice){
                case 1:
                    echo "Total Employees in Roster: " . $this->count() . "\n";  // Display total count
                    readline("Press 'Enter' to continue...");
                    break;
                case 2:
                    $commissionCount = 0;
                    foreach ($this->roster as $employee) {
                        if ($employee instanceof CommissionEmployee) {
                            $commissionCount++;
                        }
                    }
                    echo "Total Commission Employees: $commissionCount\n";
                    readline("Press 'Enter' to continue...");
                    break;
                case 3:
                    $hourlyCount = 0;
                    foreach ($this->roster as $employee) {
                        if ($employee instanceof HourlyEmployee) {
                            $hourlyCount++;
                        }
                    }
                    echo "Total Hourly Employees: $hourlyCount\n";
                    readline("Press 'Enter' to continue...");
                    break;
                case 4:
                    $pieceWorkerCount = 0;
                    foreach ($this->roster as $employee) {
                        if ($employee instanceof PieceWorker) {
                            $pieceWorkerCount++;
                        }
                    }
                    echo "Total Piece Worker Employees: $pieceWorkerCount\n";
                    readline("Press 'Enter' to continue...");
            
                    break;
                case 0:
                    return;  // Exit the loop and return to the main menu
                default:
                    echo "Invalid choice. Please try again.\n";
            }
    
            
        }
    }
}
?>

