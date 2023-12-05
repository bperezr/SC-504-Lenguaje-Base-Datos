--Drop PACKAGE P_COLABORADOR;

--COLABORADOR
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_COLABORADOR
AS

--------------------- SP ---------------------
--SP1
PROCEDURE validarCredenciales (
    p_correo IN colaborador.correo%TYPE,
    p_contrasena IN colaborador.contrasena%TYPE,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE obtenerColaboradorPorCorreo (
    p_Correo IN colaborador.correo%TYPE,
    p_idColaborador OUT colaborador.idColaborador%TYPE,
    p_idRol OUT colaborador.idRol%TYPE,
    p_nombre OUT colaborador.nombre%TYPE,
    p_apellido1 OUT colaborador.apellido1%TYPE,
    p_apellido2 OUT colaborador.apellido2%TYPE,
    p_resultado OUT NUMBER
);
--SP3

--SP4

--SP5

--SP6


END P_COLABORADOR;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_COLABORADOR 
AS

--SP1----------------------------------------------------------------------------
PROCEDURE validarCredenciales (
    p_correo IN colaborador.correo%TYPE,
    p_contrasena IN colaborador.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS
    v_consult_correo colaborador.correo%TYPE;
    v_consult_contrasena colaborador.contrasena%TYPE;
    v_passHash RAW(128);
BEGIN
    v_passHash := DBMS_CRYPTO.HASH(
        src => UTL_RAW.CAST_TO_RAW(p_contrasena),
        typ => DBMS_CRYPTO.HASH_SH256
    );

    SELECT correo, contrasena INTO v_consult_correo, v_consult_contrasena
    FROM colaborador
    WHERE correo = p_correo AND contrasena = v_passHash;

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- Credenciales incorrectas
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP2----------------------------------------------------------------------------
PROCEDURE obtenerColaboradorPorCorreo (
    p_Correo IN colaborador.correo%TYPE,
    p_idColaborador OUT colaborador.idColaborador%TYPE,
    p_idRol OUT colaborador.idRol%TYPE,
    p_nombre OUT colaborador.nombre%TYPE,
    p_apellido1 OUT colaborador.apellido1%TYPE,
    p_apellido2 OUT colaborador.apellido2%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT idColaborador, idRol, nombre, apellido1, apellido2
    INTO p_idColaborador, p_idRol, p_nombre, p_apellido1, p_apellido2
    FROM colaborador WHERE correo = p_Correo;

    p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- No se encontró ningún registro con el correo
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP3----------------------------------------------------------------------------

--SP4----------------------------------------------------------------------------

--SP5----------------------------------------------------------------------------

--SP6----------------------------------------------------------------------------

--FIN SP------------------------------------------------------------------------
END P_COLABORADOR;
--#########################################################################################################