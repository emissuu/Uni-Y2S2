<?php

echo "=== Task 1 ===\nEnter an array of numbers (separated by space): ";
$input1 = explode(' ', readline());
$product1 = 1;
foreach ($input1 as $number) {
    $product1 *= intval($number);
}
echo "Product: " . $product1 . "\n";


echo "\n=== Task 2 ===\n";
$array2 = [2, 6, 7, 28, 29, 31, 45, 69, 90, 123, 407, 421, 474, 496, 512];

function IsPerfect($number) {
    $sum = 1;
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            $sum += $i;
            if ($i != $number / $i) {
                $sum += $number / $i;
            }
        }
    }
    return $sum == $number;
}
echo "Initial array: " . implode(', ', $array2);
$perfectArray2 = [];
for ($i = 0; $i < count($array2); $i++) {
    if (IsPerfect($array2[$i])) {
        array_push($perfectArray2, $array2[$i]);
    }
}
echo "\nPerfect numbers: " . implode(', ', $perfectArray2);


echo "\n\n=== Task 3 ===\nEnter an array of numbers (separated by space): ";
$input3 = explode(' ', readline());
$count3 = 0;
foreach ($input3 as $number) {
    if ($number == 0)
        $count3++;
}
echo "Count of 0 in input array: " . $count3;


echo "\n\n=== Task 4 ===\n";
$array4 = [];
for ($i = 0; $i < 20; $i++) {
    $array4[$i] = rand(1, 50);
}
echo "Initial array: " . implode(', ', $array4);
$sum4 = 0;
for ($i = 0; $i < count($array4); $i++) {
    if ($array4[$i] % 2 == 1) {
        $sum4 += pow($array4[$i], 2);
    }
}
echo "\nSum of squeared odd digits is: " . $sum4;


echo "\n\n=== Task 5 ===\nInitial array: ";
$array5 = [];
for ($i = 0; $i < 8; $i++) {
    $array5[$i] = rand(1, 50);
}
echo implode(', ', $array5);
$temp = $array5[0];
$array5[0] = $array5[count($array5) - 1];
$array5[count($array5) - 1] = $temp;
echo "\nResult array: " . implode(', ', $array5);


echo "\n\n=== Task 6 ===\n";
$array6 = [];
for ($i = 0; $i < 10; $i++) {
    $array6[$i] = rand(-50, 50);
}
echo "Initial array: " . implode(', ', $array6);
$arrayAvg6 = [];
for ($i = 0; $i < count($array6); $i++) {
    if ($array6[$i] > 0) {
        array_push($arrayAvg6, $array6[$i]);
    }
}
echo "\nAverage of positive: " . array_sum($arrayAvg6) / count($arrayAvg6);


echo "\n\n=== Task 7 ===\nEnter your name and surname (separated by space): ";
$cyrNames7 = mb_strtolower(readline());
$cyrToLat = [
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'h', 'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'є' => 'ye',
    'ж' => 'zh', 'з' => 'z', 'и' => 'y', 'і' => 'i', 'ї' => 'yi', 'й' => 'i', 'к' => 'k', 'л' => 'l',
    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ь' => '',
    'ю' => 'yu', 'я' => 'ya'
];
$latNames7 = explode(' ', strtr($cyrNames7, $cyrToLat));
$email7 = implode('.', $latNames7) . '@example.com';
echo "Result email: " . $email7;



echo "\n\n=== Task 8 ===\nEnter a year: ";
if (intval(readline()) % 400 == 0)
    echo "That year is devisible by 400";
else
    echo "That year is not devisible by 400";


echo "\n\n=== Task 9 ===\n";
$array9 = [];
for ($i = 0; $i < 8; $i++) {
    $array9[$i] = rand(0, 100);
}
$product9 = 1;
$otherArray9 = [];
for ($i = 0; $i < count($array9); $i++) {
    if ($array9[$i] > 0) {
        if ($i % 2 == 0)
            $product9 *= $array9[$i];
        else
            array_push($otherArray9, $array9[$i]);
    }
}
echo "Product of elements with even indexes: " . $product9 . "\n";
echo "Elements with odd indexes: " . implode(', ', $otherArray9);


echo "\n\n=== Task 10 ===\nEnter a year: ";
$year10 = intval(readline());
if ($year10 < 1 || $year10 > 9999)
    echo "Year must be in range from 1 to 9999\n";
else {
    if ($year10 % 400 == 0 || ($year10 % 100 != 0 && $year10 % 4 == 0))
        echo $year10 . " is a leap year!\n";
    else
        echo $year10 . " is not a leap year!\n";
}