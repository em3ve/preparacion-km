<?php

// Declaración de tipado estricto para el documento.
declare(strict_types=1);

// Requerimiento de las clases necesarias desde la carpeta Views.
require_once __DIR__ . '/../Models/Estudiante.php';
require_once __DIR__ . '/../Controllers/ControladorEstudiante.php';

// Utilización de las clases.
use App\Models\Estudiante;
use App\Controllers\ControladorEstudiante;

// Se instancian los objetos de controlador y de modelo.
$controladorEstudiante = new ControladorEstudiante();
$modeloEstudiante      = new Estudiante();

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
    <title>Preparación KM - Pruebas de Estudiantes</title>
</head>
<body>
    <!-- Enlace de retorno al menú principal. -->
    <p><a href="../index.php">&larr; Volver al Menú Principal</a></p>
    <h1>Preparación KM (Documento de pruebas - Estudiantes)</h1>
    <p>Prueba de métodos de clases relativas a estudiantes.</p>
    <hr>
<?php
// Se vacía el buffer inicial para que headers_sent() sea true y RespuestaJson no fuerce la página a application/json.
flush();

// Evalúa el método que se solicitó y la acción a realizar.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    // Se recupera la acción del formulario enviado.
    $accionEjecutada = (string)$_POST['accion'];

    // Se inicia el buffer para capturar la salida JSON emitida por el controlador.
    ob_start();

    // Se evalúa el caso en base a la acción definida.
    switch ($accionEjecutada) {
        // Caso para registrar un usuario existente como estudiante.
        case 'registrar_estudiante':
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $arregloResultado = $controladorEstudiante->registrarEstudiante($idUsuario);
            break;

        // Caso para consultar un estudiante a partir de su ID de estudiante.
        case 'consultar_estudiante':
            $idEstudiante = (int)($_POST['idestudiante'] ?? 0);
            $arregloResultado = $controladorEstudiante->consultarEstudiante($idEstudiante);
            break;

        // Caso para consultar un estudiante a partir de su ID de usuario base.
        case 'consultar_por_usuario':
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $arregloResultado = $controladorEstudiante->consultarPorUsuario($idUsuario);
            break;

        // Caso para eliminar el registro de especialización del estudiante.
        case 'eliminar_estudiante':
            $idEstudiante = (int)($_POST['idestudiante'] ?? 0);
            $arregloResultado = $controladorEstudiante->eliminarEstudiante($idEstudiante);
            break;
    }

    // Se captura el buffer en la variable JSON y se limpia.
    $jsonCapturado = (string)ob_get_clean();
}

// Se consulta la lista actualizada de estudiantes desde vista_usuarios_segura.
$listaEstudiantes = $modeloEstudiante->listarTodos();
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

    <!-- Formulario para registrar el perfil de estudiante de un usuario existente. -->
    <fieldset>
        <legend><strong>1. Registrar Perfil de Estudiante</strong></legend>
        <p><small>Nota: Requiere un ID de usuario ya registrado con rol estudiante.</small></p>
        <form method="POST" action="estudiantes_prueba.php">
            <input type="hidden" name="accion" value="registrar_estudiante">
            <label>ID Usuario: </label>
            <input type="number" name="idusuario" min="1" step="1" required>
            <button type="submit">Registrar Estudiante</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para consultar estudiante por su identificador primario. -->
    <fieldset>
        <legend><strong>2. Consultar Estudiante por ID</strong></legend>
        <form method="POST" action="estudiantes_prueba.php">
            <input type="hidden" name="accion" value="consultar_estudiante">
            <label>ID Estudiante: </label>
            <input type="number" name="idestudiante" min="1" step="1" value="1" required>
            <button type="submit">Consultar Estudiante</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para consultar estudiante a partir de su ID de usuario. -->
    <fieldset>
        <legend><strong>3. Consultar Estudiante por ID de Usuario</strong></legend>
        <form method="POST" action="estudiantes_prueba.php">
            <input type="hidden" name="accion" value="consultar_por_usuario">
            <label>ID Usuario: </label>
            <input type="number" name="idusuario" min="1" step="1" value="1" required>
            <button type="submit">Buscar Estudiante</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para eliminar un registro de estudiante. -->
    <fieldset>
        <legend><strong>4. Eliminar Registro de Estudiante</strong></legend>
        <form method="POST" action="estudiantes_prueba.php" onsubmit="return confirm('¿Seguro que deseas eliminar este registro de la tabla estudiante?');">
            <input type="hidden" name="accion" value="eliminar_estudiante">
            <label>ID Estudiante a eliminar: </label>
            <input type="number" name="idestudiante" min="1" step="1" required>
            <button type="submit">Eliminar Estudiante</button>
        </form>
    </fieldset>
    <hr>

    <!-- Tabla para visualizar los estudiantes registrados desde vista_usuarios_segura -->
    <h2>Estudiantes Registrados Actualmente</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Estudiante</th>
                <th>ID Usuario</th>
                <th>Correo</th>
                <th>Nombre Completo</th>
                <th>Biografía</th>
                <th>Estado Cuenta</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($listaEstudiantes)): ?>
                <tr>
                    <td colspan="7">No hay estudiantes registrados o no se pudo conectar a la base de datos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($listaEstudiantes as $e): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$e['idestudiante']); ?></td>
                        <td><?php echo htmlspecialchars((string)$e['idusuario']); ?></td>
                        <td><?php echo htmlspecialchars((string)$e['correo']); ?></td>
                        <td><?php echo htmlspecialchars(trim((string)$e['nombre'] . ' ' . (string)($e['apellido'] ?? ''))); ?></td>
                        <td><?php echo htmlspecialchars((string)($e['biografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)$e['estado_cuenta']); ?></td>
                        <td><?php echo htmlspecialchars((string)$e['fecha_registro']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>