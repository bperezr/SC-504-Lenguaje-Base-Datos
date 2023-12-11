------Citas desde Admin------


----------------- ESTADO 1 / ASIGNADAS -----------------
CREATE OR REPLACE FUNCTION contar_citas_asignadas RETURN NUMBER IS
  total_citas NUMBER;
BEGIN
  -- Utiliza la función COUNT para contar las filas donde IDESTADO es igual a 1
  SELECT COUNT(*) INTO total_citas
  FROM CITAS
  WHERE IDESTADO = 1;

  -- Devuelve el resultado
  RETURN total_citas;
END contar_citas_asignadas;
/

---TEST

DECLARE
  total NUMBER;
BEGIN
  total := contar_citas_asignadas;
  DBMS_OUTPUT.PUT_LINE('Total de citas con IDESTADO = 1: ' || total);
END;
/


----------------- ESTADO 2 / ATENDIDAS -----------------


CREATE OR REPLACE FUNCTION contar_citas_atendidas RETURN NUMBER IS
  total_citas NUMBER;
BEGIN
  -- Utiliza la función COUNT para contar las filas donde IDESTADO es igual a 2
  SELECT COUNT(*) INTO total_citas
  FROM CITAS
  WHERE IDESTADO = 2;

  -- Devuelve el resultado
  RETURN total_citas;
END contar_citas_atendidas;
/

---TEST

DECLARE
  total NUMBER;
BEGIN
  total := contar_citas_atendidas;
  DBMS_OUTPUT.PUT_LINE('Total de citas con IDESTADO = 2 (Atendidas): ' || total);
END;
/

----------------- ESTADO 3 / CANCELADA -----------------


CREATE OR REPLACE FUNCTION contar_citas_canceladas RETURN NUMBER IS
  total_citas NUMBER;
BEGIN
  -- Utiliza la función COUNT para contar las filas donde IDESTADO es igual a 3
  SELECT COUNT(*) INTO total_citas
  FROM CITAS    
  WHERE IDESTADO = 3;

  -- Devuelve el resultado
  RETURN total_citas;
END contar_citas_canceladas;
/

---TEST

DECLARE
  total NUMBER;
BEGIN
  total := contar_citas_canceladas;
  DBMS_OUTPUT.PUT_LINE('Total de citas con IDESTADO = 3 (Canceladas): ' || total);
END;
/


------Citas desde Colaborador------

----------------- ESTADO 1 / ASIGNADA -----------------

CREATE OR REPLACE FUNCTION contar_citas_asignadas_colaborador(p_id_colaborador NUMBER) RETURN NUMBER IS
  total_citas NUMBER;
BEGIN
  SELECT COUNT(*) INTO total_citas
  FROM ASIGNACIONCITAS ac
  JOIN CITAS c ON ac.IDCITA = c.IDCITA
  WHERE ac.IDCOLABORADOR = p_id_colaborador AND c.IDESTADO = 1;

  RETURN total_citas;
END contar_citas_asignadas_colaborador;
/

----------------- ESTADO 2 / ATENDIDAS -----------------

CREATE OR REPLACE FUNCTION contar_citas_canceladas_colaborador(p_id_colaborador NUMBER) RETURN NUMBER IS
  total_citas NUMBER;
BEGIN
  SELECT COUNT(*) INTO total_citas
  FROM ASIGNACIONCITAS ac
  JOIN CITAS c ON ac.IDCITA = c.IDCITA
  WHERE ac.IDCOLABORADOR = p_id_colaborador AND c.IDESTADO = 3;

  RETURN total_citas;
END contar_citas_canceladas_colaborador;
/


----------------- ESTADO 3 / CANCELADA -----------------

CREATE OR REPLACE FUNCTION contar_citas_atendidas_colaborador(p_id_colaborador NUMBER) RETURN NUMBER IS
  total_citas NUMBER;
BEGIN
  SELECT COUNT(*) INTO total_citas
  FROM ASIGNACIONCITAS ac
  JOIN CITAS c ON ac.IDCITA = c.IDCITA
  WHERE ac.IDCOLABORADOR = p_id_colaborador AND c.IDESTADO = 2;

  RETURN total_citas;
END contar_citas_atendidas_colaborador;
/


------ TEST----

DECLARE
  v_id_colaborador NUMBER := 2; -- Reemplaza con el ID del colaborador deseado
  v_citas_asignadas NUMBER;
  v_citas_canceladas NUMBER;
  v_citas_atendidas NUMBER;
BEGIN
  v_citas_asignadas := contar_citas_asignadas_colaborador(v_id_colaborador);
  v_citas_canceladas := contar_citas_canceladas_colaborador(v_id_colaborador);
  v_citas_atendidas := contar_citas_atendidas_colaborador(v_id_colaborador);

  -- Puedes imprimir o usar los resultados según tus necesidades
  DBMS_OUTPUT.PUT_LINE('Citas Asignadas: ' || v_citas_asignadas);
  DBMS_OUTPUT.PUT_LINE('Citas Canceladas: ' || v_citas_canceladas);
  DBMS_OUTPUT.PUT_LINE('Citas Atendidas: ' || v_citas_atendidas);
END;
/

