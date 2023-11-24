SET SERVEROUTPUT ON;
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 --ESPECIALIDAD
------------------------------------------------------------------------------------------------------------------------------------------------------------------------

--******************************************************************************************
                                                                                --getEspecialidad
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getEspecialidad(
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
/



--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    v_idEspecialidad NUMBER := 1;
    v_especialidad VARCHAR2(50);
    v_descripcion VARCHAR2(200);
    v_resultado NUMBER;
BEGIN
    v_resultado := 0;

    getEspecialidad(v_idEspecialidad, v_especialidad, v_descripcion, v_resultado);

    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        DBMS_OUTPUT.PUT_LINE(' ');
        DBMS_OUTPUT.PUT_LINE('ID Especialidad: ' || v_idEspecialidad);
        DBMS_OUTPUT.PUT_LINE('Especialidad: ' || v_especialidad);
        DBMS_OUTPUT.PUT_LINE('Descripción: ' || v_descripcion);
    ELSIF v_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    END IF;
END;
/




--******************************************************************************************
                                                                                --getEspecialidades
--******************************************************************************************

CREATE OR REPLACE PROCEDURE getEspecialidades(
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
/




--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_idEspecialidad especialidad.idEspecialidad%TYPE;
    v_especialidad especialidad.especialidad%TYPE;
    v_descripcion especialidad.descripcion%TYPE;
    v_resultado NUMBER;

BEGIN
    getEspecialidades(cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
            DBMS_OUTPUT.PUT_LINE(' ');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idEspecialidad, v_especialidad, v_descripcion;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Especialidad: ' || v_idEspecialidad);
        DBMS_OUTPUT.PUT_LINE('Especialidad: ' || v_especialidad);
        DBMS_OUTPUT.PUT_LINE('Descripción: ' || v_descripcion);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/

--******************************************************************************************
                                                                                --insertespecialidad
--******************************************************************************************

CREATE OR REPLACE PROCEDURE insertEspecialidad(
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
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************

DECLARE
    v_resultado NUMBER;

BEGIN
    insertEspecialidad(
        p_Especialidad => 'Nueva Especialidad',
        p_Descripcion => 'Descripción de la nueva especialidad', 
        p_resultado => v_resultado
    );

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Especialidad insertada correctamente.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se pudo insertar la especialidad.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar insertar la especialidad.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;
/



--******************************************************************************************
                                                                                --updateEspecialidad
--******************************************************************************************
CREATE OR REPLACE PROCEDURE updateEspecialidad(
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
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    v_resultado NUMBER;

BEGIN
    updateEspecialidad(1, 'Especialidad Actualizada', 'Nueva descripción', v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Especialidad actualizada correctamente.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró la especialidad para actualizar.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar actualizar la especialidad.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;
/



--******************************************************************************************
                                                                                --deleteespecialidad
--******************************************************************************************
CREATE OR REPLACE PROCEDURE deleteEspecialidad(
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
/




--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    v_resultado NUMBER;

BEGIN
    deleteEspecialidad(1, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Especialidad eliminada correctamente.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró la especialidad para eliminar.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar eliminar la especialidad.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;
/


--******************************************************************************************
                                                                                --buscarEspecialidades
--******************************************************************************************
CREATE OR REPLACE PROCEDURE buscarEspecialidades(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idEspecialidad, especialidad, descripcion
        FROM especialidad;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ninguna especialidad
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en buscarEspecialidades: ' || SQLERRM);
END;
/

--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_resultado NUMBER;

BEGIN
    buscarEspecialidades(cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Especialidades encontradas:');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron especialidades.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar buscar las especialidades.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idEspecialidad, v_especialidad, v_descripcion;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Especialidad: ' || v_idEspecialidad);
        DBMS_OUTPUT.PUT_LINE('Especialidad: ' || v_especialidad);
        DBMS_OUTPUT.PUT_LINE('Descripción: ' || v_descripcion);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 --LUGAR
------------------------------------------------------------------------------------------------------------------------------------------------------------------------


--******************************************************************************************
                                                                                --obtenerNombreProvinciaPorID
--******************************************************************************************
CREATE OR REPLACE PROCEDURE obtenerNombreProvinciaPorID(
    p_idProvincia IN Provincia.idProvincia%TYPE,
    p_nombre OUT Provincia.Nombre%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT Nombre INTO p_nombre
    FROM Provincia
    WHERE idProvincia = p_idProvincia;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    v_nombre Provincia.Nombre%TYPE;
    v_resultado NUMBER;

BEGIN
    obtenerNombreProvinciaPorID(1, v_nombre, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Nombre de Provincia: ' || v_nombre);
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró la provincia con el ID especificado.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el nombre de la provincia.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;
/


--******************************************************************************************
                                                                                --obtenerNombreCantonPorID
--******************************************************************************************
CREATE OR REPLACE PROCEDURE obtenerNombreCantonPorID(
    p_idCanton IN Canton.idCanton%TYPE,
    p_nombre OUT Canton.Nombre%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT Nombre INTO p_nombre
    FROM Canton
    WHERE idCanton = p_idCanton;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    v_nombre Canton.Nombre%TYPE;
    v_resultado NUMBER;

BEGIN
    obtenerNombreCantonPorID(1, v_nombre, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Nombre de Cantón: ' || v_nombre);
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró el cantón con el ID especificado.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el nombre del cantón.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;
/

--******************************************************************************************
                                                                                --obtenerNombreDistritoPorID
--******************************************************************************************
CREATE OR REPLACE PROCEDURE obtenerNombreDistritoPorID(
    p_idDistrito IN Distrito.idDistrito%TYPE,
    p_nombre OUT Distrito.Nombre%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT Nombre INTO p_nombre
    FROM Distrito
    WHERE idDistrito = p_idDistrito;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    v_nombre Distrito.Nombre%TYPE;
    v_resultado NUMBER;

BEGIN
    obtenerNombreDistritoPorID(1, v_nombre, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Nombre de Distrito: ' || v_nombre);
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró el distrito con el ID especificado.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el nombre del distrito.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;
/

--******************************************************************************************
                                                                                --getProvincias
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getProvincias(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idProvincia, Nombre
        FROM Provincia;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ninguna provincia
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_resultado NUMBER;

BEGIN
    getProvincias(cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Listado de Provincias:');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron provincias.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el listado de provincias.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idProvincia, v_nombreProvincia;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Provincia: ' || v_idProvincia);
        DBMS_OUTPUT.PUT_LINE('Nombre de Provincia: ' || v_nombreProvincia);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/

--******************************************************************************************
                                                                                --getCantones
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getCantones(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idCanton, Nombre
        FROM Canton;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningún cantón
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_resultado NUMBER;

BEGIN
    getCantones(cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Listado de Cantones:');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron cantones.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el listado de cantones.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idCanton, v_nombreCanton;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Cantón: ' || v_idCanton);
        DBMS_OUTPUT.PUT_LINE('Nombre de Cantón: ' || v_nombreCanton);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/

--******************************************************************************************
                                                                                --getDistritos
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getDistritos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idDistrito, Nombre
        FROM Distrito;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningún distrito
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_resultado NUMBER;

BEGIN
    getDistritos(cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Listado de Distritos:');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron distritos.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el listado de distritos.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idDistrito, v_nombreDistrito;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Distrito: ' || v_idDistrito);
        DBMS_OUTPUT.PUT_LINE('Nombre de Distrito: ' || v_nombreDistrito);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/

--******************************************************************************************
                                                                                --getCantonesPorProvincia
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getCantonesPorProvincia(
    p_idProvincia IN Provincia.idProvincia%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idCanton, Nombre
        FROM Canton
        WHERE idProvincia = p_idProvincia;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningún cantón para la provincia especificada
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_resultado NUMBER;

BEGIN
    getCantonesPorProvincia(1, cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Listado de Cantones para la Provincia especificada:');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron cantones para la Provincia especificada.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el listado de cantones.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idCanton, v_nombreCanton;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Cantón: ' || v_idCanton);
        DBMS_OUTPUT.PUT_LINE('Nombre de Cantón: ' || v_nombreCanton);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/

--******************************************************************************************
                                                                                --getDistritosPorCanton
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getDistritosPorCanton(
    p_idCanton IN Canton.idCanton%TYPE,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idDistrito, Nombre
        FROM Distrito
        WHERE idCanton = p_idCanton;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningún distrito para el cantón especificado
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
/


--******************************************************************************
                                                                          --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_resultado NUMBER;

BEGIN
    getDistritosPorCanton(1, cur, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Listado de Distritos para el Cantón especificado:');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron distritos para el Cantón especificado.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar obtener el listado de distritos.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;

    LOOP
        FETCH cur INTO v_idDistrito, v_nombreDistrito;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Distrito: ' || v_idDistrito);
        DBMS_OUTPUT.PUT_LINE('Nombre de Distrito: ' || v_nombreDistrito);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;
/
