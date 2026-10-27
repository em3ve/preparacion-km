<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;


//Definición de la clase instructor. 
class Instructor extends Usuario
{

    private ?int $idInstructor = null;

    private int $idUsuario;

    private string $estadoValidacion = 'pendiente';

    //constructor de la clase instructor recibe el identificador de usuario. 
    public function __construct(int $idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    //Inicio de funciones setters y getters. 

    public function getIdInstructor(): ?int
    {
        return $this->idInstructor;
    }

    public function setIdInstructor(?int $idInstructor): void
    {
        $this->idInstructor = $idInstructor;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getEstadoValidacion(): string
    {
        return $this->estadoValidacion;
    }

    public function setEstadoValidacion(string $estadoValidacion): void
    {
        $this->estadoValidacion = $estadoValidacion;
    }


    //Funciones por desarrollar de conexión con bases de datos. 

    public function guardar(): bool
    {
        return true;
    }

    public function actualizarEstado(): bool
    {
        return true;
    }

    public function eliminar(): bool
    {
        return true;
    }
}
