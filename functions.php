<?php
function pridajPozdrav() //Pozdrav podla času
{
    $hour = date('H');
    if ($hour < 12) {
        return "Dobré ráno";
    } elseif ($hour < 18) {
        return "Dobrý deň";
    } else {
        return "Dobrý večer";
    }
}
$pozdrav = pridajPozdrav();