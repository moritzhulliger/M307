# Arrays und if/else 

Arrays:

    $array = [1, 4, 7, 9, 14];

    echo $array[0] //gibt die Zahl 1 aus
    echo $array[3] //gibt die Zahl 9 aus

Arrays können auch mit Array-Schlüssel definiert werden

    $wochentage = [
        'Mo' => 'Montag',
        'Di' => 'Dienstag',
        'Mi' => 'Mittwoch',
        'Do' => 'Donnerstag',
        'Fr' => 'Freitag',
        'Sa' => 'Samstag',
        'So' => 'Sonntag',     
    ];

    echo $wochentage['Mo'] //gibt Montag aus

Ausgabe von Arrays:

    $edelmetalle = ['Gold', 'Platin', 'Iridium', 'Silber'];

    echo $edelmetalle;
    // Array

    echo $edelmetalle[2];
    // Iridium

    print_r($edelmetalle);
    // Array
    // (
    //     [0] => Gold
    //     [1] => Platin
    //     [2] => Iridium
    //     [3] => Silber
    // )

Für Array gibt es in PHP viele nützliche Funktionen, siehe: https://www.php.net/manual/de/ref.array.php


## Aufgabe 3.1

Even oder Odd ausgabe. 
Definiert einen Array aus zufälligen Zahlen.
Gebt nun für jede Zahl einen String aus der sagt ob die Zahl gerade oder ungerade ist


Beispiel Ausgabe:

    Die Zahl  ist 4 ist gerade

## Aufgabe 3.2

Gebt aus ob die aktuelle Zahl grösser oder kleiner ist als die nächste.

Beispiel:

    Die Zahl 3 ist kleiner als die Zahl 7


## Aufgabe 3.3

