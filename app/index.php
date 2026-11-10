<?php

//Declaración de tipado estricto para la clase. 
declare(strict_types=1);

// Requerimiento de la clases. 
require_once __DIR__ . '/Models/Usuario.php';
require_once __DIR__ . '/Controllers/ControladorUsuario.php';
require_once __DIR__ . '/Helpers/ValidadorDatos.php';
require_once __DIR__ . '/Helpers/RespuestaJson.php';

// Utilización de las clases. 
use App\Models\Usuario;
use App\Controllers\ControladorUsuario;
use App\Helpers\ValidadorDatos;
use App\Helpers\RespuestaJson;

// Se instancian los objetos de controlador y de modelo. 
$controladorUsuario = new ControladorUsuario();
$modeloUsuario      = new Usuario();

// Definición de variables para utilizar en el documento. 
$accionEjecutada = '';
$jsonCapturado   = '';
$arregloResultado = null;
?>

<!-- Inicio del documento HTML. -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Preparación Km. </title>
</head>
<body>
    <h1>Preparación KM (Documento de pruebas)</h1>
    <p>Prueba de métodos de clases relativas a usuarios.</p>
    <hr>
<?php
// Se vacía el buffer inicial para que headers_sent() sea true y RespuestaJson no fuerce la página a application/json
flush();

// Evalúa el método que se solicitó y la acción a realizar. 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    // Se creará un switch case en base a la acción que se vaya a realizar. 
    $accionEjecutada = (string)$_POST['accion'];

    // Se inicia el buffer de datos para almacenar y mostrar los mensajes de retorno de las operaciones. 
    ob_start();

    // Se evalúa el caso en base a la acción definida. 
    switch ($accionEjecutada) {
        // Para la inserción del usuario se recuperan los datos a partir del formulario específico. 
        case 'insertar_usuario':
            // Se sanitizan los datos ingresados por el usuario. 
            $correo = isset($_POST['correo']) ? ValidadorDatos::limpiarCadena((string)$_POST['correo']) : '';
            $contrasena = (string)($_POST['contrasena'] ?? '');
            $nombre = isset($_POST['nombre']) ? ValidadorDatos::limpiarCadena((string)$_POST['nombre']) : '';
            $apellido = isset($_POST['apellido']) ? ValidadorDatos::limpiarCadena((string)$_POST['apellido']) : null;
            $biografia = isset($_POST['biografia']) ? ValidadorDatos::limpiarCadena((string)$_POST['biografia']) : null;
            $rol = isset($_POST['rol']) ? ValidadorDatos::limpiarCadena((string)$_POST['rol']) : 'estudiante';

            // Dependiendo si algún dato fue ingresado de manera errónea, se solicita la corrección. 
            if (!ValidadorDatos::validarCorreo($correo)) {
                // Envía la respuesta de error al mensajero JSON. 
                $arregloResultado = RespuestaJson::error('El correo electrónico no es válido o contiene caracteres prohibidos.');
            } elseif (!ValidadorDatos::validarContrasena($contrasena)) {
                $arregloResultado = RespuestaJson::error('La contraseña debe tener entre 8 y 25 caracteres, incluir mayúscula, minúscula, número y sin caracteres (; { } $ / < >).');
            } elseif (!ValidadorDatos::validarTextoCorto($nombre, 55)) {
                $arregloResultado = RespuestaJson::error('El nombre es obligatorio, máximo 55 caracteres y sin símbolos prohibidos.');
            } elseif ($apellido !== null && $apellido !== '' && !ValidadorDatos::validarTextoCorto($apellido, 55)) {
                $arregloResultado = RespuestaJson::error('El apellido excede 55 caracteres o contiene símbolos prohibidos.');
            } elseif (!ValidadorDatos::validarTextoLargo($biografia, 255)) {
                $arregloResultado = RespuestaJson::error('La biografía excede 255 caracteres o contiene símbolos prohibidos.');
            } elseif (!ValidadorDatos::validarRol($rol)) {
                $arregloResultado = RespuestaJson::error('El rol seleccionado no es válido.');
            } else {
                // En este último caso, se realiza el cifrado de la contraseña. 
                $contraCif = password_hash($contrasena, PASSWORD_ARGON2ID);
                // Con todos los datos limpios se crea una nueva instancia del objeto usuario. 
                $nuevoUsuario = new Usuario(
                    $correo,
                    $contraCif,
                    $nombre,
                    // En caso de que no se haya ingresado un apellido, se aplica como nulo. 
                    $apellido !== '' ? $apellido : null,
                    $rol,
                    // En caso de que no se haya ingresado un biografía, se aplica como nulo. 
                    $biografia !== '' ? $biografia : null,
                    null,
                    Usuario::ESTADO_ACTIVA
                );

                // Se envía el objeto usuario al método de insertar en la base de datos. El valor de retorno será el ID del usuario. 
                $idNuevo = $nuevoUsuario->insertarUsuario();
                // Evalúa si la operación tuvo éxito. 
                if ($idNuevo !== false) {
                    // Muestra el mensaje del resultado para mostrar en interfaz. 
                    $arregloResultado = RespuestaJson::exito(
                        ['idusuario' => $idNuevo, 'correo' => $correo, 'rol' => $rol],
                        'Usuario insertado correctamente.'
                    );
                } else {
                    // En caso de que haya un error al ingresar el usuario se manda mensaje.
                    $arregloResultado = RespuestaJson::error('Error al insertar el usuario (verifique que el correo no esté duplicado).', 500);
                }
            }
            break;

        // Caso para consultar un perfil en base a un número específico de ID. 
        case 'consultar_perfil':
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            // Se ejecuta la consulta de perfil a partir del método del objeto usuario y el resultado se almacena en un arreglo. 
            $arregloResultado = $controladorUsuario->consultarPerfil($idUsuario);
            break;

        // Si busca un usuario en base a un correo, esto es útil para la recuperación de Contraseñas   
        case 'consultar_correo':
            // Se toma el texto de entrada y se limpia para su operación. 
            $correo = isset($_POST['correo']) ? ValidadorDatos::limpiarCadena((string)$_POST['correo']) : '';
            // Se ejecuta la operación para evaluar que el correo tenga el formato adecuado. 
            if (!ValidadorDatos::validarCorreo($correo)) {
                // En caso de que haya un error en el correo, se alerta al usuario. 
                $arregloResultado = RespuestaJson::error('Formato de correo inválido o con caracteres no permitidos.');
            } else {
                // Se realiza una consulta en la base de datos a partir del objeto usuario para filtrar por el correo electrónico. 
                $datos = $modeloUsuario->consultarPorCorreo($correo);
                // Se evalua si se obtuvo un resultado obtenido para desplegar la existencia del correo y su información asociada. 
                if ($datos !== null) {
                    $arregloResultado = RespuestaJson::exito($datos, 'Usuario encontrado por correo.');
                } else {
                    $arregloResultado = RespuestaJson::error('No existe ningún usuario con ese correo.', 404);
                }
            }
            break;

        // Caso para la modificación de la información de un perfil. 
        case 'modificar_perfil':
            // Define los arreglos para utilizar con los datos ingresados por los usuarios. 
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $datosPerfil = [
                'nombre'    => $_POST['nombre'] ?? '',
                'apellido'  => $_POST['apellido'] ?? '',
                'biografia' => $_POST['biografia'] ?? '',
            ];
            // Se almacena de manera temporal el archivo de fotografía para su envío u operación. 
            $archivoFoto = $_FILES['fotografia'] ?? null;
            // Se ejecuta la operación de modificación de perfil de la clase controlador usuario con los datos recuperados desde la interfaz. 
            $arregloResultado = $controladorUsuario->modificarPerfil($idUsuario, $datosPerfil, $archivoFoto);
            break;
        // Caso para realizar el cambio de contraseñas. 
        case 'cambiar_contrasena':
            // Define los arreglos para utilizar con los datos ingresados por los usuarios. 
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            $datosContrasena = [
                'contrasena_actual' => $_POST['contrasena_actual'] ?? '',
                'contrasena_nueva'  => $_POST['contrasena_nueva'] ?? '',
            ];
            // Es ejecutado el método de cambiar contraseña en el controlador usuario, enviando los datos recabados por la interfaz. 
            $arregloResultado = $controladorUsuario->cambiarContrasena($idUsuario, $datosContrasena);
            break;
        // Se crea un caso específico para cambiar el estado que tiene cada cuenta. 
        case 'cambiar_estado':
            // Define los arreglos para utilizar con los datos ingresados por los usuarios. 
            $idUsuario   = (int)($_POST['idusuario'] ?? 0);
            // Se retoma el valor ingresado por el usuario y se limpia la cadena. 
            $nuevoEstado = isset($_POST['estado_cuenta']) ? ValidadorDatos::limpiarCadena((string)$_POST['estado_cuenta']) : '';
            // Es definido un arreglo de acuerdo con las constantes del modelo usuario paralos estados que puede tener una cuenta. 
            $estadosPermitidos = [
                Usuario::ESTADO_PENDIENTE,
                Usuario::ESTADO_VERIFICADA,
                Usuario::ESTADO_ACTIVA,
                Usuario::ESTADO_INACTIVA
            ];

            // En caso que exista el usuario y el estado ingresado está dentro de los estados permitidos, se realiza la operación de actualizar el estado de la cuenta. 
            if (!ValidadorDatos::validarEnteroPositivo($idUsuario) || !in_array($nuevoEstado, $estadosPermitidos, true)) {
                $arregloResultado = RespuestaJson::error('ID de usuario o estado de cuenta inválido.');
            } else {
                // Se ejecuta el método de actualización de la cuenta utilizando los datos ingresados por el usuario. 
                $actualizado = $modeloUsuario->actualizarEstadoCuenta($idUsuario, $nuevoEstado);
                // Dependiendo del éxito de la operación, se muestra un mensaje al usuario. 
                if ($actualizado) {
                    $arregloResultado = RespuestaJson::exito(
                        ['idusuario' => $idUsuario, 'estado_cuenta' => $nuevoEstado],
                        'Estado de la cuenta actualizado correctamente.'
                    );
                } else {
                    $arregloResultado = RespuestaJson::error('No fue posible actualizar el estado de la cuenta.', 500);
                }
            }
            break;

        // Caso para la eliminación de la cuenta de usuario. 
        case 'eliminar_cuenta':
            // Se genera un arreglo para el IV de el usuario. 
            $idUsuario = (int)($_POST['idusuario'] ?? 0);
            // Se ejecuta el método de eliminación de la cuenta a partir de los métodos disponibles en el controlador usuario. 
            $arregloResultado = $controladorUsuario->eliminarCuenta($idUsuario);
            break;
    }

    // Dependiendo del buffer obtenido, se envía a una variable JSON y se limpia el buffer. 
    $jsonCapturado = (string)ob_get_clean();
}

// Se consulta la lista actualizada de usuarios para mostrarla en la tabla inferior
$listaUsuarios = $modeloUsuario->listarTodos();

?>

    <!-- Se genera un cuadro con los resultados del buffer obtenido de las operaciones.  -->
    <?php if ($accionEjecutada !== ''): ?>
        <fieldset>
            <h3>Resultado de la Operación: <?php echo htmlspecialchars($accionEjecutada); ?><h3>
            <h4>Salida JSON directa:</h4>
            <pre><?php echo htmlspecialchars($jsonCapturado); ?></pre>
            <h4>Arreglo retornado:</h4>
            <pre><?php echo htmlspecialchars(print_r($arregloResultado, true)); ?></pre>
        </fieldset>
        <hr>
    <?php endif; ?>

    <!-- Formulario para la creación de usuarios nuevos.  -->
    <fieldset>
        <legend><strong>1. Crear Usuario</strong></legend>
        <form method="POST" action="index.php">
            <!-- campo para definir la acción a realizar.  -->
            <input type="hidden" name="accion" value="insertar_usuario">
            <p>
                <label>Correo electrónico: </label>
                <input type="email" name="correo" pattern="[A-Za-z0-9.@+-]+ " placeholder="correo@correo.com" required>
            </p>
            <p>
                <label>Contraseña (8-25 caracteres, Mayús, Minús, Número, sin ; { } $ / &lt; &gt;): </label>
                <input type="text" name="contrasena" placeholder="Contraseña" pattern="[A-Za-z0-9,.@+-]+"  maxlength="25" minlength="8" required>
            </p>
            <p>
                <label>Nombre: </label>
                <input type="text" name="nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]+" maxlength="30" minlength="1" placeholder="Nombre" required>
                <label>Apellido: </label>
                <input type="text" name="apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]+" maxlength="30" minlength="1" placeholder="Apellido">
            </p>
            <p>
                <label>Biografía: </label>
                <input type="text" name="biografia"  pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,.@+- ]+" maxlength="255" minlength="1"  size="50" placeholder="Biografía de prueba">
            </p>
            <p>
                <label>Rol: </label>
                <select name="rol">
                    <option value="estudiante">estudiante</option>
                    <option value="instructor">instructor</option>
                    <option value="admin">admin</option>
                </select>
            </p>
            <button type="submit">Insertar Usuario</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para consultar perfiles.  -->
    <fieldset>
        <legend><strong>2. Consultar Perfil por ID</strong></legend>
        <form method="POST" action="index.php">
            <input type="hidden" name="accion" value="consultar_perfil">
            <label>ID Usuario: </label>
            <input type="number" name="idusuario" min="1" value="1" required>
            <button type="submit">Consultar Perfil</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para consultar el usuario a partir de un correo. -->
    <fieldset>
        <legend><strong>3. Consultar Usuario por Correo</strong></legend>
        <form method="POST" action="index.php">
            <input type="hidden" name="accion" value="consultar_correo">
            <label>Correo electrónico: </label>
            <input type="email" name="correo" pattern="[A-Za-z0-9.@+-]+ " maxlength="255" minlength="1" placeholder="usuario1@correo.com" required>
            <button type="submit">Buscar por Correo</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario de modificación de perfiles. -->
    <fieldset>
        <legend><strong>4. Modificar Perfil y Fotografía</strong></legend>
        <form method="POST" action="index.php" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="modificar_perfil">
            <p>
                <label>ID Usuario: </label>
                <input type="number" name="idusuario" min="1" value="1" required>
            </p>
            <p>
                <label>Nuevo Nombre: </label>
                <input type="text" name="nombre"pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]+" maxlength="30" minlength="1" placeholder="Nombre Actualizado" required>
                <label>Nuevo Apellido: </label>
                <input type="text" name="apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]+" maxlength="30" minlength="1" placeholder="Apellido Actualizado">
            </p>
            <p>
                <label>Nueva Biografía: </label>
                <input type="text" name="biografia" size="50" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,.@+- ]+" maxlength="255" minlength="1"  placeholder="Nueva biografía de prueba">
            </p>
            <p>
                <label>Fotografía de Perfil (Opcional, PNG o JPG máx. 1 MB): </label>
                <input type="file" name="fotografia" accept=".jpg,.jpeg,.png">
            </p>
            <button type="submit">Actualizar Perfil</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para el cambio de contraseña.  -->
    <fieldset>
        <legend><strong>5. Cambiar Contraseña</strong></legend>
        <p><small>Nota: Probar con un usuario creado desde el Formulario 1 (que ya tiene hash cifrado).</small></p>
        <form method="POST" action="index.php">
            <input type="hidden" name="accion" value="cambiar_contrasena">
            <p>
                <label>ID Usuario (<code>idusuario</code>): </label>
                <input type="number" name="idusuario" min="1" required>
            </p>
            <p>
                <label>Contraseña Actual: </label>
                <input type="text" name="contrasena_actual" pattern="[A-Za-z0-9,.@+-]+"  maxlength="25" minlength="8" placeholder="Contraseña actual" required>
                <label>Contraseña Nueva (8-25 car., Mayús, Minús, Núm): </label>
                <input type="text" name="contrasena_nueva" pattern="[A-Za-z0-9,.@+-]+"  maxlength="25" minlength="8" placeholder="Contraseña nueva" required>
            </p>
            <button type="submit">Cambiar Contraseña</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para actualizar el estado de las cuentas. -->
    <fieldset>
        <legend><strong>6. Actualizar Estado de Cuenta</strong></legend>
        <form method="POST" action="index.php">
            <input type="hidden" name="accion" value="cambiar_estado">
            <label>ID Usuario (<code>idusuario</code>): </label>
            <input type="number" name="idusuario" min="1" value="1" required>
            <label>Nuevo Estado: </label>
            <select name="estado_cuenta">
                <option value="pendiente">pendiente</option>
                <option value="verificada">verificada</option>
                <option value="activa">activa</option>
                <option value="inactiva">inactiva</option>
            </select>
            <button type="submit">Actualizar Estado</button>
        </form>
    </fieldset>
    <br>

    <!-- Formulario para eliminar cuentas. -->
    <fieldset>
        <legend><strong>7. Eliminar Cuenta</strong></legend>
        <!-- Creación de un alert para confirmar la eliminación.  -->
        <form method="POST" action="index.php" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario y sus datos asociados en cascada?');">
            <input type="hidden" name="accion" value="eliminar_cuenta">
            <label>ID Usuario a eliminar (<code>idusuario</code>): </label>
            <input type="number" name="idusuario" min="1" required>
            <button type="submit">Eliminar Cuenta</button>
        </form>
    </fieldset>
    <hr>

    <!-- Tabla para visualizar todos los datos de usuarios. -->
    <h2>Usuarios Registrados Actualmente</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Correo</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Biografía</th>
                <th>Fotografía</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($listaUsuarios)): ?>
                <tr>
                    <td colspan="9">No hay usuarios registrados o no se pudo conectar a la base de datos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($listaUsuarios as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$u['idusuario']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['correo']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['nombre']); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['apellido'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['biografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['fotografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['rol']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['estado_cuenta']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['fecha_registro']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>