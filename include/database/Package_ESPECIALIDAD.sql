--drop PROCEDURE deleteEspecialidad;
--drop PROCEDURE getEspecialidad;
--drop PROCEDURE getEspecialidades;
--drop PROCEDURE updateEspecialidad;
--drop PROCEDURE updateEspecialidad;
--drop PROCEDURE buscarEspecialidades;

--ESPECIALIDAD
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_ESPECIALIDAD 
AS

--------------------- SP ---------------------
--SP1
PROCEDURE deleteEspecialidad(
    p_idEspecialidad IN especialidad.idEspecialidad%TYPE,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getEspecialidad(
    p_idEspecialidad IN especialidad.idEspecialidad%TYPE,
    p_Especialidad OUT especialidad.especialidad%TYPE,
    p_Descripcion OUT especialidad.descripcion%TYPE,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE getEspecialidades(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE insertEspecialidad(
    p_Especialidad IN especialidad.especialidad%TYPE,
    p_Descripcion IN especialidad.descripcion%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE updateEspecialidad(
    p_idEspecialidad IN especialidad.idEspecialidad%TYPE,
    p_Especialidad IN especialidad.especialidad%TYPE,
    p_Descripcion IN especialidad.descripcion%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarEspecialidades(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);

END P_ESPECIALIDAD;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_ESPECIALIDAD 
AS

--SP1----------------------------------------------------------------------------
PROCEDURE deleteEspecialidad(
    p_idEspecialidad IN especialidad.idEspecialidad%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM especialidad WHERE idEspecialidad = p_idEspecialidad;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para eliminar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en deleteEspecialidad: ' || SQLERRM);
END;
--SP2----------------------------------------------------------------------------
PROCEDURE getEspecialidad(
    p_idEspecialidad IN especialidad.idEspecialidad%TYPE,
    p_Especialidad OUT especialidad.especialidad%TYPE,
    p_Descripcion OUT especialidad.descripcion%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT especialidad, descripcion
        INTO p_Especialidad, p_Descripcion
        FROM especialidad
        WHERE idEspecialidad = p_idEspecialidad;

        p_resultado := 1; -- Encontrado

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró
            DBMS_OUTPUT.PUT_LINE('No se encontró ninguna especialidad con id ' || p_idEspecialidad);
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en getEspecialidad: ' || SQLERRM);
    END;

END;
--SP3----------------------------------------------------------------------------
PROCEDURE getEspecialidades(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT e.idEspecialidad, e.especialidad, e.descripcion
        FROM especialidad e;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en getEspecialidades: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getEspecialidades: ' || SQLERRM);
END;
--SP4----------------------------------------------------------------------------
PROCEDURE insertEspecialidad(
    p_Especialidad IN especialidad.especialidad%TYPE,
    p_Descripcion IN especialidad.descripcion%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO especialidad(especialidad, descripcion)
    VALUES (p_Especialidad, p_Descripcion);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertEspecialidad: ' || SQLERRM);
END;
--SP5----------------------------------------------------------------------------
PROCEDURE updateEspecialidad(
    p_idEspecialidad IN especialidad.idEspecialidad%TYPE,
    p_Especialidad IN especialidad.especialidad%TYPE,
    p_Descripcion IN especialidad.descripcion%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE especialidad
    SET especialidad = p_Especialidad,
        descripcion = p_Descripcion
    WHERE idEspecialidad = p_idEspecialidad;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para actualizar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateEspecialidad: ' || SQLERRM);
END;
--SP6----------------------------------------------------------------------------
PROCEDURE buscarEspecialidades(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idEspecialidad, especialidad, descripcion
        FROM especialidad
        WHERE LOWER(especialidad) LIKE LOWER('%' || p_searchTerm || '%');

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ninguna especialidad
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en buscarEspecialidades: ' || SQLERRM);
END;
--FIN SP------------------------------------------------------------------------
END P_ESPECIALIDAD;
--#########################################################################################################