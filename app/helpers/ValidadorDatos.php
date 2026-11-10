<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para el archivo de validación 
namespace App\Helpers;

// Importación de la extensión utilizada para analizar los archivos que se suban a la plataforma. 
use finfo;

// Clase para sanitizar datos de entrada, detectar caracteres peligrosos y validar reglas de formato y archivos multimedia.
class ValidadorDatos
{
    // constante para definir el tamaño máximo para imágenes: 1 MB en bytes. 
    public const MAX_TAMANO_IMAGEN = 1048576;

    // constante para definir el tamaño máximo para videos: 50 MB en bytes.
    public const MAX_TAMANO_VIDEO = 52428800;

    //Expresión regular con caracteres prohibidos que pueden generar vulnerabilidades: ; { } $ / < > " ' ` \
    private const PATRON_CARACTERES_PROHIBIDOS = '/[;{}\$\/<>"\'`\\\\]/';

    //Limpia una cadena eliminando espacios extremos, barras invertidas y etiquetas HTML o caracteres de control.
    public static function limpiarCadena(string $cadena): string
    {
        $limpio = trim($cadena);
        $limpio = stripslashes($limpio);
        // Remueve caracteres invisibles de control
        $limpio = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $limpio) ?? '';
        return $limpio;
    }

    // Verifica si una cadena contiene caracteres prohibidos por seguridad (; { } $ / < > etc.).     
    public static function esTextoSeguro(string $cadena): bool
    {
        return preg_match(self::PATRON_CARACTERES_PROHIBIDOS, $cadena) === 0;
    }

    // Valida que un campo obligatorio no esté vacío después de limpiarlo.
    public static function validarObligatorio(?string $valor): bool
    {
        if ($valor === null) {
            return false;
        }
        return trim($valor) !== '';
    }

    // Limpia y valida un correo electrónico verificando además que no contenga caracteres prohibidos.
    public static function validarCorreo(string $correo): bool
    {
        $correoLimpio = trim($correo);
        if (!self::esTextoSeguro($correoLimpio)) {
            return false;
        }
        return filter_var($correoLimpio, FILTER_VALIDATE_EMAIL) !== false
            && strlen($correoLimpio) <= 225;
    }

    // Valida una contraseña con entre 8 y 25 caracteres, al menos una mayúscula, una minúscula, un número y sin los caracteres especiales
    public static function validarContrasena(string $contrasena): bool
    {
        $longitud = strlen($contrasena);
        if ($longitud < 8 || $longitud > 25) {
            return false;
        }
        if (!self::esTextoSeguro($contrasena)) {
            return false;
        }
        return preg_match('/[A-Z]/', $contrasena) === 1
            && preg_match('/[a-z]/', $contrasena) === 1
            && preg_match('/[0-9]/', $contrasena) === 1;
    }

    // Valida un nombre o apellido (obligatorio, longitud máxima 55 y sin caracteres prohibidos).
    public static function validarTextoCorto(string $texto, int $maxLongitud = 55): bool
    {
        $limpio = self::limpiarCadena($texto);
        if ($limpio === '' || mb_strlen($limpio) > $maxLongitud) {
            return false;
        }
        return self::esTextoSeguro($limpio);
    }

    // Valida un texto descriptivo o biografía (opcional, longitud máxima y sin caracteres prohibidos).
    public static function validarTextoLargo(?string $texto, int $maxLongitud = 255): bool
    {
        if ($texto === null || trim($texto) === '') {
            return true;
        }
        $limpio = self::limpiarCadena($texto);
        if (mb_strlen($limpio) > $maxLongitud) {
            return false;
        }
        return self::esTextoSeguro($limpio);
    }

    // Valida que un valor sea un entero positivo válido (útil para IDs primarios y foráneos).
    public static function validarEnteroPositivo(mixed $id): bool
    {
        return filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) !== false;
    }

    // Valida que sea numero o precio.
    public static function validarDecimalPositivo(mixed $numero): bool
    {
        return is_numeric($numero) && (float)$numero >= 0;
    }

    // Valida que el rol pertenezca a los valores ENUM definidos en usuario
    public static function validarRol(string $rol): bool
    {
        return in_array($rol, ['admin', 'estudiante', 'instructor'], true);
    }

    // Valida un archivo de imagen subido (formato PNG o JPG, tamaño máximo 1 MB, mediante finfo).
    public static function validarImagen(array $archivo): array
    {
        // Evalúa los parámetros del archivo. 
        if (!isset($archivo['error']) || is_array($archivo['error'])) {
            return ['valido' => false, 'error' => 'Parámetros de archivo de imagen inválidos.'];
        }
        // Analiza si se pudo subir el archivo.  
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return ['valido' => false, 'error' => 'Error al subir la imagen al servidor.'];
        }
        // Analiza el tamaño de la imagen.  
        if ($archivo['size'] <= 0 || $archivo['size'] > self::MAX_TAMANO_IMAGEN) {
            return ['valido' => false, 'error' => 'La imagen supera el tamaño máximo permitido de 1 MB.'];
        }
        // Evalúa si tiene la terminación correcta. 
        $extension = strtolower(pathinfo((string)$archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            return ['valido' => false, 'error' => 'La extensión de la imagen debe ser JPG o PNG.'];
        }

        // Evalúa si el archivo es el formato correcto. 
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeReal = $finfo->file($archivo['tmp_name']);
        if (!in_array($mimeReal, ['image/jpeg', 'image/png'], true)) {
            return ['valido' => false, 'error' => 'El contenido real del archivo no corresponde a una imagen JPG o PNG válida.'];
        }

        return ['valido' => true, 'error' => ''];
    }

    // Valida un archivo de video subido (formato MP4, tamaño máximo 50 MB, mediante finfo).
    public static function validarVideo(array $archivo): array
    {
        // Evalúa los parámetros del archivo. 
        if (!isset($archivo['error']) || is_array($archivo['error'])) {
            return ['valido' => false, 'error' => 'Parámetros de archivo de video inválidos.'];
        }

        // Analiza si se pudo subir el archivo.  
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return ['valido' => false, 'error' => 'Error al subir el video al servidor.'];
        }

        // Analiza el tamaño del video.  
        if ($archivo['size'] <= 0 || $archivo['size'] > self::MAX_TAMANO_VIDEO) {
            return ['valido' => false, 'error' => 'El video supera el tamaño máximo permitido de 50 MB.'];
        }

        // Evalúa si tiene la terminación correcta. 
        $extension = strtolower(pathinfo((string)$archivo['name'], PATHINFO_EXTENSION));
        if ($extension !== 'mp4') {
            return ['valido' => false, 'error' => 'El video debe estar en formato MP4.'];
        }

        // Evalúa si el archivo es el formato correcto. 
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeReal = $finfo->file($archivo['tmp_name']);
        if ($mimeReal !== 'video/mp4') {
            return ['valido' => false, 'error' => 'El contenido real del archivo no corresponde a un video MP4 válido.'];
        }

        return ['valido' => true, 'error' => ''];
    }
}