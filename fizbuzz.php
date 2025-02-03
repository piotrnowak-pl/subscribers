<?php

/*
Zadanie 1.	
Należy przygotować kod PHP dla realizacji popularnego zadania FizzBuzz.
Zadanie polega na tym, aby wypisać na ekranie N kolejnych liczb całkowitych, 
przy czym jeśli liczba jest podzielna przez 3 to obok liczby dopisujemy słowo „Fizz”, 
jeśli liczba jest podzielna przez 5 to wypisujemy obok słowo „Buzz”, 
a jeśli jest jednocześnie podzielna przez 3 oraz 5 to wypisujemy obok słowo „FizzBuzz”.
*/

function fizzbuzz(int $start, int $n) {
    $result = '';
    $end = $start + $n;
    for ($i = $start; $i <= $end; $i++) {
        $result .= $i.' '.($i % 3 ? '' : 'Fizz') . ($i % 5 ? '' : 'Buzz').'<br>'.PHP_EOL;
    }
    return $result;
}

echo fizzbuzz(-10, 999);
