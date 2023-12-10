--Drop PACKAGE P_COLABORADOR;

--COLABORADOR
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_COLABORADOR
AS

--------------------- SP ---------------------
--SP1

--SP2

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
    p_correo IN VARCHAR2,
    p_contrasena IN VARCHAR2,
    p_resultado OUT NUMBER
) AS
    v_consult_correo VARCHAR2(100);
    v_consult_contrasena VARCHAR2(250);
    v_pass_hash RAW(128);
BEGIN
    v_pass_hash := DBMS_CRYPTO.HASH(
        src => UTL_RAW.CAST_TO_RAW(p_contrasena),
        typ => DBMS_CRYPTO.HASH_SH256
    );

    SELECT correo, contrasena INTO v_consult_correo, v_consult_contrasena
    FROM colaborador
    WHERE correo = p_correo AND contrasena = v_pass_hash;

    p_resultado := 0; -- Éxito

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- Credenciales incorrectas
    WHEN OTHERS THEN
        p_resultado := -1; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
/

--SP2----------------------------------------------------------------------------

--SP3----------------------------------------------------------------------------

--SP4----------------------------------------------------------------------------

--SP5----------------------------------------------------------------------------

--SP6----------------------------------------------------------------------------

--FIN SP------------------------------------------------------------------------
END P_COLABORADOR;
--#########################################################################################################