<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase cursos
class Leccion
{
    
    private ?int $idLeccion = null;

    private int $idCurso;

    private string $titulo;

    private ?string $descripcion = null;

    private ?string $contenidoTexto = null;

    private int $orden;

    private ?string $fechaCreacion = null;

    /** Estado de la lección (activa, inactiva, eliminada). */
    private string $estado = 'activa';

    /** Lista de contenidos asociados (imágenes y videos). */
    private array $contenidos = [];


    //constructor de la clase leccion recibe el identificador de usuario. 

    public function __construct(
        int $idCurso,
        string $titulo,
        int $orden
    ) {
        $this->idCurso = $idCurso;
        $this->titulo = $titulo;
        $this->orden = $orden;
    }

    
    //Inicio de funciones setters y getters. 

    public function getIdLeccion(): ?int
    {
        return $this->idLeccion;
    }

    public function setIdLeccion(?int $idLeccion): void
    {
        $this->idLeccion = $idLeccion;
    }

    public function getIdCurso(): int
    {
        return $this->idCurso;
    }

    public function setIdCurso(int $idCurso): void
    {
        $this->idCurso = $idCurso;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getContenidoTexto(): ?string
    {
        return $this->contenidoTexto;
    }

    public function setContenidoTexto(?string $contenidoTexto): void
    {
        $this->contenidoTexto = $contenidoTexto;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
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

    public function getContenidos(): array
    {
        return $this->contenidos;
    }

    public function agregarContenido(array $contenido): void
    {
        $this->contenidos[] = $contenido;
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