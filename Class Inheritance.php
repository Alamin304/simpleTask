<?php

abstract class Shape {
  public abstract function calculateArea(): float;
}

class Circle extends Shape {
  private $radius;

  public function __construct(float $radius) {
    $this->radius = $radius;
  }

  public function calculateArea(): float {
    return pi() * pow($this->radius, 2);
  }
}

class Rectangle extends Shape {
  private $width;
  private $height;

  public function __construct(float $width, float $height) {
    $this->width = $width;
    $this->height = $height;
  }

  public function calculateArea(): float {
    return $this->width * $this->height;
  }
}

?>
