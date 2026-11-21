<?php

// Declaración de tipado estricto para el documento.
declare(strict_types=1);

// Requerimiento de las clases necesarias desde la carpeta Views.
require_once __DIR__ . '/../Models/Administrador.php';
require_once __DIR__ . '/../Controllers/ControladorAdministrador.php';

// Utilización de las clases.
use App\Models\Administrador;
use App\Controllers\ControladorAdministrador;

// Se instancian los objetos de controlador y de modelo.
$controladorAdmin = new ControladorAdministrador();
$modeloAdmin      = new Administrador();

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
    <title>Preparación KM - Pruebas de Administradores</title>
</head>
<body>
    <!-- Enlace de retorno al menú principal. -->
    <p><a href="../index.php">&larr; Volver al Menú Principal</a></p>
    <h1>Preparación KM (Documento de pruebas - Administradores)</h1>
    <p>Prueba de métodos de administración, generación de códigos y supervisión de usuarios.</p>
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
        // Caso para generar un código de verificación asociado a un instructor pendiente.
        case 'generar_codigo':
            $idAdmin      = (int)($_POST['idadministrador'] ?? 0);
            $idInstructor = (int)($_POST['idinstructor'] ?? 0);
            $arregloResultado = $controladorAdmin->generarCodigoInstructor($idAdmin, $idInstructor);
            break;

        // Caso para cambiar manualmente el estado de validación de un instructor.
        case 'cambiar_validacion':
            $idInstructor = (int)($_POST['idinstructor'] ?? 0);
            $nuevoEstado  = (string)($_POST['estado_validacion'] ?? '');
            $arregloResultado = $controladorAdmin->cambiarEstadoValidacionInstructor($idInstructor, $nuevoEstado);
            break;

        // Caso para registrar un usuario con rol admin en la tabla administrador.
        case 'registrar_admin':
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $arregloResultado = $controladorAdmin->registrarAdministrador($idUsuario);
            break;

        // Caso para eliminar un usuario del sistema.
        case 'eliminar_usuario':
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $arregloResultado = $controladorAdmin->eliminarUsuario($idUsuario);
            break;
    }

    // Se captura el buffer en la variable JSON y se limpia.
    $jsonCapturado = (string)ob_get_clean();
}

// Se consultan las tablas de supervisión actualizadas.
$instructoresPendientes = $modeloAdmin->listarInstructoresPendientes();
$codigosGenerados       = $modeloAdmin->listarCodigosInstructor();
$usuariosSeguros        = $modeloAdmin->listarUsuariosSeguros();
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

    <!-- Formulario para generar un código de instructor en formato INS-XXXXXXXX. -->
    <fieldset>
        <legend><strong>1. Generar Código de Verificación para Instructor</strong></legend>
        <form method="POST" action="administradores_prueba.php">
            <input type="hidden" name="accion" value="generar_codigo">
            <label>ID Administrador que emite: </label>
            <input type="number" name="idadministrador" min="1" step="1" value="1" required>
            <label>ID Instructor Pendiente: </label>
            <input type="number" name="idinstructor" min="1" step="1" required>
            <button type="submit">Generar y Asociar Código</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para cambiar manualmente el estado de validación de un instructor. -->
    <fieldset>
        <legend><strong>2. Cambiar Estado de Validación de Instructor</strong></legend>
        <form method="POST" action="administradores_prueba.php">
            <input type="hidden" name="accion" value="cambiar_validacion">
            <label>ID Instructor: </label>
            <input type="number" name="idinstructor" min="1" step="1" required>
            <label>Nuevo Estado: </label>
            <select name="estado_validacion">
                <option value="pendiente">pendiente</option>
                <option value="validado">validado</option>
                <option value="rechazado">rechazado</option>
            </select>
            <button type="submit">Actualizar Validación</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para registrar un perfil de administrador. -->
    <fieldset>
        <legend><strong>3. Registrar Perfil de Administrador</strong></legend>
        <p><small>Nota: Requiere un ID de usuario previamente registrado con rol admin.</small></p>
        <form method="POST" action="administradores_prueba.php">
            <input type="hidden" name="accion" value="registrar_admin">
            <label>ID Usuario: </label>
            <input type="number" name="idusuario" min="1" step="1" required>
            <button type="submit">Registrar Administrador</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para eliminar un usuario del sistema. -->
    <fieldset>
        <legend><strong>4. Eliminar Usuario del Sistema</strong></legend>
        <form method="POST" action="administradores_prueba.php" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario y sus datos asociados en cascada?');">
            <input type="hidden" name="accion" value="eliminar_usuario">
            <label>ID Usuario a eliminar: </label>
            <input type="number" name="idusuario" min="1" step="1" required>
            <button type="submit">Eliminar Usuario</button>
        </form>
    </fieldset>
    <hr>

    <!-- Tabla de instructores pendientes de verificación. -->
    <h2>Instructores Pendientes de Verificación</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Instructor</th>
                <th>ID Usuario</th>
                <th>Correo</th>
                <th>Nombre Completo</th>
                <th>Biografía</th>
                <th>Estado Cuenta</th>
                <th>Validación</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($instructoresPendientes)): ?>
                <tr>
                    <td colspan="7">No hay instructores pendientes de verificación.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($instructoresPendientes as $ip): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$ip['idinstructor']); ?></td>
                        <td><?php echo htmlspecialchars((string)$ip['idusuario']); ?></td>
                        <td><?php echo htmlspecialchars((string)$ip['correo']); ?></td>
                        <td><?php echo htmlspecialchars(trim((string)$ip['nombre'] . ' ' . (string)($ip['apellido'] ?? ''))); ?></td>
                        <td><?php echo htmlspecialchars((string)($ip['biografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)$ip['estado_cuenta']); ?></td>
                        <td><strong><?php echo htmlspecialchars((string)$ip['validacion_instructor']); ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>

    <!-- Tabla de códigos de verificación de instructores generados. -->
    <h2>Códigos de Instructor Generados</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Código</th>
                <th>Código</th>
                <th>Estado</th>
                <th>Fecha Generación</th>
                <th>ID Admin (Correo)</th>
                <th>ID Instructor Asociado (Correo)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($codigosGenerados)): ?>
                <tr>
                    <td colspan="6">No hay códigos generados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($codigosGenerados as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$c['idcodigo_ins']); ?></td>
                        <td><strong><?php echo htmlspecialchars((string)$c['codigo']); ?></strong></td>
                        <td><?php echo htmlspecialchars((string)$c['estado']); ?></td>
                        <td><?php echo htmlspecialchars((string)$c['fecha_gen']); ?></td>
                        <td><?php echo htmlspecialchars((string)$c['administrador_idadministrador'] . ' (' . (string)$c['correo_admin'] . ')'); ?></td>
                        <td>
                            <?php
                            echo $c['instructor_idinstructor'] !== null
                                ? htmlspecialchars((string)$c['instructor_idinstructor'] . ' (' . (string)$c['correo_instructor'] . ')')
                                : 'Sin asignar';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>

    <!-- Tabla general de todos los usuarios del sistema desde vista_usuarios_segura. -->
    <h2>Todos los Usuarios del Sistema</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Correo</th>
                <th>Nombre Completo</th>
                <th>Biografía</th>
                <th>Rol</th>
                <th>Estado Cuenta</th>
                <th>ID Est.</th>
                <th>ID Inst.</th>
                <th>Validación Inst.</th>
                <th>ID Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuariosSeguros)): ?>
                <tr>
                    <td colspan="10">No hay usuarios registrados o no se pudo conectar a la base de datos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usuariosSeguros as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$u['idusuario']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['correo']); ?></td>
                        <td><?php echo htmlspecialchars(trim((string)$u['nombre'] . ' ' . (string)($u['apellido'] ?? ''))); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['biografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['rol']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['estado_cuenta']); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['idestudiante'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['idinstructor'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['validacion_instructor'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['idadministrador'] ?? '—')); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>