/*CREATE TABLE auditoria_salarios (
  CODVEND NUMBER,
  SALARIO_ANT FLOAT,
  SALARIO_NOVO  FLOAT,
  DATA_ALT DATE,
  OPERACAO  VARCHAR(30),
  NOMEUSER  VARCHAR(30),
  TIMESTAMPUSER  VARCHAR(30)
);

CREATE TRIGGER auditoria_salarios_update
BEFORE UPDATE OF SALFIXO ON VENDEDOR
FOR EACH ROW
WHEN (:OLD.FAIXACOMIS = 'A') 
BEGIN
  CASE AUDITORIA_SALARIOS.OPERACAO
    WHEN INSERTING THEN
      INSERT INTO auditoria_salarios 
      VALUES(:OLD.CODVEND,:OLD.SALFIXO,:NEW.SALARIO_NOVO,DATA_ALT,OPERACAO,NOMEUSER,TIMESTAMPUSER);
    WHEN UPDATING THEN
      UPDATE AUDITORIA_SALARIOS
         FAIXACOMIS == 'A')
      SET SALFIX = (SALFIX * 0.05) WHERE VENDEDOR.FAIXACOMIS = 'A' 
      
      UPDATE AUDITORIA_SALARIOS
      SALFIX = (SALFIX * 0.1) WHERE  VENDEDOR.FAIXACOMIS = 'B'
      
      SET SALFIX = (SALFIX * 0.15) WHERE VENDEDOR.FAIXACOMIS = 'C'
    WHEN DELETING THEN
      DELETE FROM AUDITORIA_SALARIOS WHERE :OLD.SALFIX
*/
/*
CREATE SEQUENCE seq
START WITH 1
INCREMENT BY 1;

--drop table auditoria_salarios;
*/
CREATE TABLE auditoria_salarios(
    codvend INTEGER,
    old_salfixo FLOAT,
    new_salfixo FLOAT,
    data_alt DATE,
    operacao VARCHAR(50),
    nomeuser VARCHAR(50),
    ts_data TIMESTAMP(6)
);

ALTER SESSION SET nls_timestamp_format = 'dd/mm/yyyy hh24:mi:ss.ff';

CREATE OR REPLACE TRIGGER preenche_auditoria_salarios
BEFORE INSERT OR UPDATE OF salfixo ON VENDEDOR
FOR EACH ROW
DECLARE 
    ERRO EXCEPTION;
BEGIN
    IF INSERTING THEN
        INSERT INTO auditoria_salarios
        (codvend,old_salfixo,new_salfixo,data_alt,operacao,nomeuser,ts_data)
        VALUES(:new.codvend,:old.salfixo,:new.salfixo,sysdate,'insert',user,localtimestamp);
    END IF;
    
    IF UPDATING AND (old.faixacomis = 'A') THEN
        RAISE ERRO;
    END IF;
    EXCEPTION WHEN ERRO THEN
        RAISE_APPLICATION_ERROR(-20000,'Nao eh permitodo alterar');
    
    CASE UPDATING
    WHEN faixacomis = 'A' THEN
        UPDATE VENDEDOR
        SET salfixo = old.salfixo + (old.salfixo * 0.05);
    WHEN faixacomis = 'B' THEN
        UPDATE VENDEDOR
        SET salfixo = old.salfixo + (old.salfixo * 0.10);
    ELSE
        UPDATE VENDEDOR
        SET salfixo = old.salfixo + (old.salfixo * 0.15);
    END CASE;
    
END preenche_auditoria_salarios;

-- INCOMPLETO FALTOU B & C



