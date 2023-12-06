/* DROPS CARGO
drop PROCEDURE GetCargo;
drop PROCEDURE GetCargos;
drop PROCEDURE insertCargo;
drop PROCEDURE updateCargo;
drop PROCEDURE deleteCargo;
drop PROCEDURE BuscarCargos;
*/

--#########################################################################################################
CREATE OR REPLACE PACKAGE P_Cargo
AS

--------------------- SP ---------------------
--SP1
PROCEDURE getCargo(
    p_idCargo IN cargo.idCargo%TYPE,
    p_Cargo OUT cargo.cargo%TYPE,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getCargos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE insertCargo(
    p_Cargo IN cargo.cargo%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE updateCargo(
    p_idCargo IN cargo.idCargo%TYPE,
    p_Cargo IN cargo.cargo%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE deleteCargo(
    p_idCargo IN cargo.idCargo%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarCargos(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);

END P_Cargo;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_Cargo
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getCargo(
    p_idCargo IN cargo.idCargo%TYPE,
    p_Cargo OUT cargo.cargo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT cargo
        INTO p_Cargo
        FROM cargo
        WHERE idCargo = p_idCargo;

        p_resultado := 1; -- Encontrado

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró
            DBMS_OUTPUT.PUT_LINE('No se encontró ningún Cargo con el id ' || p_idCargo);
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en getCargo: ' || SQLERRM);
    END;

END;

--SP2----------------------------------------------------------------------------
PROCEDURE getCargos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT c.idCargo, c.cargo
        FROM cargo c;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en getCargos: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getCargos: ' || SQLERRM);
END;

--SP3----------------------------------------------------------------------------
PROCEDURE insertCargo(
    p_Cargo IN cargo.cargo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO cargo(cargo)
    VALUES (p_Cargo);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertCargo: ' || SQLERRM);
END;

--SP4----------------------------------------------------------------------------
PROCEDURE updateCargo(
    p_idCargo IN cargo.idCargo%TYPE,
    p_Cargo IN cargo.cargo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE cargo
    SET cargo = p_Cargo
    WHERE idCargo = p_idCargo;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para actualizar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateCargo: ' || SQLERRM);
END;

--SP5----------------------------------------------------------------------------
PROCEDURE deleteCargo(
    p_idCargo IN cargo.idCargo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM cargo WHERE idCargo = p_idCargo;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró ninguna fila para eliminar
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en deleteCargo: ' || SQLERRM);
END;
--SP6----------------------------------------------------------------------------
PROCEDURE buscarCargos(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idCargo, cargo
        FROM cargo
        WHERE LOWER(cargo) LIKE LOWER('%' || p_searchTerm || '%');

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningun Cargo
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en buscarCargos: ' || SQLERRM);
END;
--FIN SP------------------------------------------------------------------------
END P_Cargo;
--#########################################################################################################