<?php 

// Open-closed principle
// Objects or entities should be open for extension but closed for modification
// This means that a class should be extendable without modifying the class itself.

// Looking at AreaCalculator from SRP... Consider a scenario where the user would like the sum of additional shapes like triangles, pentagons, hexagons, etc. You would have to constantly edit this file and add more if/else blocks. That would violate the open-closed principle.

// class AreaCalculator {
//   public function __construct(protected $shapes = [])
//   {
    
//   }

//   public function sum() {
//     $area = 0;
//     foreach($this->shapes as $shape) {
//       if(is_a($shape, 'Square')) {
//         $area += $shape->length * $shape->length;
//       } else if(is_a($shape, 'Circle')) {
//         $area += pi() * pow($shape->radius, 2);
//       }
//     }
//     return $area;
//   }
// }

// A way you can make this sum method better is to remove the logic to calculate the area of each shape out of the AreaCalculator class method and attach it to each shape’s class.

// Adding area() methods to the shapes:
// class Square
// {
//     public $length;

//     public function __construct($length)
//     {
//         $this->length = $length;
//     }

//     public function area()
//     {
//         return pow($this->length, 2);
//     }
// }

// class Circle
// {
//     public $radius;

//     public function construct($radius)
//     {
//         $this->radius = $radius;
//     }

//     public function area()
//     {
//         return pi() * pow($this->radius, 2);
//     }
// }

// The sum method now requires no if/else if statements, as it requires no knowledge of how to calc each shape's area.
// class AreaCalculator {
//   public function __construct(protected $shapes = [])
//   {
    
//   }

//   public function sum()
//     {
//       foreach ($this->shapes as $shape) {
//           $area[] = $shape->area();
//       }

//       return array_sum($area);
//     }
// }

// Now, you can create another shape class and pass it in when calculating the sum without breaking the code.
// However, another problem arises. How do you know that the object passed into the AreaCalculator is actually a shape or if the shape has a method named area?
// Coding to an interface is an integral part of SOLID.
// Create a ShapeInterface that supports area:
interface ShapeInterface
{
    public function area();
}

// Modify your shape classes to implement the ShapeInterface.

class Square implements ShapeInterface
{
    public $length;

    public function __construct($length)
    {
        $this->length = $length;
    }

    public function area()
    {
        return pow($this->length, 2);
    }
}

class Circle implements ShapeInterface
{
    public $radius;

    public function construct($radius)
    {
        $this->radius = $radius;
    }

    public function area()
    {
        return pi() * pow($this->radius, 2);
    }
}

// In the sum method for AreaCalculator, you can check if the shapes provided are actually instances of the ShapeInterface; otherwise, throw an exception:

class AreaCalculator {
  public function __construct(protected $shapes = [])
  {
    
  }

  public function sum() {
    $area = 0;
    foreach($this->shapes as $shape) {
      if(is_a($shape, 'ShapeInterface')) {
        $area += $shape->area();
        continue;
      }
      throw new AreaCalculatorInvalidShapeException();
    }
    return $area;
  }
}

class AreaCalculatorInvalidShapeException extends Exception {
  public function __construct($message = "Invalid shape provided", $code = 0, Exception $previous = null) {
      parent::__construct($message, $code, $previous);
  }
}

$shapes = [
  new Circle(2),
  new Square(5),
  new Square(6),
];

$areas = new AreaCalculator($shapes);
echo $areas->sum();

// AreaCalculator now satisfies the open-closed principle: it's open for extension (we can add more shapes) but closed for modificaiton (we don't need to modify it if we add more shapes)