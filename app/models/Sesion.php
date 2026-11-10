<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase
class Sesion
{
    /** Identificador único de la sesión. */
    private ?int $idSesion = null;

    /** Identificador del usuario de la sesión. */
    private int $idUsuario;

    /** Token de sesión. */
    private string $tokenSesion;

    /** Fecha y hora de inicio. */
    private ?string $fechaInicio = null;

    /** Fecha y hora de expiración. */
    private string $fechaExpiracion;

    // Constructor de la clase Sesion.

    public function __construct(
        int $idUsuario,
        string $tokenSesion,
        string $fechaExpiracion
    ) {
        $this->idUsuario = $idUsuario;
        $this->tokenSesion = $tokenSesion;
        $this->fechaExpiracion = $fechaExpiracion;
    }

    //Inicio de funciones setters y getters. 

    public function getIdSesion(): ?int
    {
        return $this->idSesion;
    }

    public function setIdSesion(?int $idSesion): void
    {
        $this->idSesion = $idSesion;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getTokenSesion(): string
    {
        return $this->tokenSesion;
    }

    public function setTokenSesion(string $tokenSesion): void
    {
        $this->tokenSesion = $tokenSesion;
    }

    public function getFechaInicio(): ?string
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(?string $fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaExpiracion(): string
    {
        return $this->fechaExpiracion;
    }

    public function setFechaExpiracion(string $fechaExpiracion): void
    {
        $this->fechaExpiracion = $fechaExpiracion;
    }

    // Funciones por desarrollar de conexión con bases de datos. 
    
    public function guardar(): bool
    {
        return true;
    }

    public function eliminar(): bool
    {
        return true;
    }
}