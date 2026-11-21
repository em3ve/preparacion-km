<?php

// Declaración de tipado estricto para el documento.
declare(strict_types=1);

// Requerimiento de las clases necesarias desde la carpeta Views.
require_once __DIR__ . '/../Models/Instructor.php';
require_once __DIR__ . '/../Controllers/ControladorInstructor.php';

// Utilización de las clases.
use App\Models\Instructor;
use App\Controllers\ControladorInstructor;

// Se instancian los objetos de controlador y de modelo.
$controladorInstructor = new ControladorInstructor();
$modeloInstructor      = new Instructor();

// Definición de variables para utilizar en el documento.
$accionEjecutada  = '';
$jsonCapturado    = '';
$arregloResultado = null;
?>

<!-- Inicio del documento HTML. -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Preparación KM - Pruebas de Instructores</title>
</head>
<body>
    <!-- Enlace de retorno al menú principal. -->
    <p><a href="../index.php">&larr; Volver al Menú Principal</a></p>
    <h1>Preparación KM (Documento de pruebas - Instructores)</h1>
    <p>Prueba de métodos de clases instructores y validación mediante código.</p>
    <hr>
<?php
// Se vacía el buffer inicial para que headers_sent() sea true y RespuestaJson no fuerce la página a application/json.
flush();

// Evalúa el método que se solicitó y la acción a realizar.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    // Se recupera la acción solicitada por el formulario.
    $accionEjecutada = (string)$_POST['accion'];

    // Se inicia el buffer para capturar la salida JSON del controlador.
    ob_start();

    // Se evalúa el caso en base a la acción definida.
    switch ($accionEjecutada) {
        // Caso para registrar un usuario con rol instructor en estado pendiente.
        case 'registrar_instructor':
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $arregloResultado = $controladorInstructor->registrarInstructor($idUsuario);
            break;

        // Caso para ingresar el código generado por el administrador y validar la cuenta.
        case 'validar_con_codigo':
            $idInstructor = (int)($_POST['idinstructor'] ?? 0);
            $codigo = (string)($_POST['codigo'] ?? '');
            $arregloResultado = $controladorInstructor->validarCuentaConCodigo($idInstructor, $codigo);
            break;

        // Caso para consultar un instructor por su ID.
        case 'consultar_instructor':
            $idInstructor = (int)($_POST['idinstructor'] ?? 0);
            $arregloResultado = $controladorInstructor->consultarInstructor($idInstructor);
            break;

        // Caso para eliminar el registro de especialización del instructor.
        case 'eliminar_instructor':
            $idInstructor = (int)($_POST['idinstructor'] ?? 0);
            $arregloResultado = $controladorInstructor->eliminarInstructor($idInstructor);
            break;
    }

    // Se almacena el buffer capturado y se limpia.
    $jsonCapturado = (string)ob_get_clean();
}

// Se consulta la lista actualizada de instructores desde vista_usuarios_segura.
$listaInstructores = $modeloInstructor->listarTodos();
?>

    <!-- Cuadro con los resultados del buffer obtenido de las operaciones. -->
    <?php if ($accionEjecutada !== ''): ?>
        <fieldset>
            <h3>Resultado de la Operación: <?php echo htmlspecialchars($accionEjecutada); ?></h3>
            <h4>Salida JSON directa:</h4>
            <pre><?php echo htmlspecialchars($jsonCapturado); ?></pre>
            <h4>Arreglo retornado:</h4>
            <pre><?php echo htmlspecialchars(print_r($arregloResultado, true)); ?></pre>
        </fieldset>
        <hr>
    <?php endif; ?>

    <!-- Formulario para registrar el perfil de instructor en estado pendiente. -->
    <fieldset>
        <legend><strong>1. Registrar Perfil de Instructor (con estado Pendiente)</strong></legend>
        <p><small>Nota: Requiere un ID de usuario ya registrado con rol instructor.</small></p>
        <form method="POST" action="instructores_prueba.php">
            <input type="hidden" name="accion" value="registrar_instructor">
            <label>ID Usuario: </label>
            <input type="number" name="idusuario" min="1" step="1" required>
            <button type="submit">Registrar Instructor</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para introducir el código de verificación con formato adecuado. -->
    <fieldset>
        <legend><strong>2. Introducir Código de Verificación de Instructor</strong></legend>
        <p><small>Formato requerido: INS-XXXXXXXX (mínimo 12 caracteres alfanuméricos).</small></p>
        <form method="POST" action="instructores_prueba.php">
            <input type="hidden" name="accion" value="validar_con_codigo">
            <label>ID Instructor: </label>
            <input type="number" name="idinstructor" min="1" step="1" required>
            <label>Código de Verificación: </label>
            <input type="text" name="codigo" pattern="INS-[A-Za-z0-9]{8,}" minlength="12" maxlength="55" placeholder="INS-XXXXXXXX" required>
            <button type="submit">Validar Cuenta de Instructor</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para consultar un instructor por su identificador primario. -->
    <fieldset>
        <legend><strong>3. Consultar Instructor por ID</strong></legend>
        <form method="POST" action="instructores_prueba.php">
            <input type="hidden" name="accion" value="consultar_instructor">
            <label>ID Instructor: </label>
            <input type="number" name="idinstructor" min="1" step="1" value="1" required>
            <button type="submit">Consultar Instructor</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para eliminar un registro de instructor. -->
    <fieldset>
        <legend><strong>4. Eliminar Registro de Instructor</strong></legend>
        <form method="POST" action="instructores_prueba.php" onsubmit="return confirm('¿Seguro que deseas eliminar este registro de la tabla instructor?');">
            <input type="hidden" name="accion" value="eliminar_instructor">
            <label>ID Instructor a eliminar: </label>
            <input type="number" name="idinstructor" min="1" step="1" required>
            <button type="submit">Eliminar Instructor</button>
        </form>
    </fieldset>
    <hr>

    <!-- Tabla para visualizar los instructores registrados desde vista_usuarios_segura con biografía. -->
    <h2>Instructores Registrados Actualmente</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Instructor</th>
                <th>ID Usuario</th>
                <th>Correo</th>
                <th>Nombre Completo</th>
                <th>Biografía</th>
                <th>Estado Cuenta</th>
                <th>Estado Validación</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($listaInstructores)): ?>
                <tr>
                    <td colspan="8">No hay instructores registrados o no se pudo conectar a la base de datos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($listaInstructores as $i): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$i['idinstructor']); ?></td>
                        <td><?php echo htmlspecialchars((string)$i['idusuario']); ?></td>
                        <td><?php echo htmlspecialchars((string)$i['correo']); ?></td>
                        <td><?php echo htmlspecialchars(trim((string)$i['nombre'] . ' ' . (string)($i['apellido'] ?? ''))); ?></td>
                        <td><?php echo htmlspecialchars((string)($i['biografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)$i['estado_cuenta']); ?></td>
                        <td><strong><?php echo htmlspecialchars((string)$i['validacion_instructor']); ?></strong></td>
                        <td><?php echo htmlspecialchars((string)$i['fecha_registro']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>