------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                                                                                                                                                --CLIETE
------------------------------------------------------------------------------------------------------------------------------------------------------------------------

--******************************************************************************************
                                                                                --getCliente x
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getCliente(
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
    p_resultado OUT NUMBER
) AS
BEGIN
    SELECT nombre, apellido1, apellido2, telefono, imagen, domicilio,
        idProvincia, idCanton, idDistrito, idRol, correo
    INTO p_nombre, p_apellido1, p_apellido2, p_telefono, p_imagen, p_domicilio,
        p_idProvincia, p_idCanton, p_idDistrito, p_idRol, p_correo
    FROM cliente
    WHERE idCliente = p_idCliente;

    p_resultado := 1; -- Encontrado
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
END;

--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_idCliente NUMBER := '55';
    v_nombre VARCHAR2(30);
    v_apellido1 VARCHAR2(30);
    v_apellido2 VARCHAR2(30);
    v_telefono VARCHAR2(15);
    v_imagen VARCHAR2(400);
    v_domicilio VARCHAR2(250);
    v_idProvincia NUMBER;
    v_idCanton NUMBER;
    v_idDistrito NUMBER;
    v_idRol NUMBER;
    v_correo VARCHAR2(100);
    v_resultado NUMBER;
BEGIN
    getCliente(v_idCliente, v_nombre, v_apellido1, v_apellido2, v_telefono, v_imagen, v_domicilio, v_idProvincia, v_idCanton, v_idDistrito, v_idRol, v_correo, v_resultado);
    IF v_resultado = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
        DBMS_OUTPUT.PUT_LINE(' ');
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
        DBMS_OUTPUT.PUT_LINE('Primer apellido: ' || v_apellido1);
        DBMS_OUTPUT.PUT_LINE('Segundo apellido: ' || v_apellido2);
        DBMS_OUTPUT.PUT_LINE('Teléfono: ' || v_telefono);
        DBMS_OUTPUT.PUT_LINE('Imagen: ' || v_imagen);
        DBMS_OUTPUT.PUT_LINE('Domicilio: ' || v_domicilio);
        DBMS_OUTPUT.PUT_LINE('ID Provincia: ' || TO_CHAR(v_idProvincia));
        DBMS_OUTPUT.PUT_LINE('ID Cantón: ' || TO_CHAR(v_idCanton));
        DBMS_OUTPUT.PUT_LINE('ID Distrito: ' || TO_CHAR(v_idDistrito));
        DBMS_OUTPUT.PUT_LINE('ID Rol: ' || TO_CHAR(v_idRol));
        DBMS_OUTPUT.PUT_LINE('Correo: ' || v_correo);
    ELSIF v_resultado = 0 THEN
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Resultado: ' || v_resultado);
    END IF;
END;



--******************************************************************************************
                                                                                --getClientes x
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getClientes(
p_cursor OUT SYS_REFCURSOR, 
p_resultado OUT NUMBER
) AS
BEGIN

    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT c.idCliente, c.nombre, c.apellido1, c.apellido2, c.telefono, c.imagen, c.domicilio,
            c.correo, c.idProvincia, c.idCanton, c.idDistrito, c.idRol,
            p.nombre AS nombre_provincia,
            cn.nombre AS nombre_canton,
            d.nombre AS nombre_distrito,
            r.nombrerol AS nombre_rol
        FROM cliente c
        JOIN provincia p ON c.idProvincia = p.idProvincia
        JOIN canton cn ON c.idCanton = cn.idCanton
        JOIN distrito d ON c.idDistrito = d.idDistrito
        JOIN rol r ON c.idRol = r.idRol;

    p_resultado := 1; -- Encontrado
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
END;


--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    cur SYS_REFCURSOR;
    v_idCliente cliente.idCliente%TYPE;
    v_nombre cliente.nombre%TYPE;
    v_apellido1 cliente.apellido1%TYPE;
    v_apellido2 cliente.apellido2%TYPE;
    v_telefono cliente.telefono%TYPE;
    v_imagen cliente.imagen%TYPE;
    v_domicilio cliente.domicilio%TYPE;
    v_correo cliente.correo%TYPE;
    v_idProvincia cliente.idProvincia%TYPE;
    v_idCanton cliente.idCanton%TYPE;
    v_idDistrito cliente.idDistrito%TYPE;
    v_idRol cliente.idRol%TYPE;
    v_nombreProvincia provincia.nombre%TYPE;
    v_nombreCanton canton.nombre%TYPE;
    v_nombreDistrito distrito.nombre%TYPE;
    v_nombrerol rol.nombrerol%TYPE;
    v_resultado NUMBER;

BEGIN
    getClientes(cur, v_resultado);

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
        FETCH cur INTO v_idCliente, v_nombre, v_apellido1, v_apellido2, v_telefono, v_imagen,
                    v_domicilio, v_correo, v_idProvincia, v_idCanton, v_idDistrito, v_idRol,
                    v_nombreProvincia, v_nombreCanton, v_nombreDistrito, v_nombrerol;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Cliente: ' || v_idCliente);
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
        DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
        DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || v_apellido2);
        DBMS_OUTPUT.PUT_LINE('Teléfono: ' || v_telefono);
        DBMS_OUTPUT.PUT_LINE('Imagen: ' || v_imagen);
        DBMS_OUTPUT.PUT_LINE('Domicilio: ' || v_domicilio);
        DBMS_OUTPUT.PUT_LINE('Correo: ' || v_correo);
        DBMS_OUTPUT.PUT_LINE('ID Provincia: ' || v_idProvincia);
        DBMS_OUTPUT.PUT_LINE('ID Cantón: ' || v_idCanton);
        DBMS_OUTPUT.PUT_LINE('ID Distrito: ' || v_idDistrito);
        DBMS_OUTPUT.PUT_LINE('ID Rol: ' || v_idRol);
        DBMS_OUTPUT.PUT_LINE('Nombre Provincia: ' || v_nombreProvincia);
        DBMS_OUTPUT.PUT_LINE('Nombre Cantón: ' || v_nombreCanton);
        DBMS_OUTPUT.PUT_LINE('Nombre Distrito: ' || v_nombreDistrito);
        DBMS_OUTPUT.PUT_LINE('Nombre Rol: ' || v_nombrerol);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;

--******************************************************************************************
                                                                                --getVerClientes x
--******************************************************************************************
CREATE OR REPLACE PROCEDURE getVerClientes(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) IS
BEGIN
    OPEN p_cursor FOR
        SELECT idCliente, nombre, apellido1, apellido2, telefono, imagen,
            domicilio, idProvincia, idCanton, idDistrito, correo
        FROM cliente;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;


--******************************************************************************
                                                                        --TEST
--******************************************************************************

DECLARE
    cur SYS_REFCURSOR;
    v_idCliente cliente.idCliente%TYPE;
    v_nombre cliente.nombre%TYPE;
    v_apellido1 cliente.apellido1%TYPE;
    v_apellido2 cliente.apellido2%TYPE;
    v_telefono cliente.telefono%TYPE;
    v_imagen cliente.imagen%TYPE;
    v_domicilio cliente.domicilio%TYPE;
    v_idProvincia cliente.idProvincia%TYPE;
    v_idCanton cliente.idCanton%TYPE;
    v_idDistrito cliente.idDistrito%TYPE;
    v_correo cliente.correo%TYPE;
    v_resultado NUMBER;
BEGIN
    getVerClientes(cur,  v_resultado);

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

    LOOP
        FETCH cur INTO v_idCliente, v_nombre, v_apellido1, v_apellido2, v_telefono, v_imagen,
                    v_domicilio, v_idProvincia, v_idCanton, v_idDistrito, v_correo;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Cliente: ' || v_idCliente);
        DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
        DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
        DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || v_apellido2);
        DBMS_OUTPUT.PUT_LINE('Teléfono: ' || v_telefono);
        DBMS_OUTPUT.PUT_LINE('Imagen: ' || v_imagen);
        DBMS_OUTPUT.PUT_LINE('Domicilio: ' || v_domicilio);
        DBMS_OUTPUT.PUT_LINE('ID Provincia: ' || v_idProvincia);
        DBMS_OUTPUT.PUT_LINE('ID Cantón: ' || v_idCanton);
        DBMS_OUTPUT.PUT_LINE('ID Distrito: ' || v_idDistrito);
        DBMS_OUTPUT.PUT_LINE('Correo: ' || v_correo);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;

--******************************************************************************************
                                                                                --getRoles x
--******************************************************************************************

CREATE OR REPLACE PROCEDURE getRoles(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) IS
BEGIN
    OPEN p_cursor FOR
        SELECT idRol, nombreRol FROM rol;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
END;


--******************************************************************************
                                                                        --TEST
--******************************************************************************

DECLARE
    cur SYS_REFCURSOR;
    v_idRol rol.idRol%TYPE;
    v_nombreRol rol.nombreRol%TYPE;
    v_resultado NUMBER;
BEGIN
    getRoles(cur, v_resultado);

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

    LOOP
        FETCH cur INTO v_idRol, v_nombreRol;
        EXIT WHEN cur%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('ID Rol: ' || v_idRol);
        DBMS_OUTPUT.PUT_LINE('Nombre Rol: ' || v_nombreRol);
        DBMS_OUTPUT.PUT_LINE('--------------------------------');
    END LOOP;

    CLOSE cur;
END;

--******************************************************************************************
                                                                                --insertCliente
--******************************************************************************************

CREATE OR REPLACE PROCEDURE insertCliente(
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) IS
BEGIN
    INSERT INTO cliente (
        nombre, apellido1, apellido2, telefono, domicilio,
        idProvincia, idCanton, idDistrito, idRol, correo, contrasena
    ) VALUES (
        p_nombre, p_apellido1, p_apellido2, p_telefono, p_domicilio,
        p_idProvincia, p_idCanton, p_idDistrito, p_idRol, p_correo, p_contrasena
    );

        IF SQL%ROWCOUNT = 1 THEN
            p_resultado := 1; -- OK
        ELSE
            p_resultado := 0; -- Not Insert
            DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
        END IF;
    EXCEPTION
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en updateCliente: ' || SQLERRM);
END;

--******************************************************************************
                                                                        --TEST
--******************************************************************************

DECLARE
    v_resultado NUMBER;

BEGIN

    insertCliente(
        p_nombre => 'Juan',
        p_apellido1 => 'Pérez',
        p_apellido2 => 'García',
        p_telefono => '1234567890',
        p_domicilio => 'Calle Falsa 123',
        p_idProvincia => 1,
        p_idCanton => 101,
        p_idDistrito => 10101,
        --p_idDistrito => '22',
        p_idRol => 3,
        p_correo => 'juan.perez@example.com',
        p_contrasena => 'contraseñaSegura123',
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

--******************************************************************************************
                                                                                --updateCliente
--******************************************************************************************

CREATE OR REPLACE PROCEDURE updateCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_nombre IN cliente.nombre%TYPE,
    p_apellido1 IN cliente.apellido1%TYPE,
    p_apellido2 IN cliente.apellido2%TYPE,
    p_telefono IN cliente.telefono%TYPE,
    p_domicilio IN cliente.domicilio%TYPE,
    p_idProvincia IN cliente.idProvincia%TYPE,
    p_idCanton IN cliente.idCanton%TYPE,
    p_idDistrito IN cliente.idDistrito%TYPE,
    p_idRol IN cliente.idRol%TYPE,
    p_correo IN cliente.correo%TYPE,
    p_resultado OUT NUMBER
) AS
    v_actualizaciones_realizadas NUMBER;
BEGIN
    -- Actualiza el registro
    UPDATE cliente
    SET nombre = p_nombre,
        apellido1 = p_apellido1,
        apellido2 = p_apellido2,
        telefono = p_telefono,
        domicilio = p_domicilio,
        idProvincia = p_idProvincia,
        idCanton = p_idCanton,
        idDistrito = p_idDistrito,
        idRol = p_idRol,
        correo = p_correo
    WHERE idCliente = p_idCliente
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

--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_resultado NUMBER;
BEGIN
    updateCliente(
        p_idCliente => 45,
        p_nombre => 'JORGE',
        p_apellido1 => 'Lópezs',
        p_apellido2 => 'Martínez',
        p_telefono => '987654321',
        p_domicilio => 'Calle TEST',
        p_idProvincia => 1,
        p_idCanton => 101,
        p_idDistrito => '525',
        p_idRol => 2,
        p_correo => 'ana.lopez@example.com',
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

--******************************************************************************************
                                                                                --updateClienteNuevo
--******************************************************************************************
CREATE OR REPLACE PROCEDURE updateClienteNuevo(
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
    v_elimnaciones_realizadas NUMBER;
BEGIN
    -- Actualiza el registro
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
    WHERE idCliente = p_idCliente
    RETURNING 1 INTO v_elimnaciones_realizadas;

    -- Verifica el resultado
    IF v_elimnaciones_realizadas = 1 THEN
        p_resultado := 1; -- Éxito, 
    ELSE
        p_resultado := 0; -- No encontrado
        DBMS_OUTPUT.PUT_LINE('Error en deleteCliente: ' || SQLERRM);
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en deleteCliente: ' || SQLERRM);
END;


--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_resultado NUMBER;
BEGIN
    updateClienteNuevo(
        p_idCliente => 435,
        p_nombre => 'Juannn',
        p_apellido1 => 'Pérez',
        p_apellido2 => 'García',
        p_telefono => '123456789',
        p_domicilio => 'Calle Falsa 123',
        p_idProvincia => 1,
        p_idCanton => 101,
        p_idDistrito => '10102',
        p_imagen => 'ruta/a/imagen.jpg',
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
--******************************************************************************************
                                                                                --deleteCliente
--******************************************************************************************
CREATE OR REPLACE PROCEDURE deleteCliente(
    p_idCliente IN cliente.idCliente%TYPE,
    p_resultado OUT NUMBER
) AS
    v_elimnaciones_realizadas NUMBER;
BEGIN
    -- Elimina el registro
    DELETE FROM cliente
    WHERE idCliente = p_idCliente
    RETURNING 1 INTO v_elimnaciones_realizadas;

    -- Verifica el resultado
    IF v_elimnaciones_realizadas = 1 THEN
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


--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_resultado NUMBER;
BEGIN
    deleteCliente(
        p_idCliente => '45',
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

--******************************************************************************************
                                                                                --buscarclientess
--******************************************************************************************

CREATE OR REPLACE PROCEDURE buscarclientes (
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Sin resultados

    OPEN p_cursor FOR
        SELECT idCliente, nombre, apellido1, apellido2, correo, imagen, telefono
        FROM cliente
        WHERE nombre LIKE '%' || p_searchTerm || '%' OR
            apellido1 LIKE '%' || p_searchTerm || '%' OR
            apellido2 LIKE '%' || p_searchTerm || '%' OR
            correo LIKE '%' || p_searchTerm || '%';

            p_resultado := SQL%ROWCOUNT; -- Resultados encontrados
    EXCEPTION
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
END;


--******************************************************************************
                                                                        --TEST
--******************************************************************************

DECLARE
    cur SYS_REFCURSOR;
    v_searchTerm VARCHAR2(100); -- búsqueda
    v_idCliente cliente.idCliente%TYPE;
    v_nombre cliente.nombre%TYPE;
    v_apellido1 cliente.apellido1%TYPE;
    v_apellido2 cliente.apellido2%TYPE;
    v_correo cliente.correo%TYPE;
    v_imagen cliente.imagen%TYPE;
    v_telefono cliente.telefono%TYPE;
    v_resultado NUMBER;
BEGIN
    v_searchTerm := '@email'; -- 'Término de búsqueda'
    buscarclientes(v_searchTerm, cur, v_resultado);

    CASE v_resultado
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontraron resultados.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al ejecutar el SP');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultados encontrados: ' || v_resultado);
        LOOP
            FETCH cur INTO v_idCliente, v_nombre, v_apellido1, v_apellido2, v_correo, v_imagen, v_telefono;
            EXIT WHEN cur%NOTFOUND;
            DBMS_OUTPUT.PUT_LINE('ID Cliente: ' || v_idCliente);
            DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
            DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
            DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || v_apellido2);
            DBMS_OUTPUT.PUT_LINE('Correo: ' || v_correo);
            DBMS_OUTPUT.PUT_LINE('Imagen: ' || v_imagen);
            DBMS_OUTPUT.PUT_LINE('Teléfono: ' || v_telefono);
            DBMS_OUTPUT.PUT_LINE('--------------------------------');
        END LOOP;
    END CASE;
    CLOSE cur;
END;

--******************************************************************************************
                                                                                --verificarCorreoCliente
--******************************************************************************************
CREATE OR REPLACE PROCEDURE verificarCorreoCliente(
    p_correo IN cliente.correo%TYPE,
    p_existe OUT NUMBER
) AS
BEGIN
    SELECT COUNT(*) INTO p_existe
    FROM cliente
    WHERE correo = p_correo;
    
    IF p_existe > 0 THEN
        p_existe := 1; -- El correo existe
    ELSE
        p_existe := 0; -- El correo no existe
    END IF;
    
EXCEPTION
    WHEN OTHERS THEN
        p_existe := 9; -- Error
END;

--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_correo cliente.correo%TYPE := 'jorge1@email.com';
    v_existe NUMBER;

BEGIN
    verificarCorreoCliente(v_correo, v_existe);

    CASE v_existe
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('El correo ' || v_correo || ' existe en la base de datos.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('El correo ' || v_correo || ' no existe en la base de datos.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al verificar el correo ' || v_correo);
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_existe);
    END CASE;
END;

--******************************************************************************************
                                                                                --validarcredencialesCliente
--******************************************************************************************
CREATE OR REPLACE NONEDITIONABLE PROCEDURE validarcredencialesCliente (
    v_correo     IN cliente.correo%TYPE,
    v_contrasena IN VARCHAR2,
    resultado    OUT NUMBER
) AS
    consult_correo     VARCHAR2(20);
    consult_contrasena VARCHAR2(250);
BEGIN
    DECLARE
        passhash RAW(128);
    BEGIN
        passhash := dbms_crypto.hash(src => utl_raw.cast_to_raw(v_contrasena), typ => dbms_crypto.hash_sh256);

        SELECT correo, contrasena
        INTO consult_correo, consult_contrasena
        FROM cliente
        WHERE correo = v_correo
            AND contrasena = passhash;

        resultado := 1; -- Si se encuentra el registro
        
    EXCEPTION
        WHEN OTHERS THEN
            resultado := 0; -- No se encontraron coincidencias.
    END;
END;
--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_correo_cliente cliente.correo%TYPE := 'test@test.com';
    v_contrasena VARCHAR2(250) := 'admin01';
    v_resultado NUMBER;

BEGIN
    validarcredencialesCliente(v_correo_cliente, v_contrasena, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Credenciales válidas');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('Credenciales inválidas');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;

--******************************************************************************************
                                                                                --insertClienteNuevo
--******************************************************************************************
CREATE OR REPLACE NONEDITIONABLE PROCEDURE insertClienteNuevo (
    p_correo IN cliente.correo%TYPE,
    p_contrasena IN cliente.contrasena%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN    
    DECLARE
        passHash RAW(128);
    BEGIN
        passHash := DBMS_CRYPTO.HASH(
            src => UTL_RAW.CAST_TO_RAW(p_contrasena),
            typ => DBMS_CRYPTO.HASH_SH256
        );

        INSERT INTO cliente (correo, contrasena) VALUES (p_correo, passHash);

        p_resultado := 1; -- Éxito
    EXCEPTION
        WHEN DUP_VAL_ON_INDEX THEN
            p_resultado := 0; -- Correo duplicado
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
    END; 
END;

--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_correo cliente.correo%TYPE := 'test@test.com';
    v_contrasena cliente.contrasena%TYPE := 'contrasena123';
    v_resultado NUMBER;

BEGIN
    insertClienteNuevo(v_correo, v_contrasena, v_resultado);

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Cliente insertado correctamente.');
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('El correo ya existe en la base de datos.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al intentar insertar el cliente.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;

--******************************************************************************************
                                                                                --obtenerClientePorCorreo
--******************************************************************************************
CREATE OR REPLACE NONEDITIONABLE PROCEDURE obtenerClientePorCorreo(
    p_correo IN cliente.correo%TYPE,
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
    FROM cliente
    WHERE correo = p_correo;

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró el cliente
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;

--******************************************************************************
                                                                        --TEST
--******************************************************************************
DECLARE
    v_correo cliente.correo%TYPE := 'jorge@email.com';
    v_idCliente cliente.idCliente%TYPE;
    v_idRol cliente.idRol%TYPE;
    v_nombre cliente.nombre%TYPE;
    v_apellido1 cliente.apellido1%TYPE;
    v_apellido2 cliente.apellido2%TYPE;
    v_resultado NUMBER;

BEGIN
    obtenerClientePorCorreo(
        p_correo => v_correo,
        p_idCliente => v_idCliente,
        p_idRol => v_idRol,
        p_nombre => v_nombre,
        p_apellido1 => v_apellido1,
        p_apellido2 => v_apellido2,
        p_resultado => v_resultado
    );

    CASE v_resultado
        WHEN 1 THEN
            DBMS_OUTPUT.PUT_LINE('Cliente encontrado:');
            DBMS_OUTPUT.PUT_LINE('ID Cliente: ' || v_idCliente);
            DBMS_OUTPUT.PUT_LINE('ID Rol: ' || v_idRol);
            DBMS_OUTPUT.PUT_LINE('Nombre: ' || v_nombre);
            DBMS_OUTPUT.PUT_LINE('Apellido 1: ' || v_apellido1);
            DBMS_OUTPUT.PUT_LINE('Apellido 2: ' || v_apellido2);
        WHEN 0 THEN
            DBMS_OUTPUT.PUT_LINE('No se encontró el cliente.');
        WHEN 9 THEN
            DBMS_OUTPUT.PUT_LINE('Error al buscar el cliente.');
        ELSE
            DBMS_OUTPUT.PUT_LINE('Resultado inesperado: ' || v_resultado);
    END CASE;
END;