<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase Usuario. 
class Usuario
{
    public const ROL_ESTUDIANTE = 'estudiante';

    public const ROL_INSTRUCTOR = 'instructor';

    public const ROL_ADMINISTRADOR = 'administrador';

    private ?int $idUsuario = null;

    private string $correo;

    private string $contrasena;

    private string $nombre;

    private string $apellido;

    private ?string $biografia = null;

    /** Rol del usuario (estudiante, instructor o administrador). **/
    private string $rol;

    /** Estado de la cuenta (pendiente, verificada, activa, inactiva). **/
    private string $estadoCuenta = 'pendiente';

    private ?string $fechaRegistro = null;

    //método constructor 
    public function __construct(
        string $correo, 
        string $contrasena, 
        string $nombre, 
        string $apellido, 
        string $rol
        )
    {
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->rol = $rol;
    }

    //Inicio de funciones setters y getters. 

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    //La biografía puede no llenarse en el momento de la creación del usuario. 
    public function getBiografia(): ?string
    {
        return $this->biografia;
    }

    public function setBiografia(?string $biografia): void
    {
        $this->biografia = $biografia;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public function getEstadoCuenta(): string
    {
        return $this->estadoCuenta;
    }

    public function setEstadoCuenta(string $estadoCuenta): void
    {
        $this->estadoCuenta = $estadoCuenta;
    }

    public function getFechaRegistro(): ?string
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?string $fechaRegistro): void
    {
        $this->fechaRegistro = $fechaRegistro;
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
