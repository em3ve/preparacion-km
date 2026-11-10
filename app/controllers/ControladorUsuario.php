<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para los controladores 
namespace App\Controllers;

// Requerimiento de la clase del modelo y del validador de datos. 
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Helpers/ValidadorDatos.php';
require_once __DIR__ . '/../Helpers/RespuestaJson.php';

// Utilización de las clases. 
use App\Models\Usuario;
use App\Helpers\ValidadorDatos;
use App\Helpers\RespuestaJson;

// Controlador encargado de gestionar las solicitudes relacionadas con el perfil de usuario
class ControladorUsuario
{
    /* Instancia del modelo Usuario. */
    private Usuario $modeloUsuario;

    /* Directorio base donde se almacenan las fotografías de perfil. */
    private string $directorioPerfiles;

    // Constructor con definicion de la ubicación de almacenamiento.
    public function __construct()
    {
        $this->modeloUsuario = new Usuario();
        $this->directorioPerfiles = __DIR__ . '/../../public/uploads/perfiles/';
    }

    // Consulta la información de perfil de un usuario por su ID.
    public function consultarPerfil(int $idUsuario): array
    {
        // Ejecuta una validación en el dato ingresado. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Ejecuta la consulta a partir del id del usuario, sin contraseña. 
        $datosUsuario = $this->modeloUsuario->consultarPorId($idUsuario, false);

        // En dado caso que no se recuperen resultados, se avisa al usuario. 
        if ($datosUsuario === null) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('No se encontró el perfil del usuario solicitado.', 404);
        }

        // Envía la respuesta de error al mensajero JSON. 
        return RespuestaJson::exito($datosUsuario, 'Perfil de usuario recuperado correctamente.');
    }

    // Modifica los datos del perfil del usuario (nombre, apellido, biografía y fotografía opcional).
    public function modificarPerfil(int $idUsuario, array $datos, ?array $archivoFoto = null): array
    {
        // Evalúa si el id del usuario es válido. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Limpieza de los datos recibidos al momento de asignarlos a las variables. 
        $nombre = isset($datos['nombre']) ? ValidadorDatos::limpiarCadena((string)$datos['nombre']) : '';
        $apellido = isset($datos['apellido']) ? ValidadorDatos::limpiarCadena((string)$datos['apellido']) : null;
        $biografia = isset($datos['biografia']) ? ValidadorDatos::limpiarCadena((string)$datos['biografia']) : null;

        // Validación de reglas definidas y caracteres prohibidos
        if (!ValidadorDatos::validarTextoCorto($nombre, 55)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error(
                'El nombre es obligatorio, no debe exceder 55 caracteres ni contener caracteres especiales (; { } $ / < >).'
            );
        }

        // Validación de reglas definidas y caracteres prohibidos
        if ($apellido !== null && $apellido !== '' && !ValidadorDatos::validarTextoCorto($apellido, 55)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error(
                'El apellido no debe exceder 55 caracteres ni contener caracteres prohibidos (; { } $ / < >).'
            );
        }

        // Validación de reglas definidas y caracteres prohibidos
        if (!ValidadorDatos::validarTextoLargo($biografia, 255)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error(
                'La biografía no debe exceder 255 caracteres ni contener caracteres prohibidos (; { } $ / < >).'
            );
        }

        // Validación y almacenamiento de la fotografía de perfil (PNG/JPG máx. 1 MB)
        $rutaFotografiaRelativa = null;
        // Verifica que haya un archivo válido en la variable. 
        if ($archivoFoto !== null && isset($archivoFoto['error']) && $archivoFoto['error'] !== UPLOAD_ERR_NO_FILE) {
            // Realiza las validaciones de acuerdo al archivo validador. 
            $validacionImagen = ValidadorDatos::validarImagen($archivoFoto);
            // En caso que el archivo no sea válido, manda un mensaje. 
            if (!$validacionImagen['valido']) {
            // Envía la respuesta de error al mensajero JSON. 

                return RespuestaJson::error($validacionImagen['error'] . ' Por favor, seleccione un archivo válido.');
            }

            // Intenta la creación del directorio en caso de que no exista. 
            if (!is_dir($this->directorioPerfiles)) {
                // Ejecuta la operación y asigna los permisos correspondientes. 
                mkdir($this->directorioPerfiles, 0755, true);
            }

            // Define la ruta de acceso y extencion correcta del archivo en minúscula y añadiendo el nombre del archivo. 
            $extension = strtolower(pathinfo((string)$archivoFoto['name'], PATHINFO_EXTENSION));
            // Asegura que el nombre del archivo sea único para evitar duplicidad con una generación de nombre aleatoria. 
            $nombreArchivoUnico = 'perfil_usr_' . $idUsuario . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
            // Define la ruta absoluta del archivo. 
            $rutaDestinoAbsoluta = $this->directorioPerfiles . $nombreArchivoUnico;

            // Pasa el archivo de la ubicación temporal hacia la ruta definitiva donde se almacenará. 
            if (!move_uploaded_file($archivoFoto['tmp_name'], $rutaDestinoAbsoluta)) {
                // Envía la respuesta de error al mensajero JSON. 
                return RespuestaJson::error('No fue posible almacenar la fotografía en el servidor.', 500);
            }

            // Se concatena la ruta del archivo más el nombre. 
            $rutaFotografiaRelativa = 'uploads/perfiles/' . $nombreArchivoUnico;
        }

        // Envío de la información validada al usuario para ejecutar el UPDATE
        $actualizado = $this->modeloUsuario->actualizarPerfil(
            $idUsuario,
            $nombre,
            $apellido !== '' ? $apellido : null,
            $biografia !== '' ? $biografia : null,
            $rutaFotografiaRelativa
        );

        // Intenta la actualización del perfil y si esta no es lograda Manda un mensaje. 
        if (!$actualizado) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('Ocurrió un error al actualizar el perfil en la base de datos.', 500);
        }

        // Envía la respuesta de error al mensajero JSON. 
        return RespuestaJson::exito(
            ['fotografia' => $rutaFotografiaRelativa],
            'El perfil ha sido actualizado correctamente.'
        );
    }

    // Cambia la contraseña del usuario autenticado verificando su contraseña actual y aplicando el algoritmo Argon2id.
    public function cambiarContrasena(int $idUsuario, array $datos): array
    {
        // Ejecuta una validación en el dato ingresado. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Recupera la contraseña actual y la contraseña nueva. 
        $contrasenaActual = (string)($datos['contrasena_actual'] ?? '');
        $contrasenaNueva  = (string)($datos['contrasena_nueva'] ?? '');

        // Realiza la validación de que el auto debe de existir y valida que la contraseña se ajuste a los parámetros. 
        if (!ValidadorDatos::validarObligatorio($contrasenaActual) || !ValidadorDatos::validarContrasena($contrasenaNueva)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error(
                'La nueva contraseña debe tener entre 8 y 25 caracteres, incluir mayúsculas, minúsculas, números y no contener caracteres prohibidos (; { } $ / < >).'
            );
        }

        // Recupera los datos del usuario. 
        $usuarioActual = $this->modeloUsuario->consultarPorId($idUsuario, true);
        if ($usuarioActual === null) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('El usuario no existe.', 404);
        }

        // Contrasta la contraseña ingresada por el usuario con lo almacenado por la base de datos. 
        if (!password_verify($contrasenaActual, (string)$usuarioActual['contrasena'])) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('La contraseña actual proporcionada es incorrecta.', 401);
        }

        // Realiza el cifrado de la nueva contraseña utilizando el algoritmo Argon2id
        // La contraseña cifrada la manda como campo para actualizar la contraseña en la base de datos. 
        $nuevoHashArgon2id = password_hash($contrasenaNueva, PASSWORD_ARGON2ID);
        $actualizado = $this->modeloUsuario->actualizarContrasena($idUsuario, $nuevoHashArgon2id);

        // En caso de error, se envía un mensaje. 
        if (!$actualizado) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('No fue posible actualizar la contraseña en la base de datos.', 500);
        }

        // Envía la respuesta de error al mensajero JSON. 
        return RespuestaJson::exito(null, 'La contraseña ha sido actualizada exitosamente.');
    }

    // Elimina la cuenta del usuario en la base de datos y destruye su sesión activa.
    public function eliminarCuenta(int $idUsuario): array
    {
        // Ejecuta una validación en el dato ingresado. 
        if (!ValidadorDatos::validarEnteroPositivo($idUsuario)) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('El identificador de usuario no es válido.');
        }

        // Realiza el método de eliminación de usuario. 
        $eliminado = $this->modeloUsuario->eliminarUsuario($idUsuario);

        // Dependiendo del resultado de la eliminación se muestra un mensaje. 
        if (!$eliminado) {
            // Envía la respuesta de error al mensajero JSON. 
            return RespuestaJson::error('No se pudo eliminar la cuenta o el usuario no existe.', 404);
        }

        // Destrucción segura de la sesión activa al eliminar un usuario 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se limpia el arreglo de la sesión activa. 
        $_SESSION = [];

        // En caso que haya una cookie con datos de la sesión, se limpia. 
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Se destruye la sesión. 
        session_destroy();

        // Se envía un mensaje Jason para informar de la eliminación de la cuenta. 
        return RespuestaJson::exito(null, 'La cuenta y toda su información asociada han sido eliminadas correctamente.');
    }
}