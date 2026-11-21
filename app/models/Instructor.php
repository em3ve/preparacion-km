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

//Definición de la clase instructor. 
class Instructor 
{
    // Definición de las constantes que almacenan los estados posibles. 
    public const VALIDACION_PENDIENTE = 'pendiente';
    public const VALIDACION_VALIDADO  = 'validado';
    public const VALIDACION_RECHAZADO = 'rechazado';

    // Definición de variables. 
    private ?int $idInstructor;
    private ?int $idUsuario;
    private string $estadoValidacion;

    // Método constructor. 
    public function __construct(
        ?int $idUsuario = null,
        string $estadoValidacion = self::VALIDACION_PENDIENTE,
        ?int $idInstructor = null
    ) {
        $this->idInstructor     = $idInstructor;
        $this->idUsuario        = $idUsuario;
        $this->estadoValidacion = $estadoValidacion;
    }

    //Inicio de funciones setters y getters. 

    public function getIdInstructor(): ?int
    {
        return $this->idInstructor;
    }

    public function setIdInstructor(?int $idInstructor): void
    {
        $this->idInstructor = $idInstructor;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getEstadoValidacion(): string
    {
        return $this->estadoValidacion;
    }

    public function setEstadoValidacion(string $estadoValidacion): void
    {
        $this->estadoValidacion = $estadoValidacion;
    }

    // Métodos para el acceso a bases de datos y consultas. 

    // Registra un nuevo instructor en la tabla instructor.
    public function insertarInstructor(        
        int $idUsuario,
        string $estadoValidacion = self::VALIDACION_PENDIENTE
    ): int|false {

        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "INSERT INTO instructor (estado_validacion, usuario_idusuario)
                VALUES (:estado_validacion, :usuario_idusuario)";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':estado_validacion', $estadoValidacion, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_idusuario', $idUsuario, PDO::PARAM_INT);

            // Intenta realizar la ejecución de la inserción en la base de datos. 
            if ($stmt->execute()) {
                $this->idInstructor = (int)$pdo->lastInsertId();
                $this->idUsuario = $idUsuario;
                $this->estadoValidacion = $estadoValidacion;
                return $this->idInstructor;
            }
            return false;

        // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Instructor::insertarInstructor: " . $e->getMessage());
            return false;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Consulta un instructor por su idinstructor usando vista_usuarios_segura y usuario.biografia.
    public function consultarPorId(int $idInstructor): ?array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return null;
        }

        // Prepara la variable con atributos intermedios seguros. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro,
                        v.idinstructor, v.validacion_instructor
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idinstructor = :idinstructor
                LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {

            // Intenta realizar la ejecución de la inserción en la base de datos. 
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idinstructor', $idInstructor, PDO::PARAM_INT);
            $stmt->execute();

            // Almacena los datos recolectados en un array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;

            // En caso de error, alerta al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Instructor::consultarPorId: " . $e->getMessage());
            return null;
        } finally {

            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Consulta un instructor a partir de su idusuario.
    public function consultarPorUsuario(int $idUsuario): ?array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return null;
        }

        // Prepara la variable de la consulta con atributos intermedios seguros. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro,
                        v.idinstructor, v.validacion_instructor
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idusuario = :idusuario AND v.idinstructor IS NOT NULL
                LIMIT 1";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idusuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            // Almacena los datos recolectados en un array. 
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado !== false ? $resultado : null;

            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Instructor::consultarPorUsuario: " . $e->getMessage());
            return null;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    //Lista todos los instructores filtrados por estado de validación.
    public function listarTodos(?string $filtroEstado = null): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return [];
        }

        // Prepara la variable de la consulta con atributos intermedios seguros. 
        $sql = "SELECT v.idusuario, v.correo, v.nombre, v.apellido, u.biografia,
                        v.fotografia, v.rol, v.estado_cuenta, v.fecha_registro,
                        v.idinstructor, v.validacion_instructor
                FROM vista_usuarios_segura v
                INNER JOIN usuario u ON v.idusuario = u.idusuario
                WHERE v.idinstructor IS NOT NULL";

        // Si se está filtrando por algún estado específico, se añade a la variable. 
        if ($filtroEstado !== null) {
            $sql .= " AND v.validacion_instructor = :estado";
        }
        $sql .= " ORDER BY v.idinstructor ASC";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            if ($filtroEstado !== null) {
                $stmt->bindValue(':estado', $filtroEstado, PDO::PARAM_STR);
            }
            // Ejecuta la consulta. 
            $stmt->execute();

            // Almacena los datos recolectados en un array. 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Instructor::listarTodos: " . $e->getMessage());
            return [];
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Actualiza el estado de validación de un instructor.
    public function actualizarEstadoValidacion(int $idInstructor, string $nuevoEstado): bool
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Prepara la variable de la consulta con atributos intermedios seguros. 
        $sql = "UPDATE instructor SET estado_validacion = :estado WHERE idinstructor = :idinstructor";

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':estado', $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindValue(':idinstructor', $idInstructor, PDO::PARAM_INT);

            // Ejecuta la consulta. 
            return $stmt->execute();
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Instructor::actualizarEstadoValidacion: " . $e->getMessage());
            return false;
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Valida y aplica el código de verificación de la tabla codigo_ins generado por un administrador y actualiza el estado del instructor a validado.
    public function verificarConCodigo(int $idInstructor, string $codigo): array
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return ['exito' => false, 'mensaje' => 'Error de conexión con la base de datos.'];
        }

        // Intenta la preparación del statement y asigna a los atributos definidos en la parte de arriba con los valores recolectados en el objeto. 
        try {
            // Inicia una transacción para la verificación del código y la asignación de ese código a un instructor. 
            $pdo->beginTransaction();

            // Verificar que el código exista, esté activo y pertenezca a este instructor.
            $sqlBuscar = "SELECT idcodigo_ins, instructor_idinstructor, estado
                            FROM codigo_ins
                            WHERE codigo = :codigo
                            LIMIT 1
                            FOR UPDATE";
            // Prepara la consulta con la variable definida anteriormente. 
            $stmtBuscar = $pdo->prepare($sqlBuscar);
            $stmtBuscar->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            // Ejecuta la consulta. 
            $stmtBuscar->execute();
            // Almacena los valores recibidos en un array. 
            $registroCodigo = $stmtBuscar->fetch(PDO::FETCH_ASSOC);

            // Evalúa si el código existe, en caso contrario, avisa al usuario. 
            if ($registroCodigo === false) {
                $pdo->rollBack();
                return ['exito' => false, 'mensaje' => 'El código de verificación ingresado no existe.'];
            }

            // Evalúa si el código ya fue utilizado, en caso contrario, avisa al usuario. 
            if ($registroCodigo['estado'] !== 'activo') {
                $pdo->rollBack();
                return ['exito' => false, 'mensaje' => 'El código de verificación ya fue utilizado anteriormente.'];
            }

            // Evalúa si el código ha sido asignado a otro instructor. 
            if (
                $registroCodigo['instructor_idinstructor'] !== null
                && (int)$registroCodigo['instructor_idinstructor'] !== $idInstructor
            ) {
                $pdo->rollBack();
                return ['exito' => false, 'mensaje' => 'Este código está asignado a otra cuenta de instructor.'];
            }

            // Marcar el código como utilizado y se asigna a un instructor. 
            // Se prepara una actualización en el estado del código. 
            $sqlCodigo = "UPDATE codigo_ins
                            SET estado = 'utilizado',
                                instructor_idinstructor = :idinstructor
                            WHERE idcodigo_ins = :idcodigo_ins";
            // Se prepara la consulta a realizar. 
            $stmtCodigo = $pdo->prepare($sqlCodigo);
            // Se añaden los valores en el objeto a la consulta. 
            $stmtCodigo->bindValue(':idinstructor', $idInstructor, PDO::PARAM_INT);
            $stmtCodigo->bindValue(':idcodigo_ins', (int)$registroCodigo['idcodigo_ins'], PDO::PARAM_INT);
            // Se ejecuta la actualización en el valor del código. . 
            $stmtCodigo->execute();

            // Actualizar la cuenta del instructor a validado. 
            // Se prepara una actualización en el estado del instructor. 
            $sqlInstructor = "UPDATE instructor
                                SET estado_validacion = 'validado'
                                WHERE idinstructor = :idinstructor";
            // Se prepara la consulta a realizar. 
            $stmtInstructor = $pdo->prepare($sqlInstructor);
            // Se asignan los valores del objeto a la consulta. 
            $stmtInstructor->bindValue(':idinstructor', $idInstructor, PDO::PARAM_INT);
            // Se ejecuta la actualización. 
            $stmtInstructor->execute();

            // Se ejecutan todos los pasos en un commit. En caso que haya algún error durante alguno de ellos, se hace un rollback. 
            $pdo->commit();
            // Se avisa al usuario en caso de éxito. 
            return ['exito' => true, 'mensaje' => 'Código verificado correctamente. La cuenta del instructor ha sido validada.'];
        // En caso de error, se hace un rollback. 
            } catch (PDOException $e) {
            // Se evalúa el éxito de la transacción. 
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Error en Instructor::verificarConCodigo: " . $e->getMessage());
            return ['exito' => false, 'mensaje' => 'Ocurrió un error al procesar la validación del código.'];
        } finally {
            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }

    // Elimina el registro de especialización en la tabla instructor.
    public function eliminarInstructor(int $idInstructor): bool
    {
        // Creación del nuevo objeto de conexión. 
        $conexionObj = new ConexionBaseDatos();
        // Creación del objeto pdo. 
        $pdo = $conexionObj->conectar();

        // Se evalúa si la conexión fue exitosa a la base de datos. 
        if ($pdo === null) {
            return false;
        }

        // Se prepara la consulta de eliminación. 
        $sql = "DELETE FROM instructor WHERE idinstructor = :idinstructor";

        // Se intenta la eliminación. 
        try {
            // Se prepara la consulta y se asignan los valores de acuerdo al objeto. 
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idinstructor', $idInstructor, PDO::PARAM_INT);
            // Se ejecuta la sentencia. 
            $stmt->execute();

            // Se retorna el resultado de la consulta. 
            return $stmt->rowCount() > 0;
            // En caso de error, avisa al usuario. 
        } catch (PDOException $e) {
            error_log("Error en Instructor::eliminarInstructor: " . $e->getMessage());
            return false;
        } finally {

            // Realiza la desconexión de la base de datos. 
            $conexionObj->desconectar();
        }
    }
}