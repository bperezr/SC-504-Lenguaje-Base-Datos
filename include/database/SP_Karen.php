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


