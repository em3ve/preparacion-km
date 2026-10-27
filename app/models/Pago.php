<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

//Definición de la clase pago
class Pago
{
    private ?int $idCompra = null;

    private int $idEstudiante;

    private float $total;

    /** Identificador de transacción de PayPal. */
    private ?string $idTransaccionPaypal = null;

    /** Estado del pago (pendiente, aprobado, rechazado, cancelado). */
    private string $estadoPago = 'pendiente';

    /** Fecha y hora de la transacción de PayPal. **/
    private ?string $fechaTransaccion = null;

    private ?string $fechaCreacion = null;

    /** Lista de cursos incluidos en la compra. */
    private array $detalleCursos = [];


    //constructor de la clase recibe el identificador de usuario. 

    public function __construct(
        int $idEstudiante,
        float $total
    ) {
        $this->idEstudiante = $idEstudiante;
        $this->total = $total;
    }

    //Inicio de funciones setters y getters. 
    
    public function getIdCompra(): ?int
    {
        return $this->idCompra;
    }

    public function setIdCompra(?int $idCompra): void
    {
        $this->idCompra = $idCompra;
    }

    public function getIdEstudiante(): int
    {
        return $this->idEstudiante;
    }

    public function setIdEstudiante(int $idEstudiante): void
    {
        $this->idEstudiante = $idEstudiante;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getIdTransaccionPaypal(): ?string
    {
        return $this->idTransaccionPaypal;
    }

    public function setIdTransaccionPaypal(?string $idTransaccionPaypal): void
    {
        $this->idTransaccionPaypal = $idTransaccionPaypal;
    }

    public function getEstadoPago(): string
    {
        return $this->estadoPago;
    }

    public function setEstadoPago(string $estadoPago): void
    {
        $this->estadoPago = $estadoPago;
    }

    public function getFechaTransaccion(): ?string
    {
        return $this->fechaTransaccion;
    }

    public function setFechaTransaccion(?string $fechaTransaccion): void
    {
        $this->fechaTransaccion = $fechaTransaccion;
    }

    public function getFechaCreacion(): ?string
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(?string $fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getDetalleCursos(): array
    {
        return $this->detalleCursos;
    }

    public function agregarCurso(Curso $curso, float $precioUnitario): void
    {
        $this->detalleCursos[] = [
            'curso' => $curso,
            'precio_unitario' => $precioUnitario,
        ];
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