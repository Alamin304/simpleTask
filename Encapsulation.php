<?php 
class Employee {
  private $id;
  private $name;
  private $salary;

  public function __construct(int $id, string $name, float $salary) {
    $this->id = $id;
    $this->name = $name;
    $this->setSalary($salary); 
  }

  public function getId(): int {
    return $this->id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function setSalary(float $salary): void {
    if ($salary < 0) {
      throw new InvalidArgumentException("Salary cannot be negative.");
    }
    $this->salary = $salary;
  }

  public function getFormattedSalary(): string {
    return number_format($this->salary, 2, '.', ','); 
  }
}

?>