/* DROPS tipoMascota
drop PROCEDURE getTipoMascota;
drop PROCEDURE getTipoMascotas;
drop PROCEDURE insertTipoMascota;
drop PROCEDURE updateTipoMascota;
drop PROCEDURE deleteTipoMascota;
drop PROCEDURE buscarTipoMascota;
*/

--#########################################################################################################
CREATE OR REPLACE PACKAGE P_tipoMascota
AS

--------------------- SP ---------------------
--SP1
PROCEDURE getTipoMascota(
    p_idTipoMascota IN tipoMascota.idTipoMascota%TYPE,
    p_Tipo OUT tipoMascota.tipo%TYPE,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getTipoMascotas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE insertTipoMascota(
    p_Tipo IN tipoMascota.tipo%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE updateTipoMascota(
    p_idTipoMascota IN tipoMascota.idTipoMascota%TYPE,
    p_Tipo IN tipoMascota.tipo%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE deleteTipoMascota(
    p_idTipoMascota IN tipoMascota.idTipoMascota%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarTipoMascotas(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);

END P_tipoMascota;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_tipoMascota
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getTipoMascota(
    p_idTipoMascota IN tipoMascota.idTipoMascota%TYPE,
    p_Tipo OUT tipoMascota.tipo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT tipo
        INTO p_Tipo
        FROM tipoMascota
        WHERE idTipoMascota = p_idTipoMascota;

        p_resultado := 1; -- Encontrado

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró
            DBMS_OUTPUT.PUT_LINE('No se encontró ningún Tipo con el id ' || p_idTipoMascota);
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en getTipoMascota: ' || SQLERRM);
    END;

END;

--SP2----------------------------------------------------------------------------
PROCEDURE getTipoMascotas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT t.idTipoMascota, t.tipo
        FROM tipoMascota t;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en getTipotipoMascotas: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getTipotipoMascotas: ' || SQLERRM);
END;

--SP3----------------------------------------------------------------------------
PROCEDURE insertTipoMascota(
    p_Tipo IN tipoMascota.tipo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO tipoMascota(tipo)
    VALUES (p_Tipo);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertTipoMascota: ' || SQLERRM);
END;

--SP4----------------------------------------------------------------------------
PROCEDURE updateTipoMascota(
    p_idTipoMascota IN tipoMascota.idTipoMascota%TYPE,
    p_Tipo IN tipoMascota.tipo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE tipoMascota
    SET tipo = p_Tipo
    WHERE idTipoMascota = p_idTipoMascota;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para actualizar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateTipoMascota: ' || SQLERRM);
END;

--SP5----------------------------------------------------------------------------
PROCEDURE deleteTipoMascota(
    p_idTipoMascota IN tipoMascota.idTipoMascota%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM tipoMascota WHERE idTipoMascota = p_idTipoMascota;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para eliminar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en deleteTipoMascota: ' || SQLERRM);
END;
--SP6----------------------------------------------------------------------------
PROCEDURE buscarTipoMascotas(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idTipoMascota, tipo
        FROM tipoMascota
        WHERE LOWER(tipo) LIKE LOWER('%' || p_searchTerm || '%');

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningun Tipo
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en buscarTipoMascotas: ' || SQLERRM);
END;
--FIN SP------------------------------------------------------------------------
END P_tipoMascota;
--#########################################################################################################