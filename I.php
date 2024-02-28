<?php 

// Interface Segregation Principle

// A client should never be forced to implement an interface that it doesn't use, or clients shouldn't be forced to depend on methods they do not use.

// Say we have the shapes square, circle, cuboid, sphere.
// Our interface:

// interface ShapeInterface
// {
//     public function area();

//     public function volume();
// }

// Now, any shape you create must implement the volume method, but you know that squares are flat shapes and that they do not have volumes, so this interface would force the Square class to implement a method that it has no use of.

// This would violate the interface segregation principle. Instead, you could create another interface called ThreeDimensionalShapeInterface that has the volume contract and three-dimensional shapes can implement this interface:

interface ShapeInterface
{
    public function area();
}

interface ThreeDimensionalShapeInterface {
  public function volume();
}

class Cuboid implements ShapeInterface, ThreeDimensionalShapeInterface
{
    public function area()
    {
        // calculate the surface area of the cuboid
    }

    public function volume()
    {
        // calculate the volume of the cuboid
    }
}

// In this refactored design, each class implements only the interfaces relevant to its specific role, and the Interface Segregation Principle is followed. This makes it easier to extend functionality in the future without affecting unrelated classes. Each interface represents a specific behavior, and classes only implement the interfaces they need.