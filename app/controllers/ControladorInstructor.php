<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para los controladores 
namespace App\Controllers;

// Requerimiento de la clase del modelo y del validador de datos. 
require_once __DIR__ . '/../Models/Instructor.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Helpers/ValidadorDatos.php';
require_once __DIR__ . '/../Helpers/RespuestaJson.php';

// Utilización de las clases. 
use App\Models\Instructor;
use App\Models\Usuario;
use App\Helpers\ValidadorDatos;
use App\Helpers\RespuestaJson;

// Controlador para las operaciones del rol Instructor,
class ControladorInstructor
{
    // Definición del modelo, usuario y estudiante. 
    private Instructor $modeloInstructor;
    private Usuario $modeloUsuario;

    // Constructor con instanciación de objetos. 
    public function __construct()
    {
        $this->modeloInstructor = new Instructor();
        $this->modeloUsuario    = new Usuario();
    }

    // Registra un usuario existente con rol instructor en la tabla con estado inicial 'pendiente' de verificación.
    public function registrarInstructor(int $idUsuario): array
    {
        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Recupera los datos del usuario de acuerdo a su ID. 
        $usuario = $this->modeloUsuario->consultarPorId($idUsuario);
        if ($usuario === null) {
            return RespuestaJson::error('El usuario especificado no existe.', 404);
        }

        // Verifica que el rol sea el adecuado. 
        if ($usuario['rol'] !== Usuario::ROL_INSTRUCTOR) {
            return RespuestaJson::error('El usuario no tiene asignado el rol de instructor en su cuenta base.');
        }

        // Verifica que el usuario no esté registrado como estudiante. 
        if ($this->modeloInstructor->consultarPorUsuario($idUsuario) !== null) {
            return RespuestaJson::error('Este usuario ya se encuentra registrado en la tabla instructor.');
        }

        // Realiza la inserción en la tabla. 
        $idInstructor = $this->modeloInstructor->insertarInstructor($idUsuario, Instructor::VALIDACION_PENDIENTE);
        if ($idInstructor === false) {
            return RespuestaJson::error('Error al registrar el perfil de instructor.', 500);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito(
            [
                'idinstructor' => $idInstructor,
                'usuario_idusuario' => $idUsuario,
                'estado_validacion' => Instructor::VALIDACION_PENDIENTE,
            ],
            'Instructor registrado en estado pendiente. Solicite su código de verificación al administrador.'
        );
    }

    // Recupera la información del instructor a partir de su ID de instructor. 
    public function consultarInstructor(int $idInstructor): array
    {
        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idInstructor)) {
            return RespuestaJson::error('El identificador de instructor no es válido.');
        }

        // Recupera los datos del usuario de acuerdo a su ID. 
        $datos = $this->modeloInstructor->consultarPorId($idInstructor);
        if ($datos === null) {
            return RespuestaJson::error('No se encontró el instructor solicitado.', 404);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito($datos, 'Información del instructor recuperada correctamente.');
    }

    // Permite a un instructor ingresar el código de verificación compartido por el administrador para validar.
    public function validarCuentaConCodigo(int $idInstructor, string $codigo): array
    {
        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idInstructor)) {
            return RespuestaJson::error('El identificador de instructor no es válido.');
        }

        // el código a partir de lo introducido por el usuario. 
        $codigoLimpio = ValidadorDatos::limpiarCadena($codigo);
        // Ejecuta la validación para que sea un texto adecuado.  
        if (!ValidadorDatos::validarTextoCorto($codigoLimpio, 55)) {
            return RespuestaJson::error(
                'El código ingresado no es válido o contiene caracteres prohibidos (; { } $ / < >). Verifique e intente nuevamente.'
            );
        }

        // Valida que el instructor exista en la plataforma. 
        $instructor = $this->modeloInstructor->consultarPorId($idInstructor);
        if ($instructor === null) {
            return RespuestaJson::error('El instructor especificado no existe.', 404);
        }

        // Cambia el estatus de validación de la cuenta de instructor. 
        if ($instructor['validacion_instructor'] === Instructor::VALIDACION_VALIDADO) {
            return RespuestaJson::error('Esta cuenta de instructor ya se encuentra validada.');
        }

        // Ejecuta la verificación utilizando el código introducido por el usuario para el instructor. 
        $resultado = $this->modeloInstructor->verificarConCodigo($idInstructor, $codigoLimpio);

        // Evalúa el éxito de la operación. 
        if (!$resultado['exito']) {
            return RespuestaJson::error($resultado['mensaje']);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito(
            ['idinstructor' => $idInstructor, 'estado_validacion' => Instructor::VALIDACION_VALIDADO],
            $resultado['mensaje']
        );
    }

    // Lista todos los instructores opcionalmente filtrando por estado.
    public function listarInstructores(?string $filtroEstado = null): array
    {
        // Recupera los posibles estados desde el objeto. 
        $estadosValidos = [
            Instructor::VALIDACION_PENDIENTE,
            Instructor::VALIDACION_VALIDADO,
            Instructor::VALIDACION_RECHAZADO,
        ];

        // Evalúa el filtro ingresado por el usuario y valida su existencia. 
        if ($filtroEstado !== null && !in_array($filtroEstado, $estadosValidos, true)) {
            return RespuestaJson::error('El estado de validación filtrado no es válido.');
        }

        // Regresa un array con la lista de todos los instructores. 
        $lista = $this->modeloInstructor->listarTodos($filtroEstado);
        return RespuestaJson::exito($lista, 'Lista de instructores recuperada correctamente.');
    }

    // Termina un registro de instructor de la tabla. 
    public function eliminarInstructor(int $idInstructor): array
    {
        // Valida que el ID sea un número permitido . 
        if (!ValidadorDatos::validarEnteroPositivo($idInstructor)) {
            return RespuestaJson::error('El identificador de instructor no es válido.');
        }

        // Intenta el proceso de eliminación en base al I D del instructor. 
        if (!$this->modeloInstructor->eliminarInstructor($idInstructor)) {
            return RespuestaJson::error('No se pudo eliminar el registro o el instructor no existe.', 404);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito(null, 'Registro de instructor eliminado correctamente.');
    }
}