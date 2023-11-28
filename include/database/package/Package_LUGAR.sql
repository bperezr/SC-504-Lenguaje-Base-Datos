--LUGAR
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_LUGAR 
AS

--------------------- SP ---------------------
--SP1
PROCEDURE getNombreProvinciaPorID (
    p_idprovincia IN provincia.idprovincia%TYPE,
    p_nombre      OUT provincia.nombre%TYPE,
    p_resultado   OUT NUMBER
);
--SP2
PROCEDURE getNombreCantonPorID(
    p_idCanton IN NUMBER,
    p_nombreCanton OUT VARCHAR2,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE getNombreDistritoPorID (
    p_idDistrito IN distrito.idDistrito%TYPE,
    p_nombreDistrito OUT distrito.nombre%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE getCantonesPorProvincia(
    p_idProvincia IN canton.idProvincia%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE getDistritosPorCanton(
    p_idCanton IN distrito.idCanton%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE getProvincias(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP7
PROCEDURE getCantones(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP8
PROCEDURE getDistritos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP9
    PROCEDURE getLugares(
        p_cursor OUT SYS_REFCURSOR,
        p_resultado OUT NUMBER
    );
END P_LUGAR;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_LUGAR 
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getNombreProvinciaPorID (
    p_idProvincia IN provincia.idProvincia%TYPE,
    p_nombre OUT provincia.nombre%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT nombre INTO p_nombre FROM provincia WHERE idProvincia = p_idProvincia;
        p_resultado := 1; -- Provincia encontrada
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró la provincia
        WHEN OTHERS THEN
            p_resultado := 9; -- Ocurrió un error
    END;
END;
--SP2----------------------------------------------------------------------------
PROCEDURE getNombreCantonPorID(
    p_idCanton IN NUMBER,
    p_nombreCanton OUT VARCHAR2,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT nombre INTO p_nombreCanton FROM canton WHERE idCanton = p_idCanton;

        p_resultado := 1; -- Encontrado

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
    END;
END;
--SP3----------------------------------------------------------------------------
PROCEDURE getNombreDistritoPorID (
    p_idDistrito IN distrito.idDistrito%TYPE,
    p_nombreDistrito OUT distrito.nombre%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT nombre INTO p_nombreDistrito FROM distrito WHERE idDistrito = p_idDistrito;
        p_resultado := 1; -- Distrito encontrado
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró el distrito
        WHEN OTHERS THEN
            p_resultado := 9; -- Ocurrió un error
    END;
END;
--SP4----------------------------------------------------------------------------
PROCEDURE getCantonesPorProvincia(
    p_idProvincia IN canton.idProvincia%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
    v_contadorFilas NUMBER;
BEGIN
    -- Abrir cursor con los resultados de la consulta
    OPEN p_cursor FOR
        SELECT idCanton, nombre FROM canton WHERE idProvincia = p_idProvincia;

    -- Contar el número de filas
    SELECT COUNT(*)
    INTO v_contadorFilas
    FROM canton
    WHERE idProvincia = p_idProvincia;

    -- Establecer el resultado basado en el contador de filas
    IF v_contadorFilas > 0 THEN
        p_resultado := 1; -- Se encontraron filas
    ELSE
        p_resultado := 0; -- No se encontraron filas
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
--SP5----------------------------------------------------------------------------
PROCEDURE getDistritosPorCanton(
    p_idCanton IN distrito.idCanton%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
    v_contadorFilas NUMBER;
BEGIN
    -- Abrir cursor con los resultados de la consulta
    OPEN p_cursor FOR
        SELECT idDistrito, nombre FROM distrito WHERE idCanton = p_idCanton;

    -- Contar el número de filas
    SELECT COUNT(*)
    INTO v_contadorFilas
    FROM distrito
    WHERE idCanton = p_idCanton;

    -- Establecer el resultado basado en el contador de filas
    IF v_contadorFilas > 0 THEN
        p_resultado := 1; -- Se encontraron filas
    ELSE
        p_resultado := 0; -- No se encontraron filas
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
--SP6----------------------------------------------------------------------------
PROCEDURE getProvincias(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontraron provincias

    BEGIN
        -- Abrir el cursor para seleccionar todas las provincias
        OPEN p_cursor FOR
            SELECT idProvincia, nombre
            FROM provincia;
            
            p_resultado := 1;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontraron
            DBMS_OUTPUT.PUT_LINE('Error en getProvincias: ' || SQLERRM);
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en getProvincias: ' || SQLERRM);
    END;
END;
--SP7----------------------------------------------------------------------------
PROCEDURE getCantones(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT idCanton, nombre FROM canton;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en getCantones: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getCantones: ' || SQLERRM);
END;
--SP8----------------------------------------------------------------------------
PROCEDURE getDistritos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT idDistrito, nombre FROM distrito;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en getDistritos: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getDistritos: ' || SQLERRM);
END;
--SP8----------------------------------------------------------------------------
PROCEDURE getLugares(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    BEGIN
        -- Abrir el cursor para seleccionar todas las provincias, cantones y distritos
        -- Aquí solo seleccionamos los IDs y nombres para cada nivel
        OPEN p_cursor FOR
            SELECT 
                p.idProvincia, 
                p.nombre AS nombreProvincia, 
                c.idCanton, 
                c.nombre AS nombreCanton, 
                d.idDistrito, 
                d.nombre AS nombreDistrito
            FROM provincia p
            LEFT JOIN canton c ON p.idProvincia = c.idProvincia
            LEFT JOIN distrito d ON c.idCanton = d.idCanton
            ORDER BY p.idProvincia, c.idCanton, d.idDistrito;

        -- Establecer resultado como encontrado si la consulta se ejecuta correctamente
        p_resultado := 1;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            -- Establecer resultado como no encontrado si no hay datos
            p_resultado := 0;
            DBMS_OUTPUT.PUT_LINE('Error en getLugaresJerarquia: No se encontraron datos.');
        WHEN OTHERS THEN
            -- Establecer resultado como error en caso de un error inesperado
            p_resultado := 9;
            DBMS_OUTPUT.PUT_LINE('Error en getLugaresJerarquia: ' || SQLERRM);
    END;
END;

--FIN SP------------------------------------------------------------------------
END P_LUGAR;
--#########################################################################################################