--DROP PACKAGE P_CLIENTE
--CLIENTE
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_CLIENTE
AS

--------------------- SP Basicos---------------------
--SP1
PROCEDURE getClientes(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre OUT cliente.nombre%TYPE,
    p_apellido1 OUT cliente.apellido1%TYPE,
    p_apellido2 OUT cliente.apellido2%TYPE,
    p_telefono OUT cliente.telefono%TYPE,
    p_imagen OUT cliente.imagen%TYPE,
    p_domicilio OUT cliente.domicilio%TYPE,
    p_idProvincia OUT cliente.idProvincia%TYPE,
    p_idCanton OUT cliente.idCanton%TYPE,
    p_idDistrito OUT cliente.idDistrito%TYPE,
    p_idRol OUT cliente.idRol%TYPE,
    p_correo OUT cliente.correo%TYPE,
    p_contrasena OUT cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE insertCliente(
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_imagen IN cliente.imagen%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE updateCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_imagen IN cliente.imagen%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE deleteCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarClientes(
    p_searchTerm IN cliente.nombre%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
);
--------------------- SP login -------------------
--SP7
PROCEDURE insertClienteNuevo (
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
);
--SP8
PROCEDURE obtenerClientePorCorreo (
    p_Correo IN cliente.correo%TYPE,
    p_idCliente OUT cliente.idCliente%TYPE,
    p_idRol OUT cliente.idRol%TYPE,
    p_nombre OUT cliente.nombre%TYPE,
    p_apellido1 OUT cliente.apellido1%TYPE,
    p_apellido2 OUT cliente.apellido2%TYPE,
    p_resultado OUT NUMBER
);
--SP9
PROCEDURE validarCredenciales (
    p_Correo IN cliente.correo%TYPE,
    p_Contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
);
--SP10
PROCEDURE getVerClientes(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP11
PROCEDURE getRoles(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP12
PROCEDURE camposNull(
    p_correo IN cliente.correo%TYPE,
    p_nombre OUT cliente.nombre%TYPE,
    p_apellido1 OUT cliente.apellido1%TYPE,
    p_apellido2 OUT cliente.apellido2%TYPE,
    p_telefono OUT cliente.telefono%TYPE,
    p_domicilio OUT cliente.domicilio%TYPE,
    p_idProvincia OUT cliente.idProvincia%TYPE,
    p_idCanton OUT cliente.idCanton%TYPE,
    p_idDistrito OUT cliente.idDistrito%TYPE,
    p_resultado OUT NUMBER
);
--SP13
PROCEDURE updateClienteNuevo(
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
);
--SP14
PROCEDURE verificarCorreoExistente(
    p_correo IN cliente.correo%TYPE,
    p_existe OUT NUMBER
);

END P_CLIENTE;

--#########################################################################################################

CREATE OR REPLACE PACKAGE BODY P_CLIENTE
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getClientes(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idCliente, nombre, apellido1, apellido2, telefono, imagen, domicilio, 
               idProvincia, idCanton, idDistrito, idRol, correo, contrasena
        FROM cliente;

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
END ;
--SP2----------------------------------------------------------------------------
PROCEDURE getCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre OUT cliente.nombre%TYPE,
    p_apellido1 OUT cliente.apellido1%TYPE,
    p_apellido2 OUT cliente.apellido2%TYPE,
    p_telefono OUT cliente.telefono%TYPE,
    p_imagen OUT cliente.imagen%TYPE,
    p_domicilio OUT cliente.domicilio%TYPE,
    p_idProvincia OUT cliente.idProvincia%TYPE,
    p_idCanton OUT cliente.idCanton%TYPE,
    p_idDistrito OUT cliente.idDistrito%TYPE,
    p_idRol OUT cliente.idRol%TYPE,
    p_correo OUT cliente.correo%TYPE,
    p_contrasena OUT cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT nombre, apellido1, apellido2, telefono, imagen, domicilio, 
           idProvincia, idCanton, idDistrito, idRol, correo, contrasena
    INTO p_nombre, p_apellido1, p_apellido2, p_telefono, p_imagen, p_domicilio, 
         p_idProvincia, p_idCanton, p_idDistrito, p_idRol, p_correo, p_contrasena
    FROM cliente
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
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END ;
--SP3----------------------------------------------------------------------------
PROCEDURE insertCliente(
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_imagen IN cliente.imagen%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO cliente(nombre, apellido1, apellido2, telefono, imagen, domicilio, 
                        idProvincia, idCanton, idDistrito, idRol, correo, contrasena)
    VALUES (p_nombre, p_apellido1, p_apellido2, p_telefono, p_imagen, p_domicilio, 
            p_idProvincia, p_idCanton, p_idDistrito, p_idRol, p_correo, p_contrasena);

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
END ;
--SP4----------------------------------------------------------------------------
PROCEDURE updateCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_imagen IN cliente.imagen%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    UPDATE cliente
    SET nombre = p_nombre,
        apellido1 = p_apellido1,
        apellido2 = p_apellido2,
        telefono = p_telefono,
        imagen = p_imagen,
        domicilio = p_domicilio,
        idProvincia = p_idProvincia,
        idCanton = p_idCanton,
        idDistrito = p_idDistrito,
        idRol = p_idRol,
        correo = p_correo,
        contrasena = p_contrasena
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
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END ;
--SP5----------------------------------------------------------------------------
PROCEDURE deleteCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM cliente WHERE idCliente = p_idCliente;

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
END ;
--SP6----------------------------------------------------------------------------
PROCEDURE buscarClientes(
    p_searchTerm IN cliente.nombre%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
) AS
BEGIN
    -- Primera consulta para contar las filas
    SELECT COUNT(*) INTO p_numFilas
    FROM cliente
    WHERE LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(apellido1) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(apellido2) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(correo) LIKE LOWER('%' || p_searchTerm || '%');

    -- Segunda consulta para obtener los datos
    OPEN p_cursor FOR
        SELECT idCliente, nombre, apellido1, apellido2, telefono, imagen, domicilio, 
               idProvincia, idCanton, idDistrito, idRol, correo, contrasena
        FROM cliente
        WHERE LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(apellido1) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(apellido2) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(correo) LIKE LOWER('%' || p_searchTerm || '%');

    
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
END ;
--SP7------------------------------------------------------------------------
PROCEDURE insertClienteNuevo (
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS
    passHash RAW(128);
BEGIN
    passHash := DBMS_CRYPTO.HASH(
        src => UTL_RAW.CAST_TO_RAW(p_contrasena),
        typ => DBMS_CRYPTO.HASH_SH256
    );

    INSERT INTO cliente (correo, contrasena) VALUES (p_correo, passHash);

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
END ;
--SP8------------------------------------------------------------------------
PROCEDURE obtenerClientePorCorreo (
    p_Correo IN cliente.correo%TYPE,
    p_idCliente OUT cliente.idCliente%TYPE,
    p_idRol OUT cliente.idRol%TYPE,
    p_nombre OUT cliente.nombre%TYPE,
    p_apellido1 OUT cliente.apellido1%TYPE,
    p_apellido2 OUT cliente.apellido2%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT idCliente, idRol, nombre, apellido1, apellido2 
    INTO p_idCliente, p_idRol, p_nombre, p_apellido1, p_apellido2
    FROM cliente WHERE correo = p_Correo;

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
--SP9------------------------------------------------------------------------
PROCEDURE validarCredenciales (
    p_Correo IN cliente.correo%TYPE,
    p_Contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS 
    CONSULT_CORREO cliente.correo%TYPE;
    CONSULT_CONTRASENA cliente.contrasena%TYPE;
    passHash RAW(128);
BEGIN
    passHash := DBMS_CRYPTO.HASH(
        src => UTL_RAW.CAST_TO_RAW(p_Contrasena),
        typ => DBMS_CRYPTO.HASH_SH256
    );

    SELECT CORREO, CONTRASENA INTO CONSULT_CORREO, CONSULT_CONTRASENA 
    FROM CLIENTE 
    WHERE CORREO = p_Correo AND CONTRASENA = passHash;

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
--SP10------------------------------------------------------------------------
PROCEDURE getVerClientes(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idCliente, nombre, apellido1, apellido2, telefono, imagen, domicilio, 
               idProvincia, idCanton, idDistrito, correo
        FROM cliente;

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
END ;
--SP11------------------------------------------------------------------------
PROCEDURE getRoles(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idRol, nombreRol
        FROM rol;

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
END ;
--SP12------------------------------------------------------------------------
PROCEDURE camposNull(
    p_correo IN cliente.correo%TYPE,
    p_nombre OUT cliente.nombre%TYPE,
    p_apellido1 OUT cliente.apellido1%TYPE,
    p_apellido2 OUT cliente.apellido2%TYPE,
    p_telefono OUT cliente.telefono%TYPE,
    p_domicilio OUT cliente.domicilio%TYPE,
    p_idProvincia OUT cliente.idProvincia%TYPE,
    p_idCanton OUT cliente.idCanton%TYPE,
    p_idDistrito OUT cliente.idDistrito%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT nombre, apellido1, apellido2, telefono, domicilio, idProvincia, idCanton, idDistrito
    INTO p_nombre, p_apellido1, p_apellido2, p_telefono, p_domicilio, p_idProvincia, p_idCanton, p_idDistrito
    FROM cliente
    WHERE correo = p_correo;

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
END ;
--SP13------------------------------------------------------------------------
PROCEDURE updateClienteNuevo(
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
END ;
--SP14------------------------------------------------------------------------
PROCEDURE verificarCorreoExistente(
    p_correo IN cliente.correo%TYPE,
    p_resultado OUT NUMBER
) AS
    v_count NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO v_count
    FROM cliente
    WHERE correo = p_correo;

    IF v_count > 0 THEN
        p_resultado := 0; -- El correo existe
    ELSE
        p_resultado := 1; -- El correo no existe
    END IF;
EXCEPTION
    WHEN OTHERS THEN

        p_resultado := -1; -- Indica un error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--FIN SP------------------------------------------------------------------------
END P_CLIENTE;
--#########################################################################################################