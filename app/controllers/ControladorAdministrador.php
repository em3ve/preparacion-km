<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para los controladores 
namespace App\Controllers;

// Requerimiento de la clase del modelo y del validador de datos. 
require_once __DIR__ . '/../Models/Administrador.php';
require_once __DIR__ . '/../Models/Instructor.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Helpers/ValidadorDatos.php';
require_once __DIR__ . '/../Helpers/RespuestaJson.php';

// Utilización de las clases. 
use App\Models\Administrador;
use App\Models\Instructor;
use App\Models\Usuario;
use App\Helpers\ValidadorDatos;
use App\Helpers\RespuestaJson;

// Controlador para las operaciones del rol administrador. 
class ControladorAdministrador
{
    // Definición del modelo, administrador, usuario y estudiante. 
    private Administrador $modeloAdministrador;
    private Instructor $modeloInstructor;
    private Usuario $modeloUsuario;

    // Constructor con instanciación de objetos. 
    public function __construct()
    {
        $this->modeloAdministrador = new Administrador();
        $this->modeloInstructor    = new Instructor();
        $this->modeloUsuario       = new Usuario();
    }

    // Registra un usuario en la tabla administrador. 
    public function registrarAdministrador(int $idUsuario): array
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
        if ($usuario['rol'] !== Usuario::ROL_ADMIN) {
            return RespuestaJson::error('El usuario no tiene asignado el rol admin en su cuenta base.');
        }

        // Verifica que el usuario no esté registrado como administrador. 
        if ($this->modeloAdministrador->consultarPorUsuario($idUsuario) !== null) {
            return RespuestaJson::error('Este usuario ya se encuentra registrado en la tabla administrador.');
        }

        // Realiza la inserción en la tabla. 
        $idAdmin = $this->modeloAdministrador->insertarAdministrador($idUsuario);
        if ($idAdmin === false) {
            return RespuestaJson::error('Error al registrar el perfil de administrador.', 500);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito(
            ['idadministrador' => $idAdmin, 'usuario_idusuario' => $idUsuario],
            'Administrador registrado correctamente.'
        );
    }

    // Genera un código único en codigo_ins y lo asocia a la cuenta del instructor pendiente
    public function generarCodigoInstructor(int $idAdministrador, int $idInstructor): array
    {
        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idAdministrador)) {
            return RespuestaJson::error('El identificador del administrador no es válido.');
        }

        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idInstructor)) {
            return RespuestaJson::error('El identificador del instructor no es válido.');
        }

        // Recupera los datos del usuario de acuerdo a su ID. 
        if ($this->modeloAdministrador->consultarPorId($idAdministrador) === null) {
            return RespuestaJson::error('El administrador indicado no existe.', 404);
        }

        // Recupera los datos del usuario de acuerdo a su ID. 
        $instructor = $this->modeloInstructor->consultarPorId($idInstructor);
        if ($instructor === null) {
            return RespuestaJson::error('El instructor indicado no existe.', 404);
        }

        // Verifica que el instructor no haya sido validado aún. 
        if ($instructor['validacion_instructor'] === Instructor::VALIDACION_VALIDADO) {
            return RespuestaJson::error('Este instructor ya fue validado; no requiere un nuevo código.');
        }

        // genera el código necesario a partir de una estructura base con cuatro caracteres predefinidos y cuatro caracteres aleatorios.  
        $codigoGenerado = 'INS-' . strtoupper(bin2hex(random_bytes(4)));
        // Efectúa la inserción del código en la tabla correspondiente. 
        $idCodigo = $this->modeloAdministrador->generarCodigoInstructor(
            $idAdministrador,
            $codigoGenerado,
            $idInstructor
        );

        // Si hay un fallo en la generación del código, avisa al usuario. 
        if ($idCodigo === false) {
            return RespuestaJson::error('No fue posible generar y almacenar el código de instructor.', 500);
        }

        // Manda un mensaje al usuario con los datos de la operación para pruebas.  
        return RespuestaJson::exito(
            [
                'idcodigo_ins' => $idCodigo,
                'codigo' => $codigoGenerado,
                'administrador_idadministrador' => $idAdministrador,
                'instructor_idinstructor' => $idInstructor,
                'estado' => 'activo',
            ],
            'Código de verificación generado y asociado al instructor. Compártalo manualmente con el instructor.'
        );
    }

    // Lista todos los códigos de verificación generados en codigo_ins.
    public function listarCodigosInstructor(): array
    {
        // Recupera la lista completa de códigos que han sido generados. 
        $codigos = $this->modeloAdministrador->listarCodigosInstructor();
        return RespuestaJson::exito($codigos, 'Códigos de instructor recuperados correctamente.');
    }

    // Cambia manualmente el estado de validación de un instructor (pendiente, validado, rechazado).
    public function cambiarEstadoValidacionInstructor(int $idInstructor, string $nuevoEstado): array
    {
        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idInstructor)) {
            return RespuestaJson::error('El identificador del instructor no es válido.');
        }

        // Verifica que el estado de validación introducido sea válido y esté dentro de los estados permitidos. 
        $estadoLimpio = ValidadorDatos::limpiarCadena($nuevoEstado);
        $estadosPermitidos = [
            Instructor::VALIDACION_PENDIENTE,
            Instructor::VALIDACION_VALIDADO,
            Instructor::VALIDACION_RECHAZADO,
        ];

        // En caso en que el estado de validación no sea el último, se avisa al usuario. 
        if (!in_array($estadoLimpio, $estadosPermitidos, true)) {
            return RespuestaJson::error('Estado de validación no permitido. Use pendiente, validado o rechazado.');
        }

        // Se verifica que el ID del instructor existe. 
        if ($this->modeloInstructor->consultarPorId($idInstructor) === null) {
            return RespuestaJson::error('El instructor especificado no existe.', 404);
        }

        // Se realiza la actualización del estado de validación del instructor. 
        $actualizado = $this->modeloInstructor->actualizarEstadoValidacion($idInstructor, $estadoLimpio);
        if (!$actualizado) {
            return RespuestaJson::error('Error al actualizar el estado de validación del instructor.', 500);
        }
        
        // Envía mensaje al usuario. 
        return RespuestaJson::exito(
            ['idinstructor' => $idInstructor, 'estado_validacion' => $estadoLimpio],
            'Estado de validación del instructor actualizado correctamente.'
        );
    }

    // Lista todos los usuarios del sistema desde `vista_usuarios_segura`.
    public function consultarUsuarios(): array
    {
        // Ejecuta el método para la recuperación de la lista de usuarios. 
        $usuarios = $this->modeloAdministrador->listarUsuariosSeguros();
        return RespuestaJson::exito($usuarios, 'Lista de usuarios recuperada desde vista_usuarios_segura.');
    }

    // Elimina un usuario del sistema desde el panel de administración.
    public function eliminarUsuario(int $idUsuario): array
    {
        // Valida que el id sea un número válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Ejecuta la eliminación del usuario a partir de su Id. 
        if (!$this->modeloUsuario->eliminarUsuario($idUsuario)) {
            return RespuestaJson::error('No se pudo eliminar el usuario o no existe.', 404);
        }

        // Envía un mensaje al usuario. 
        return RespuestaJson::exito(null, 'Usuario eliminado correctamente del sistema.');
    }
}