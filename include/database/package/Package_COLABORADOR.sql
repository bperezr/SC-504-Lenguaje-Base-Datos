--Drop PACKAGE P_COLABORADOR;

--COLABORADOR
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_COLABORADOR
AS

--------------------- SP ---------------------
--SP1

--SP2

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
p_resultado OUT NUMBER);


--SP10
PROCEDURE insertColaborador(
     p_nombre IN colaborador.nombre%TYPE,
    p_apellido1 IN colaborador.apellido1%TYPE,
    p_apellido2 IN colaborador.apellido2%TYPE,
    p_idCargo IN colaborador.idCargo%TYPE,
    p_idEspecialidad IN colaborador.idEspecialidad%TYPE,
    p_imagen IN colaborador.imagen%TYPE,
    p_correo IN colaborador.correo%TYPE,
    p_contrasena IN VARCHAR2, -- No hay un tipo equivalente en la tabla, deberás ajustarlo según tus necesidades
    p_idRol IN colaborador.idRol%TYPE,
    p_resultado OUT NUMBER
  );
  
--SP11
PROCEDURE verificarCorreoExistente (
    p_correo IN VARCHAR2,
    p_resultado OUT NUMBER
) ;


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

    END buscarColaboradores;
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
    
    END deleteColaborador;
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
    END getColaborador;

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
END getColaboradores;

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
    END getColaboradorPorCorreo;
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
    END updateColaborador;
--SP9----------------------------------------------------------------------------

PROCEDURE getRoles(p_cursor OUT SYS_REFCURSOR, p_resultado OUT NUMBER) AS
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
END getRoles;
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
  v_contr_hash RAW(2000);
BEGIN
  -- Genera el hash de la contraseña
  v_contr_hash := DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(p_contrasena), DBMS_CRYPTO.HASH_SH1);

  INSERT INTO colaborador (
    nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo, contrasena, idRol
  ) VALUES (
    p_nombre, p_apellido1, p_apellido2, p_idCargo, p_idEspecialidad, p_imagen, p_correo, v_contr_hash, p_idRol
  );

  p_resultado := 1; -- Éxito

EXCEPTION
  WHEN OTHERS THEN
    p_resultado := 0; -- Error
    DBMS_OUTPUT.PUT_LINE('Error en insertColaborador: ' || SQLERRM);
END insertColaborador;
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
END verificarCorreoExistente;
--FIN SP------------------------------------------------------------------------
END P_COLABORADOR;
--#########################################################################################################