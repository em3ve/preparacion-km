<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

//espacio de trabajo para las clases del Modelo 
namespace app\models;

// Requerimiento de la clase para la conexión hacia la base de datos. 
require_once __DIR__ . '/../Config/ConexionBaseDatos.php';

// Utilización de las clases en la base de datos. 
use app\config\ConexionBaseDatos;
use PDO;
use PDOException;

//Definición de la clase Usuario. 
class Usuario
{
    /* Roles permitidos según el ENUM('admin', 'estudiante', 'instructor') de la BD. */
    public const ROL_ADMIN = 'admin';

    public const ROL_ESTUDIANTE = 'estudiante';

    public const ROL_INSTRUCTOR = 'instructor';

    /* Estados de cuenta permitidos según el ENUM de la BD. */
    public const ESTADO_PENDIENTE = 'pendiente';

    public const ESTADO_VERIFICADA = 'verificada';

    public const ESTADO_ACTIVA = 'activa';

    public const ESTADO_INACTIVA = 'inactiva';

    /* Atributos de acuerdo a lo almacenado en la base de datos. */
    private ?int $idUsuario = null;

    private ?string $correo;

    private ?string $contrasena;

    private ?string $nombre;

    private ?string $apellido;

    private ?string $biografia = null;

    private ?string $fotografia;

    /* Rol del usuario (estudiante, instructor o administrador). */
    private ?string $rol;

    /* Estado de la cuenta (pendiente, verificada, activa, inactiva). */
    private string $estadoCuenta = 'pendiente';

    private ?string $fechaRegistro = null;

    //método constructor 
    public function __construct(
        ?string $correo = null,
        ?string $contrasena = null,
        ?string $nombre = null,
        ?string $apellido = null,
        ?string $rol = self::ROL_ESTUDIANTE,
        ?string $biografia = null,
        ?string $fotografia = null,
        string $estadoCuenta = self::ESTADO_PENDIENTE,
        ?int $idUsuario = null,
        ?string $fechaRegistro = null
    ) {
        $this->idUsuario = $idUsuario;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->biografia = $biografia;
        $this->fotografia = $fotografia;
        $this->rol = $rol;
        $this->estadoCuenta = $estadoCuenta;
        $this->fechaRegistro = $fechaRegistro;
    }

    //Inicio de funciones setters y getters. 

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): void
    {
        $this->correo = $correo;
    }

    public function getContrasena(): ?string
    {
        return $this->contrasena;
    }

    public function setContrasena(?string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function getBiografia(): ?string
    {
        return $this->biografia;
    }

    public function setBiografia(?string $biografia): void
    {
        $this->biografia = $biografia;
    }

    public function getFotografia(): ?string
    {
        return $this->fotografia;
    }

    public function setFotografia(?string $fotografia): void
    {
        $this->fotografia = $fotografia;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(?string $rol): void
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

    // Métodos para el acceso a bases de datos y consultas. 

    // Inserta un nuevo registro en la tabla usuario.
    public function insertarUsuario(): int|false
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            echo "Error en la conexión a base de datos. ";
            return false;
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "INSERT INTO usuario (correo, contrasena, nombre, apellido, biografia, fotografia, rol, estado_cuenta)
                VALUES (:correo, :contrasena, :nombre, :apellido, :biografia, :fotografia, :rol, :estado_cuenta)";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', $this->contrasena, PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindValue(':apellido', $this->apellido, $this->apellido !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':biografia', $this->biografia, $this->biografia !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':fotografia', $this->fotografia, $this->fotografia !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':rol', $this->rol, PDO::PARAM_STR);
            $stmt->bindValue(':estado_cuenta', $this->estadoCuenta, PDO::PARAM_STR);

            // Intenta realizar la ejecución de la inserción en la base de datos. 
            if ($stmt->execute()) {
                $this->idUsuario = (int)$pdo->lastInsertId();
                return $this->idUsuario;
            }
            return false;

            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en insertarUsuario: " . $e->getMessage());
            return false;
        } finally {

            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Método para realizar la consulta de un usuario en la base de datos. 
    public function consultarPorId(int $idUsuario, bool $incluirContrasena = false): ?array
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
        $campos = $incluirContrasena
            ? "idusuario, correo, contrasena, nombre, apellido, biografia, fotografia, rol, estado_cuenta, fecha_registro"
            : "idusuario, correo, nombre, apellido, biografia, fotografia, rol, estado_cuenta, fecha_registro";

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "SELECT {$campos} FROM usuario WHERE idusuario = :idusuario LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);
            // Ejecuta la sentencia definida anteriormente. 
            $stmt->execute();

            // Almacena los resultados obtenidos en una variable array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;
        } catch (PDOException $e) {
            // En caso de error, avisa al usuario. 
            error_log("Error en Usuario::consultarPorId: " . $e->getMessage());
            return null;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Consulta un usuario por su dirección de correo electrónico correo esto permite la recuperación de cuentas a partir del correo. 
    public function consultarPorCorreo(string $correo): ?array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return null;
        }

        // Prepara la consulta con sustitución de campos en base al correo. 
        $sql = "SELECT idusuario, correo, contrasena, nombre, apellido, biografia, fotografia, rol, estado_cuenta, fecha_registro
                FROM usuario
                WHERE correo = :correo
                LIMIT 1";

        // Intenta preparar la consulta y asigna los valores a la variable intermedia definida arriba. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
            // Ejecuta la consulta. 
            $stmt->execute();

            // Integra los resultados en una variable array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            // Retorna el objeto resultado, en caso de fallo, lo regresa como nulo. 
            return $resultado !== false ? $resultado : null;
        } catch (PDOException $e) {
            // En caso de error, alerta al usuario. 
            error_log("Error en Usuario::consultarPorCorreo: " . $e->getMessage());
            return null;
        } finally {
            // Desconecta de la base de datos. 
            $conexionObj->desconectar();
        }

    }

    // Actualiza los datos de perfil de un usuario (`nombre`, `apellido`, `biografia` y `fotografia`).
    public function actualizarPerfil(
        int $idUsuario,
        string $nombre,
        ?string $apellido,
        ?string $biografia,
        ?string $fotografia = null
    ): bool {

        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Si se proporciona una nueva ruta de fotografía, se incluye en el UPDATE
        if ($fotografia !== null) {
            $sql = "UPDATE usuario
                    SET nombre = :nombre,
                        apellido = :apellido,
                        biografia = :biografia,
                        fotografia = :fotografia
                    WHERE idusuario = :idusuario";
        } else {
            $sql = "UPDATE usuario
                    SET nombre = :nombre,
                        apellido = :apellido,
                        biografia = :biografia
                    WHERE idusuario = :idusuario";
        }

        // Intenta preparar la consulta y asigna los valores a la variable intermedia definida arriba. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':apellido', $apellido, $apellido !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':biografia', $biografia, $biografia !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
            // En caso que haya una nueva ruta para la fotografía se añade también. 
            if ($fotografia !== null) {
                $stmt->bindValue(':fotografia', $fotografia, PDO::PARAM_STR);
            }
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);

            // Se ejecuta la consulta. 
            return $stmt->execute();
        } catch (PDOException $e) {
            // En caso de error, alerta al usuario. 
            error_log("Error en Usuario::actualizarPerfil: " . $e->getMessage());
            return false;
        } finally {
            // Desconecta de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    //* Actualiza únicamente la contraseña ya cifrada de un usuario.
    public function actualizarContrasena(int $idUsuario, string $contrasenaHash): bool
    {

        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la consulta con sustitución de campos en base al correo. 
        $sql = "UPDATE usuario SET contrasena = :contrasena WHERE idusuario = :idusuario";

        // Intenta preparar la consulta y asigna los valores a la variable intermedia definida arriba. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':contrasena', $contrasenaHash, PDO::PARAM_STR);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);

            // Ejecuta la consulta. 
            return $stmt->execute();
        } catch (PDOException $e) {
            // En caso de error, alerta al usuario. 
            error_log("Error en Usuario::actualizarContrasena: " . $e->getMessage());
            return false;
        } finally {
            // Desconecta de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Actualiza el estado de la cuenta (`pendiente`, `verificada`, `activa`, `inactiva`).
    public function actualizarEstadoCuenta(int $idUsuario, string $nuevoEstado): bool
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la consulta con sustitución de campos. 
        $sql = "UPDATE usuario SET estado_cuenta = :estado_cuenta WHERE idusuario = :idusuario";

        // Intenta preparar la consulta y asigna los valores a la variable intermedia definida arriba. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':estado_cuenta', $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);

            // Ejecuta la consulta. 
            return $stmt->execute();
        } catch (PDOException $e) {
            // En caso de error, alerta al usuario. 
            error_log("Error en Usuario::actualizarEstadoCuenta: " . $e->getMessage());
            return false;
        } finally {
            // Desconecta de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Elimina el registro del usuario en la tabla usuario elimina toda su informacion asociada.
    public function eliminarUsuario(int $idUsuario): bool
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la consulta con sustitución de campos en base al correo. 
        $sql = "DELETE FROM usuario WHERE idusuario = :idusuario";

        // Intenta preparar la consulta y asigna los valores a la variable intermedia definida arriba. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);
            // Ejecuta la consulta. 
            $stmt->execute();

            // Si el conteo de las columnas en la base de datos corresponde a cero, significa que se borró el usuario de manera adecuada. 
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // En caso de error, alerta al usuario. 
            error_log("Error en Usuario::eliminarUsuario: " . $e->getMessage());
            return false;
        } finally {
            // Desconecta de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Lista todos los usuarios registrados en el sistema (requerido para el panel de Administrador).
    public function listarTodos(): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Intenta realizar una conexión a la base de datos. 
        if ($pdo === null) {
            return [];
        }

        // Prepara la consulta . 
        $sql = "SELECT idusuario, correo, nombre, apellido, biografia, fotografia, rol, estado_cuenta, fecha_registro
                FROM usuario
                ORDER BY fecha_registro DESC";

        // Intenta preparar la consulta. 
        try {
            $stmt = $pdo->query($sql);
            // Ejecuta la consulta envía los datos recuperados desde la base de datos.  
            return $stmt !== false ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            // En caso de error, alerta al usuario. 
            error_log("Error en Usuario::listarTodos: " . $e->getMessage());
            return [];
        } finally {
            // Desconecta de la base de datos. 
            $conexionObj->desconectar();
        }
    }

}
