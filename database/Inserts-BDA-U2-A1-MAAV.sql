USE `preparacionkm`;


-- 1. Tabla: usuario (10 registros: 5 estudiantes, 3 instructores, 2 admins)

INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (1, 'usuario1@correo.com', '12345678', 'Nombre1', 'Apellido1', 'Biografia usuario 1', 'foto_perfil_1.jpg', 'estudiante', 'activa', '2026-11-01 08:00:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (2, 'usuario2@correo.com', '23456789', 'Nombre2', 'Apellido2', 'Biografia usuario 2', 'foto_perfil_2.jpg', 'estudiante', 'activa', '2026-11-01 08:10:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (3, 'usuario3@correo.com', '34567890', 'Nombre3', 'Apellido3', 'Biografia usuario 3', 'foto_perfil_3.jpg', 'estudiante', 'verificada', '2026-11-01 08:20:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (4, 'usuario4@correo.com', '45678901', 'Nombre4', 'Apellido4', 'Biografia usuario 4', 'foto_perfil_4.jpg', 'estudiante', 'verificada', '2026-11-01 08:30:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (5, 'usuario5@correo.com', '56789012', 'Nombre5', 'Apellido5', 'Biografia usuario 5', 'foto_perfil_5.jpg', 'estudiante', 'pendiente', '2026-11-01 08:40:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (6, 'usuario6@correo.com', '67890123', 'Nombre6', 'Apellido6', 'Biografia usuario 6', 'foto_perfil_6.jpg', 'instructor', 'activa', '2026-11-01 09:00:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (7, 'usuario7@correo.com', '78901234', 'Nombre7', 'Apellido7', 'Biografia usuario 7', 'foto_perfil_7.jpg', 'instructor', 'activa', '2026-11-01 09:10:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (8, 'usuario8@correo.com', '89012345', 'Nombre8', 'Apellido8', 'Biografia usuario 8', 'foto_perfil_8.jpg', 'instructor', 'pendiente', '2026-11-01 09:20:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (9, 'usuario9@correo.com', '90123456', 'Nombre9', 'Apellido9', 'Biografia usuario 9', 'foto_perfil_9.jpg', 'admin', 'activa', '2026-11-01 10:00:00');
INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES (10, 'usuario10@correo.com', '01234567', 'Nombre10', 'Apellido10', 'Biografia usuario 10', 'foto_perfil_10.jpg', 'admin', 'activa', '2026-11-01 10:10:00');


-- 2. Tabla: estudiante (5 registros asociados a idusuario 1 al 5)

INSERT INTO `estudiante` (`idestudiante`, `usuario_idusuario`) VALUES (1, 1);
INSERT INTO `estudiante` (`idestudiante`, `usuario_idusuario`) VALUES (2, 2);
INSERT INTO `estudiante` (`idestudiante`, `usuario_idusuario`) VALUES (3, 3);
INSERT INTO `estudiante` (`idestudiante`, `usuario_idusuario`) VALUES (4, 4);
INSERT INTO `estudiante` (`idestudiante`, `usuario_idusuario`) VALUES (5, 5);


-- 3. Tabla: instructor (3 registros asociados a idusuario 6 al 8)

INSERT INTO `instructor` (`idinstructor`, `estado_validacion`, `usuario_idusuario`) VALUES (1, 'validado', 6);
INSERT INTO `instructor` (`idinstructor`, `estado_validacion`, `usuario_idusuario`) VALUES (2, 'validado', 7);
INSERT INTO `instructor` (`idinstructor`, `estado_validacion`, `usuario_idusuario`) VALUES (3, 'pendiente', 8);


-- 4. Tabla: administrador (2 registros asociados a idusuario 9 y 10)

INSERT INTO `administrador` (`idadministrador`, `usuario_idusuario`) VALUES (1, 9);
INSERT INTO `administrador` (`idadministrador`, `usuario_idusuario`) VALUES (2, 10);


-- 5. Tabla: codigo_ver (10 registros asociados a usuario 1 al 10)

INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (1, 'CODVER01', '2026-11-01 08:00:00', '2026-11-02 08:00:00', 'utilizado', 1);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (2, 'CODVER02', '2026-11-01 08:10:00', '2026-11-02 08:10:00', 'utilizado', 2);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (3, 'CODVER03', '2026-11-01 08:20:00', '2026-11-02 08:20:00', 'utilizado', 3);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (4, 'CODVER04', '2026-11-01 08:30:00', '2026-11-02 08:30:00', 'utilizado', 4);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (5, 'CODVER05', '2026-11-01 08:40:00', '2026-11-02 08:40:00', 'activo', 5);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (6, 'CODVER06', '2026-11-01 09:00:00', '2026-11-02 09:00:00', 'utilizado', 6);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (7, 'CODVER07', '2026-11-01 09:10:00', '2026-11-02 09:10:00', 'utilizado', 7);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (8, 'CODVER08', '2026-11-01 09:20:00', '2026-11-02 09:20:00', 'activo', 8);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (9, 'CODVER09', '2026-11-01 10:00:00', '2026-11-02 10:00:00', 'utilizado', 9);
INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES (10, 'CODVER10', '2026-11-01 10:10:00', '2026-11-02 10:10:00', 'utilizado', 10);


-- 6. Tabla: codigo_ins (10 registros: 3 utilizados y 7 disponibles)

INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (1, 'CODINS01', 'utilizado', '2026-11-01 07:00:00', 1, 1);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (2, 'CODINS02', 'utilizado', '2026-11-01 07:05:00', 2, 1);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (3, 'CODINS03', 'utilizado', '2026-11-01 07:10:00', 3, 2);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (4, 'CODINS04', 'activo', '2026-11-01 07:15:00', NULL, 1);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (5, 'CODINS05', 'activo', '2026-11-01 07:20:00', NULL, 1);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (6, 'CODINS06', 'activo', '2026-11-01 07:25:00', NULL, 2);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (7, 'CODINS07', 'activo', '2026-11-01 07:30:00', NULL, 2);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (8, 'CODINS08', 'activo', '2026-11-01 07:35:00', NULL, 1);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (9, 'CODINS09', 'activo', '2026-11-01 07:40:00', NULL, 2);
INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES (10, 'CODINS10', 'activo', '2026-11-01 07:45:00', NULL, 1);


-- 7. Tabla: curso (10 registros asociados a idinstructor 1, 2 y 3)

INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (1, 'Curso 1', 'Descripcion del curso 1', 'portada_curso_1.jpg', 100.00, '2026-11-02 10:00:00', 'disponible', 1);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (2, 'Curso 2', 'Descripcion del curso 2', 'portada_curso_2.jpg', 200.00, '2026-11-02 10:10:00', 'disponible', 1);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (3, 'Curso 3', 'Descripcion del curso 3', 'portada_curso_3.jpg', 300.00, '2026-11-02 10:20:00', 'disponible', 1);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (4, 'Curso 4', 'Descripcion del curso 4', 'portada_curso_4.jpg', 400.00, '2026-11-02 10:30:00', 'disponible', 2);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (5, 'Curso 5', 'Descripcion del curso 5', 'portada_curso_5.jpg', 500.00, '2026-11-02 10:40:00', 'disponible', 2);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (6, 'Curso 6', 'Descripcion del curso 6', 'portada_curso_6.jpg', 600.00, '2026-11-02 10:50:00', 'disponible', 2);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (7, 'Curso 7', 'Descripcion del curso 7', 'portada_curso_7.jpg', 700.00, '2026-11-02 11:00:00', 'disponible', 3);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (8, 'Curso 8', 'Descripcion del curso 8', 'portada_curso_8.jpg', 800.00, '2026-11-02 11:10:00', 'disponible', 3);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (9, 'Curso 9', 'Descripcion del curso 9', 'portada_curso_9.jpg', 900.00, '2026-11-02 11:20:00', 'inactivo', 3);
INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES (10, 'Curso 10', 'Descripcion del curso 10', 'portada_curso_10.jpg', 1000.00, '2026-11-02 11:30:00', 'disponible', 1);


-- 8. Tabla: leccion (10 registros asociados a curso 1 al 10)

INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (1, 'Leccion 1', 'Descripcion leccion 1', 'Texto de la leccion 1', 1, '2026-11-02 12:00:00', 'activa', 1);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (2, 'Leccion 2', 'Descripcion leccion 2', 'Texto de la leccion 2', 1, '2026-11-02 12:10:00', 'activa', 2);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (3, 'Leccion 3', 'Descripcion leccion 3', 'Texto de la leccion 3', 1, '2026-11-02 12:20:00', 'activa', 3);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (4, 'Leccion 4', 'Descripcion leccion 4', 'Texto de la leccion 4', 1, '2026-11-02 12:30:00', 'activa', 4);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (5, 'Leccion 5', 'Descripcion leccion 5', 'Texto de la leccion 5', 1, '2026-11-02 12:40:00', 'activa', 5);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (6, 'Leccion 6', 'Descripcion leccion 6', 'Texto de la leccion 6', 1, '2026-11-02 12:50:00', 'activa', 6);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (7, 'Leccion 7', 'Descripcion leccion 7', 'Texto de la leccion 7', 1, '2026-11-02 13:00:00', 'activa', 7);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (8, 'Leccion 8', 'Descripcion leccion 8', 'Texto de la leccion 8', 1, '2026-11-02 13:10:00', 'activa', 8);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (9, 'Leccion 9', 'Descripcion leccion 9', 'Texto de la leccion 9', 1, '2026-11-02 13:20:00', 'activa', 9);
INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES (10, 'Leccion 10', 'Descripcion leccion 10', 'Texto de la leccion 10', 1, '2026-11-02 13:30:00', 'activa', 10);


-- 9. Tabla: contenido (10 registros asociados a leccion 1 al 10)

INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (1, 'imagen', 'ruta/archivo_1.jpg', 'archivo_1.jpg', '2026-11-02 14:00:00', 1);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (2, 'video', 'ruta/archivo_2.mp4', 'archivo_2.mp4', '2026-11-02 14:05:00', 2);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (3, 'imagen', 'ruta/archivo_3.png', 'archivo_3.png', '2026-11-02 14:10:00', 3);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (4, 'video', 'ruta/archivo_4.mp4', 'archivo_4.mp4', '2026-11-02 14:15:00', 4);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (5, 'imagen', 'ruta/archivo_5.jpg', 'archivo_5.jpg', '2026-11-02 14:20:00', 5);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (6, 'video', 'ruta/archivo_6.mp4', 'archivo_6.mp4', '2026-11-02 14:25:00', 6);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (7, 'imagen', 'ruta/archivo_7.png', 'archivo_7.png', '2026-11-02 14:30:00', 7);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (8, 'video', 'ruta/archivo_8.mp4', 'archivo_8.mp4', '2026-11-02 14:35:00', 8);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (9, 'imagen', 'ruta/archivo_9.jpg', 'archivo_9.jpg', '2026-11-02 14:40:00', 9);
INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES (10, 'video', 'ruta/archivo_10.mp4', 'archivo_10.mp4', '2026-11-02 14:45:00', 10);


-- 10. Tabla: compra (10 registros distribuidos entre idestudiante 1 al 5)

INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (1, 100.00, 'PAYPAL001', 'aprobado', '2026-11-03 10:00:00', '2026-11-03 09:55:00', 1);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (2, 200.00, 'PAYPAL002', 'aprobado', '2026-11-03 10:10:00', '2026-11-03 10:05:00', 2);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (3, 300.00, 'PAYPAL003', 'aprobado', '2026-11-03 10:20:00', '2026-11-03 10:15:00', 3);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (4, 400.00, 'PAYPAL004', 'aprobado', '2026-11-03 10:30:00', '2026-11-03 10:25:00', 4);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (5, 500.00, 'PAYPAL005', 'aprobado', '2026-11-03 10:40:00', '2026-11-03 10:35:00', 5);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (6, 600.00, 'PAYPAL006', 'aprobado', '2026-11-03 10:50:00', '2026-11-03 10:45:00', 1);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (7, 700.00, 'PAYPAL007', 'pendiente', NULL, '2026-11-03 10:55:00', 2);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (8, 800.00, 'PAYPAL008', 'rechazado', '2026-11-03 11:10:00', '2026-11-03 11:05:00', 3);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (9, 900.00, 'PAYPAL009', 'cancelado', '2026-11-03 11:20:00', '2026-11-03 11:15:00', 4);
INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (10, 1000.00, 'PAYPAL010', 'aprobado', '2026-11-03 11:30:00', '2026-11-03 11:25:00', 5);


-- 11. Tabla: detalle_compra (10 registros asociados a compra 1 al 10)

INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (1, 100.00, 1, 1);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (2, 200.00, 2, 2);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (3, 300.00, 3, 3);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (4, 400.00, 4, 4);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (5, 500.00, 5, 5);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (6, 600.00, 6, 6);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (7, 700.00, 7, 7);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (8, 800.00, 8, 8);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (9, 900.00, 9, 9);
INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES (10, 1000.00, 10, 10);


-- 12. Tabla: progreso (10 registros entre idestudiante 1-5 e idleccion 1-10)

INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (1, '2026-11-04 09:00:00', 'visto', 1, 1);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (2, '2026-11-04 09:10:00', 'visto', 2, 2);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (3, '2026-11-04 09:20:00', 'visto', 3, 3);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (4, '2026-11-04 09:30:00', 'visto', 4, 4);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (5, '2026-11-04 09:40:00', 'visto', 5, 5);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (6, '2026-11-04 09:50:00', 'visto', 1, 6);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (7, '2026-11-04 10:00:00', 'no_visto', 2, 7);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (8, '2026-11-04 10:10:00', 'no_visto', 3, 8);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (9, '2026-11-04 10:20:00', 'no_visto', 4, 9);
INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES (10, '2026-11-04 10:30:00', 'visto', 5, 10);


-- 13. Tabla: certificado (10 registros entre idestudiante 1-5 e idcurso 1-10)

INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (1, 'CERT-001', 'certificados/cert_1.pdf', '2026-11-04 12:00:00', 1, 1);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (2, 'CERT-002', 'certificados/cert_2.pdf', '2026-11-04 12:10:00', 2, 2);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (3, 'CERT-003', 'certificados/cert_3.pdf', '2026-11-04 12:20:00', 3, 3);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (4, 'CERT-004', 'certificados/cert_4.pdf', '2026-11-04 12:30:00', 4, 4);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (5, 'CERT-005', 'certificados/cert_5.pdf', '2026-11-04 12:40:00', 5, 5);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (6, 'CERT-006', 'certificados/cert_6.pdf', '2026-11-04 12:50:00', 1, 6);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (7, 'CERT-007', 'certificados/cert_7.pdf', '2026-11-04 13:00:00', 2, 7);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (8, 'CERT-008', 'certificados/cert_8.pdf', '2026-11-04 13:10:00', 3, 8);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (9, 'CERT-009', 'certificados/cert_9.pdf', '2026-11-04 13:20:00', 4, 9);
INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES (10, 'CERT-010', 'certificados/cert_10.pdf', '2026-11-04 13:30:00', 5, 10);


-- 14. Tabla: carrito (10 registros: 5 cerrados y 5 activos para estudiantes 1-5)

INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (1, 'cerrado', '2026-11-03 09:00:00', 1);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (2, 'cerrado', '2026-11-03 09:05:00', 2);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (3, 'cerrado', '2026-11-03 09:10:00', 3);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (4, 'cerrado', '2026-11-03 09:15:00', 4);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (5, 'cerrado', '2026-11-03 09:20:00', 5);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (6, 'activo', '2026-11-05 08:00:00', 1);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (7, 'activo', '2026-11-05 08:05:00', 2);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (8, 'activo', '2026-11-05 08:10:00', 3);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (9, 'activo', '2026-11-05 08:15:00', 4);
INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES (10, 'activo', '2026-11-05 08:20:00', 5);


-- 15. Tabla: carrito_cursos (10 registros asociados a carrito 1-10 y curso 1-10)

INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (1, '2026-11-03 09:01:00', 1, 1);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (2, '2026-11-03 09:06:00', 2, 2);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (3, '2026-11-03 09:11:00', 3, 3);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (4, '2026-11-03 09:16:00', 4, 4);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (5, '2026-11-03 09:21:00', 5, 5);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (6, '2026-11-05 08:01:00', 6, 6);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (7, '2026-11-05 08:06:00', 7, 7);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (8, '2026-11-05 08:11:00', 8, 8);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (9, '2026-11-05 08:16:00', 9, 9);
INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES (10, '2026-11-05 08:21:00', 10, 10);


-- 16. Tabla: sesion (10 registros asociados a usuario 1 al 10)

INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (1, 'TOKEN_SESION_01', '2026-11-05 09:00:00', '2026-11-05 21:00:00', 1);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (2, 'TOKEN_SESION_02', '2026-11-05 09:05:00', '2026-11-05 21:05:00', 2);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (3, 'TOKEN_SESION_03', '2026-11-05 09:10:00', '2026-11-05 21:10:00', 3);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (4, 'TOKEN_SESION_04', '2026-11-05 09:15:00', '2026-11-05 21:15:00', 4);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (5, 'TOKEN_SESION_05', '2026-11-05 09:20:00', '2026-11-05 21:20:00', 5);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (6, 'TOKEN_SESION_06', '2026-11-05 09:25:00', '2026-11-05 21:25:00', 6);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (7, 'TOKEN_SESION_07', '2026-11-05 09:30:00', '2026-11-05 21:30:00', 7);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (8, 'TOKEN_SESION_08', '2026-11-05 09:35:00', '2026-11-05 21:35:00', 8);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (9, 'TOKEN_SESION_09', '2026-11-05 09:40:00', '2026-11-05 21:40:00', 9);
INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES (10, 'TOKEN_SESION_10', '2026-11-05 09:45:00', '2026-11-05 21:45:00', 10);