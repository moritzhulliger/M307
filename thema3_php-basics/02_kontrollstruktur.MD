# Kontrollstrukturen

## If


    if(ausdruck) {
        anweisung;
    }

Nur wenn _ausdruck_ den Wert _true_ zurückgibt wird _anweisung_ ausgeführt.

    if($a > $b) {
        echo '$a ist grösser als $b';
    }

### Vergleichs-Operatoren


| Name      | Ergebnis        | Beschreibung |
|-----------|----------------|----------------------------------------------------------|
| `$a == $b`  | Gleich         | Gibt `true` zurück, wenn `$a` gleich `$b` ist.          |
| `$a === $b` | Identisch      | Gibt `true` zurück, wenn `$a` gleich `$b` ist und beide vom gleichen Typ sind. |
| `$a != $b`  | Ungleich       | Gibt `true` zurück, wenn `$a` ungleich `$b` ist.        |
| `$a !== $b` | Nicht identisch | Gibt `true` zurück, wenn `$a` ungleich `$b` ist oder nicht vom gleichen Typ ist. |
| `$a < $b`   | Kleiner als    | Gibt `true` zurück, wenn `$a` kleiner als `$b` ist.    |
| `$a > $b`   | Größer als     | Gibt `true` zurück, wenn `$a` größer als `$b` ist.     |
| `$a <= $b`  | Kleiner Gleich | Gibt `true` zurück, wenn `$a` kleiner oder gleich `$b` ist. |
| `$a >= $b`  | Größer Gleich  | Gibt `true` zurück, wenn `$a` größer oder gleich `$b` ist. |
