CREATE OR REPLACE PROCEDURE getCliente(
    p_idCliente IN NUMBER,
    p_nombre OUT VARCHAR2,
    p_apellido1 OUT VARCHAR2,
    p_apellido2 OUT VARCHAR2,
    p_telefono OUT VARCHAR2,
    p_imagen OUT VARCHAR2,
    p_domicilio OUT VARCHAR2,
    p_idProvincia OUT NUMBER,
    p_idCanton OUT NUMBER,
    p_idDistrito OUT NUMBER,
    p_idRol OUT NUMBER,
    p_correo OUT VARCHAR2,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT nombre, apellido1, apellido2, telefono, imagen, domicilio,
        idProvincia, idCanton, idDistrito, idRol, correo
    INTO p_nombre, p_apellido1, p_apellido2, p_telefono, p_imagen, p_domicilio,
        p_idProvincia, p_idCanton, p_idDistrito, p_idRol, p_correo
    FROM cliente
    WHERE idCliente = p_idCliente;

    p_resultado := 1; -- Éxito, cliente encontrado
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró el cliente
    WHEN OTHERS THEN
        p_resultado := -1; -- Error inesperado
END;

------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE getClientes(c_cursor OUT SYS_REFCURSOR) AS
BEGIN
    OPEN c_cursor FOR
        SELECT c.idCliente, c.nombre, c.apellido1, c.apellido2, c.telefono, c.imagen, c.domicilio, 
            c.correo, c.idProvincia, c.idCanton, c.idDistrito, c.idRol,
            p.nombre AS nombre,
            cn.nombre AS nombre,
            d.nombre AS nombre,
            r.nombrerol AS nombrerol
        FROM cliente c
        JOIN provincia p ON c.idProvincia = p.idProvincia
        JOIN canton cn ON c.idCanton = cn.idCanton
        JOIN distrito d ON c.idDistrito = d.idDistrito
        JOIN rol r ON c.idRol = r.idRol;
END;
------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE getVerClientes(p_cursor OUT SYS_REFCURSOR) IS
BEGIN
    OPEN p_cursor FOR
        SELECT idCliente, nombre, apellido1, apellido2, telefono, imagen,
            domicilio, idProvincia, idCanton, idDistrito, correo
        FROM cliente;
END;
------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE getRoles(p_cursor OUT SYS_REFCURSOR) IS
BEGIN
    OPEN p_cursor FOR
        SELECT idRol, nombreRol FROM rol;
END;
------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE insertCliente(
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) IS
BEGIN
    INSERT INTO cliente (
        nombre, apellido1, apellido2, telefono, domicilio,
        idProvincia, idCanton, idDistrito, idRol, correo, contrasena
    ) VALUES (
        p_nombre, p_apellido1, p_apellido2, p_telefono, p_domicilio,
        p_idProvincia, p_idCanton, p_idDistrito, p_idRol, p_correo, p_contrasena
    );

    -- Si la inserción fue exitosa, devolver 1
    p_resultado := 1;

    -- Si se captura una excepción, devolver -1
    EXCEPTION
    WHEN OTHERS THEN
        p_resultado := -1;
        ROLLBACK;
END;

------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE updateCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE cliente
    SET nombre = p_nombre,
        apellido1 = p_apellido1,
        apellido2 = p_apellido2,
        telefono = p_telefono,
        domicilio = p_domicilio,
        idProvincia = p_idProvincia,
        idCanton = p_idCanton,
        idDistrito = p_idDistrito,
        idRol = p_idRol,
        correo = p_correo
    WHERE idCliente = p_idCliente;

    -- Si se actualizan filas, entonces el resultado es exitoso
    IF SQL%ROWCOUNT > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- Ninguna fila afectada
    END IF;

    COMMIT;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := -1; -- Error
        ROLLBACK;
END;

------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE updateClienteNuevo(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_imagen IN cliente.imagen%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE cliente
    SET nombre = p_nombre,
        apellido1 = p_apellido1,
        apellido2 = p_apellido2,
        telefono = p_telefono,
        domicilio = p_domicilio,
        idProvincia = p_idProvincia,
        idCanton = p_idCanton,
        idDistrito = p_idDistrito,
        imagen = p_imagen
    WHERE idCliente = p_idCliente;

    -- Si se actualizan filas, entonces el resultado es exitoso
    IF SQL%ROWCOUNT > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- Ninguna fila afectada
    END IF;

    COMMIT;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := -1; -- Error
        ROLLBACK;
END;

------------------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE deleteCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM cliente
    WHERE idCliente = p_idCliente;

    -- Si se eliminan filas, entonces el resultado es exitoso
    IF SQL%ROWCOUNT > 0 THEN
        p_resultado := 1; -- Éxito, cliente eliminado
    ELSE
        p_resultado := 0; -- Ninguna fila afectada, cliente no encontrado
    END IF;

    COMMIT;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := -1; -- Error
        ROLLBACK;
END;
