<?php

require_once("autoload.php");

use app\models\Usuario;
use app\models\Estudiante;
use app\models\Curso;


$objUsuario = new Usuario("correo","pass","nombre","apellido","rol");

echo $objUsuario->getApellido();

$objEstudiante = new Estudiante(10);

echo $objEstudiante->getIdUsuario();

