--drop PROCEDURE getEvento;
--drop PROCEDURE getEventos;
--drop PROCEDURE insertEvento
--drop PROCEDURE updateEvento
--drop PROCEDURE deleteEvento
--drop PROCEDURE buscarEventos


--EVENTO
--#########################################################################################################
CREATE OR REPLACE PACKAGE P_EVENTO
AS

--------------------- SP ---------------------
--SP1
PROCEDURE getEventos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getEvento(
    p_idEvento IN eventos.idEvento%TYPE,
    p_Lugar OUT eventos.Lugar%TYPE,
    p_Fecha OUT eventos.fecha%TYPE,
    p_HoraInicio OUT eventos.hora_inicio%TYPE,
    p_HoraFin OUT eventos.hora_fin%TYPE,
    p_Descripcion OUT eventos.descripcion%TYPE,
    p_Imagen OUT eventos.imagen%TYPE,
    p_IdProvincia OUT eventos.idProvincia%TYPE,
    p_IdCanton OUT eventos.idCanton%TYPE,
    p_IdDistrito OUT eventos.idDistrito%TYPE,
    p_NombreEvento OUT eventos.nombreEvento%TYPE,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE insertEvento(
    p_Lugar IN eventos.Lugar%TYPE,
    p_Fecha IN eventos.fecha%TYPE,
    p_HoraInicio IN eventos.hora_inicio%TYPE,
    p_HoraFin IN eventos.hora_fin%TYPE,
    p_Descripcion IN eventos.descripcion%TYPE,
    p_Imagen IN eventos.imagen%TYPE,
    p_IdProvincia IN eventos.idProvincia%TYPE,
    p_IdCanton IN eventos.idCanton%TYPE,
    p_IdDistrito IN eventos.idDistrito%TYPE,
    p_NombreEvento IN eventos.nombreEvento%TYPE,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE updateEvento(
    p_idEvento IN eventos.idEvento%TYPE,
    p_Lugar IN eventos.Lugar%TYPE,
    p_Fecha IN VARCHAR2,
    p_HoraInicio IN VARCHAR2,
    p_HoraFin IN VARCHAR2,
    p_Descripcion IN eventos.descripcion%TYPE,
    p_Imagen IN eventos.imagen%TYPE,
    p_IdProvincia IN eventos.idProvincia%TYPE,
    p_IdCanton IN eventos.idCanton%TYPE,
    p_IdDistrito IN eventos.idDistrito%TYPE,
    p_NombreEvento IN eventos.nombreEvento%TYPE,
    p_resultado OUT NUMBER
);
--SP5
PROCEDURE deleteEvento(
    p_idEvento IN eventos.idEvento%TYPE,
    p_resultado OUT NUMBER
);
--SP6
PROCEDURE buscarEventos (
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
);
--------------------- Fin SP -------------------
END P_EVENTO;

--#########################################################################################################
CREATE OR REPLACE PACKAGE BODY P_EVENTO
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getEventos(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0;

    OPEN p_cursor FOR
        SELECT idEvento, Lugar, fecha, hora_inicio, hora_fin, descripcion, imagen, idProvincia, idCanton, idDistrito, nombreEvento
        FROM eventos;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontró ningún evento
        DBMS_OUTPUT.PUT_LINE('Error en getEventos: ' || SQLERRM);
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en getEventos: ' || SQLERRM);
END;
--SP2----------------------------------------------------------------------------
PROCEDURE getEvento(
    p_idEvento IN eventos.idEvento%TYPE,
    p_Lugar OUT eventos.Lugar%TYPE,
    p_Fecha OUT eventos.fecha%TYPE,
    p_HoraInicio OUT eventos.hora_inicio%TYPE,
    p_HoraFin OUT eventos.hora_fin%TYPE,
    p_Descripcion OUT eventos.descripcion%TYPE,
    p_Imagen OUT eventos.imagen%TYPE,
    p_IdProvincia OUT eventos.idProvincia%TYPE,
    p_IdCanton OUT eventos.idCanton%TYPE,
    p_IdDistrito OUT eventos.idDistrito%TYPE,
    p_NombreEvento OUT eventos.nombreEvento%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    p_resultado := 0; -- Por defecto, no se encontró

    BEGIN
        SELECT Lugar, fecha, hora_inicio, hora_fin, descripcion, imagen, idProvincia, idCanton, idDistrito, nombreEvento
        INTO p_Lugar, p_Fecha, p_HoraInicio, p_HoraFin, p_Descripcion, p_Imagen, p_IdProvincia, p_IdCanton, p_IdDistrito, p_NombreEvento
        FROM eventos
        WHERE idEvento = p_idEvento;

        p_resultado := 1; -- Encontrado

    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_resultado := 0; -- No se encontró
            DBMS_OUTPUT.PUT_LINE('No se encontró ningún evento con id ' || p_idEvento);
        WHEN OTHERS THEN
            p_resultado := 9; -- Error
            DBMS_OUTPUT.PUT_LINE('Error en getEvento: ' || SQLERRM);
    END;

END;
--SP3----------------------------------------------------------------------------
PROCEDURE insertEvento(
    p_Lugar IN eventos.Lugar%TYPE,
    p_Fecha IN eventos.fecha%TYPE,
    p_HoraInicio IN eventos.hora_inicio%TYPE,
    p_HoraFin IN eventos.hora_fin%TYPE,
    p_Descripcion IN eventos.descripcion%TYPE,
    p_Imagen IN eventos.imagen%TYPE,
    p_IdProvincia IN eventos.idProvincia%TYPE,
    p_IdCanton IN eventos.idCanton%TYPE,
    p_IdDistrito IN eventos.idDistrito%TYPE,
    p_NombreEvento IN eventos.nombreEvento%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    INSERT INTO eventos(Lugar, fecha, hora_inicio, hora_fin, descripcion, imagen, idProvincia, idCanton, idDistrito, nombreEvento)
    VALUES (p_Lugar, p_Fecha, p_HoraInicio, p_HoraFin, p_Descripcion, p_Imagen, p_IdProvincia, p_IdCanton, p_IdDistrito, p_NombreEvento);

    p_resultado := 1; -- Éxito

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
        DBMS_OUTPUT.PUT_LINE('Error en insertEvento: ' || SQLERRM);
END;
--SP4----------------------------------------------------------------------------
PROCEDURE updateEvento(
    p_idEvento IN eventos.idEvento%TYPE,
    p_Lugar IN eventos.Lugar%TYPE,
    p_Fecha IN VARCHAR2,
    p_HoraInicio IN VARCHAR2,
    p_HoraFin IN VARCHAR2,
    p_Descripcion IN eventos.descripcion%TYPE,
    p_Imagen IN eventos.imagen%TYPE,
    p_IdProvincia IN eventos.idProvincia%TYPE,
    p_IdCanton IN eventos.idCanton%TYPE,
    p_IdDistrito IN eventos.idDistrito%TYPE,
    p_NombreEvento IN eventos.nombreEvento%TYPE,
    p_resultado OUT NUMBER
) AS
    v_fecha DATE;
    v_horaInicio TIMESTAMP;
    v_horaFin TIMESTAMP;
BEGIN
    -- Convertir la fecha y hora al formato correcto
    v_fecha := TO_DATE(p_Fecha, 'YYYY-MM-DD');
    v_horaInicio := TO_TIMESTAMP(p_HoraInicio, 'YYYY-MM-DD HH24:MI:SS');
    v_horaFin := TO_TIMESTAMP(p_HoraFin, 'YYYY-MM-DD HH24:MI:SS');

    UPDATE eventos
    SET Lugar = p_Lugar,
        fecha = v_fecha,
        hora_inicio = v_horaInicio,
        hora_fin = v_horaFin,
        descripcion = p_Descripcion,
        imagen = p_Imagen,
        idProvincia = p_IdProvincia,
        idCanton = p_IdCanton,
        idDistrito = p_IdDistrito,
        nombreEvento = p_NombreEvento
    WHERE idEvento = p_idEvento;

    p_resultado := SQL%ROWCOUNT;

    IF p_resultado > 0 THEN
        p_resultado := 1;
    ELSE
        p_resultado := 0;
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9;
END;
--SP5----------------------------------------------------------------------------
PROCEDURE deleteEvento(
    p_idEvento IN eventos.idEvento%TYPE,
    p_resultado OUT NUMBER
) AS
BEGIN
    DELETE FROM eventos WHERE idEvento = p_idEvento;

    p_resultado := SQL%ROWCOUNT;

    IF p_resultado > 0 THEN
        p_resultado := 1;
    ELSE
        p_resultado := 0;
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9;
        DBMS_OUTPUT.PUT_LINE('Error en deleteEvento: ' || SQLERRM);
END;
--SP6----------------------------------------------------------------------------
PROCEDURE buscarEventos (
    p_searchTerm IN VARCHAR2,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER,
    p_numFilas OUT NUMBER
) AS
BEGIN
    -- Primera consulta para contar las filas
    SELECT COUNT(*) INTO p_numFilas
    FROM eventos
    WHERE LOWER(Lugar) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(descripcion) LIKE LOWER('%' || p_searchTerm || '%') OR
          LOWER(nombreEvento) LIKE LOWER('%' || p_searchTerm || '%');

    -- Segunda consulta para obtener los datos
    OPEN p_cursor FOR
        SELECT idEvento, Lugar, fecha, hora_inicio, hora_fin, descripcion, imagen, idProvincia, idCanton, idDistrito, nombreEvento
        FROM eventos
        WHERE LOWER(Lugar) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(descripcion) LIKE LOWER('%' || p_searchTerm || '%') OR
              LOWER(nombreEvento) LIKE LOWER('%' || p_searchTerm || '%');

    -- Establecer el resultado basado en el recuento de filas
    IF p_numFilas > 0 THEN
        p_resultado := 1; -- Se encontraron filas
    ELSE
        p_resultado := 0; -- No se encontraron filas
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
--FIN SP------------------------------------------------------------------------
END P_EVENTO;
--#########################################################################################################