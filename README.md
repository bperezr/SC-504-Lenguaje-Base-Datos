# SC-504-Lenguaje-Base-Datos

## TABLESPACE

ALTER SESSION SET "_ORACLE_SCRIPT" = TRUE;

CREATE TABLESPACE HAPPYPAWS
   DATAFILE 'happypaws.dbf'
   size 10M
   AUTOEXTEND ON NEXT 2M;
   
CREATE USER happypaws IDENTIFIED BY 12345
    DEFAULT TABLESPACE HAPPYPAWS;
	
ALTER USER happypaws quota unlimited on HAPPYPAWS;


CREATE ROLE Admin;
GRANT CREATE SESSION, CREATE TABLE, CREATE ANY TABLE, ALTER ANY TABLE, CREATE VIEW, RESOURCE TO Admin;
GRANT Admin to happypaws;

## Corrección de error 'DBMS_CRYPTO'

Ejecutar con sys:

GRANT EXECUTE ON DBMS_CRYPTO TO happypaws;

## Configurar XDebug para PHP con XAMPP y Visual Studio Code
https://www.youtube.com/watch?v=TexkCrk6njc
