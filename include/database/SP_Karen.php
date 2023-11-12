--SP HAPPYPAWS--

--DB_Cargo-- PRIMER INTENTO EN LA BD--

---SP  para obtener un cargo por su ID--
CREATE OR REPLACE FUNCTION GetCargoById(p_idCargo IN NUMBER)
RETURN cargo%ROWTYPE
IS
    v_cargo cargo%ROWTYPE;
BEGIN
    SELECT * INTO v_cargo
    FROM cargo
    WHERE idCargo = p_idCargo;

    RETURN v_cargo;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN NULL;
END;
/

DECLARE
    v_result cargo%ROWTYPE;
BEGIN
    v_result := GetCargoById(1); -- Reemplaza 1 con el ID que deseas comprobar

    IF v_result.idCargo IS NOT NULL THEN
        DBMS_OUTPUT.PUT_LINE('ID Cargo: ' || v_result.idCargo || ', Cargo: ' || v_result.cargo);
    ELSE
        DBMS_OUTPUT.PUT_LINE('No se encontró un cargo con el ID proporcionado.');
    END IF;
END;
/

SET SERVEROUTPUT ON;


-------------------Para obtener los Cargos por su ID-----------------



CREATE OR REPLACE PROCEDURE GetCargos(p_cargos OUT SYS_REFCURSOR)
IS
BEGIN
    OPEN p_cargos FOR
    SELECT * FROM cargo;
END GetCargos;
/


DECLARE
    v_cargos SYS_REFCURSOR;
    v_cargo cargo%ROWTYPE;
    v_resultado NUMBER := 0; -- 0: No encontrado, 1: Encontrado, 9: Error
BEGIN
    GetAllCargos(v_cargos);

    LOOP
        FETCH v_cargos INTO v_cargo;
        EXIT WHEN v_cargos%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Cargo: ' || v_cargo.idCargo || ', Cargo: ' || v_cargo.cargo);
        v_resultado := 1; -- Indicar que al menos un cargo fue encontrado
    END LOOP;

    CLOSE v_cargos;
    
--Resultado--
    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Cargos encontrados exitosamente.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('No se encontraron cargos o hubo un error.');
    END IF;
END;
/




--SP para insertar un nuevo cargo----


--SP PARA INSERTAR UN NUEVO CARGO--  LISTO

CREATE OR REPLACE PROCEDURE InsertarNuevoCargo(
    p_cargo IN VARCHAR2,
    p_resultado OUT NUMBER
)
IS
BEGIN
    INSERT INTO cargo (cargo)
    VALUES (p_cargo);

    COMMIT;

    p_resultado := 1; -- Indicar que la inserción fue exitosa
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 0; -- Indicar que hubo un error en la inserción
        DBMS_OUTPUT.PUT_LINE('Error en InsertarNuevoCargo: ' || SQLERRM);
END InsertarNuevoCargo;
/

DECLARE
    v_nuevoCargo VARCHAR2(30) := 'Estetica'; -- Reemplaza con el nuevo cargo que deseas insertar
    v_resultado NUMBER := 0; -- 0: Error, 1: Éxito
BEGIN
    InsertarNuevoCargo(v_nuevoCargo, v_resultado);

    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Nuevo cargo insertado exitosamente: ' || v_nuevoCargo);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error en la inserción del nuevo cargo.');
    END IF;
END;
/


--SP ACTUALIZAR CARGO---


--SP para  actualizar un cargo--

CREATE OR REPLACE PROCEDURE ActualizarCargo(
    p_idCargo IN NUMBER,
    p_nuevoCargo IN VARCHAR2,
    p_resultado OUT NUMBER
)
IS
BEGIN
    UPDATE cargo
    SET cargo = p_nuevoCargo
    WHERE idCargo = p_idCargo;

    COMMIT;

    p_resultado := SQL%ROWCOUNT; 
END ActualizarCargo;
/

DECLARE
    v_idCargo NUMBER := 5; -- Reemplaza con el ID del cargo que deseas actualizar
    v_nuevoCargo VARCHAR2(30) := 'pelo'; -- Reemplaza con el nuevo nombre del cargo
    v_resultado NUMBER := 0; -- 0: No se actualizó, >0: Éxito
BEGIN
    ActualizarCargo(v_idCargo, v_nuevoCargo, v_resultado);

    IF v_resultado > 0 THEN
        DBMS_OUTPUT.PUT_LINE('Cargo actualizado exitosamente: ' || v_nuevoCargo);
    -- Elimina la siguiente parte para que no se muestre el mensaje de error
     --ELSE
    --     DBMS_OUTPUT.PUT_LINE('Error en la actualización del cargo o el cargo no existe.');
    END IF;
END;
/


SELECT * FROM CARGO;


--SP PARA ELIMINAR CARGO--

--SP para  Eliminar un cargo--

CREATE OR REPLACE PROCEDURE EliminarCargoPorID(
    p_idCargo IN NUMBER,
    p_resultado OUT NUMBER
)
IS
BEGIN
    DELETE FROM cargo WHERE idCargo = p_idCargo;
    
    COMMIT;
    
    p_resultado := SQL%ROWCOUNT; -- Indicar el número de filas afectadas por la eliminación
END EliminarCargoPorID;
/

DECLARE
    v_idCargo NUMBER := 5; -- Reemplaza con el ID del cargo que deseas eliminar
    v_resultado NUMBER := 0; -- 0: No se eliminó, >0: Éxito
BEGIN
    EliminarCargoPorID(v_idCargo, v_resultado);

    IF v_resultado > 0 THEN
        DBMS_OUTPUT.PUT_LINE('Cargo eliminado exitosamente.');
   -- ELSE
        --DBMS_OUTPUT.PUT_LINE('Error en la eliminación del cargo o el cargo no existe.');
    END IF;
END;
/


--SP PARA BUSCAR UN CARGO POR ID--




--SP para  buscar un cargo por su ID--

CREATE OR REPLACE PROCEDURE BuscarCargoPorID(
    p_idCargo IN NUMBER,
    p_nombreCargo OUT VARCHAR2,
    p_resultado OUT NUMBER
)
IS
BEGIN
    SELECT cargo
    INTO p_nombreCargo
    FROM cargo
    WHERE idCargo = p_idCargo;

    p_resultado := 1; -- Indicar que la búsqueda fue exitosa
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- Indicar que no se encontró el cargo
        p_nombreCargo := NULL; -- Establecer a NULL en caso de no encontrar el cargo
    WHEN OTHERS THEN
        p_resultado := 9; -- Indicar un error
        p_nombreCargo := NULL;
        DBMS_OUTPUT.PUT_LINE('Error en BuscarCargoPorID: ' || SQLERRM);
END BuscarCargoPorID;
/


DECLARE
    v_idCargo NUMBER := 1; -- Reemplaza con el ID del cargo que deseas buscar
    v_nombreCargo VARCHAR2(30);
    v_resultado NUMBER := 0; -- 0: No se encontró, 1: Éxito, 9: Error
BEGIN
    BuscarCargoPorID(v_idCargo, v_nombreCargo, v_resultado);

    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Cargo encontrado exitosamente: ' || v_nombreCargo);
    ELSIF v_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Cargo no encontrado.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error en la búsqueda del cargo.');
    END IF;
END;
/




-----------------------SP DE SERVICIOS----------------------------
---SP  para obtener un servicio por su ID--

CREATE OR REPLACE PROCEDURE GetServicioPorID(
    p_idServicio IN NUMBER,
    p_nombre OUT VARCHAR2,
    p_descripcion OUT VARCHAR2,
    p_resultado OUT NUMBER
)
IS
BEGIN
    SELECT servicio, descripcion
    INTO p_nombre, p_descripcion
    FROM servicios
    WHERE idServicio = p_idServicio;

    p_resultado := 1; -- Indicar que la búsqueda fue exitosa
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- Indicar que no se encontró el servicio
        p_nombre := NULL; -- Establecer a NULL en caso de no encontrar el servicio
        p_descripcion := NULL;
    WHEN OTHERS THEN
        p_resultado := 9; -- Indicar un error
        p_nombre := NULL;
        p_descripcion := NULL;
        DBMS_OUTPUT.PUT_LINE('Error en GetServicioPorID: ' || SQLERRM);
END GetServicioPorID;
/
DECLARE
    v_idServicio NUMBER := 2; -- Reemplaza con el ID del servicio que deseas buscar
    v_nombreServicio VARCHAR2(30);
    v_descripcionServicio VARCHAR2(100);
    v_resultado NUMBER := 0; -- 0: No se encontró, 1: Éxito, 9: Error
BEGIN
    GetServicioPorID(v_idServicio, v_nombreServicio, v_descripcionServicio, v_resultado);

    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Servicio encontrado exitosamente: ' || v_nombreServicio || ', Descripción: ' || v_descripcionServicio);
    ELSIF v_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Servicio no encontrado.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error en la búsqueda del servicio.');
    END IF;

    -- Comprobación adicional para verificar el resultado
    IF SQL%FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Búsqueda realizada correctamente.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error en la búsqueda.');
    END IF;
END;
/


-- SP para obtener todos los servicios--
CREATE OR REPLACE PROCEDURE GetServicios(
    p_resultado OUT SYS_REFCURSOR
)
IS
BEGIN
    OPEN p_resultado FOR
    SELECT * FROM servicios;
END GetServicios;
/

DECLARE
    v_resultado SYS_REFCURSOR;
    v_servicio servicios%ROWTYPE;
BEGIN
    GetServicios(v_resultado);

    LOOP
        FETCH v_resultado INTO v_servicio;
        EXIT WHEN v_resultado%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Servicio: ' || v_servicio.idServicio);
        DBMS_OUTPUT.PUT_LINE('Nombre del Servicio: ' || v_servicio.servicio);
        DBMS_OUTPUT.PUT_LINE('Descripción del Servicio: ' || v_servicio.descripcion);
    END LOOP;

    CLOSE v_resultado;

    -- Comprobación adicional para verificar el resultado
    IF SQL%FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Obtención de servicios realizada correctamente.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error en la obtención de servicios.');
    END IF;
END;
/


--SP PARA INSERTAR UN SERVICIO
--SP para insertar un nuevo servicio--  

CREATE OR REPLACE PROCEDURE InsertarNuevoServicio(
    p_servicio IN VARCHAR2,
    p_descripcion IN VARCHAR2,
    p_resultado OUT VARCHAR2
)
IS
    v_filas_afectadas NUMBER;
BEGIN
    INSERT INTO servicios (servicio, descripcion)
    VALUES (p_servicio, p_descripcion);

    v_filas_afectadas := SQL%ROWCOUNT; -- Número de filas afectadas por la inserción

    IF v_filas_afectadas = 1 THEN
        COMMIT;
        p_resultado := 'Éxito: Servicio insertado correctamente.';
    ELSE
        ROLLBACK;
        p_resultado := 'Error: No se pudo insertar el servicio.';
        DBMS_OUTPUT.PUT_LINE('Error en InsertarNuevoServicio: No se pudo insertar el servicio.');
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        p_resultado := 'Error: ' || SQLERRM;
        DBMS_OUTPUT.PUT_LINE('Error en InsertarNuevoServicio: ' || SQLERRM);
END InsertarNuevoServicio;
/


DECLARE
    v_nombreServicio VARCHAR2(30) := 'Adoptación'; -- Reemplaza con el nombre del nuevo servicio
    v_descripcionServicio VARCHAR2(100) := 'Adoptar una mascota'; -- Reemplaza con la descripción del nuevo servicio
    v_resultado VARCHAR2(100); -- Mensaje de resultado
BEGIN
    InsertarNuevoServicio(v_nombreServicio, v_descripcionServicio, v_resultado);

    DBMS_OUTPUT.PUT_LINE(v_resultado);
END;
/


--SP PARA ACTUALIZAR UN SERVICIO--

--SP para actualizar un servicio--
CREATE OR REPLACE PROCEDURE UpdateServicio(
    p_idServicio IN NUMBER,
    p_nuevoServicio IN VARCHAR2,
    p_nuevaDescripcion IN VARCHAR2,
    p_resultado OUT VARCHAR2
)
IS
    v_filas_afectadas NUMBER;
BEGIN
    UPDATE servicios
    SET servicio = p_nuevoServicio, descripcion = p_nuevaDescripcion
    WHERE idServicio = p_idServicio;

    v_filas_afectadas := SQL%ROWCOUNT; -- Número de filas afectadas por la actualización

    IF v_filas_afectadas = 1 THEN
        COMMIT;
        p_resultado := 'Éxito: Servicio actualizado correctamente.';
    ELSE
        ROLLBACK;
        p_resultado := 'Error: No se pudo actualizar el servicio.';
        DBMS_OUTPUT.PUT_LINE('Error en UpdateServicio: No se pudo actualizar el servicio.');
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        p_resultado := 'Error: ' || SQLERRM;
        DBMS_OUTPUT.PUT_LINE('Error en UpdateServicio: ' || SQLERRM);
END UpdateServicio;
/


DECLARE
    v_idServicio NUMBER := 5; -- Reemplaza con el ID del servicio que deseas actualizar
    v_nuevoServicio VARCHAR2(30) := 'Compra'; -- Reemplaza con el nuevo nombre del servicio
    v_nuevaDescripcion VARCHAR2(100) := 'Comprar una mascota'; -- Reemplaza con la nueva descripción del servicio
    v_resultado VARCHAR2(100); -- Mensaje de resultado
BEGIN
    UpdateServicio(v_idServicio, v_nuevoServicio, v_nuevaDescripcion, v_resultado);

    DBMS_OUTPUT.PUT_LINE(v_resultado);
END;
/


SELECT * FROM SERVICIOS;


--SP PARA ELIMINAR UN SERVICIO--


--SP para eliminar un servicio por su ID--

CREATE OR REPLACE PROCEDURE DeleteServicio(
    p_idServicio IN NUMBER,
    p_resultado OUT VARCHAR2
)
IS
    v_filas_afectadas NUMBER;
BEGIN
    DELETE FROM servicios
    WHERE idServicio = p_idServicio;

    v_filas_afectadas := SQL%ROWCOUNT; -- Número de filas afectadas por la eliminación

    IF v_filas_afectadas = 1 THEN
        COMMIT;
        p_resultado := 'Éxito: Servicio eliminado correctamente.';
    ELSE
        ROLLBACK;
        p_resultado := 'Error: No se pudo eliminar el servicio.';
        DBMS_OUTPUT.PUT_LINE('Error en DeleteServicio: No se pudo eliminar el servicio.');
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        p_resultado := 'Error: ' || SQLERRM;
        DBMS_OUTPUT.PUT_LINE('Error en DeleteServicio: ' || SQLERRM);
END DeleteServicio;
/

DECLARE
    v_idServicio NUMBER := 5; 
    v_resultado VARCHAR2(100); 
BEGIN
    DeleteServicio(v_idServicio, v_resultado);

    DBMS_OUTPUT.PUT_LINE(v_resultado);
END;
/


--SP PARA BUSCAR UN SERVICIO--


--SP para buscar un servicio por su ID--
CREATE OR REPLACE PROCEDURE BuscarServicios(
    p_searchTerm IN VARCHAR2,
    p_resultado OUT SYS_REFCURSOR,
    p_resultadoBusqueda OUT VARCHAR2
)
IS
BEGIN
    OPEN p_resultado FOR
    SELECT * FROM servicios
    WHERE servicio LIKE '%' || p_searchTerm || '%' OR descripcion LIKE '%' || p_searchTerm || '%';

    IF p_resultado%ISOPEN THEN
        p_resultadoBusqueda := 'Éxito: Búsqueda de servicios realizada correctamente.';
    ELSE
        p_resultadoBusqueda := 'Error: No se pudo realizar la búsqueda de servicios.';
        DBMS_OUTPUT.PUT_LINE('Error en BuscarServicios: No se pudo abrir el cursor.');
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        p_resultadoBusqueda := 'Error: ' || SQLERRM;
        DBMS_OUTPUT.PUT_LINE('Error en BuscarServicios: ' || SQLERRM);
END BuscarServicios;
/
DECLARE
    v_searchTerm VARCHAR2(50) := 'Cirugía';
    v_resultado SYS_REFCURSOR;
    v_resultadoBusqueda VARCHAR2(100); 
    v_servicio servicios%ROWTYPE;
BEGIN
    BuscarServicios(v_searchTerm, v_resultado, v_resultadoBusqueda);

    DBMS_OUTPUT.PUT_LINE(v_resultadoBusqueda);

    IF v_resultadoBusqueda LIKE 'Éxito%' THEN
        LOOP
            FETCH v_resultado INTO v_servicio;
            EXIT WHEN v_resultado%NOTFOUND;

            DBMS_OUTPUT.PUT_LINE('Nombre del Servicio: ' || v_servicio.servicio);
        END LOOP;
    END IF;

    CLOSE v_resultado;
END;
/


SELECT * FROM SERVICIOS;



























