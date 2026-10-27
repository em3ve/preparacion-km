<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;


//Definición de la clase estudiante. 
class Estudiante extends Usuario
{

    private ?int $idEstudiante = null;

    private int $idUsuario;

    //constructor de la clase estudiante recibe el identificador de usuario. 
    public function __construct(int $idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    //Inicio de funciones setters y getters. 

    public function getIdEstudiante(): ?int
    {
        return $this->idEstudiante;
    }

    public function setIdEstudiante(?int $idEstudiante): void
    {
        $this->idEstudiante = $idEstudiante;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }


    //Funciones por desarrollar de conexión con bases de datos. 

    public function guardar(): bool
    {
        return true;
    }

    public function eliminar(): bool
    {
        return true;
    }
}
