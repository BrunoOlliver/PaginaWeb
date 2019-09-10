-- Exercicio 01: funcionario com maior salário
CREATE VIEW fun_maior_sal
    AS SELECT fid, fnome, salario 
    FROM FUNCIONARIO
    WHERE salario = (
      SELECT MAX(salario) FROM FUNCIONARIO
    );
    
SELECT * FROM FUN_MAIOR_SAL;

--OBS.: existem dois funcionários com salários iguais.

-- Exercicio 02: DOIS Funcionarios com maior salário
CREATE VIEW FUN_DOIS_MAIOR_SAL
    AS SELECT fid, fnome, salario
    FROM FUNCIONARIO
    WHERE salario
    IN (
        SELECT salario 
        FROM (
            SELECT salario 
            FROM FUNCIONARIO
            ORDER BY salario DESC
            )
        WHERE ROWNUM <= 2
        )
    ORDER BY salario DESC;

SELECT * FROM FUN_DOIS_MAIOR_SAL;

--Exercicio 03:  certificados em pelo menos duas aeronaves acima de 1000 milhas
CREATE VIEW CERTI_FUNC_AERO_ACIMA_1000 AS
SELECT DISTINCT F.FID, F.FNOME
FROM (
    FUNCIONARIO F 
    INNER JOIN (
        AERONAVE A 
        INNER JOIN 
        CERTIFICADO C
        ON A.AID = C.AID
        AND A.LIMDISTANCIA > 1000
        )
    ON F.FID = C.FID
    );

--Exercicio 04: nome dos funcionarios e aeronaves para quais possuem certificado
CREATE VIEW FUNC_AERO_CERTI AS
SELECT F.FNOME, A.ANOME FROM (
    FUNCIONARIO F INNER JOIN (
    AERONAVE A INNER JOIN CERTIFICADO C
    ON A.AID = C.AID)
    ON F.FID = C.FID)
ORDER BY F.FNOME;
SELECT * FROM FUNC_AERO_CERTI;

--Exercicio 05: Criar visões conforme as opções abaixo 
--a) visão com uma seleção em funcionario
CREATE VIEW VISAO_FUNCIONARIO AS
SELECT * FROM FUNCIONARIO
ORDER BY FNOME;

SELECT * FROM VISAO_FUNCIONARIO;

--b) visao com junção entre funcionario e certificado
SELECT * FROM (
    FUNCIONARIO F INNER JOIN CERTIFICADO C
    ON F.FID = C.FID)
    ORDER BY F.FNOME;

--c) visao de uniao entre funcionario de A - F e M - Z
SELECT FNOME FROM FUNCIONARIO
WHERE FNOME > 'A%' AND FNOME < 'F%'
UNION
SELECT FNOME FROM FUNCIONARIO
WHERE FNOME > 'M%' AND FNOME < 'Z%'
ORDER BY FNOME;

--Exercicio 06: Criar tabela com junção entre Funcionario, Aernave e Certificado
CREATE TABLE FUNC_CERT_AERO AS
SELECT DISTINCT F.FID, F.FNOME, F.SALARIO, A.AID, A.ANOME, A.LIMDISTANCIA
FROM FUNCIONARIO F INNER JOIN (
    AERONAVE A INNER JOIN CERTIFICADO C
    ON A.AID = C.AID)
    ON F.FID = C.FID
    ORDER BY F.FNOME;

SELECT * FROM FUNC_CERT_AERO;

--Exercicio 07: Criar uma visão Materializada 
CREATE MATERIALIZED VIEW MV_FUNC_CERT_AERO
BUILD IMMEDIATE
REFRESH COMPLETE AS
SELECT F.FID, FNOME, F.SALARIO, A.AID, A.ANOME, A.LIMDISTANCIA
FROM FUNCIONARIO F INNER JOIN (
    AERONAVE A INNER JOIN CERTIFICADO C
    ON A.AID = C.AID)
    ON F.FID = C.FID
    ORDER BY F.FNOME;

SELECT * FROM MV_FUNC_CERT_AERO;

--Exercicio 08: Insira uma linha com seu nome e crie uma view que o selecione
INSERT INTO FUNCIONARIO VALUES (724589475,'Bruno Alberto de Oliveira', 9999);

CREATE VIEW MEU_NOME AS
SELECT FNOME FROM FUNCIONARIO F
WHERE F.FNOME LIKE '%Bruno%';

SELECT * FROM MEU_NOME;








