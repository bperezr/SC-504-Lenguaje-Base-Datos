
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_auditoria
AS

--------------------- SP ---------------------
--SP1
PROCEDURE getAuditoriaCita(
    p_idAuditoria IN AUDITORIACITAS.idAuditoria%TYPE,
    p_fechaModificacion OUT AUDITORIACITAS.fechaModificacion%TYPE,
    p_idCita OUT AUDITORIACITAS.idCita%TYPE,
    p_modificador OUT AUDITORIACITAS.modificador%TYPE,
    p_nuevoEstado OUT AUDITORIACITAS.nuevoEstado%TYPE,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getAuditoriasCitas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE buscarAuditoriasCitas(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
);
END P_auditoria;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_auditoria
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getAuditoriaCita(
    p_idAuditoria IN AUDITORIACITAS.idAuditoria%TYPE,
    p_fechaModificacion OUT AUDITORIACITAS.fechaModificacion%TYPE,
    p_idCita OUT AUDITORIACITAS.idCita%TYPE,
    p_modificador OUT AUDITORIACITAS.modificador%TYPE,
    p_nuevoEstado OUT AUDITORIACITAS.nuevoEstado%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT fechaModificacion, idCita, modificador, nuevoEstado
    INTO p_fechaModificacion, p_idCita, p_modificador, p_nuevoEstado
    FROM AUDITORIACITAS
    WHERE idAuditoria = p_idAuditoria;

    p_resultado := 0; -- Éxito
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- No se encontraron datos
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
END;
--SP2----------------------------------------------------------------------------
PROCEDURE getAuditoriasCitas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT fechaModificacion, idCita, modificador, nuevoEstado
        FROM AUDITORIACITAS;

    p_resultado := 0; -- Éxito
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
END;
--SP3----------------------------------------------------------------------------
PROCEDURE buscarAuditoriasCitas(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
) AS
BEGIN
    -- Primera consulta para contar las filas
    SELECT COUNT(*) INTO p_numFilas
    FROM auditoriaCitas
    WHERE LOWER(modificador) LIKE LOWER('%' || p_searchTerm || '%');

    -- Segunda consulta para obtener los datos
    OPEN p_cursor FOR
        SELECT idAuditoria, fechaModificacion, idCita, modificador, nuevoEstado
        FROM auditoriaCitas
        WHERE LOWER(modificador) LIKE LOWER('%' || p_searchTerm || '%');

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
END P_auditoria;
--#########################################################################################################