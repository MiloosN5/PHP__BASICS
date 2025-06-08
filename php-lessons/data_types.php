<?php

//////////// ATOMIC TYPES

# 1. SCALAR TYPES (bool, int, float, string)

## bool

$bool1 = true;
echo $bool1 . PHP_EOL; // 1
var_dump($bool1); // bool(true)
echo PHP_EOL . get_debug_type($bool1); // bool

$bool1 = false; // reassigning a new value
echo $bool1 . PHP_EOL; // empty output
var_dump($bool1); // bool(false)
echo PHP_EOL;

## int

$int1 = 1039; // decimal number
$int2 = 011; // octal number (equivalent to 9 decimal)
$int3 = 0o11; // octal number (as of PHP 8.1.0)
$int4 = 0x1A; // hexadecimal number (equivalent to 26 decimal)
$int5 = 0b11111111; // binary number (equivalent to 255 decimal)
$int6 = 1_234_567; // decimal number (as of PHP 7.4.0)

var_dump($int1); // int(1039)
echo PHP_EOL;
var_dump($int2); // int(9)
echo PHP_EOL;
var_dump($int3); // int(9)
echo PHP_EOL;
var_dump($int4); // int(26)
echo PHP_EOL;
var_dump($int5); // int(255)
echo PHP_EOL;
var_dump($int6); // int(1234567)
echo PHP_EOL;

## float

$float1 = 1.234; // DNUM (decimal number)
$float2 = 1.2e3; // EXPONENT_DNUM 
$float3 = 7E-10; // // EXPONENT_DNUM 
$float4 = 1_234.567; // as of PHP 7.4.0

if (is_int(($float1))) {
    echo PHP_EOL . "1.234 is integer" . PHP_EOL;
} else {
    echo PHP_EOL . "1.234 is not integer" . PHP_EOL; // ✔
}

var_dump($float1); // float(1.234)
echo PHP_EOL;
var_dump($float2); // float(1200)
echo PHP_EOL;
var_dump($float3); // float(7.0E-10)
echo PHP_EOL;
var_dump($float4); // float(1234.567)
echo PHP_EOL;

## string

### single quoted
echo 'this is a simple string' . PHP_EOL; // this is a simple string
echo 'This will not expand: \n a newline', PHP_EOL; // This will not expand: \n a newline
echo 'Variables do not $expand $either', PHP_EOL; // Variables do not $expand $either

### double quoted
$string_expand = 'expandText';
echo "This will expand: \n a newline", PHP_EOL;
/*
    [CLI]
    -->|This will expand: 
    -->| a newline
    [BROWSER] This will expand: a newline
*/
echo "Variables do $string_expand both",  PHP_EOL;
/*
    [CLI] Variables do expandText both
    [BROWSER] Variables do expandText both
*/

### heredoc
// no indentation
echo <<<END
      a
     b
    c
\n
END;
/*
    [CLI]
    -->|      a
    -->|     b
    -->|    c    
    [BROWSER] a b c
*/

echo  PHP_EOL;

// 4 spaces of indentation
echo <<<END
      a
     b
    c
    END;
/*
    [CLI]
    -->|  a
    -->| b
    -->|c      
    [BROWSER] a b c
*/

echo PHP_EOL;

/* ERROR
    echo <<<END
      a
     b
    c
       END;

    Parse error: Invalid body indentation level
*/

### nowdoc
echo <<<'EOD'
Example of string spanning multiple lines
using nowdoc syntax. Backslashes are always treated literally,
e.g. \\ and \'.
EOD;
echo PHP_EOL;
/*
    [CLI]
    -->|Example of string spanning multiple lines
    -->|using nowdoc syntax. Backslashes are always treated literally,
    -->|e.g. \\ and \'.
    [BROWSER] Example of string spanning multiple lines using nowdoc syntax. Backslashes are always treated literally, e.g. \\ and \'.
*/

# 2. ARRAY TYPE (array)

$array1 = array(
    "food" => "apple",
    "color" => "green",
);
var_dump($array1); // array(2) { ["food"]=> string(5) "apple" ["color"]=> string(5) "green" }
echo PHP_EOL;

## Using the short array syntax
$array2 = [
    "food" => "apple",
    "color" => "green",
];
var_dump($array2); // array(2) { ["food"]=> string(5) "apple" ["color"]=> string(5) "green" }
echo PHP_EOL;

# 3. OBJECT TYPE (object)

## Object Construction
class objectFoo
{
    function object_do()
    {
        echo "Doing foo.";
    }
}

$object1 = new objectFoo;
$object1->object_do(); // Doing foo.
echo PHP_EOL;
var_dump($object1); // object(objectFoo)#1 (0) { }
echo PHP_EOL;

# 4. RESOURCE TYPE (resource)

// [CLI] 
 $resource1 = fopen('helpers/resource_example.txt', 'r');
// [BROWSER]
//$resource1 = fopen('../helpers/resource_example.txt', 'r'); 
var_dump($resource1);
/*
    [BROWSER] resource(3) of type (stream)
    [CLI] resource(5) of type (stream)
*/
 echo PHP_EOL;

# 5. NEVER TYPE 

function never_function(): never
{
    echo "This is never return-only type function";
    exit();
}

# 6. VOID TYPE

function void_function(string $name): void
{
    echo "Hi, $name!";
}
void_function("Jack"); // Hi, Jack!
echo PHP_EOL;

# 7. RELATIVE CLASS TYPES (self, parent, static)

class RelativePerson
{
    public static function whoAmI(): string
    {
        return 'Person';
    }

    public static function make(): self
    {
        return new self();
    }

    public static function makeStatic(): static
    {
        return new static();
    }
}

class RelativeStudent extends RelativePerson
{
    public static function whoAmI(): string
    {
        return 'Student';
    }

    // Valid only if called from child class!!!
    public static function makeParent(): parent
    {
        return new parent();
    }
}

$relative_person1 = RelativePerson::make();
$relative_student1 = RelativeStudent::make();
$relative_student2 = RelativeStudent::makeStatic();
$relative_student3 = RelativeStudent::makeParent();

echo get_class($relative_person1) . PHP_EOL; // RelativePerson
echo get_class($relative_student1) . PHP_EOL; // RelativePerson
echo get_class($relative_student2) . PHP_EOL; // RelativeStudent
echo get_class($relative_student3) . PHP_EOL; // RelativePerson

# 8. SINGLETON TYPES (flase, true)

class Singleton
{
    private static ?Singleton $instance = null;

    private function __construct()
    {
        // A private constructor prevents an outer instance
    }

    public static function getInstance(): Singleton
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

$singleton1 = Singleton::getInstance();
$singleton2 = Singleton::getInstance();

var_dump($singleton1); // object(Singleton)#6 (0) { }
echo PHP_EOL;
var_dump($singleton2); // object(Singleton)#6 (0) { }
echo PHP_EOL;
var_dump($singleton1 === $singleton2); // bool(true)
echo PHP_EOL;

# 9. UNIT TYPES (null)

$unit_null1 = NULL;
var_dump($unit_null1); // NULL
echo PHP_EOL;
$unit_null2 = null;
var_dump($unit_null2); // NULL
echo PHP_EOL;
$unit_null3 = Null;
var_dump($unit_null3); // NULL
echo PHP_EOL;

# 10. USER-DEFINED TYPES (Interfaces, Classes, Enumerations)

## Interfaces 

interface InterfaceI1
{
    public string $readable { get; }
    public string $writable { set; }
    public string $both { get; set; }
}

class InterfaceC1 implements InterfaceI1
{
    public string $readable;
    public string $writable;
    public string $both;
}

class InterfaceC2 implements InterfaceI1
{
    private string $written = '';
    private string $all = '';
    public string $readable {
        get => strtoupper($this->writable);
    }
    public string $writable {
        get => $this->written;
        set {
            $this->written = $value;
        }
    }
    public string $both {
        get => $this->all;
        set {
            $this->all = strtoupper($value);
        }
    }
}

## Classes

class ClassesC1
{
    // property declaration
    public $var1 = 'a default value';
    # public var2 = 'another value'; // Unexpected '='. Expected 'VariableName'.

    // method declaration
    public function displayVar()
    {
        echo $this->var1;
    }
}

$classes_instance1 = new ClassesC1();
var_dump($classes_instance1); // object(ClassesC1)#7 (1) { ["var"]=> string(15) "a default value" }
echo PHP_EOL;

## Enumerations

enum EnumerationsSuit
{
    case Hearts;
    case Diamonds;
    case Clubs;
    case Spades;
}
$enumerations_suit = EnumerationsSuit::Diamonds;
var_dump($enumerations_suit); // enum(EnumerationsSuit::Diamonds)
echo PHP_EOL;

function enum_do_stuff(EnumerationsSuit $s)
{
    match ($s) {
        EnumerationsSuit::Hearts => print("You chose ♥ Hearts!\n"),
        EnumerationsSuit::Diamonds => print("You chose ♦ Diamonds!\n"),
        EnumerationsSuit::Clubs => print("You chose ♣ Clubs!\n"),
        EnumerationsSuit::Spades => print("You chose ♠ Spades!\n"),
    };
}

enum_do_stuff(EnumerationsSuit::Clubs); // You chose ♣ Clubs!

# 11. CALLABLE TYPE (callable)

function callable_function1()
{
    echo 'hello world' . PHP_EOL;
}
call_user_func('callable_function1'); // hello world
# var_dump(callable_function_1); // Undefined constant 'callable_function_1'

//////////// COMPOSITE TYPES

# 1. INTERSECTION TYPES

interface IntersectionA
{
    public function greeting();
}

interface IntersectionB
{
    public function farewell();
}

class IntersectionC implements IntersectionA, IntersectionB
{
    public function greeting()
    {
        echo "Hello!" . PHP_EOL;
    }

    public function farewell()
    {
        echo "Bye" . PHP_EOL;
    }
}

function intersection_testing(IntersectionA & IntersectionB $intersection_obj)
{
    $intersection_obj->greeting();
    $intersection_obj->farewell();
}
intersection_testing(new IntersectionC);
/*
    Hello!
    Bye
*/

# 2. UNION TYPES

function union_formatting(string|int $value): string
{
    return "Value: " . $value;
}
echo union_formatting("some text"); // Value: some text
echo PHP_EOL;
echo union_formatting(148); // Value: 148
echo PHP_EOL;

//////////// TYPE ALIASES (mixed, iterable)

## 1. MIXED

function mixed_process(mixed $value)
{
    var_dump($value);
    echo PHP_EOL;
}
mixed_process("text"); // string(4) "text"
mixed_process(50); // int(50)
mixed_process(["a", "b"]); // array(2) { [0]=> string(1) "a" [1]=> string(1) "b" }

## 2. ITERABLE

function mixed_showAll(iterable $items): void
{
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
}
mixed_showAll(["apple", "banana"]);
/*
    apple
    banana
*/
mixed_showAll(new ArrayIterator(["kiwi", "mango"]));
/*
    kiwi
    mango
*/

?>