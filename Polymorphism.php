<?php

class Animal {
  public function makeSound() {
    echo "The animal makes a sound.\n";
  }
}

class Dog extends Animal {
  public function makeSound() {
    echo "The dog barks!\n"; 
  }
}

class Cat extends Animal {
  public function makeSound() {
    echo "The cat meows.\n"; 
  }
}

class Bird extends Animal {
  public function makeSound() {
    echo "The bird chirps.\n"; 
  }
}

$animals = [new Dog(), new Cat(), new Bird()];

foreach ($animals as $animal) {
  $animal->makeSound();
}

?>
