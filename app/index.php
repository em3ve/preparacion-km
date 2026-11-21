<?php

// Declaración de tipado estricto para el documento.
declare(strict_types=1);

// Requerimiento del modelo Administrador para consultar la vista segura de usuarios.
require_once __DIR__ . '/Models/Administrador.php';

// Utilización de la clase del modelo.
use App\Models\Administrador;

// Se instancia el modelo para obtener el estado general de los usuarios desde vista_usuarios_segura.
$modeloAdmin = new Administrador();
// Se almacena la lista de usuarios registrados en el sistema en una variable para su uso posterior. 
$usuariosSeguros = $modeloAdmin->listarUsuariosSeguros();
?>

<!-- Inicio del documento HTML. -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Preparación KM - Inicio</title>
</head>
<body>
    <h1>Preparación KM (Panel Principal de Pruebas)</h1>
    <p>Seleccione el conjunto de pruebas para ejecutar:</p>

    <!-- Menú de navegación hacia los documentos de prueba de cada módulo. -->
    <nav>
        <ul>
            <li><a href="views/usuarios_prueba.php"><strong>1. Usuarios:</strong> Gestión de cuentas, perfiles y contraseñas</a></li>
            <li><a href="views/estudiantes_prueba.php"><strong>2. Estudiantes:</strong> Asignación del rol y consulta de estudiantes</a></li>
            <li><a href="views/instructores_prueba.php"><strong>3. Instructores:</strong> Registro y validación con código</a></li>
            <li><a href="views/administradores_prueba.php"><strong>4. Administradores:</strong> Generación de códigos y supervisión de cuentas</a></li>
        </ul>
    </nav>
    <hr>

    <!-- Tabla reúne los datos desde  vista_usuarios_segura junto con la biografía del usuario. -->
    <h2>Estado Actual de Usuarios Registrados</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Correo</th>
                <th>Nombre Completo</th>
                <th>Biografía</th>
                <th>Fotografía</th>
                <th>Rol</th>
                <th>Estado Cuenta</th>
                <th>ID Estudiante</th>
                <th>ID Instructor</th>
                <th>Validación Instructor</th>
                <th>ID Admin</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuariosSeguros)): ?>
                <tr>
                    <td colspan="12">No se encontraron usuarios o no se pudo conectar a la base de datos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usuariosSeguros as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$u['idusuario']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['correo']); ?></td>
                        <td><?php echo htmlspecialchars(trim((string)$u['nombre'] . ' ' . (string)($u['apellido'] ?? ''))); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['biografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['fotografia'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['rol']); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['estado_cuenta']); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['idestudiante'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['idinstructor'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['validacion_instructor'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)($u['idadministrador'] ?? '—')); ?></td>
                        <td><?php echo htmlspecialchars((string)$u['fecha_registro']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>