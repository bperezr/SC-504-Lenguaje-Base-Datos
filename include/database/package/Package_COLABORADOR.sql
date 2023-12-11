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
PROCEDURE buscarColaboradores(
    p_searchTerm IN VARCHAR2,
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE deleteColaborador(
    p_idColaborador IN colaborador.idColaborador%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE getColaborador(
    p_idColaborador IN colaborador.idColaborador%TYPE,
    p_nombre OUT colaborador.nombre%TYPE,
    p_apellido1 OUT colaborador.apellido1%TYPE,
    p_apellido2 OUT colaborador.apellido2%TYPE,
    p_idCargo OUT colaborador.idCargo%TYPE,
    p_idEspecialidad OUT colaborador.idEspecialidad%TYPE,
    p_imagen OUT colaborador.imagen%TYPE,
    p_correo OUT colaborador.correo%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE getColaboradores(
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP7
PROCEDURE getColaboradorPorCorreo(
    p_correo IN VARCHAR2,
    p_colaborador OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP8
PROCEDURE updateColaborador(
    p_idColaborador IN colaborador.idColaborador%TYPE,
    p_nombre IN colaborador.nombre%TYPE,
    p_apellido1 IN colaborador.apellido1%TYPE,
    p_apellido2 IN colaborador.apellido2%TYPE,
    p_idCargo IN colaborador.idCargo%TYPE,
    p_idEspecialidad IN colaborador.idEspecialidad%TYPE,
    p_imagen IN colaborador.imagen%TYPE,
    p_correo IN colaborador.correo%TYPE,
    p_idRol IN colaborador.idRol%TYPE,
    p_resultado OUT NUMBER
);
--SP9
PROCEDURE getRoles(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP10
PROCEDURE insertColaborador(
    p_nombre IN colaborador.nombre%TYPE,
    p_apellido1 IN colaborador.apellido1%TYPE,
    p_apellido2 IN colaborador.apellido2%TYPE,
    p_idCargo IN colaborador.idCargo%TYPE,
    p_idEspecialidad IN colaborador.idEspecialidad%TYPE,
    p_imagen IN colaborador.imagen%TYPE,
    p_correo IN colaborador.correo%TYPE,
    p_contrasena IN VARCHAR2, 
    p_idRol IN colaborador.idRol%TYPE,
    p_resultado OUT NUMBER
);
--SP11
PROCEDURE verificarCorreoExistente (
    p_correo IN VARCHAR2,
    p_resultado OUT NUMBER
);
--SP12
PROCEDURE buscarcolaboradores(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
);
--SP13
PROCEDURE getMedicosPorServicio(
    p_idServicio IN NUMBER,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP14
PROCEDURE getColaboradorPorCorreo(
    p_correo IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP15
PROCEDURE getColaboradoresEspecialidad(
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP16
PROCEDURE getServiciosPorColaborador(
    p_idColaborador IN NUMBER,
    p_servicios OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP17
PROCEDURE deleteColaboradorServicio (
    p_idServicio IN colaboradorservicio.idServicio%TYPE,
    p_idColaborador IN colaboradorservicio.idColaborador%TYPE,
    p_resultado OUT NUMBER
);
--SP18
PROCEDURE insertColaboradorServicio (
    p_idServicio IN colaboradorservicio.idServicio%TYPE,
    p_idColaborador IN colaboradorservicio.idColaborador%TYPE,
    p_resultado OUT NUMBER
);
--SP19
PROCEDURE getServiciosNoAsignados (
    p_idColaborador IN NUMBER,
    p_resultado OUT NUMBER,
    p_servicios OUT SYS_REFCURSOR
);
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
PROCEDURE buscarColaboradores(
    p_searchTerm IN VARCHAR2,
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
    v_searchTerm_lower VARCHAR2(50);
BEGIN
    -- Convertir el término de búsqueda a minúsculas
    v_searchTerm_lower := LOWER(p_searchTerm);

    -- Mensajes de depuración
    DBMS_OUTPUT.PUT_LINE('Término de búsqueda: ' || v_searchTerm_lower);

    OPEN p_colaboradores FOR
    SELECT c.*, ca.cargo, e.especialidad
    FROM colaborador c
    INNER JOIN cargo ca ON c.idCargo = ca.idCargo
    INNER JOIN especialidad e ON c.idEspecialidad = e.idEspecialidad
    WHERE LOWER(c.nombre) LIKE '%' || v_searchTerm_lower || '%'
        OR LOWER(c.apellido1) LIKE '%' || v_searchTerm_lower || '%'
        OR LOWER(c.apellido2) LIKE '%' || v_searchTerm_lower || '%';

    -- Mensajes de depuración
    DBMS_OUTPUT.PUT_LINE('Número de filas encontradas: ' || SQL%ROWCOUNT);

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontraron colaboradores
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        -- Mensajes de depuración
        DBMS_OUTPUT.PUT_LINE('Error en el procedimiento buscarColaboradores: ' || SQLERRM);
        p_resultado := 9; -- Otro error

END;
--SP4----------------------------------------------------------------------------
PROCEDURE deleteColaborador(
    p_idColaborador IN colaborador.idColaborador%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    -- Eliminar al colaborador
    DELETE FROM colaborador
    WHERE idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- No se encontró el colaborador
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE;
        DBMS_OUTPUT.PUT_LINE('Error en deleteEvento: ' || SQLERRM);

END;
--SP5----------------------------------------------------------------------------
PROCEDURE getColaborador(
    p_idColaborador IN colaborador.idColaborador%TYPE,
    p_nombre OUT colaborador.nombre%TYPE,
    p_apellido1 OUT colaborador.apellido1%TYPE,
    p_apellido2 OUT colaborador.apellido2%TYPE,
    p_idCargo OUT colaborador.idCargo%TYPE,
    p_idEspecialidad OUT colaborador.idEspecialidad%TYPE,
    p_imagen OUT colaborador.imagen%TYPE,
    p_correo OUT colaborador.correo%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo
    INTO p_nombre, p_apellido1, p_apellido2, p_idCargo, p_idEspecialidad, p_imagen, p_correo
    FROM colaborador
    WHERE idColaborador = p_idColaborador;

    p_resultado := 0; -- Encontrado
EXCEPTION
WHEN NO_DATA_FOUND THEN
    p_resultado := SQLCODE; -- No se encontró
    DBMS_OUTPUT.PUT_LINE('Error en getColaborador: ' || SQLERRM);
WHEN OTHERS THEN
    p_resultado := SQLCODE; -- Error
    DBMS_OUTPUT.PUT_LINE('Error en getColaborador: ' || SQLERRM);
END;
--SP6----------------------------------------------------------------------------
PROCEDURE getColaboradores(
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_colaboradores FOR
        SELECT c.idColaborador,
            c.nombre,
            c.apellido1,
            c.apellido2,
            car.cargo as nombreCargo,
            esp.especialidad as nombreEspecialidad,
            c.imagen,
            c.correo
        FROM colaborador c
        LEFT JOIN cargo car ON c.idCargo = car.idCargo
        LEFT JOIN especialidad esp ON c.idEspecialidad = esp.idEspecialidad;

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradores: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradores: ' || SQLERRM);
END;
--SP7----------------------------------------------------------------------------
PROCEDURE getColaboradorPorCorreo(
    p_correo IN VARCHAR2,
    p_colaborador OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_colaborador FOR
    SELECT nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, idRol, correo
    FROM colaborador
    WHERE correo = p_correo;

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
END;
--SP8----------------------------------------------------------------------------
PROCEDURE updateColaborador(
    p_idColaborador IN colaborador.idColaborador%TYPE,
    p_nombre IN colaborador.nombre%TYPE,
    p_apellido1 IN colaborador.apellido1%TYPE,
    p_apellido2 IN colaborador.apellido2%TYPE,
    p_idCargo IN colaborador.idCargo%TYPE,
    p_idEspecialidad IN colaborador.idEspecialidad%TYPE,
    p_imagen IN colaborador.imagen%TYPE,
    p_correo IN colaborador.correo%TYPE,
    p_idRol IN colaborador.idRol%TYPE,
    p_resultado OUT NUMBER
) AS
    v_contr_hash RAW(2000);
BEGIN

    -- Construye la consulta de actualización
    UPDATE colaborador
    SET
        nombre = p_nombre,
        apellido1 = p_apellido1,
        apellido2 = p_apellido2,
        idCargo = p_idCargo,
        idEspecialidad = p_idEspecialidad,
        imagen = p_imagen,
        correo = p_correo,
        idRol = p_idRol
    WHERE idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- No se encontró el colaborador
        DBMS_OUTPUT.PUT_LINE('No se encontró el colaborador con ID ' || p_idColaborador);
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en la actualización del colaborador: ' || SQLERRM);
END;
--SP9----------------------------------------------------------------------------
PROCEDURE getRoles(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
p_resultado := 0;

OPEN p_cursor FOR
    SELECT idRol, nombreRol
    FROM rol;

p_resultado := 1; -- Encontrado

EXCEPTION
WHEN NO_DATA_FOUND THEN
    p_resultado := 0; -- No se encontró
    DBMS_OUTPUT.PUT_LINE('Error en getRoles: ' || SQLERRM);
WHEN OTHERS THEN
    p_resultado := 9; -- Error
    DBMS_OUTPUT.PUT_LINE('Error en getRoles: ' || SQLERRM);
END;
--SP10----------------------------------------------------------------------------
PROCEDURE insertColaborador(
    p_nombre IN colaborador.nombre%TYPE,
    p_apellido1 IN colaborador.apellido1%TYPE,
    p_apellido2 IN colaborador.apellido2%TYPE,
    p_idCargo IN colaborador.idCargo%TYPE,
    p_idEspecialidad IN colaborador.idEspecialidad%TYPE,
    p_imagen IN colaborador.imagen%TYPE,
    p_correo IN colaborador.correo%TYPE,
    p_contrasena IN VARCHAR2, 
    p_idRol IN colaborador.idRol%TYPE,
    p_resultado OUT NUMBER
) AS
    v_contr_hash RAW(128); -- Usar RAW(128) para almacenar el hash

BEGIN
    -- Genera el hash de la contraseña
    v_contr_hash := DBMS_CRYPTO.HASH(
        src => UTL_RAW.CAST_TO_RAW(p_contrasena),
        typ => DBMS_CRYPTO.HASH_SH256
    );

    INSERT INTO colaborador (
        nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo, contrasena, idRol
    ) VALUES (
        p_nombre, p_apellido1, p_apellido2, p_idCargo, p_idEspecialidad, p_imagen, p_correo, v_contr_hash, p_idRol
    );

    p_resultado := SQLCODE; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertColaborador: ' || SQLERRM);
END;
--SP11----------------------------------------------------------------------------
PROCEDURE verificarCorreoExistente (
    p_correo IN VARCHAR2,
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT COUNT(*) INTO p_resultado
    FROM colaborador
    WHERE correo = p_correo;

    p_resultado := CASE WHEN p_resultado > 0 THEN 1 ELSE 0 END;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := -1; -- Error
END;
--SP12----------------------------------------------------------------------------
PROCEDURE buscarcolaboradores(
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
) AS
BEGIN
    -- Primera consulta para contar las filas
    SELECT COUNT(*) INTO p_numFilas
    FROM colaborador
    WHERE LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(apellido1) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(apellido2) LIKE LOWER('%' || p_searchTerm || '%');

    -- Segunda consulta para obtener los datos
    OPEN p_cursor FOR
        SELECT idColaborador, nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo, contrasena, idRol
        FROM colaborador
        WHERE LOWER(nombre) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(apellido1) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(apellido2) LIKE LOWER('%' || p_searchTerm || '%');

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
--SP13----------------------------------------------------------------------------
PROCEDURE getMedicosPorServicio(
    p_idServicio IN NUMBER,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
)
IS
BEGIN
    p_resultado := 0; -- Éxito inicial

    OPEN p_cursor FOR
    SELECT c.idColaborador, c.nombre, c.apellido1, c.apellido2
    FROM colaborador c
    INNER JOIN colaboradorservicio cs ON c.idColaborador = cs.idColaborador
    WHERE cs.idServicio = p_idServicio;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
END;
--SP14----------------------------------------------------------------------------
PROCEDURE getColaboradorPorCorreo(
    p_correo IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT * FROM colaborador WHERE correo = p_correo;
        
    p_resultado := 0; -- Éxito

    EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- No se encontraron datos
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradorPorCorreo: ' || SQLERRM);
END;
--SP15----------------------------------------------------------------------------
PROCEDURE getColaboradoresEspecialidad(
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_colaboradores FOR
        SELECT c.idColaborador,
            c.nombre,
            c.apellido1,
            c.apellido2,
            car.cargo as nombreCargo,
            esp.especialidad as nombreEspecialidad,
            c.imagen,
            c.correo
        FROM colaborador c
        LEFT JOIN cargo car ON c.idCargo = car.idCargo
        LEFT JOIN especialidad esp ON c.idEspecialidad = esp.idEspecialidad
        WHERE c.idEspecialidad IN (1, 2, 3, 4);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradoresEspecialidad: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradoresEspecialidad: ' || SQLERRM);
END;
--SP16----------------------------------------------------------------------------
PROCEDURE getServiciosPorColaborador(
    p_idColaborador IN NUMBER,
    p_servicios OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_servicios FOR
        SELECT s.idServicio,
            s.servicio,
            s.descripcion
        FROM colaboradorservicio cs
        JOIN servicios s ON cs.idServicio = s.idServicio
        WHERE cs.idColaborador = p_idColaborador;

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
        DBMS_OUTPUT.PUT_LINE('Error en getServiciosPorColaborador: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en getServiciosPorColaborador: ' || SQLERRM);
END;
--SP17------------------------------------------------------------------------
PROCEDURE deleteColaboradorServicio (
    p_idServicio IN colaboradorservicio.idServicio%TYPE,
    p_idColaborador IN colaboradorservicio.idColaborador%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    -- Eliminar la asociación del colaborador con el servicio
    DELETE FROM colaboradorservicio
    WHERE idServicio = p_idServicio AND idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 0; -- Éxito
    ELSE
        p_resultado := SQLCODE; -- No se encontró la asociación
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE;
        DBMS_OUTPUT.PUT_LINE('Error en deleteColaboradorServicio: ' || SQLERRM);
END;
--SP18------------------------------------------------------------------------
PROCEDURE insertColaboradorServicio (
    p_idServicio IN colaboradorservicio.idServicio%TYPE,
    p_idColaborador IN colaboradorservicio.idColaborador%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO colaboradorservicio (idServicio, idColaborador)
    VALUES (p_idServicio, p_idColaborador);

    p_resultado := SQLCODE; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertColaboradorServicio: ' || SQLERRM);
END;
--SP19------------------------------------------------------------------------
PROCEDURE getServiciosNoAsignados (
    p_idColaborador IN NUMBER,
    p_resultado OUT NUMBER,
    p_servicios OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_servicios FOR
    SELECT s.IDSERVICIO, s.SERVICIO
    FROM servicios s
    WHERE s.IDSERVICIO NOT IN (
        SELECT cs.IDSERVICIO
        FROM colaboradorservicio cs
        WHERE cs.IDCOLABORADOR = p_idColaborador
    );

    p_resultado := 0; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getServiciosNoAsignados: ' || SQLERRM);
        p_servicios := NULL;
END;
END P_COLABORADOR;
--#########################################################################################################