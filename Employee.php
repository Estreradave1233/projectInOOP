<?php
class Employee {
    private string $name;
    private string $address;
    private int $age;
    private string $companyName;

    public function __construct($name, $address, $age, $companyName) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
        $this->companyName = $companyName;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getAge(): int {
        return $this->age;
    }

    public function getCompanyName(): string {
        return $this->companyName;
    }

    // Optional: __toString() method to print the employee details easily
    public function __toString(): string {
        return "Name: {$this->name}\nAddress: {$this->address}\nAge: {$this->age}\nCompany: {$this->companyName}\n";
    }
}
?>