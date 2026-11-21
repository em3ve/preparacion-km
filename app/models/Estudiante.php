<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

// Importación de el archivo para la conexión con base de datos.
require_once __DIR__ . '/../Config/ConexionBaseDatos.php';

use App\Config\ConexionBaseDatos;
use PDO;
use PDOException;

//Definición de la clase estudiante. 
class Estudiante 
{

    private ?int $idEstudiante = null;

    private ?int $idUsuario;

    //constructor de la clase estudiante recibe el identificador de usuario. 
    public function __construct(?int $idUsuario = null, ?int $idEstudiante = null)
    {
        $this->idUsuario    = $idUsuario;
        $this->idEstudiante = $idEstudiante;
    }

    //Inicio de funciones setters y getters. 

    public function getIdEstudiante(): ?int
    {
        return $this->idEstudiante;
    }

    public function setIdEstudiante(?int $idEstudiante): void
    {
        $this->idEstudiante = $idEstudiante;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }


    // Métodos para el acceso a bases de datos y consultas. 

    // Realiza un nuevo registro en base a un usuario dado.
    public function insertarEstudiante(int $idUsuario): int|false
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "INSERT INTO estudiante (usuario_idusuario) VALUES (:usuario_idusuario)";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':usuario_idusuario', $idUsuario, PDO::PARAM_INT);

            // Intenta realizar la ejecución de la inserción en la base de datos. 
            if ($stmt->execute()) {
                $this->idEstudiante = (int)$pdo->lastInsertId();
                $this->idUsuario    = $idUsuario;
                return $this->idEstudiante;
            }
            return false;

            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Estudiante::insertarEstudiante: " . $e->getMessage());
            return false;
        } finally {

            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Realiza la consulta de los datos del usuario en base a un id de estudiante.
    public function consultarPorId(int $idEstudiante): ?array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return null;
        }


        //  Array con los campos a recuperar de la base de datos. 
        // Se recupera de esta manera temporalmente para incluir la biografia. Ese elemento solo se ocupara en la pagina de perfil en el producto final.
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro, v.idestudiante
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idestudiante = :idestudiante
                LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idestudiante', $idEstudiante, PDO::PARAM_INT);
            // Ejecuta la sentencia definida anteriormente. 
            $stmt->execute();

            // Almacena los resultados obtenidos en una variable array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;
        } catch (PDOException $e) {
            // En caso de error, avisa al usuario. 
            error_log("Error en Estudiante::consultarPorId: " . $e->getMessage());
            return null;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Realiza la consulta de los datos del usuario en base a un id de usuario.
    public function consultarPorUsuario(int $idUsuario): ?array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return null;
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro, v.idestudiante
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idusuario = :idusuario AND v.idestudiante IS NOT NULL
                LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            // Intenta realizar la ejecución de la consulta en la base de datos. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;
        } catch (PDOException $e) {
            // En caso de error, avisa al usuario. 
            error_log("Error en Estudiante::consultarPorUsuario: " . $e->getMessage());
            return null;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Uso de `vista_usuarios_segura` incluyendo su biografía para comprobar funcionamiento. 
    public function listarTodos(): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return [];
        }
        // Genera una consulta SQL con los datos a regresar desde la vista y desde la tabla de usuarios. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro, v.idestudiante
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idestudiante IS NOT NULL
                ORDER BY v.idestudiante ASC";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {
            // Almacena los resultados obtenidos en una variable array. 
            $stmt = $pdo->query($sql);
            return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            // En caso de error, avisa al usuario. 
            error_log("Error en Estudiante::listarTodos: " . $e->getMessage());
            return [];
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Se elimina la atribución de estudiante de un usuario. 
    public function eliminarEstudiante(int $idEstudiante): bool
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Definición de la consulta que será utilizada para eliminar al estudiante. 
        $sql = "DELETE FROM estudiante WHERE idestudiante = :idestudiante";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idestudiante', $idEstudiante, PDO::PARAM_INT);
            // Ejecuta la sentencia definida anteriormente. 
            $stmt->execute();

            // Se evalúa el número de filas retornadas desde la base de datos. 
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {

        // En caso de error, avisa al usuario. 
            error_log("Error en Estudiante::eliminarEstudiante: " . $e->getMessage());
            return false;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }
}