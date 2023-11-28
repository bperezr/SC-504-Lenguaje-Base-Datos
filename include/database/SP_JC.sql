--******TABLA MASCOTA ******
--Se inicia una secuencia para crea runa llave autoincremental
-- Sin la llave autoincremental dar�a errores el insertar sin tener que asignarle manualmente el ID
CREATE SEQUENCE IDMASCOTASECUENCIA
   START WITH 18
   INCREMENT BY 1
   NOCACHE;

-- Se crea un trigger para que la llave de MASCOTA sea AutoIncremental
CREATE OR REPLACE TRIGGER mascota_IDAutoIncrementTrigger
BEFORE INSERT ON MASCOTA
FOR EACH ROW
BEGIN
   SELECT IDMASCOTASECUENCIA.NEXTVAL INTO :NEW.IDMASCOTA FROM DUAL;
END;
/


--SP INSERTAR MASCOTA
CREATE OR REPLACE PROCEDURE insertarMascota(
    p_NOMBRE IN VARCHAR2,
    p_DESCRIPCION IN VARCHAR2,
    p_IDTIPOMASCOTA IN NUMBER,
    p_IDCLIENTE IN NUMBER,
    p_IMAGEN IN VARCHAR2
)
AS
BEGIN
    INSERT INTO mascota (NOMBRE, DESCRIPCION, IDTIPOMASCOTA, IDCLIENTE, IMAGEN)
    VALUES (p_NOMBRE, p_DESCRIPCION, p_IDTIPOMASCOTA, p_IDCLIENTE, p_IMAGEN);
    
    COMMIT; -- Confirmar la transacci�n
END insertarMascota;
/


--------------------------------------------------------
-- SP para getmascota

CREATE OR REPLACE PROCEDURE GETMASCOTA(
    V_IdMascota IN NUMBER,
    V_Nombre OUT VARCHAR2,
    V_Descripcion OUT VARCHAR2,
    V_IdTipoMascota OUT NUMBER,
    V_IdCliente OUT NUMBER,
    V_Imagen OUT VARCHAR2,
    V_Resultado OUT NUMBER
)
AS
BEGIN
    SELECT Nombre, Descripcion, IdTipoMascota, IdCliente, Imagen
    INTO V_Nombre, V_Descripcion, V_IdTipoMascota, V_IdCliente, V_Imagen
    FROM Mascota
    WHERE IDMASCOTA = V_IdMascota;

    V_Resultado := 1;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        V_Resultado := 0;
END OBTENERMASCOTAPORID;
/



--------------------------------------------------------

-- SP OBTENER MASCOTA POR IDCLIENTE 

CREATE OR REPLACE PROCEDURE GETMASCOTAPORCLIENTE(
    V_IdCliente IN NUMBER,
    V_Cursor OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN V_Cursor FOR
        SELECT IDMASCOTA, Nombre, Descripcion, IdTipoMascota, Imagen
        FROM Mascota
        WHERE IDCLIENTE = V_IdCliente;
END GETMASCOTAPORCLIENTE;
/


--------------------------------------------------------

-- SP ACTUALIZAR MASCOTA 

CREATE OR REPLACE PROCEDURE UPDATEMASCOTA(
    V_IdMascota IN NUMBER,
    V_NuevoNombre IN VARCHAR2,
    V_NuevaDescripcion IN VARCHAR2,
    V_NuevoIdTipoMascota IN NUMBER,
    V_NuevaImagen IN VARCHAR2,
    V_Resultado OUT NUMBER
)
AS
BEGIN
    UPDATE Mascota
    SET
        Nombre = V_NuevoNombre,
        Descripcion = V_NuevaDescripcion,
        IdTipoMascota = V_NuevoIdTipoMascota,
        Imagen = V_NuevaImagen
    WHERE IDMASCOTA = V_IdMascota;

    V_Resultado := SQL%ROWCOUNT;

    IF V_Resultado > 0 THEN
        COMMIT; -- Confirmar los cambios si se actualiza al menos una fila
    ELSE
        ROLLBACK; -- Deshacer cambios si no se encuentra ninguna fila
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        V_Resultado := 0;
        ROLLBACK; -- Deshacer cambios en caso de error
END UPDATEMASCOTA;
/

--------------------------------------------------------
-- SP ELIMINARMASCOTA 
CREATE OR REPLACE PROCEDURE DELETEMASCOTA(
    V_IdMascota IN NUMBER,
    V_Resultado OUT NUMBER
)
AS
BEGIN
    DELETE FROM Mascota
    WHERE IDMASCOTA = V_IdMascota;

    V_Resultado := SQL%ROWCOUNT;

    IF V_Resultado > 0 THEN
        COMMIT; -- Confirmar los cambios si se elimina al menos una fila
    ELSE
        ROLLBACK; -- Deshacer cambios si no se encuentra ninguna fila
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        V_Resultado := 0;
        ROLLBACK; -- Deshacer cambios en caso de error
END DELETEMASCOTA;
/



--******TABLA TIPOMASCOTA ******

-- SP OBTENER_TIPO_MASCOTA_POR_ID

CREATE OR REPLACE PROCEDURE GETTIPOMASCOTA(
    V_IdTipoMascota IN TIPOMASCOTA.IDTIPOMASCOTA%TYPE,
    V_Tipo OUT TIPOMASCOTA.TIPO%TYPE
)
AS
BEGIN
    SELECT TIPO
    INTO V_Tipo
    FROM TIPOMASCOTA
    WHERE IDTIPOMASCOTA = V_IdTipoMascota;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        V_Tipo := NULL; 
END GETTIPOMASCOTA;
/


--------------------------------------------------------

-- SP OBTENER_TIPOS_MASCOTAS
CREATE OR REPLACE PROCEDURE GETTIPOMASCOTAS(
    V_Cursor OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN V_Cursor FOR
        SELECT IDTIPOMASCOTA, TIPO
        FROM TIPOMASCOTA;
END GETTIPOMASCOTAS;
/

--------------------------------------------------------
-- SP INSERTAR_TIPO_MASCOTA

CREATE OR REPLACE PROCEDURE INSERTTIPOMASCOTA(
    V_Tipo IN VARCHAR2,
    V_IdTipoMascota OUT NUMBER,
    V_Resultado OUT NUMBER
)
AS
BEGIN
    SELECT IDTIPOMASCOTASECUENCIA.NEXTVAL
    INTO V_IdTipoMascota
    FROM DUAL;

    INSERT INTO TIPOMASCOTA (IDTIPOMASCOTA, TIPO)
    VALUES (V_IdTipoMascota, V_Tipo);

    V_Resultado := 1;
EXCEPTION
    WHEN OTHERS THEN
        V_Resultado := 0;
END INSERTTIPOMASCOTA;
/
--------------------------------------------------------

---- ACTUALIZAR_TIPO_MASCOTA

CREATE OR REPLACE PROCEDURE UPDATETIPOMASCOTA(
    V_IdTipoMascota IN NUMBER,
    V_NuevoTipo IN VARCHAR2,
    V_Resultado OUT NUMBER
)
AS
BEGIN
    UPDATE TIPOMASCOTA
    SET TIPO = V_NuevoTipo
    WHERE IDTIPOMASCOTA = V_IdTipoMascota;

    IF SQL%ROWCOUNT > 0 THEN
        -- Indicar que la operaci�n fue exitosa
        V_Resultado := 1;
    ELSE
        -- Indicar que no se encontr� el tipo de mascota con el ID proporcionado
        V_Resultado := 0;
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        -- Capturar cualquier error y retornar un indicador de error
        V_Resultado := 0;
END UPDATETIPOMASCOTA;
/

--------------------------------------------------------
-- SP ELIMINAR_TIPO_MASCOTA

CREATE OR REPLACE PROCEDURE DELETETIPOMASCOTA(
    V_IdTipoMascota IN NUMBER,
    V_Resultado OUT NUMBER
)
AS
BEGIN
    DELETE FROM TIPOMASCOTA
    WHERE IDTIPOMASCOTA = V_IdTipoMascota;

    IF SQL%ROWCOUNT > 0 THEN
        -- Indicar que la operaci�n fue exitosa
        V_Resultado := 1;
    ELSE
        -- Indicar que no se encontr� el tipo de mascota con el ID proporcionado
        V_Resultado := 0;
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        -- Capturar cualquier error y retornar un indicador de error
        V_Resultado := 0;
END DELETETIPOMASCOTA;
/



/*******************************
COLABORADOR
***************************/


CREATE OR REPLACE PROCEDURE getColaborador(
  p_idColaborador IN colaborador.idColaborador%TYPE,
  p_nombre OUT colaborador.nombre%TYPE,
  p_apellido1 OUT colaborador.apellido1%TYPE,
  p_apellido2 OUT colaborador.apellido2%TYPE,
  p_idCargo OUT colaborador.idCargo%TYPE,
  p_idEspecialidad OUT colaborador.idEspecialidad%TYPE,
  p_imagen OUT colaborador.imagen%TYPE,
  p_correo OUT colaborador.correo%TYPE,
  p_resultado OUT NUMBER
)
AS
BEGIN
  SELECT nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo
  INTO p_nombre, p_apellido1, p_apellido2, p_idCargo, p_idEspecialidad, p_imagen, p_correo
  FROM colaborador
  WHERE idColaborador = p_idColaborador;

  p_resultado := 1; -- Encontrado
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    p_resultado := 0; -- No se encontró
    DBMS_OUTPUT.PUT_LINE('Error en getColaborador: ' || SQLERRM);
  WHEN OTHERS THEN
    p_resultado := 9; -- Error
    DBMS_OUTPUT.PUT_LINE('Error en getColaborador: ' || SQLERRM);
END;
/




// TEST

DECLARE
    p_idColaborador NUMBER := 1;
    p_nombre VARCHAR2(50);
    p_apellido1 VARCHAR2(50);
    p_apellido2 VARCHAR2(50);
    p_idCargo NUMBER;
    p_idEspecialidad NUMBER;
    p_imagen VARCHAR2(255);
    p_correo VARCHAR2(255);
    p_resultado NUMBER;
BEGIN
    BEGIN
        getColaborador(p_idColaborador, p_nombre, p_apellido1, p_apellido2, p_idCargo, p_idEspecialidad, p_imagen, p_correo, p_resultado);
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || p_nombre);
        DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || p_apellido1);
        DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || p_apellido2);
        DBMS_OUTPUT.PUT_LINE('ID cargo: ' || p_idCargo);
        DBMS_OUTPUT.PUT_LINE('ID especialidad: ' || p_idEspecialidad);
        DBMS_OUTPUT.PUT_LINE('Imagen: ' || p_imagen);
        DBMS_OUTPUT.PUT_LINE('Correo: ' || p_correo);
        DBMS_OUTPUT.PUT_LINE('Código de resultado: ' || p_resultado);
    EXCEPTION
        WHEN OTHERS THEN
            DBMS_OUTPUT.PUT_LINE('Error en el bloque PL/SQL: ' || SQLERRM);
    END;
END;
/

//------------------------------------------------------------------------------

CREATE OR REPLACE PROCEDURE getColaboradores(
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
)
AS
BEGIN
    OPEN p_colaboradores FOR
    SELECT
        idColaborador,
        nombre,
        apellido1,
        apellido2,
        idCargo,
        idEspecialidad,
        imagen,
        correo
    FROM colaborador;

    p_resultado := 1; -- Éxito
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradores: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradores: ' || SQLERRM);
END;
/




//-- TEST

DECLARE
    p_colaboradores SYS_REFCURSOR;
    p_resultado NUMBER;
    v_id_colaborador colaborador.idColaborador%TYPE;
    v_nombre colaborador.nombre%TYPE;
    v_apellido1 colaborador.apellido1%TYPE;
    v_apellido2 colaborador.apellido2%TYPE;
    v_id_cargo colaborador.idCargo%TYPE;
    v_id_especialidad colaborador.idEspecialidad%TYPE;
    v_imagen colaborador.imagen%TYPE;
    v_correo_colaborador colaborador.correo%TYPE;
BEGIN
    getColaboradores(p_colaboradores, p_resultado);

    -- Iterar a través de los resultados
    LOOP
        FETCH p_colaboradores INTO
            v_id_colaborador,
            v_nombre,
            v_apellido1,
            v_apellido2,
            v_id_cargo,
            v_id_especialidad,
            v_imagen,
            v_correo_colaborador;

        EXIT WHEN p_colaboradores%NOTFOUND;

        -- Puedes imprimir o utilizar los valores como necesites
        DBMS_OUTPUT.PUT_LINE('ID Colaborador: ' || v_id_colaborador);
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
        DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
        DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || v_apellido2);
        DBMS_OUTPUT.PUT_LINE('ID Cargo: ' || v_id_cargo);
        DBMS_OUTPUT.PUT_LINE('ID Especialidad: ' || v_id_especialidad);
        DBMS_OUTPUT.PUT_LINE('Imagen: ' || v_imagen);
        DBMS_OUTPUT.PUT_LINE('Correo: ' || v_correo_colaborador);
    END LOOP;

    CLOSE p_colaboradores;

    -- Imprimir el resultado del procedimiento
    DBMS_OUTPUT.PUT_LINE('Resultado del procedimiento: ' || p_resultado);
END;
/




------------------------------------------------------

CREATE OR REPLACE PROCEDURE getRoles(
    p_roles OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN p_roles FOR
    SELECT idRol, nombreRol
    FROM rol;
END;
/


//----- TEST


DECLARE
    p_roles SYS_REFCURSOR;
    v_id_rol rol.idRol%TYPE;
    v_nombre_rol rol.nombreRol%TYPE;
BEGIN
    getRoles(p_roles);

    -- Iterar a través de los resultados
    LOOP
        FETCH p_roles INTO v_id_rol, v_nombre_rol;
        EXIT WHEN p_roles%NOTFOUND;

        -- Puedes imprimir o utilizar los valores como necesites
        DBMS_OUTPUT.PUT_LINE('ID Rol: ' || v_id_rol);
        DBMS_OUTPUT.PUT_LINE('Nombre Rol: ' || v_nombre_rol);
    END LOOP;

    CLOSE p_roles;
END;
/



//--------------------------

CREATE OR REPLACE FUNCTION verificarCorreoExistente(
    p_correo IN VARCHAR2
)
RETURN NUMBER
AS
    v_count NUMBER;
    p_resultado NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_count
    FROM colaborador
    WHERE correo = p_correo;

    p_resultado := 1; -- Éxito

    RETURN v_count;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
        DBMS_OUTPUT.PUT_LINE('Error en verificarCorreoExistente: ' || SQLERRM);
        RETURN p_resultado; -- Devuelve el resultado después de manejar la excepción
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en verificarCorreoExistente: ' || SQLERRM);
        RETURN p_resultado; -- Devuelve el resultado después de manejar la excepción
END;
/





//-- TEST

DECLARE
    v_correo varchar2(255) := 'juan.moreles@happypaws.com';  -- Asigna el correo que deseas verificar
    v_count NUMBER;
BEGIN
    v_count := verificarCorreoExistente(v_correo);

    IF v_count > 0 THEN
        DBMS_OUTPUT.PUT_LINE('El correo existe en la base de datos.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('El correo NO existe en la base de datos.');
    END IF;
END;
/



//---------

CREATE OR REPLACE PROCEDURE getColaboradorPorCorreo(
    p_correo IN VARCHAR2,
    p_colaborador OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
)
AS
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
/



//------- TEST

DECLARE
    v_correo VARCHAR2(255) := 'juan.moreles@happypaws.com';
    p_colaborador SYS_REFCURSOR;
    v_nombre colaborador.nombre%TYPE;
    v_apellido1 colaborador.apellido1%TYPE;
    v_apellido2 colaborador.apellido2%TYPE;
    v_id_cargo colaborador.idCargo%TYPE;
    v_id_especialidad colaborador.idEspecialidad%TYPE;
    v_imagen colaborador.imagen%TYPE;
    v_id_rol colaborador.idRol%TYPE;
    v_correo_colaborador colaborador.correo%TYPE;
    v_resultado NUMBER;
BEGIN
    getColaboradorPorCorreo(v_correo, p_colaborador, v_resultado);

    IF v_resultado = 1 THEN
        LOOP
            FETCH p_colaborador INTO
                v_nombre,
                v_apellido1,
                v_apellido2,
                v_id_cargo,
                v_id_especialidad,
                v_imagen,
                v_id_rol,
                v_correo_colaborador;

            EXIT WHEN p_colaborador%NOTFOUND;

            DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
            DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
            DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || v_apellido2);
            DBMS_OUTPUT.PUT_LINE('ID Cargo: ' || v_id_cargo);
            DBMS_OUTPUT.PUT_LINE('ID Especialidad: ' || v_id_especialidad);
            DBMS_OUTPUT.PUT_LINE('Imagen: ' || v_imagen);
            DBMS_OUTPUT.PUT_LINE('ID Rol: ' || v_id_rol);
            DBMS_OUTPUT.PUT_LINE('Correo: ' || v_correo_colaborador);
        END LOOP;

        CLOSE p_colaborador;
    ELSE
        DBMS_OUTPUT.PUT_LINE('El procedimiento getColaboradorPorCorreo no fue exitoso. Código de resultado: ' || v_resultado);
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error en el bloque DECLARE: ' || SQLERRM);
END;
/


//----------------------------------

CREATE OR REPLACE PROCEDURE insertColaborador(
    p_idColaborador IN NUMBER,
    p_nombre IN VARCHAR2,
    p_apellido1 IN VARCHAR2,
    p_apellido2 IN VARCHAR2,
    p_idCargo IN NUMBER,
    p_idEspecialidad IN NUMBER,
    p_imagen IN VARCHAR2,
    p_correo IN VARCHAR2,
    p_contrasena IN VARCHAR2,
    p_idRol IN NUMBER,
    p_resultado OUT NUMBER
)
AS
    v_hash_raw RAW(2000);
BEGIN
    -- Genera el hash de la contraseña
    v_hash_raw := DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(p_contrasena), DBMS_CRYPTO.HASH_SH1);
    
    -- Inserta el colaborador con la contraseña hasheada
    INSERT INTO colaborador (IDColaborador, nombre, apellido1, apellido2, idCargo, idEspecialidad, imagen, correo, contrasena, idRol)
    VALUES (p_idColaborador, p_nombre, p_apellido1, p_apellido2, p_idCargo, p_idEspecialidad, p_imagen, p_correo, v_hash_raw, p_idRol);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
END;
/



//---------- TEST

DECLARE
    v_idColaborador NUMBER := 6; -- Cambia esto por un ID que no exista
    v_nombre VARCHAR2(30) := 'Nombre';
    v_apellido1 VARCHAR2(30) := 'Apellido1';
    v_apellido2 VARCHAR2(30) := 'Apellido2';
    v_idCargo NUMBER := 1;
    v_idEspecialidad NUMBER := 2;
    v_imagen VARCHAR2(400) := 'ruta_de_imagen.jpg';
    v_correo VARCHAR2(100) := 'correo_ejemplo@example.com';
    v_contrasena VARCHAR2(100) := 'contrasena123';
    v_idRol NUMBER := 3;
    v_resultado NUMBER;
BEGIN
    -- Llamada al procedimiento
    insertColaborador(
        v_idColaborador,
        v_nombre,
        v_apellido1,
        v_apellido2,
        v_idCargo,
        v_idEspecialidad,
        v_imagen,
        v_correo,
        v_contrasena,
        v_idRol,
        v_resultado
    );

    -- Evaluar el resultado
    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('El colaborador fue insertado exitosamente.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error en la inserción del colaborador.');
    END CASE;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error en el bloque DECLARE: ' || SQLERRM);
END;
/


/// updateColaborador

CREATE OR REPLACE PROCEDURE updateColaborador(
    p_idColaborador IN NUMBER,
    p_nombre IN VARCHAR2,
    p_apellido1 IN VARCHAR2,
    p_apellido2 IN VARCHAR2,
    p_idCargo IN NUMBER,
    p_idEspecialidad IN NUMBER,
    p_imagen IN VARCHAR2,
    p_correo IN VARCHAR2,
    p_contrasena IN VARCHAR2,
    p_idRol IN NUMBER,
    p_resultado OUT NUMBER
)
AS
    v_contr_hash RAW(2000);
BEGIN
    -- Si se proporciona una nueva contraseña, genera el hash de la misma
    IF p_contrasena IS NOT NULL THEN
        v_contr_hash := DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(p_contrasena), DBMS_CRYPTO.HASH_SH1);
    END IF;

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
        contrasena = NVL(v_contr_hash, contrasena), -- Actualiza la contraseña solo si se proporciona una nueva
        idRol = p_idRol
    WHERE idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró el colaborador
        DBMS_OUTPUT.PUT_LINE('No se encontró el colaborador con ID ' || p_idColaborador);
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en la actualización del colaborador: ' || SQLERRM);
END;
/



// --------------------- TEST

DECLARE
    v_idColaborador NUMBER := 6; -- Proporciona el ID del colaborador que deseas actualizar
    v_nombre VARCHAR2(30) := 'JEAN';
    v_apellido1 VARCHAR2(30) := 'NuevoApellido1';
    v_apellido2 VARCHAR2(30) := 'NuevoApellido2';
    v_idCargo NUMBER := 2;
    v_idEspecialidad NUMBER := 3;
    v_imagen VARCHAR2(400) := 'nueva_imagen.jpg';
    v_correo VARCHAR2(100) := 'nuevo_correo@example.com';
    v_contrasena VARCHAR2(100) := 'nueva_contrasena';
    v_idRol NUMBER := 2;
    v_resultado NUMBER;
BEGIN
    -- Llamada al procedimiento
    updateColaborador(
        v_idColaborador,
        v_nombre,
        v_apellido1,
        v_apellido2,
        v_idCargo,
        v_idEspecialidad,
        v_imagen,
        v_correo,
        v_contrasena,
        v_idRol,
        v_resultado
    );

    -- Evaluar el resultado
    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('El colaborador fue actualizado exitosamente.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró el colaborador.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error en la actualización del colaborador.');
    END CASE;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error en el bloque DECLARE: ' || SQLERRM);
END;
/




//----------------------

CREATE OR REPLACE PROCEDURE deleteColaborador(
    p_idColaborador IN NUMBER,
    p_resultado OUT NUMBER
)
AS
BEGIN
    -- Eliminar al colaborador
    DELETE FROM colaborador
    WHERE idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró el colaborador
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
END;
/



//------------ TEST

DECLARE
    v_idColaborador NUMBER := 6; -- Proporciona el ID del colaborador que deseas eliminar
    v_resultado NUMBER;
BEGIN
    -- Llamada al procedimiento
    deleteColaborador(v_idColaborador, v_resultado);

    -- Evaluar el resultado
    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('El colaborador fue eliminado exitosamente.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró el colaborador.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error en la eliminación del colaborador.');
    END CASE;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error en el bloque DECLARE: ' || SQLERRM);
END;
/



//------ buscarColaborador

CREATE OR REPLACE PROCEDURE buscarColaboradores(
    p_searchTerm IN VARCHAR2,
    p_colaboradores OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
)
AS
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
/

//------ TEST
-- ------ TEST
DECLARE
    v_searchTerm VARCHAR2(50) := 'ana'; -- Proporciona el término de búsqueda en minúsculas
    p_colaboradores SYS_REFCURSOR;
    v_idColaborador colaborador.idColaborador%TYPE;
    v_nombre colaborador.nombre%TYPE;
    v_apellido1 colaborador.apellido1%TYPE;
BEGIN
    -- Habilitar la salida de mensajes de depuración
    DBMS_OUTPUT.ENABLE(1000000);

    OPEN p_colaboradores FOR
    SELECT c.idColaborador, c.nombre, c.apellido1
    FROM colaborador c
    WHERE (LOWER(c.nombre) LIKE '%' || v_searchTerm || '%' OR c.nombre LIKE '%' || v_searchTerm || '%')
       OR (LOWER(c.apellido1) LIKE '%' || v_searchTerm || '%' OR c.apellido1 LIKE '%' || v_searchTerm || '%')
       OR (LOWER(c.apellido2) LIKE '%' || v_searchTerm || '%' OR c.apellido2 LIKE '%' || v_searchTerm || '%');

    LOOP
        FETCH p_colaboradores INTO
            v_idColaborador,
            v_nombre,
            v_apellido1;

        EXIT WHEN p_colaboradores%NOTFOUND;

        -- Puedes imprimir o utilizar los valores como necesites
        DBMS_OUTPUT.PUT_LINE('ID Colaborador: ' || v_idColaborador);
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
        DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
        -- Otras líneas de impresión...
    END LOOP;

    CLOSE p_colaboradores;

EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error en el bloque DECLARE: ' || SQLERRM);
END;
/


-- PACKAGE

-- PAQUETE

CREATE OR REPLACE PACKAGE paquete_colaboradores AS
    PROCEDURE buscarColaboradores(
        p_searchTerm IN VARCHAR2,
        p_colaboradores OUT SYS_REFCURSOR,
        p_resultado OUT NUMBER
    );

    PROCEDURE deleteColaborador(
        p_idColaborador IN NUMBER,
        p_resultado OUT NUMBER
    );

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

    PROCEDURE getColaboradores(
        p_colaboradores OUT SYS_REFCURSOR,
        p_resultado OUT NUMBER
    );

    PROCEDURE getColaboradorPorCorreo(
        p_correo IN VARCHAR2,
        p_colaborador OUT SYS_REFCURSOR,
        p_resultado OUT NUMBER
    );

    PROCEDURE updateColaborador(
        p_idColaborador IN NUMBER,
        p_nombre IN VARCHAR2,
        p_apellido1 IN VARCHAR2,
        p_apellido2 IN VARCHAR2,
        p_idCargo IN NUMBER,
        p_idEspecialidad IN NUMBER,
        p_imagen IN VARCHAR2,
        p_correo IN VARCHAR2,
        p_contrasena IN VARCHAR2,
        p_idRol IN NUMBER,
        p_resultado OUT NUMBER
    );
END paquete_colaboradores;
/

-- PACKAGE BODY


CREATE OR REPLACE PACKAGE BODY paquete_colaboradores AS
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

    PROCEDURE deleteColaborador(
        p_idColaborador IN NUMBER,
        p_resultado OUT NUMBER
    ) AS
BEGIN
    -- Eliminar al colaborador
    DELETE FROM colaborador
    WHERE idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró el colaborador
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
    END deleteColaborador;

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

  p_resultado := 1; -- Encontrado
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    p_resultado := 0; -- No se encontró
    DBMS_OUTPUT.PUT_LINE('Error en getColaborador: ' || SQLERRM);
  WHEN OTHERS THEN
    p_resultado := 9; -- Error
    DBMS_OUTPUT.PUT_LINE('Error en getColaborador: ' || SQLERRM);
    END getColaborador;

    PROCEDURE getColaboradores(
        p_colaboradores OUT SYS_REFCURSOR,
        p_resultado OUT NUMBER
    ) AS
BEGIN
    OPEN p_colaboradores FOR
    SELECT
        idColaborador,
        nombre,
        apellido1,
        apellido2,
        idCargo,
        idEspecialidad,
        imagen,
        correo
    FROM colaborador;

    p_resultado := 1; -- Éxito
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontraron datos
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradores: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en getColaboradores: ' || SQLERRM);
    END getColaboradores;

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

    PROCEDURE updateColaborador(
        p_idColaborador IN NUMBER,
        p_nombre IN VARCHAR2,
        p_apellido1 IN VARCHAR2,
        p_apellido2 IN VARCHAR2,
        p_idCargo IN NUMBER,
        p_idEspecialidad IN NUMBER,
        p_imagen IN VARCHAR2,
        p_correo IN VARCHAR2,
        p_contrasena IN VARCHAR2,
        p_idRol IN NUMBER,
        p_resultado OUT NUMBER
    ) AS
    v_contr_hash RAW(2000);
BEGIN
    -- Si se proporciona una nueva contraseña, genera el hash de la misma
    IF p_contrasena IS NOT NULL THEN
        v_contr_hash := DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(p_contrasena), DBMS_CRYPTO.HASH_SH1);
    END IF;

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
        contrasena = NVL(v_contr_hash, contrasena), -- Actualiza la contraseña solo si se proporciona una nueva
        idRol = p_idRol
    WHERE idColaborador = p_idColaborador;

    p_resultado := SQL%ROWCOUNT; -- Número de filas afectadas

    IF p_resultado > 0 THEN
        p_resultado := 1; -- Éxito
    ELSE
        p_resultado := 0; -- No se encontró el colaborador
        DBMS_OUTPUT.PUT_LINE('No se encontró el colaborador con ID ' || p_idColaborador);
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
        DBMS_OUTPUT.PUT_LINE('Error en la actualización del colaborador: ' || SQLERRM);
    END updateColaborador;
END paquete_colaboradores;
/

