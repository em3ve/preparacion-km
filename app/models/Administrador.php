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

// Definición de la clase administrador. 
class Administrador
{
    // Definición de variables. 
    private ?int $idAdministrador;
    private ?int $idUsuario;

    // Definición de método constructor.  
    public function __construct(?int $idUsuario = null, ?int $idAdministrador = null)
    {
        $this->idAdministrador = $idAdministrador;
        $this->idUsuario       = $idUsuario;
    }

    //Inicio de funciones setters y getters. 

    public function getIdAdministrador(): ?int
    {
        return $this->idAdministrador;
    }

    public function setIdAdministrador(?int $idAdministrador): void
    {
        $this->idAdministrador = $idAdministrador;
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

    // Registra un nuevo administrador vinculándolo con un idusuario.
    public function insertarAdministrador(int $idUsuario): int|false
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
        $sql = "INSERT INTO administrador (usuario_idusuario) VALUES (:usuario_idusuario)";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            // Prepara la consulta. 
            $stmt = $pdo->prepare($sql);
            // Asigna los valores a la consulta definida. 
            $stmt->bindValue(':usuario_idusuario', $idUsuario, PDO::PARAM_INT);

            // Intenta ejecutar la consulta. 
            if ($stmt->execute()) {
                // Devuelve los valores correspondientes a el último administrador creado. 
                $this->idAdministrador = (int)$pdo->lastInsertId();
                $this->idUsuario = $idUsuario;
                return $this->idAdministrador;
            }
            return false;
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::insertarAdministrador: " . $e->getMessage());
            return false;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Consulta un administrador por su id administrador usando vista_usuarios_segura y biografia.
    public function consultarPorId(int $idAdministrador): ?array
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
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro, v.idadministrador
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idadministrador = :idadministrador
                LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idadministrador', $idAdministrador, PDO::PARAM_INT);
            $stmt->execute();

            // Almacena los resultados obtenidos en una variable array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::consultarPorId: " . $e->getMessage());
            return null;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Consulta un administrador por su idusuario.
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
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro, v.idadministrador
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idusuario = :idusuario AND v.idadministrador IS NOT NULL
                LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            // Almacena los resultados obtenidos en una variable array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::consultarPorUsuario: " . $e->getMessage());
            return null;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Lista todos los usuarios del sistema consultando vista_usuarios_segura junto con biografia.
    public function listarUsuariosSeguros(): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return [];
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro,
                        v.idestudiante, v.idinstructor, v.validacion_instructor, v.idadministrador
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                ORDER BY v.idusuario ASC";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->query($sql);
            // Almacena los resultados obtenidos en una variable array. 
            return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::listarUsuariosSeguros: " . $e->getMessage());
            return [];
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Lista únicamente los instructores que están pendientes de verificación.
    public function listarInstructoresPendientes(): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return [];
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.estado_cuenta, v.idinstructor, v.validacion_instructor
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idinstructor IS NOT NULL AND v.validacion_instructor = 'pendiente'
                ORDER BY v.idinstructor ASC";

        // Intenta la preparación del statement. 
        try {
            $stmt = $pdo->query($sql);
            // Almacena los resultados obtenidos en una variable array. 
            return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::listarInstructoresPendientes: " . $e->getMessage());
            return [];
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Inserta un nuevo código de verificación en codigo_ins asociado al administrador
    public function generarCodigoInstructor(
        int $idAdministrador,
        string $codigo,
        ?int $idInstructor = null
    ): int|false {

        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "INSERT INTO codigo_ins (codigo, estado, instructor_idinstructor, administrador_idadministrador)
                VALUES (:codigo, 'activo', :idinstructor, :idadministrador)";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindValue(
                ':idinstructor',
                $idInstructor,
                $idInstructor !== null ? PDO::PARAM_INT : PDO::PARAM_NULL
            );
            $stmt->bindValue(':idadministrador', $idAdministrador, PDO::PARAM_INT);

            // Ejecuta la inserción del dato y retorna el id del registro. 
            if ($stmt->execute()) {
                return (int)$pdo->lastInsertId();
            }
            return false;
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::generarCodigoInstructor: " . $e->getMessage());
            return false;
        } finally {
            // En caso de error, avisa al usuario. 
            $conexionObj->desconectar();
        }
    }

    // Lista todos los códigos de verificación de instructores generados en codigo_ins y su información asociada. 
    public function listarCodigosInstructor(): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return [];
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "SELECT ci.idcodigo_ins, ci.codigo, ci.estado, ci.fecha_gen,
                        ci.administrador_idadministrador, ua.correo AS correo_admin,
                        ci.instructor_idinstructor, ui.correo AS correo_instructor
                FROM codigo_ins ci
                INNER JOIN administrador a ON ci.administrador_idadministrador = a.idadministrador
                INNER JOIN usuario ua ON a.usuario_idusuario = ua.idusuario
                LEFT JOIN instructor i ON ci.instructor_idinstructor = i.idinstructor
                LEFT JOIN usuario ui ON i.usuario_idusuario = ui.idusuario
                ORDER BY ci.fecha_gen DESC";

        // Intenta la preparación del statement
        try {
            $stmt = $pdo->query($sql);
            // Almacena los resultados obtenidos en una variable array. 
            return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            // En caso de error, avisa al usuario. 
            error_log("Error en Administrador::listarCodigosInstructor: " . $e->getMessage());
            return [];
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Elimina un registro de la tabla administrador.
    public function eliminarAdministrador(int $idAdministrador): bool
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
        $sql = "DELETE FROM administrador WHERE idadministrador = :idadministrador";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idadministrador', $idAdministrador, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Administrador::eliminarAdministrador: " . $e->getMessage());
            return false;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }
}