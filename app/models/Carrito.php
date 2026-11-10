<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase carrito
class Carrito
{
    /** Identificador único del carrito. */
    private ?int $idCarrito = null;

    /** Identificador del estudiante al que pertenece. */
    private int $idEstudiante;

    /** Estado del carrito (activo, cerrado). */
    private string $estado = 'activo';

    /** Fecha y hora de creación. */
    private ?string $fechaCreacion = null;

    /** Lista de cursos agregados al carrito. */
    private array $cursos = [];

    //Constructor de la clase recibe el identificador de estudiante. 

    public function __construct(int $idEstudiante)
    {
        $this->idEstudiante = $idEstudiante;
    }

    //Inicio de funciones setters y getters. 
    
    public function getIdCarrito(): ?int
    {
        return $this->idCarrito;
    }

    public function setIdCarrito(?int $idCarrito): void
    {
        $this->idCarrito = $idCarrito;
    }

    public function getIdEstudiante(): int
    {
        return $this->idEstudiante;
    }
    
    public function setIdEstudiante(int $idEstudiante): void
    {
        $this->idEstudiante = $idEstudiante;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getFechaCreacion(): ?string
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(?string $fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getCursos(): array
    {
        return $this->cursos;
    }

    public function agregarCurso(Curso $curso): void
    {
        $this->cursos[] = $curso;
    }

    public function eliminarCurso(int $idCurso): void
    {
        $this->cursos = array_filter($this->cursos, fn($c) => $c->getIdCurso() !== $idCurso);
    }

    public function calcularTotal(): float
    {
        return array_sum(array_map(fn($c) => $c->getPrecio(), $this->cursos));
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