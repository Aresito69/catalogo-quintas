<?php

// Simulación académica. No ejecuta el módulo real.

$telefonoAdministrador = '7771234567'; 
// Número ficticio; pendiente de incorporar código internacional.

$nombreQuinta = 'Casa Luna';

$mensaje = rawurlencode(
    "Hola, deseo información sobre {$nombreQuinta}."
);

$urlWhatsApp = "https://wa.me/{$telefonoAdministrador}?text={$mensaje}";

echo $urlWhatsApp;
