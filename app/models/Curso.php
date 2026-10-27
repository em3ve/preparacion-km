<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

use App\Models\Leccion;

//Definición de la clase cursos
class Curso
{

    private ?int $idCurso = null;

    private string $nombre;

    private string $descripcion;

    private float $precio;

    private int $idInstructor;

    private ?string $fechaCreacion = null;

    /** Estado del curso (disponible, inactivo, eliminado). **/
    private string $estado = 'disponible';

    /** Lista de lecciones asociadas al curso. **/
    private array $lecciones = [];

    //constructor de la clase curso recibe el identificador de usuario. 

    public function __construct(
        string $nombre,
        string $descripcion,
        float $precio,
        int $idInstructor
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->idInstructor = $idInstructor;
    }

    //Inicio de funciones setters y getters. 

    public function getIdCurso(): ?int
    {
        return $this->idCurso;
    }


    public function setIdCurso(?int $idCurso): void
    {
        $this->idCurso = $idCurso;
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }


    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }


    public function getDescripcion(): string
    {
        return $this->descripcion;
    }


    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }


    public function getPrecio(): float
    {
        return $this->precio;
    }


    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }


    public function getIdInstructor(): int
    {
        return $this->idInstructor;
    }


    public function setIdInstructor(int $idInstructor): void
    {
        $this->idInstructor = $idInstructor;
    }


    public function getFechaCreacion(): ?string
    {
        return $this->fechaCreacion;
    }


    public function setFechaCreacion(?string $fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
    }


    public function getEstado(): string
    {
        return $this->estado;
    }


    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }


    public function getLecciones(): array
    {
        return $this->lecciones;
    }


    public function agregarLeccion(Leccion $leccion): void
    {
        $this->lecciones[] = $leccion;
    }

    //Funciones por desarrollar de conexión con bases de datos. 

    public function guardar(): bool
    {
        return true;
    }


    public function actualizar(): bool
    {
        return true;
    }


    public function eliminar(): bool
    {
        return true;
    }
}
