<?php 
// https://www.digitalocean.com/community/conceptual-articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design#liskov-substitution-principle

// Single responsibility principle (https://blog.cleancoder.com/uncle-bob/2014/05/08/SingleReponsibilityPrinciple.html)
// a class should only have one reason to change, meaning a class should only have one job.
class Square {
  public function __construct(public $length)
  {

  }

}

class Circle {
  public function __construct(public $radius)
  {
    
  }
}

class AreaCalculator {
  public function __construct(protected $shapes = [])
  {
    
  }

  public function sum() {
    $area = 0;
    foreach($this->shapes as $shape) {
      if(is_a($shape, 'Square')) {
        $area += $shape->length * $shape->length;
      } else if(is_a($shape, 'Circle')) {
        $area += pi() * pow($shape->radius, 2);
      }
    }
    return $area;
  }

  public function output()
    {
        return implode('', [
          '',
              'Sum of the areas of provided shapes: ',
              $this->sum(),
          '',
      ]);
    }
}

$shapes = [
  new Circle(2),
  new Square(5),
  new Square(6),
];

$areas = new AreaCalculator($shapes);

// TODO: uncomment to see result
// echo $areas->output();
// echo '<br>';
// echo '<br>';

// PROBLEM: our AreaCalculator is handling the logic to output the data. What if we wanted to also have the ability to output the data in another format, like JSON. All of the logic would be handled by the AreaCalculator class. This would violate the single-responsibility principle. The AreaCalculator class should only be concerned with the sum of the areas of provided shapes. It should not care whether the user wants JSON or HTML.
// The single responsibility principle is violated: the class has multiple jobs -- calculating the area and outputting in various formats. It therefore has multiple reasons to change: if we add other shapes AND if we want to output in another format.

// REFACTORING: create new class for handling all the formatting/output logic for the area calculator.
class SumCalculatorFormatter {
  public function __construct(protected AreaCalculator $calculator)
  {
    
  }

  public function JSON() {
    $data = [
      'sum' => $this->calculator->sum(),
    ];
    return json_encode($data);
  }

  public function HTML() {
    return implode('', [
      '',
          'Sum of the areas of provided shapes: ',
          $this->calculator->sum(),
      '',
  ]);
  }
}

$shapes = [
  new Circle(2),
  new Square(5),
  new Square(6),
];

$areas = new AreaCalculator($shapes);
$output = new SumCalculatorFormatter($areas);

echo $output->HTML();
echo '<br>';
echo '<br>';
echo $output->JSON();

// We now have a class thats only job is to sum areas of shapes, and a class thats only job is formatting and outputting the data.
// (we can now remove the output() method from AreaCalculator)
// Single responsibility principle satisfied!