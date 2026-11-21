-- Documento de creación de triggers para crear registros en tabla instructor y estudiante.

USE `preparacionkm`;

-- Eliminación de trigger sí existe. 
DROP TRIGGER IF EXISTS `trg_usuario_ai_instructor`;
DROP TRIGGER IF EXISTS `trg_usuario_au_instructor`;
DROP TRIGGER IF EXISTS `trg_usuario_ai_estudiante`;
DROP TRIGGER IF EXISTS `trg_usuario_au_estudiante`;

DELIMITER $$

-- 1. TRIGGERS PARA EL ROL: INSTRUCTOR

-- 1.A. Al insertar un nuevo usuario con rol 'instructor'
CREATE TRIGGER `trg_usuario_ai_instructor`
-- Al detectar un nuevo registro en la tabla usuario 
AFTER INSERT ON `usuario`
FOR EACH ROW
BEGIN
    -- Si el rol se define como instructor, entonces 
    IF NEW.rol = 'instructor' THEN
    -- Crea un nuevo registro en la tabla instructor. 
        INSERT INTO `instructor` (`estado_validacion`, `usuario_idusuario`)
        VALUES ('pendiente', NEW.idusuario);
    END IF;
END$$

-- 1.B. Al actualizar el rol de un usuario hacia o desde 'instructor'
CREATE TRIGGER `trg_usuario_au_instructor`
-- Al detectar una actualización de registro en la tabla usuario 
AFTER UPDATE ON `usuario`
FOR EACH ROW
BEGIN
    -- Si el rol cambió hacia 'instructor', crea el registro si no existe
    IF OLD.rol <> NEW.rol AND NEW.rol = 'instructor' THEN
        IF NOT EXISTS (
            SELECT 1 FROM `instructor` WHERE `usuario_idusuario` = NEW.idusuario
        ) THEN
            -- Si no existe el registro, lo realiza.  
            INSERT INTO `instructor` (`estado_validacion`, `usuario_idusuario`)
            VALUES ('pendiente', NEW.idusuario);
        END IF;
    END IF;

    -- Si dejó de ser 'instructor', elimina su registro de la tabla instructor. 
    IF OLD.rol = 'instructor' AND NEW.rol <> 'instructor' THEN
        DELETE FROM `instructor` WHERE `usuario_idusuario` = OLD.idusuario;
    END IF;
END$$

-- 2. TRIGGERS PARA EL ROL: ESTUDIANTE

-- 2.A. Al insertar un nuevo usuario con rol 'estudiante'
CREATE TRIGGER `trg_usuario_ai_estudiante`
-- Al detectar un nuevo registro en la tabla usuario 
AFTER INSERT ON `usuario`
FOR EACH ROW
BEGIN
    -- Si el rol se define como estudiante, entonces 
    IF NEW.rol = 'estudiante' THEN
    -- Crea un nuevo registro en la tabla estudiante. 
        INSERT INTO `estudiante` (`usuario_idusuario`)
        VALUES (NEW.idusuario);
    END IF;
END$$

-- 2.B. Al actualizar el rol de un usuario hacia o desde 'estudiante'
CREATE TRIGGER `trg_usuario_au_estudiante`
-- Al detectar una actualización de registro en la tabla usuario 
AFTER UPDATE ON `usuario`
FOR EACH ROW
BEGIN
    -- Si el rol cambió hacia 'estudiante', crea el registro si no existe
    IF OLD.rol <> NEW.rol AND NEW.rol = 'estudiante' THEN
        IF NOT EXISTS (
            SELECT 1 FROM `estudiante` WHERE `usuario_idusuario` = NEW.idusuario
        ) THEN
            -- Si no existe el registro, lo realiza.  
            INSERT INTO `estudiante` (`usuario_idusuario`)
            VALUES (NEW.idusuario);
        END IF;
    END IF;

    -- Si dejó de ser 'estudiante', elimina su registro de especialización
    IF OLD.rol = 'estudiante' AND NEW.rol <> 'estudiante' THEN
        DELETE FROM `estudiante` WHERE `usuario_idusuario` = OLD.idusuario;
    END IF;
END$$

DELIMITER ;


-- Verifica que los triggers hayan sido creados correctamente. 

SHOW TRIGGERS FROM `preparacionkm`;