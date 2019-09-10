--Bruno Alberto
--11511BSI224

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
