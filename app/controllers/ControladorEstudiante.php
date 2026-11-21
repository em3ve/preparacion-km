<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para los controladores 
namespace App\Controllers;

// Requerimiento de la clase del modelo y del validador de datos. 
require_once __DIR__ . '/../Models/Estudiante.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Helpers/ValidadorDatos.php';
require_once __DIR__ . '/../Helpers/RespuestaJson.php';

// Utilización de las clases. 
use App\Models\Estudiante;
use App\Models\Usuario;
use App\Helpers\ValidadorDatos;
use App\Helpers\RespuestaJson;

// Controlador para las operaciones del rol Estudiante.
class ControladorEstudiante
{
    // Definición del modelo, usuario y estudiante. 
    private Estudiante $modeloEstudiante;
    private Usuario $modeloUsuario;

    // Constructor con instanciación de objetos. 
    public function __construct()
    {
        $this->modeloEstudiante = new Estudiante();
        $this->modeloUsuario    = new Usuario();
    }

    // Registra un usuario existente como estudiante en la tabla estudiante.
    public function registrarEstudiante(int $idUsuario): array
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
        if ($usuario['rol'] !== Usuario::ROL_ESTUDIANTE) {
            return RespuestaJson::error('El usuario no tiene asignado el rol de estudiante en su cuenta base.');
        }

        // Verifica que el usuario no esté registrado como estudiante. 
        if ($this->modeloEstudiante->consultarPorUsuario($idUsuario) !== null) {
            return RespuestaJson::error('Este usuario ya se encuentra registrado en la tabla estudiante.');
        }

        // Realiza la inserción en la tabla. 
        $idEstudiante = $this->modeloEstudiante->insertarEstudiante($idUsuario);
        if ($idEstudiante === false) {
            return RespuestaJson::error('Error al registrar el perfil de estudiante.', 500);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito(
            ['idestudiante' => $idEstudiante, 'usuario_idusuario' => $idUsuario],
            'Estudiante registrado correctamente.'
        );
    }

    // Recupera la información del estudiante desde la tabla Estudiante. . 
    public function consultarEstudiante(int $idEstudiante): array
    {
        // Verifica que el ID introducido sea válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idEstudiante)) {
            return RespuestaJson::error('El identificador de estudiante no es válido.');
        }

        // Recupera la información desde la base de datos a partir del Id. 
        $datos = $this->modeloEstudiante->consultarPorId($idEstudiante);
        if ($datos === null) {
            // En caso de error, alerta al usuario. 
            return RespuestaJson::error('No se encontró el estudiante solicitado.', 404);
        }

        // En caso de éxito se informa. 
        return RespuestaJson::exito($datos, 'Información del estudiante recuperada correctamente.');
    }

    // Recupera la información del estudiante desde la tabla usuario. 
    public function consultarPorUsuario(int $idUsuario): array
    {
        // Verifica que el id introducido sea válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Recupera la información desde la base de datos a partir del Id. 
        $datos = $this->modeloEstudiante->consultarPorUsuario($idUsuario);
        if ($datos === null) {
            // En caso de error, alerta al usuario. 
            return RespuestaJson::error('No se encontró un perfil de estudiante para ese usuario.', 404);
        }

        // En caso de éxito se informa. 
        return RespuestaJson::exito($datos, 'Estudiante encontrado correctamente.');
    }

    // Recupera una lista con todos los estudiantes para prueba. 
    public function listarEstudiantes(): array
    {
        $lista = $this->modeloEstudiante->listarTodos();
        return RespuestaJson::exito($lista, 'Lista de estudiantes recuperada correctamente.');
    }

    // Elimina el registro del estudiante.
    public function eliminarEstudiante(int $idEstudiante): array
    {
        // Valida que el Id sea válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idEstudiante)) {
            return RespuestaJson::error('El identificador de estudiante no es válido.');
        }

        // Ejecuta el método de eliminación para una id del estudiante. 
        if (!$this->modeloEstudiante->eliminarEstudiante($idEstudiante)) {
            return RespuestaJson::error('No se pudo eliminar el registro o el estudiante no existe.', 404);
        }

        // En caso de éxito se informa. 
        return RespuestaJson::exito(null, 'Registro de estudiante eliminado correctamente.');
    }
}