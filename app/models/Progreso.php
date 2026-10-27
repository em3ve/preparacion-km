<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase progreso
class Progreso
{
    private ?int $idProgreso = null;

    private int $idEstudiante;

    private int $idLeccion;

    private ?string $fechaVisualizacion = null;

    /** Estado de la lección para el estudiante (visto, no_visto). */
    private string $estado = 'visto';

    //constructor de la clase recibe el identificador de usuario. 

    public function __construct(
        int $idEstudiante,
        int $idLeccion
    ) {
        $this->idEstudiante = $idEstudiante;
        $this->idLeccion = $idLeccion;
    }

    
    //Inicio de funciones setters y getters. 

    public function getIdProgreso(): ?int
    {
        return $this->idProgreso;
    }

    public function setIdProgreso(?int $idProgreso): void
    {
        $this->idProgreso = $idProgreso;
    }

    public function getIdEstudiante(): int
    {
        return $this->idEstudiante;
    }

    public function setIdEstudiante(int $idEstudiante): void
    {
        $this->idEstudiante = $idEstudiante;
    }

    public function getIdLeccion(): int
    {
        return $this->idLeccion;
    }

    public function setIdLeccion(int $idLeccion): void
    {
        $this->idLeccion = $idLeccion;
    }

    public function getFechaVisualizacion(): ?string
    {
        return $this->fechaVisualizacion;
    }

    public function setFechaVisualizacion(?string $fechaVisualizacion): void
    {
        $this->fechaVisualizacion = $fechaVisualizacion;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
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