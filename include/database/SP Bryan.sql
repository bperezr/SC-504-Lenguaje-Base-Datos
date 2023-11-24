    
CREATE OR REPLACE PROCEDURE getColaboradorPorCorreo(
V_CORREO IN colaborador.correo%TYPE,
V_IDCOLABORADOR OUT COLABORADOR.IDCOLABORADOR%TYPE,
V_NOMBRE OUT COLABORADOR.NOMBRE%TYPE,
V_APELLIDO1 OUT COLABORADOR.APELLIDO1%TYPE,
V_APELLIDO2 OUT COLABORADOR.APELLIDO2%TYPE,
V_IDCARGO OUT COLABORADOR.IDCARGO%TYPE,
V_IDESPECIALIDAD OUT COLABORADOR.IDESPECIALIDAD%TYPE,
V_IMAGEN OUT COLABORADOR.IMAGEN%TYPE,
V_IDROL OUT COLABORADOR.IDROL%TYPE,
V_CONTRASENA OUT COLABORADOR.CONTRASENA%TYPE,
resultado OUT NUMBER
)
AS BEGIN 
    SELECT 
    IDCOLABORADOR,
    NOMBRE,
    APELLIDO1,
    APELLIDO2,
    IDCARGO,
    IDESPECIALIDAD,
    IMAGEN,
    IDROL,
    CONTRASENA
    INTO
    V_IDCOLABORADOR,
    V_NOMBRE,
    V_APELLIDO1,
    V_APELLIDO2 ,
    V_IDCARGO,
    V_IDESPECIALIDAD ,
    V_IMAGEN ,
    V_IDROL,
    V_CONTRASENA
    FROM colaborador WHERE correo = V_CORREO;
    resultado := 1;
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
        resultado := 0; -- No se encontró
         DBMS_OUTPUT.PUT_LINE('Error en getColaboradorPorCorreo: ' || 'Numero: '|| resultado || ' ' ||SQLERRM);
    WHEN OTHERS THEN
         DBMS_OUTPUT.PUT_LINE('Error en getColaboradorPorCorreo: ' || 'Numero: '|| resultado || ' ' ||SQLERRM);
END;

DECLARE
    v_correo VARCHAR2(100) := 'admin@happypaws.com';
    V_IDCOLABORADOR NUMBER;
    V_NOMBRE VARCHAR(100);
    V_APELLIDO1 VARCHAR(100);
    V_APELLIDO2 VARCHAR(100);
    V_IDCARGO NUMBER;
    V_IDESPECIALIDAD NUMBER;
    V_IMAGEN VARCHAR(250);
    V_IDROL NUMBER;
    V_CONTRASENA VARCHAR(250);
    v_resultado NUMBER;
BEGIN
    getColaboradorPorCorreo(v_correo,V_IDCOLABORADOR, V_NOMBRE, V_APELLIDO1, V_APELLIDO2, V_IDCARGO, V_IDESPECIALIDAD, V_IMAGEN, V_IDROL, V_CONTRASENA, v_resultado);
    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        DBMS_OUTPUT.PUT_LINE(' ');
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || V_NOMBRE || ' ' || V_APELLIDO1 ||' ' || V_APELLIDO2  ||' ' || V_IDCARGO);
    ELSIF v_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    END IF;
END;

--------------------------------------------------------
CREATE OR REPLACE PROCEDURE insertColaborador(
V_NOMBRE IN COLABORADOR.NOMBRE%TYPE,
V_APELLIDO1 IN COLABORADOR.APELLIDO1%TYPE,
V_APELLIDO2 IN COLABORADOR.APELLIDO2%TYPE,
V_IDCARGO IN COLABORADOR.IDCARGO%TYPE,
V_IDESPECIALIDAD IN COLABORADOR.IDESPECIALIDAD%TYPE,
V_IMAGEN IN COLABORADOR.IMAGEN%TYPE,
V_IDROL IN COLABORADOR.IDROL%TYPE,
V_CORREO IN colaborador.correo%TYPE,
V_CONTRASENA IN COLABORADOR.CONTRASENA%TYPE,
p_resultado OUT NUMBER
)AS
    BEGIN
    DECLARE
        passHash RAW(128);
     BEGIN
     passHash := DBMS_CRYPTO.HASH(
            src => UTL_RAW.CAST_TO_RAW(V_CONTRASENA),
            typ => DBMS_CRYPTO.HASH_SH256
        );
     INSERT INTO COLABORADOR (NOMBRE,APELLIDO1,APELLIDO2,IDCARGO,IDESPECIALIDAD,IMAGEN,IDROL,CORREO,CONTRASENA)
     VALUES (V_NOMBRE,V_APELLIDO1,V_APELLIDO2,V_IDCARGO,V_IDESPECIALIDAD,V_IMAGEN,V_IDROL,V_CORREO,passHash);
     
     IF SQL%ROWCOUNT = 1 THEN
            p_resultado := 1; -- OK
        ELSE
            p_resultado := 0; -- Not Insert
            DBMS_OUTPUT.PUT_LINE('Error en insertColaborador: ' || SQLERRM);
        END IF;
    EXCEPTION
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en insertColaborador: ' || SQLERRM);
    END;
END;

DECLARE    
    V_NOMBRE VARCHAR2(50) := 'Bryan';
    V_APELLIDO1 VARCHAR2(50) := 'Perez';
    V_APELLIDO2 VARCHAR2(50) := 'Reyes';
    V_IDCARGO NUMBER := 1;
    V_IDESPECIALIDAD NUMBER := 1;
    V_IMAGEN VARCHAR2(255) := '95f06f81d2dea3f9c5807f3b7658b3fe.jpg';
    V_IDROL NUMBER := 1;
    V_CORREO VARCHAR2(255) := 'bpr@gmail.com';
    V_CONTRASENA VARCHAR2(50) := '123';
    p_resultado NUMBER;
BEGIN
    insertColaborador(        
        V_NOMBRE,
        V_APELLIDO1,
        V_APELLIDO2,
        V_IDCARGO,
        V_IDESPECIALIDAD,
        V_IMAGEN,
        V_IDROL,
        V_CORREO,
        V_CONTRASENA,
        p_resultado
    );

    -- Verificar el resultado
    IF p_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Procedimiento almacenado ejecutado con éxito.');
    ELSIF p_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Procedimiento almacenado no pudo realizar la inserción.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error al ejecutar el procedimiento almacenado.');
    END IF;
END;

-----------------------------------------------------------

CREATE OR REPLACE PROCEDURE updateColaborador(
V_IDCOLABORADOR IN COLABORADOR.IDCOLABORADOR%TYPE,
V_NOMBRE IN COLABORADOR.NOMBRE%TYPE,
V_APELLIDO1 IN COLABORADOR.APELLIDO1%TYPE,
V_APELLIDO2 IN COLABORADOR.APELLIDO2%TYPE,
V_IDCARGO IN COLABORADOR.IDCARGO%TYPE,
V_IDESPECIALIDAD IN COLABORADOR.IDESPECIALIDAD%TYPE,
V_IMAGEN IN COLABORADOR.IMAGEN%TYPE,
V_IDROL IN COLABORADOR.IDROL%TYPE,
V_CORREO IN colaborador.correo%TYPE,
p_resultado OUT NUMBER
)
AS
 v_actualizaciones_realizadas NUMBER;
    BEGIN
    UPDATE COLABORADOR
    SET nombre = V_NOMBRE,
        apellido1 = V_APELLIDO1,
        apellido2 = V_APELLIDO2,
        IDCARGO = V_IDCARGO,
        IDESPECIALIDAD = V_IDESPECIALIDAD,
        IMAGEN = V_IMAGEN,
        idRol = V_IDROL,
        correo = V_CORREO
    WHERE IDCOLABORADOR = V_IDCOLABORADOR
    RETURNING 1 INTO v_actualizaciones_realizadas;
    -- Verifica el resultado
    IF v_actualizaciones_realizadas = 1 THEN
        p_resultado := 1; -- OK
    ELSE
        p_resultado := 0; -- No se realizó la actualización
        DBMS_OUTPUT.PUT_LINE('No se realizó ninguna actualización.');
    END IF;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('No se encontró el cliente a actualizar.');
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
END;


DECLARE    
   V_IDCOLABORADOR NUMBER := 8;
    V_NOMBRE VARCHAR2(50) := 'Bryan steven';
    V_APELLIDO1 VARCHAR2(50) := 'Perezzzzz';
    V_APELLIDO2 VARCHAR2(50) := 'Reyes';
    V_IDCARGO NUMBER := 2;
    V_IDESPECIALIDAD NUMBER := 2;
    V_IMAGEN VARCHAR2(255) := '95f06f81d2dea3f9c5807f3b7658b3fe.jpg';
    V_IDROL NUMBER := 2;
    V_CORREO VARCHAR2(255) := 'bpr31@gmail.com';
    p_resultado NUMBER;
BEGIN
    updateColaborador(     
        V_IDCOLABORADOR,
        V_NOMBRE,
        V_APELLIDO1,
        V_APELLIDO2,
        V_IDCARGO,
        V_IDESPECIALIDAD,
        V_IMAGEN,
        V_IDROL,
        V_CORREO,
        p_resultado
    );

    -- Verificar el resultado
    IF p_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Procedimiento almacenado ejecutado con éxito.');
    ELSIF p_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Procedimiento almacenado no pudo realizar la inserción.');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error al ejecutar el procedimiento almacenado.');
    END IF;
END;

-------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURE deleteColaborador(
    V_IDCOLABORADOR IN cliente.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
    v_eliminaciones_realizadas NUMBER;
BEGIN
    -- Elimina el registro
    DELETE FROM COLABORADOR
    WHERE IDCOLABORADOR = V_IDCOLABORADOR
    RETURNING 1 INTO v_eliminaciones_realizadas;

    -- Verifica el resultado
    IF v_eliminaciones_realizadas = 1 THEN
        p_resultado := 1; -- Éxito, cliente eliminado
    ELSE
        p_resultado := 0; -- Cliente no encontrado
        DBMS_OUTPUT.PUT_LINE('Cliente no encontrado.');
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en deleteCliente: ' || SQLERRM);
END;


DECLARE
    v_resultado NUMBER;
BEGIN
    deleteColaborador(
        V_IDCOLABORADOR => '8',
        p_resultado => v_resultado
    );
    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    END CASE;
END;

------------------------------------------------------------

CREATE OR REPLACE PROCEDURE buscarColaboradores (
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Sin resultados

    OPEN p_cursor FOR        
SELECT 
c.IDCOLABORADOR,
C.NOMBRE,
C.APELLIDO1,
C.APELLIDO2,
C.IDCARGO,
C.IDESPECIALIDAD,
C.IMAGEN,
C.IDROL,
C.CORREO,
ca.cargo,
e.especialidad
FROM colaborador c
INNER JOIN cargo ca ON c.idCargo = ca.idCargo
INNER JOIN especialidad e ON c.idEspecialidad = e.idEspecialidad
        WHERE c.nombre LIKE '%' || p_searchTerm || '%' OR
            c.apellido1 LIKE '%' || p_searchTerm || '%' OR
            c.apellido2 LIKE '%' || p_searchTerm || '%' OR
            c.correo LIKE '%' || p_searchTerm || '%';
            
            p_resultado := SQL%ROWCOUNT; -- Resultados encontrados
    EXCEPTION
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
END;



