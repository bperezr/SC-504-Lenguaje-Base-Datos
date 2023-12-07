/* DROPS SERVICIOS
drop PROCEDURE getServicio;
drop PROCEDURE GetServicios;
drop PROCEDURE insertServicio;
drop PROCEDURE UpdateServicio;
drop PROCEDURE DeleteServicio;
drop PROCEDURE BuscarServicios;
*/

--#########################################################################################################
CREATE OR REPLACE PACKAGE P_SERVICIOS 
AS

--------------------- SP ---------------------
--SP1
PROCEDURE getServicio(
    p_idServicio IN Servicios.idServicio%TYPE,
    p_Servicio OUT Servicios.Servicio%TYPE,
    p_Descripcion OUT Servicios.descripcion%TYPE,
    p_resultado OUT NUMBER
);


--SP2
PROCEDURE getServicios(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE insertServicio(
    p_Servicio IN Servicios.Servicio%TYPE,
    p_Descripcion IN Servicios.descripcion%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE updateServicio(
    p_idServicio IN Servicios.idServicio%TYPE,
    p_Servicio IN Servicios.Servicio%TYPE,
    p_Descripcion IN Servicios.descripcion%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE deleteServicio(
    p_idServicio IN Servicios.idServicio%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarServicios(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);

END P_SERVICIOS;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_SERVICIOS 
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getServicio(
    p_idServicio IN Servicios.idServicio%TYPE,
    p_Servicio OUT Servicios.Servicio%TYPE,
    p_Descripcion OUT Servicios.descripcion%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT Servicio, descripcion
        INTO p_Servicio, p_Descripcion
        FROM Servicios
        WHERE idServicio = p_idServicio;

        p_resultado := 1; -- Encontrado

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró
            DBMS_OUTPUT.PUT_LINE('No se encontró ninguna Servicio con id ' || p_idServicio);
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en getServicio: ' || SQLERRM);
    END;

END;

--SP2----------------------------------------------------------------------------
PROCEDURE getServicios(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT s.idServicio, s.Servicio, s.descripcion
        FROM Servicios s;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en getServicios: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getServicios: ' || SQLERRM);
END;

--SP3----------------------------------------------------------------------------
PROCEDURE insertServicio(
    p_Servicio IN Servicios.Servicio%TYPE,
    p_Descripcion IN Servicios.descripcion%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO Servicios(Servicio, descripcion)
    VALUES (p_Servicio, p_Descripcion);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertServicio: ' || SQLERRM);
END;

--SP4----------------------------------------------------------------------------
PROCEDURE updateServicio(
    p_idServicio IN Servicios.idServicio%TYPE,
    p_Servicio IN Servicios.Servicio%TYPE,
    p_Descripcion IN Servicios.descripcion%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE Servicios
    SET Servicio = p_Servicio,
        descripcion = p_Descripcion
    WHERE idServicio = p_idServicio;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para actualizar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateServicio: ' || SQLERRM);
END;

--SP5----------------------------------------------------------------------------
PROCEDURE deleteServicio(
    p_idServicio IN Servicios.idServicio%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM Servicios WHERE idServicio = p_idServicio;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para eliminar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en deleteServicio: ' || SQLERRM);
END;

--SP6----------------------------------------------------------------------------
PROCEDURE buscarServicios(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idServicio, Servicio, descripcion
        FROM Servicios
        WHERE LOWER(Servicio) LIKE LOWER('%' || p_searchTerm || '%');

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ninguna Servicio
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en buscarServicios: ' || SQLERRM);
END;
--FIN SP------------------------------------------------------------------------
END P_SERVICIOS;
--#########################################################################################################