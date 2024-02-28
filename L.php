<?php 

// Liskov Substitution Principle 
// https://accesto.com/blog/solid-php-solid-principles-in-php/

// The Liskov Substitution Principle states that objects of a superclass should be able to be replaced with objects of a subclass without affecting the correctness of the program. In other words, if a class S is a subclass of class T, an object of class T should be replaceable with an object of class S without affecting the functionality of the program.

class Rectangle {
  protected $width;
  protected $height;

  public function setWidth(int $width): void {
      $this->width = $width;
  }

  public function setHeight(int $height): void {
      $this->height = $height;
  }

  public function area() {
      return $this->width * $this->height;
  }
}

// Now we're adding a Square PHP class that inherits the Rectangle class. Because every square is also a rectangle :). They have the same properties, height and width.

// The height of the square is the same as the width. So, setHeight() and setWidth() will set both (what about single responsibility?) of these values:

class Square extends Rectangle
{
    public function setWidth(int $width): void { 
        $this->width = $width;
        $this->height = $width;
    }
 
    public function setHeight(int $height): void {
        $this->width = $height;
        $this->height = $height;
    }

    public function area() {
      return $this->width * $this->height;
    }
}

// Is that a good solution? Unfortunately, it does not follow the Liskov substitution principle. Let's say there is a test that computes the area of a rectangle, and it looks like this:

function testCalculateArea() {
  $shape = new Square();
  $shape->setWidth(10);
  $shape->setHeight(2);

  // Test ("assertEquals") that area is as expected
  if($shape->area() !== 20) {
    echo "ERROR 1: area not as expected";
  }

  $shape->setWidth(5);
  if($shape->area() !== 10) {
    echo "ERROR 2: area not as expected";
  }
}

testCalculateArea();

// According to the Liskov substitution principle, we should be able to replace the Rectangle class with the Square class. But if we replace it, it turns out that the test does not pass (100 != 20). Overriding the setWidth() and setHight() methods broke the Liskov substitution rule. We should not change how the parent class's methods work.

// So what is the correct solution? Not every idea from "reality" should be implemented 1:1 in code. The Square class should not inherit from the Rectangle class. If both of these classes can have a computed area, let them implement a common interface, and not inherit one from the other since they are quite different.

// SOLUTION THAT SATISFIES LSP:

// interface CalculableArea
// {
//     public function calculateArea();
// }

// class Rectangle implements CalculableArea
// {
//     protected int $width;
//     protected int $height;

//     public function __construct(int $width, int $height)
//     {
//         $this->width = $width;
//         $this->height = $height;
//     }

//     public function calculateArea(): int
//     {
//         return $this->width * $this->height;
//     }
// }

// class Square implements CalculableArea
// {
//     protected int $edge;

//     public function __construct(int $edge)
//     {
//         $this->edge = $edge;
//     }

//     public function calculateArea(): int
//     {
//         return $this->edge ** 2;
//     }
// }