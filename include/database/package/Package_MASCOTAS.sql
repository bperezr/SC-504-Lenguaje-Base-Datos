--DROP PACKAGE P_MASCOTA
--CLIENTE
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_MASCOTA
AS

--------------------- SP Basicos---------------------
--SP1
PROCEDURE getMascotas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getMascota(
    p_idMascota IN mascota.idMascota%TYPE,
    p_nombre OUT mascota.nombre%TYPE,
    p_descripcion OUT mascota.descripcion%TYPE,
    p_imagen OUT mascota.imagen%TYPE,
    p_idTipoMascota OUT mascota.idTipoMascota%TYPE,
    p_idCliente OUT mascota.idCliente%TYPE,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE insertMascota(
    p_nombre IN mascota.nombre%TYPE,
    p_descripcion IN mascota.descripcion%TYPE,
    p_imagen IN mascota.imagen%TYPE,
    p_idTipoMascota IN mascota.idTipoMascota%TYPE,
    p_idCliente IN mascota.idCliente%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE updateMascota(
    p_idMascota IN mascota.idMascota%TYPE,
    p_nombre IN mascota.nombre%TYPE,
    p_descripcion IN mascota.descripcion%TYPE,
    p_imagen IN mascota.imagen%TYPE,
    p_idTipoMascota IN mascota.idTipoMascota%TYPE,
    p_idCliente IN mascota.idCliente%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE deleteMascota(
    p_idMascota IN mascota.idMascota%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarMascotas(
    p_searchTerm IN mascota.nombre%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
);
--SP7
PROCEDURE getMascotasPorCliente(
    p_idCliente IN NUMBER,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP8
PROCEDURE buscarMascotasPorCliente(
    p_idCliente IN NUMBER,
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
);

END P_MASCOTA;

--#########################################################################################################

CREATE OR REPLACE PACKAGE BODY P_MASCOTA
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getMascotas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    -- Abrir cursor para seleccionar datos de las mascotas
    OPEN p_cursor FOR
        SELECT m.idMascota, m.nombre, m.descripcion, m.imagen,
            m.idTipoMascota, m.idCliente
        FROM mascota m;

    -- Establecer el resultado
    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getMascotas: ' || SQLERRM);
END;
--SP2----------------------------------------------------------------------------
PROCEDURE getMascota(
    p_idMascota IN mascota.idMascota%TYPE,
    p_nombre OUT mascota.nombre%TYPE,
    p_descripcion OUT mascota.descripcion%TYPE,
    p_imagen OUT mascota.imagen%TYPE,
    p_idTipoMascota OUT mascota.idTipoMascota%TYPE,
    p_idCliente OUT mascota.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT nombre, descripcion, imagen, idTipoMascota, idCliente
    INTO p_nombre, p_descripcion, p_imagen, p_idTipoMascota, p_idCliente
    FROM mascota
    WHERE idMascota = p_idMascota;

    -- Establecer el resultado basado en SQLCODE
    p_resultado := SQLCODE;

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getMascota: ' || SQLERRM);
END;
--SP3----------------------------------------------------------------------------
PROCEDURE insertMascota(
    p_nombre IN mascota.nombre%TYPE,
    p_descripcion IN mascota.descripcion%TYPE,
    p_imagen IN mascota.imagen%TYPE,
    p_idTipoMascota IN mascota.idTipoMascota%TYPE,
    p_idCliente IN mascota.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO mascota(nombre, descripcion, imagen, idTipoMascota, idCliente)
    VALUES (p_nombre, p_descripcion, p_imagen, p_idTipoMascota, p_idCliente);

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP4----------------------------------------------------------------------------
PROCEDURE updateMascota(
    p_idMascota IN mascota.idMascota%TYPE,
    p_nombre IN mascota.nombre%TYPE,
    p_descripcion IN mascota.descripcion%TYPE,
    p_imagen IN mascota.imagen%TYPE,
    p_idTipoMascota IN mascota.idTipoMascota%TYPE,
    p_idCliente IN mascota.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE mascota
    SET nombre = p_nombre,
        descripcion = p_descripcion,
        imagen = p_imagen,
        idTipoMascota = p_idTipoMascota,
        idCliente = p_idCliente
    WHERE idMascota = p_idMascota;

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP5----------------------------------------------------------------------------
PROCEDURE deleteMascota(
    p_idMascota IN mascota.idMascota%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM mascota WHERE idMascota = p_idMascota;

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP6----------------------------------------------------------------------------
PROCEDURE buscarMascotas(
    p_searchTerm IN mascota.nombre%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
) AS
BEGIN
    -- Primera consulta para contar las filas
    SELECT COUNT(*) INTO p_numFilas
    FROM mascota
    WHERE LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
        LOWER(descripcion) LIKE LOWER('%' || p_searchTerm || '%');

    -- Segunda consulta para obtener los datos
    OPEN p_cursor FOR
        SELECT idMascota, nombre, descripcion, imagen, idTipoMascota, idCliente
        FROM mascota
        WHERE LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
            LOWER(descripcion) LIKE LOWER('%' || p_searchTerm || '%');

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    -- Establecer el resultado basado en el recuento de filas
    IF p_numFilas > 0 THEN
        p_resultado := 0; -- Se encontraron filas
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP7----------------------------------------------------------------------------
PROCEDURE getMascotasPorCliente(
    p_idCliente IN NUMBER,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT *
        FROM mascota
        WHERE idCliente = p_idCliente;

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getMascotasPorCliente: ' || SQLERRM);
END;
--SP8----------------------------------------------------------------------------
PROCEDURE buscarMascotasPorCliente(
    p_idCliente IN NUMBER,
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
) AS
BEGIN
    -- Primera consulta para contar las filas
    SELECT COUNT(*) INTO p_numFilas
    FROM mascota
    WHERE idCliente = p_idCliente
      AND (LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
           LOWER(descripcion) LIKE LOWER('%' || p_searchTerm || '%'));

    -- Segunda consulta para obtener los datos
    OPEN p_cursor FOR
        SELECT idMascota, nombre, descripcion, imagen, idTipoMascota, idCliente
        FROM mascota
        WHERE idCliente = p_idCliente
          AND (LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
               LOWER(descripcion) LIKE LOWER('%' || p_searchTerm || '%'));

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    -- Establecer el resultado basado en el recuento de filas
    IF p_numFilas > 0 THEN
        p_resultado := 0; -- Se encontraron filas
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--FIN SP------------------------------------------------------------------------
END P_MASCOTA;
--#########################################################################################################