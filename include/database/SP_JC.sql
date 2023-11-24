--******TABLA MASCOTA ******
--Se inicia una secuencia para crea runa llave autoincremental
-- Sin la llave autoincremental daría errores el insertar sin tener que asignarle manualmente el ID
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
    
    COMMIT; -- Confirmar la transacción
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
        -- Indicar que la operación fue exitosa
        V_Resultado := 1;
    ELSE
        -- Indicar que no se encontró el tipo de mascota con el ID proporcionado
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
        -- Indicar que la operación fue exitosa
        V_Resultado := 1;
    ELSE
        -- Indicar que no se encontró el tipo de mascota con el ID proporcionado
        V_Resultado := 0;
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        -- Capturar cualquier error y retornar un indicador de error
        V_Resultado := 0;
END DELETETIPOMASCOTA;
/



