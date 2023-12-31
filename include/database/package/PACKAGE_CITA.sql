--Drop PACKAGE P_CITA;

--CITA
--#########################################################################################################

CREATE OR REPLACE PACKAGE P_CITA
AS
--------------------- SP ---------------------
--SP1
PROCEDURE getMascotasCliente(
    p_IDCLIENTE IN MASCOTA.IDCLIENTE%TYPE,
    P_IDMASCOTA out MASCOTA.IDMASCOTA%TYPE,
    p_NOMBRE OUT MASCOTA.NOMBRE%TYPE,
    p_DESCRIPCION OUT MASCOTA.DESCRIPCION%TYPE,
    p_IMAGEN OUT MASCOTA.IMAGEN%TYPE,
    p_IDTIPOMASCOTA OUT MASCOTA.IDTIPOMASCOTA%TYPE,
    p_resultado OUT NUMBER
);
--SP2
PROCEDURE getServicios(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP3
PROCEDURE getEstados(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP4
PROCEDURE getMedicosPorServicio(
    p_IDSERVICIO IN COLABORADORSERVICIO.IDSERVICIO%TYPE,
    P_idColaborador OUT COLABORADOR.IDCOLABORADOR%TYPE,
    p_NOMBRE OUT COLABORADOR.NOMBRE%TYPE,
    p_apellido1 OUT COLABORADOR.APELLIDO1%TYPE,
    p_apellido2 OUT COLABORADOR.APELLIDO2%TYPE,
    p_resultado OUT NUMBER 
);
--SP5
PROCEDURE insertCita(
 P_IDCLIENTE IN CITAS.IDCLIENTE%TYPE,
 P_IDMASCOTA IN CITAS.IDMASCOTA%TYPE,
 P_IDSERVICIO IN CITAS.IDSERVICIO%TYPE,
 P_FECHA IN CITAS.FECHA%TYPE,
 P_IDHORARIO IN CITAS.IDHORARIO%TYPE,
 P_IDESTADO IN CITAS.IDESTADO%TYPE,
 P_RESULTADO OUT NUMBER
);
--SP6
PROCEDURE updateCita(
 P_IDCITA IN CITAS.IDCITA%TYPE,
 P_IDCLIENTE IN CITAS.IDCLIENTE%TYPE,
 P_IDMASCOTA IN CITAS.IDMASCOTA%TYPE,
 P_IDSERVICIO IN CITAS.IDSERVICIO%TYPE,
 P_FECHA IN CITAS.FECHA%TYPE,
 P_IDHORARIO IN CITAS.IDHORARIO%TYPE,
 P_IDESTADO IN CITAS.IDESTADO%TYPE,
 P_RESULTADO OUT NUMBER
);
PROCEDURE updateEstadoCita(
P_IDCITA IN CITAS.IDCITA%TYPE,
P_IDESTADO IN CITAS.IDESTADO%TYPE,
P_RESULTADO OUT NUMBER
);
--SP7
PROCEDURE insertAsignacionCita(
P_IDCITA IN ASIGNACIONCITAS.IDCITA%TYPE,
P_IDCOLABORADOR IN ASIGNACIONCITAS.IDCOLABORADOR%TYPE,
P_RESULTADO OUT NUMBER
);
--SP8
PROCEDURE insertHistorialMedico(
P_DETALLECITA IN HISTORIALMEDICO.DETALLECITA%TYPE,
P_COSTE IN HISTORIALMEDICO.COSTE%TYPE,
P_IDMASCOTA IN HISTORIALMEDICO.IDMASCOTA%TYPE,
P_IDCOLABORADOR IN HISTORIALMEDICO.IDCOLABORADOR%TYPE,
P_IDCITA IN HISTORIALMEDICO.IDCITA%TYPE,
P_RESULTADO OUT NUMBER
);
--SP9
PROCEDURE updateAsignacionCita(
P_IDASIGNACION IN ASIGNACIONCITAS.IDASIGNACIONCITA%TYPE,
P_IDCOLABORADOR IN ASIGNACIONCITAS.IDCOLABORADOR%TYPE,
P_RESULTADO OUT NUMBER
);
--SP10
PROCEDURE getDetalleCitaMedico (
    P_IDCOLABORADOR IN NUMBER,
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
);
--SP11
PROCEDURE getAllDetalleCitaMedico(
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
);
--SP12
PROCEDURE getCitaMedica(
    P_IDCITA IN NUMBER,
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
);
--SP13
PROCEDURE getHistorialMedico(
    P_IDCITA IN NUMBER,
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
);
--SP14
PROCEDURE getAllHistorialMedico(
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
);
--SP15
PROCEDURE getCitasCliente(
P_IDCLIENTE IN CITAS.IDCLIENTE%TYPE,
P_RESULTADO OUT NUMBER,
P_CITASCLIENTE OUT SYS_REFCURSOR
);
--SP16
PROCEDURE getCitasPorEstado(
P_IDESTADO IN CITAS.IDESTADO%TYPE,
P_RESULTADO OUT NUMBER,
P_CITAS OUT SYS_REFCURSOR
);
--SP17
PROCEDURE getCitasPorEstadoYColaborador(
 P_IDESTADO IN CITAS.IDESTADO%TYPE,
 P_IDCOLABORADOR IN COLABORADOR.IDCOLABORADOR%TYPE,
 P_RESULTADO OUT NUMBER,
 P_CITAS OUT SYS_REFCURSOR
);
--SP18
PROCEDURE GetHorariosDisponibles(
    p_fecha IN DATE,
    p_medicoId IN NUMBER,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);
--SP19
PROCEDURE GetHorariosCitas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
);

END P_CITA;

--#########################################################################################################

create or replace PACKAGE BODY  P_CITA 
AS

--SP1----------------------------------------------------------------------------
PROCEDURE getMascotasCliente(
    p_IDCLIENTE IN MASCOTA.IDCLIENTE%TYPE,
    P_IDMASCOTA out MASCOTA.IDMASCOTA%TYPE,
    p_NOMBRE OUT MASCOTA.NOMBRE%TYPE,
    p_DESCRIPCION OUT MASCOTA.DESCRIPCION%TYPE,
    p_IMAGEN OUT MASCOTA.IMAGEN%TYPE,
    p_IDTIPOMASCOTA OUT MASCOTA.IDTIPOMASCOTA%TYPE,
    p_resultado OUT NUMBER
)as
begin
SELECT IDMASCOTA,NOMBRE, DESCRIPCION,IMAGEN,IDTIPOMASCOTA
INTO P_IDMASCOTA,p_NOMBRE, p_DESCRIPCION, p_IMAGEN, p_IDTIPOMASCOTA 
FROM MASCOTA WHERE idCliente = p_IDCLIENTE;

p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP2----------------------------------------------------------------------------
PROCEDURE getServicios(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) as
BEGIN
    OPEN p_cursor FOR
        SELECT IDSERVICIO, SERVICIO, DESCRIPCION
        FROM SERVICIOS;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontr�
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
--SP3----------------------------------------------------------------------------
PROCEDURE getEstados(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT IDESTADO, ESTADO
        FROM ESTADO;

    p_resultado := 1; -- Encontrado

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 0; -- No se encontr�
    WHEN OTHERS THEN
        p_resultado := 9; -- Error
END;
--SP4----------------------------------------------------------------------------
PROCEDURE getMedicosPorServicio(
    p_IDSERVICIO IN COLABORADORSERVICIO.IDSERVICIO%TYPE,
    P_idColaborador OUT COLABORADOR.IDCOLABORADOR%TYPE,
    p_NOMBRE OUT COLABORADOR.NOMBRE%TYPE,
    p_apellido1 OUT COLABORADOR.APELLIDO1%TYPE,
    p_apellido2 OUT COLABORADOR.APELLIDO2%TYPE,
    p_resultado OUT NUMBER 
)as
begin
SELECT c.idColaborador, c.nombre, c.apellido1, c.apellido2
 INTO P_idColaborador, p_NOMBRE, p_apellido1, p_apellido2
            FROM colaborador c
            INNER JOIN colaboradorservicio cs ON c.idColaborador = cs.idColaborador
            WHERE cs.idServicio = p_IDSERVICIO;  

p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP5----------------------------------------------------------------------------
PROCEDURE insertCita(
 P_IDCLIENTE IN CITAS.IDCLIENTE%TYPE,
 P_IDMASCOTA IN CITAS.IDMASCOTA%TYPE,
 P_IDSERVICIO IN CITAS.IDSERVICIO%TYPE,
 P_FECHA IN CITAS.FECHA%TYPE,
 P_IDHORARIO IN CITAS.IDHORARIO%TYPE,
 P_IDESTADO IN CITAS.IDESTADO%TYPE,
 P_RESULTADO OUT NUMBER
)AS
BEGIN
 INSERT INTO CITAS (IDCLIENTE,IDMASCOTA,IDSERVICIO,FECHA,IDHORARIO,IDESTADO)
 VALUES (P_IDCLIENTE,P_IDMASCOTA,P_IDSERVICIO,P_FECHA,P_IDHORARIO,P_IDESTADO);
 
  p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- Exito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP5----------------------------------------------------------------------------
PROCEDURE updateCita(
 P_IDCITA IN CITAS.IDCITA%TYPE,
 P_IDCLIENTE IN CITAS.IDCLIENTE%TYPE,
 P_IDMASCOTA IN CITAS.IDMASCOTA%TYPE,
 P_IDSERVICIO IN CITAS.IDSERVICIO%TYPE,
 P_FECHA IN CITAS.FECHA%TYPE,
 P_IDHORARIO IN CITAS.IDHORARIO%TYPE,
 P_IDESTADO IN CITAS.IDESTADO%TYPE,
 P_RESULTADO OUT NUMBER
)AS
BEGIN
    UPDATE CITAS SET
    IDCITA = P_IDCITA,
    IDCLIENTE = P_IDCLIENTE,
    IDMASCOTA = P_IDMASCOTA,
    IDSERVICIO = P_IDSERVICIO,
    FECHA = P_FECHA,
    IDHORARIO = P_IDHORARIO,
    IDESTADO = P_IDESTADO
    WHERE IDCITA = P_IDCITA;

 p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END ;
--SP6----------------------------------------------------------------------------
PROCEDURE updateEstadoCita(
P_IDCITA IN CITAS.IDCITA%TYPE,
P_IDESTADO IN CITAS.IDESTADO%TYPE,
P_RESULTADO OUT NUMBER
)AS
BEGIN
UPDATE CITAS SET IDESTADO = P_IDESTADO WHERE IDCITA = P_IDCITA;

 p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);

END;
--SP7----------------------------------------------------------------------------
PROCEDURE insertAsignacionCita(
P_IDCITA IN ASIGNACIONCITAS.IDCITA%TYPE,
P_IDCOLABORADOR IN ASIGNACIONCITAS.IDCOLABORADOR%TYPE,
P_RESULTADO OUT NUMBER
)AS
BEGIN
INSERT INTO ASIGNACIONCITAS (IDCITA, IDCOLABORADOR) VALUES (P_IDCITA,P_IDCOLABORADOR);

p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP8----------------------------------------------------------------------------
PROCEDURE insertHistorialMedico(
P_DETALLECITA IN HISTORIALMEDICO.DETALLECITA%TYPE,
P_COSTE IN HISTORIALMEDICO.COSTE%TYPE,
P_IDMASCOTA IN HISTORIALMEDICO.IDMASCOTA%TYPE,
P_IDCOLABORADOR IN HISTORIALMEDICO.IDCOLABORADOR%TYPE,
P_IDCITA IN HISTORIALMEDICO.IDCITA%TYPE,
P_RESULTADO OUT NUMBER
)AS
BEGIN
INSERT into historialmedico (detalleCita,coste,idMascota,idColaborador,idCita) 
VALUES (P_DETALLECITA, P_COSTE, P_IDMASCOTA, P_IDCOLABORADOR, P_IDCITA);

p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
--SP9----------------------------------------------------------------------------
PROCEDURE updateAsignacionCita(
P_IDASIGNACION IN ASIGNACIONCITAS.IDASIGNACIONCITA%TYPE,
P_IDCOLABORADOR IN ASIGNACIONCITAS.IDCOLABORADOR%TYPE,
P_RESULTADO OUT NUMBER
)AS 
BEGIN 
UPDATE asignacioncitas SET idColaborador = P_IDCOLABORADOR WHERE idasignacionCita = P_IDASIGNACION;

p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);

END;
--SP10----------------------------------------------------------------------------
PROCEDURE getDetalleCitaMedico (
    P_IDCOLABORADOR IN NUMBER,
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN P_CITAS FOR
    SELECT 
        ac.idcita,
        ac.idColaborador,
        m.idMascota,
        col.nombre as nombreMedico,
        m.nombre as nombreMascota,
        m.descripcion,
        cli.nombre, 
        cli.apellido1,
        cli.apellido2,
        cli.correo,
        cli.telefono,
        s.servicio,
        c.fecha,
        c.idestado,
        hc.horaInicio,
        hc.horaFin,
        e.estado  
    FROM asignacioncitas ac 
        JOIN citas c ON ac.idcita = c.idcita
        JOIN colaborador col ON ac.idColaborador = col.idColaborador
        JOIN mascota m ON c.idMascota = m.idmascota 
        JOIN cliente cli ON c.idCliente = cli.idCliente
        JOIN servicios s ON c.idServicio = s.idServicio
        JOIN horariocitas hc ON c.idHorario = hc.idHorario
        JOIN estado e ON c.idestado = e.idestado 
    WHERE ac.idColaborador = P_IDCOLABORADOR
    ORDER BY c.fecha DESC;
    
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);   
    
    
END getDetalleCitaMedico;
--SP11----------------------------------------------------------------------------
PROCEDURE getAllDetalleCitaMedico(
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN P_CITAS FOR
    SELECT 
        ac.idcita,
        ac.idColaborador,
        m.idMascota,
        col.nombre as nombreMedico,
        m.nombre as nombreMascota,
        m.descripcion,
        cli.nombre, 
        cli.apellido1,
        cli.apellido2,
        cli.correo,
        cli.telefono,
        s.servicio,
        c.fecha,
        c.idestado,
        hc.horaInicio,
        hc.horaFin,
        e.estado  
    FROM asignacioncitas ac 
        JOIN citas c ON ac.idcita = c.idcita
        JOIN colaborador col ON ac.idColaborador = col.idColaborador
        JOIN mascota m ON c.idMascota = m.idmascota 
        JOIN cliente cli ON c.idCliente = cli.idCliente
        JOIN servicios s ON c.idServicio = s.idServicio
        JOIN horariocitas hc ON c.idHorario = hc.idHorario
        JOIN estado e ON c.idestado = e.idestado 
    ORDER BY c.fecha DESC;
    
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM); 
END;
--SP12----------------------------------------------------------------------------
PROCEDURE getCitaMedica(
    P_IDCITA IN NUMBER,
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN P_CITAS FOR
    SELECT 
        ac.idcita,
        ac.idColaborador,
        m.idMascota,
        col.nombre as nombreMedico,
        m.nombre as nombreMascota,
        m.descripcion,
        cli.nombre, 
        cli.apellido1,
        cli.apellido2,
        cli.correo,
        cli.telefono,
        s.servicio,
        c.fecha,
        c.idestado,
        hc.horaInicio,
        hc.horaFin,
        e.estado  
    FROM asignacioncitas ac 
        JOIN citas c ON ac.idcita = c.idcita
        JOIN colaborador col ON ac.idColaborador = col.idColaborador
        JOIN mascota m ON c.idMascota = m.idmascota 
        JOIN cliente cli ON c.idCliente = cli.idCliente
        JOIN servicios s ON c.idServicio = s.idServicio
        JOIN horariocitas hc ON c.idHorario = hc.idHorario
        JOIN estado e ON c.idestado = e.idestado 
    WHERE ac.idcita = P_IDCITA
    ORDER BY c.fecha DESC;
    
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);   
END;
--SP13----------------------------------------------------------------------------
PROCEDURE getHistorialMedico(
    P_IDCITA IN NUMBER,
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN P_CITAS FOR
    SELECT 
    H.IDHMEDICO,
    H.DETALLECITA,
    H.COSTE,
    H.IDMASCOTA,
    H.IDCOLABORADOR,
    H.IDCITA,
    c.fecha, 
    s.servicio,
    m.nombre as nombreMascota,
    c.idestado,
    c.idCliente,
    cli.nombre,
    cli.apellido1,
    cli.apellido2,
    e.estado
        from historialmedico h 
        JOIN  mascota m on h.idMascota = m.idmascota 
        join citas c on h.idCita = c.idcita
        join cliente cli on c.idCliente = cli.idCliente
        join estado e on c.idestado = e.idestado
        join servicios s on c.idServicio = s.idServicio 
        WHERE h.idcita  = P_IDCITA;
   
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM); 

END;
--SP14----------------------------------------------------------------------------
PROCEDURE getAllHistorialMedico(
    P_RESULTADO OUT NUMBER,
    P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN P_CITAS FOR
    SELECT 
    H.IDHMEDICO,
    H.DETALLECITA,
    H.COSTE,
    H.IDMASCOTA,
    H.IDCOLABORADOR,
    H.IDCITA,
    c.fecha, 
    s.servicio,
    m.nombre as nombreMascota,
    c.idestado,
    c.idCliente,
    cli.nombre,
    cli.apellido1,
    cli.apellido2,
    e.estado
        from historialmedico h 
        JOIN  mascota m on h.idMascota = m.idmascota 
        join citas c on h.idCita = c.idcita
        join cliente cli on c.idCliente = cli.idCliente
        join estado e on c.idestado = e.idestado
        join servicios s on c.idServicio = s.idServicio;
   
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM); 
END;
--SP15----------------------------------------------------------------------------
PROCEDURE getCitasCliente(
P_IDCLIENTE IN CITAS.IDCLIENTE%TYPE,
P_RESULTADO OUT NUMBER,
P_CITASCLIENTE OUT SYS_REFCURSOR
)
AS
BEGIN 
OPEN P_CITASCLIENTE FOR
SELECT 
c.idCita,
m.nombre AS nombreMascota,
s.servicio AS nombreServicio,
c.fecha,
h.horaInicio,
h.horaFin,
co.nombre AS nombreMedico,
e.estado AS nombreEstado,
e.estado AS idEstado
FROM citas c
JOIN mascota m ON c.idMascota = m.idMascota
JOIN servicios s ON c.idServicio = s.idServicio
JOIN horariocitas h ON c.idHorario = h.idHorario
JOIN asignacioncitas ac ON c.idCita = ac.idCita
JOIN colaborador co ON ac.idColaborador = co.idColaborador
JOIN estado e ON c.idestado = e.idestado
WHERE c.idCliente = P_IDCLIENTE;

p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);   

END getCitasCliente;
--SP16----------------------------------------------------------------------------
PROCEDURE getCitasPorEstado(
P_IDESTADO IN CITAS.IDESTADO%TYPE,
P_RESULTADO OUT NUMBER,
P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN 
OPEN P_CITAS FOR
SELECT 
c.idCita,
m.nombre AS nombreMascota,
s.servicio AS nombreServicio,
c.fecha,
h.horaInicio,
h.horaFin,
co.nombre AS nombreMedico,
e.estado AS nombreEstado
                    FROM citas c
                    JOIN mascota m ON c.idMascota = m.idMascota
                    JOIN servicios s ON c.idServicio = s.idServicio
                    JOIN horariocitas h ON c.idHorario = h.idHorario
                    JOIN asignacioncitas ac ON c.idCita = ac.idCita
                    JOIN colaborador co ON ac.idColaborador = co.idColaborador
                    JOIN estado e ON c.idestado = e.idestado
                    WHERE c.idestado = P_IDESTADO;
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);                    
                    
END getCitasPorEstado;
--SP17----------------------------------------------------------------------------
PROCEDURE getCitasPorEstadoYColaborador(
 P_IDESTADO IN CITAS.IDESTADO%TYPE,
 P_IDCOLABORADOR IN COLABORADOR.IDCOLABORADOR%TYPE,
 P_RESULTADO OUT NUMBER,
 P_CITAS OUT SYS_REFCURSOR
)
AS
BEGIN 
OPEN P_CITAS FOR
SELECT c.idCita,
m.nombre AS nombreMascota,
s.servicio AS nombreServicio,
c.fecha,
h.horaInicio,
h.horaFin,
e.estado AS nombreEstado
            FROM citas c
            JOIN mascota m ON c.idMascota = m.idMascota
            JOIN servicios s ON c.idServicio = s.idServicio
            JOIN horariocitas h ON c.idHorario = h.idHorario
            JOIN asignacioncitas ac ON c.idCita = ac.idcita
            JOIN colaborador co ON ac.idColaborador = co.idColaborador
            JOIN estado e ON c.idestado = e.idestado
            WHERE c.idestado = P_IDESTADO AND co.idColaborador = P_IDCOLABORADOR;
            
p_resultado := SQLCODE; -- Establecer el resultado basado en SQLCODE

    IF p_resultado = 0 THEN
        p_resultado := 0; -- �xito
    ELSE
        p_resultado := SQLCODE; -- Otro estado
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_resultado := SQLCODE; -- Error
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);                  

            
END;
--SP18----------------------------------------------------------------------------
PROCEDURE GetHorariosDisponibles(
    p_fecha IN DATE,
    p_medicoId IN NUMBER,
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT hc.idHorario, hc.horaInicio, hc.horaFin
        FROM horariocitas hc
        LEFT JOIN citas c ON hc.idHorario = c.idHorario AND c.fecha = p_fecha AND c.idestado != 2
        LEFT JOIN asignacioncitas ac ON c.idCita = ac.idcita
        WHERE c.idCita IS NULL OR (ac.idColaborador != p_medicoId OR ac.idColaborador IS NULL)
        ORDER BY hc.horaInicio;

    p_resultado := 0; -- Éxito
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- No se encontraron datos
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
END;
--SP19----------------------------------------------------------------------------
PROCEDURE GetHorariosCitas(
    p_cursor OUT SYS_REFCURSOR,
    p_resultado OUT NUMBER
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT idHorario, horaInicio, horaFin
        FROM horariocitas;

    p_resultado := 0; -- Éxito
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_resultado := 1; -- No se encontraron datos
    WHEN OTHERS THEN
        p_resultado := 9; -- Otro error
END;
--FIN SP----------------------------------------------------------------------------
END P_CITA;
--#########################################################################################################




