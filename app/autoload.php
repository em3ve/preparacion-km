<?php

//definicion de la función autoload 
function autoload(string $class)
{

    // prueba de string
    echo "<br>" . $class.".php"."<br>";

    //Se reemplazan las barras invertidas por barras sencillas en la URL del archivo, además, se añade el nombre de la clase y la terminación: php. 
    $relativePath = str_replace('\\', '/', $class) . '.php';

    // dir que apunta a la url correcta
    $file = dirname(__DIR__) . '/' . $relativePath;

    // prueba de string
    echo "<br>" . $file . "<br>";

    if (file_exists($file)) {
        require_once $file;
    }
    
}

spl_autoload_register('autoload');
