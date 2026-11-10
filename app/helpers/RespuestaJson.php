<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para el archivo generador de json 
namespace App\Helpers;

// Clase utilitaria encargada de estandarizar y emitir las respuestas JSON
class RespuestaJson
{
    // Envía una respuesta JSON indicando que la operación fue exitosa.
    public static function exito(
        mixed $datos = null,
        string $mensaje = 'Operación realizada correctamente.',
        int $codigoHttp = 200
    ): array {
        if (!headers_sent()) {
            http_response_code($codigoHttp);
            header('Content-Type: application/json; charset=utf-8');
        }

        $respuesta = [
            'exito'   => true,
            'mensaje' => $mensaje,
            'datos'   => $datos,
        ];

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        return $respuesta;
    }

    // Envía una respuesta JSON indicando un error de validación o de procesamiento, solicitando al usuario verificar o ingresar nuevamente los datos.
    public static function error(
        string $mensaje = 'Los datos proporcionados no son válidos. Por favor, verifique e intente nuevamente.',
        int $codigoHttp = 400,
        mixed $detalles = null
    ): array {
        if (!headers_sent()) {
            http_response_code($codigoHttp);
            header('Content-Type: application/json; charset=utf-8');
        }

        $respuesta = [
            'exito'    => false,
            'mensaje'  => $mensaje,
            'detalles' => $detalles,
        ];

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        return $respuesta;
    }
}