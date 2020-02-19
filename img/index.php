<?php 
$name = "jake";
$age = 20;
// variables x et y et somme
$x = 21544;
$y = 568;
$somme = $x+$y;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Hello world ! </h1>
<div>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi leo libero, placerat non enim a, placerat aliquam urna. Curabitur odio nunc, porta ac sapien nec, rutrum elementum velit. In laoreet eros id neque pulvinar, at sagittis nibh volutpat. Donec lobortis at nulla ac tristique. Donec ornare lobortis ullamcorper. Vivamus ex lorem, pellentesque id justo a, hendrerit faucibus mauris. Aliquam lacinia est at metus auctor tincidunt. Ut posuere nulla non magna mollis cursus. Proin egestas scelerisque augue in semper. Donec dictum dignissim nisi. Duis sollicitudin mauris tortor, a aliquam purus maximus scelerisque. Sed suscipit mi nec bibendum tempor. Vivamus eros purus, cursus quis eros et, venenatis sodales tortor. Nam mattis mauris vitae quam aliquet dictum. Donec odio turpis, commodo quis venenatis ut, sagittis vel velit. Proin ornare orci vel magna bibendum, a fermentum nibh vehicula. 
</div>

<?php
echo "Hello $name. You are $age years old. \n" ;

echo "'<br /> . La somme de $x et $y est $somme. '<br /> .\n";

$odd_numbers = [1,3,5,7,9];

$odd_numbers[5] = 11;
print_r($odd_numbers); // ajoute un cinquième élément au tableau

unset( $odd_numbers[2]); // va enlever l'élément (5) du tableau, la clé 2 sera désormais vide
print_r($odd_numbers);
echo('<br />' . $odd_numbers[3]);

echo ('<br />'. count ($odd_numbers));

$first_item = reset($odd_numbers);
echo ('<br />'. $first_item);

$last_item = end($odd_numbers);
echo ('<br />'.$last_item. '======================<br />');

$numbers = [1,2,3];
array_push($numbers, 6); // ajoute une valeur à un tableau [1,2,3,4];
// print the new array
echo (print_r($numbers). '======================<br />');

$numbers = [1,2,3,4];
array_pop($numbers); // enlève la dernière valeur d'un tableau [1,2,3];
// print the new array
echo ('<br />' . print_r($numbers). '======================<br />');

$numbers = [1,2,3];
array_unshift($numbers, 0); // ajoute une valeur en première place du tableau [0,1,2,3];
// print the new array
echo ('<br />' . print_r($numbers). '======================<br />');

$numbers = [0,1,2,3];
array_shift($numbers); // now array is [1,2,3];
// print the new array
echo ('<br />' . print_r($numbers). '======================<br />');

echo ('<br />');
echo ('<br />');

$odd_numbers = [1,3,5,7,9];
$even_numbers = [2,4,6,8,10];
$all_numbers = array_merge($odd_numbers, $even_numbers);
echo ('<br />' . print_r($all_numbers));

$numbers = [4,2,3,1,5];
sort($numbers);
echo ('<br />' . print_r($numbers));

$numbers = [1,2,3,4,5,6];
echo ('<br />' . print_r(array_slice($numbers, 3)));

$numbers = [1,2,3,4,5,6];
echo ('<br />' . print_r(array_slice($numbers, 3, 2)));

$numbers = [1,2,3,4,5,6];
print_r(array_splice($numbers, 3, 2));
echo ('<br />' );
print_r($numbers);
echo ('<br />' );

$phone_numbers = [
    "Alex" => "415-235-8573",
    "Jessica" => "415-492-4856",
  ];
  
  print_r($phone_numbers);
  echo ('<br />');

  echo "Alex's phone number is " . $phone_numbers["Alex"] . '<br/>'."\n";
  echo "Jessica's phone number is " . $phone_numbers["Jessica"] . "\n";
  echo ('<br />');

  $phone_numbers = [
    "Alex" => "415-235-8573",
    "Jessica" => "415-492-4856",
  ];
  
  $phone_numbers["Michael"] = "415-955-3857";
  
  print_r($phone_numbers);
  echo ('<br />');

  $phone_numbers = [
    "Alex" => "415-235-8573",
    "Jessica" => "415-492-4856",
  ];
  
  if (array_key_exists("Alex", $phone_numbers)) {
      echo "Alex's phone number is " . $phone_numbers["Alex"] . "\n";
      echo ('<br />');
  } else {
      echo "Alex's phone number is not in the phone book!";
      echo ('<br />');
  }
  
  if (array_key_exists("Michael", $phone_numbers)) {
      echo "Michael's phone number is " . $phone_numbers["Michael"] . "\n";
      echo ('<br />');
  } else {
      echo "Michael's phone number is not in the phone book!";
      echo ('<br />');
  }
  echo ('<br />');

  $phone_numbers = [
    "Alex" => "415-235-8573",
    "Jessica" => "415-492-4856",
  ];
  
  print_r(array_keys($phone_numbers));
  echo ('<br />');

  $phone_numbers = [
    "Alex" => "415-235-8573",
    "Jessica" => "415-492-4856",
  ];
  
  print_r(array_values($phone_numbers));
  echo ('<br />');

  $name = "John";
echo $name;
echo ('<br />');

$first_name = "John";
$last_name = "Doe";
$name = $first_name . " " . $last_name;
echo $name;
echo ('<br />');
echo ('<br />');

$filename = "image.png";
$extension = substr($filename, strlen($filename) - 3);
echo "The extension of the file is $extension";
echo ('<br />');
echo ('<br />');

$fruits = "apple,banana,orange";
$fruit_list = explode(",", $fruits);
echo "The second fruit in the list is $fruit_list[1]";
echo ('<br />');
echo ('<br />');

$fruit_list = ["apple","banana","orange"];
$fruits = implode(",", $fruit_list);
echo "The fruits are $fruits";
echo ('<br />');
echo ('<br />');

$nombre = "38,42,58,48,33,59,87,17,20,8,98,14";
$number_list = explode(",",$nombre);
print_r($number_list);
echo ('<br />');
echo ('<br />');

$odd_numbers = [1,3,5,7,9];
for ($i = 0; $i < count($odd_numbers); $i=$i+1) {
    $odd_number = $odd_numbers[$i];
    echo $odd_number . "\n";
}
echo ('<br />');
echo ('<br />');

$odd_numbers = [1,3,5,7,9];
foreach ($odd_numbers as $odd_number) {
  echo $odd_number . "\n";
}
echo ('<br />');
echo ('<br />');

$phone_numbers = [
  "Alex" => "415-235-8573",
  "Jessica" => "415-492-4856",
];

foreach ($phone_numbers as $name => $number) {
  echo "$name's number is $number.\n";
}
echo ('<br />');
echo ('<br />');

$counter = 0;

while ($counter < 10) {
    $counter += 1;
    echo "Executing - counter is $counter.\n";
}
echo ('<br />');
echo ('<br />');

$counter = 0;

while ($counter < 10) {
    $counter += 1;

    if ($counter % 2 == 0) {
        echo "Skipping number $counter because it is even.\n";
        continue;
    }

    echo "Executing - counter is $counter.\n";
}
echo ('<br />');
echo ('<br />');

$counter = 0;

while ($counter < 10) {
    $counter += 1;

    if ($counter > 8) {
        echo "counter is larger than 8, stopping the loop.\n";
        break;
    }

    if ($counter % 2 == 0) {
        echo "Skipping number $counter because it is even.\n";
        continue;
    }

    echo "Executing - counter is $counter.\n";
}
echo ('<br />');
echo ('<br />');
?>

</body>
</html>