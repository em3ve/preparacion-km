<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase codigo verificacion
class CodigoVerificacion
{
    /** Identificador único del código. */
    private ?int $idCodigo = null;

    /** Identificador del usuario al que se envió. */
    private int $idUsuario;

    /** Código o token de verificación. */
    private string $codigo;

    /** Fecha y hora de generación. */
    private ?string $fechaGeneracion = null;

    /** Fecha y hora de expiración (24 horas). */
    private string $fechaExpiracion;

    /** Estado del código (activo, utilizado, expirado). */
    private string $estado = 'activo';


     // Constructor de la clase CodigoVerificacion.

    public function __construct(
        int $idUsuario,
        string $codigo,
        string $fechaExpiracion
    ) {
        $this->idUsuario = $idUsuario;
        $this->codigo = $codigo;
        $this->fechaExpiracion = $fechaExpiracion;
    }
    
    //Inicio de funciones setters y getters. 

    public function getIdCodigo(): ?int
    {
        return $this->idCodigo;
    }

    
    public function setIdCodigo(?int $idCodigo): void
    {
        $this->idCodigo = $idCodigo;
    }

    
    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    
    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    
    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    
    public function getFechaGeneracion(): ?string
    {
        return $this->fechaGeneracion;
    }

    
    public function setFechaGeneracion(?string $fechaGeneracion): void
    {
        $this->fechaGeneracion = $fechaGeneracion;
    }

    
    public function getFechaExpiracion(): string
    {
        return $this->fechaExpiracion;
    }

    
    public function setFechaExpiracion(string $fechaExpiracion): void
    {
        $this->fechaExpiracion = $fechaExpiracion;
    }

    
    public function getEstado(): string
    {
        return $this->estado;
    }

    
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    // Funciones por desarrollar de conexión con bases de datos. 
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