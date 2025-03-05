<?php 
$numbers = [2, 3, 6, 7, 11, 14, 17, 20, 23, 29];

echo '<h2>Aufgabe 3.1</h2>';

foreach($numbers as $number) {
    if($number % 2 == 0) {
        echo 'Die Zahl ' . $number . ' ist gerade.<br>';
    } else {
        echo 'Die Zahl ' .  $number . ' ist ungerade.<br>';
    }
}

echo '<h2>Aufgabe 3.2</h2>';

for($i = 0; $i < count($numbers) - 1; $i++) {
    if($numbers[$i] < $numbers[$i + 1]) {
        echo 'Die Zahl ' . $numbers[$i] . ' ist kleiner als die Zahl ' . $numbers[$i + 1] . '.<br>';
    } else if($numbers[$i] > $numbers[$i + 1]) {
        echo 'Die Zahl ' . $numbers[$i] . ' ist größer als die Zahl ' . $numbers[$i + 1] . '.<br>';
    } else {
        echo 'Die Zahl ' . $numbers[$i] . ' ist gleich wie die Zahl ' . $numbers[$i + 1] . '.<br>';
    }
}
?>