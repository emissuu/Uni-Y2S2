<?php

echo "=== Task 1 ===\nEnter integer: ";
function SumNumberDigits($number) {
    if (!is_numeric($number)) return -1;
    return array_sum(str_split($number));
}
$input1 = intval(readline());
echo "Sum of digits is " . SumNumberDigits($input1);


echo "\n\n=== Task 2 ===\nEnter the digit to count: ";
$digit2 = 0;
while(true) { // may make one generic input function that takes arrow function as an argument to not repeat anything
    $digit2 = intval(readline());
    if ($digit2 > 9 || $digit2 < 0)
        echo "Digit must be between 0 and 10!\nEnter the digit to count: ";
    else
        break;
}
echo "Enter the number: ";
$number2 = readline();
$sum2 = 0;
foreach(str_split($number2) as $digit) {
    if ($digit == $digit2) $sum2++;
}
echo "Number of digit {$digit2} in {$number2} is {$sum2}";


echo "\n\n=== Task 3 ===\n";
$value3 = [20, 10, 42, 94, 5];
$sum3 = 0;

foreach($value3 as $digit) {
    if ($digit % 5 == 0)
        $sum3 += $digit;
}
echo "Sum of digits divisible by 5: {$sum3}";


echo "\n\n=== Task 4 ===\n";
$rand_array4 = [];
for ($i = 0; $i < 5; $i++) {
    $rand_array4[$i] = rand(0, 100);
}
echo "Starting array: {implode(', ', $rand_array4)}";
$min = min($rand_array4);
$max = max($rand_array4);
foreach ($rand_array4 as $index => $digit) {
    if ($digit == $min) $min = $index;
    if ($digit == $max) $max = $index;
}
$temp = $rand_array4[$min];
$rand_array4[$min] = $rand_array4[$max];
$rand_array4[$max] = $temp;
echo "Result array: {implode(', ', $rand_array4)}";

