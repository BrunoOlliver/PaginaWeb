DROP VIEW FUN_MAIOR_SAL;
DROP VIEW fun_dois_maior_sal;

-- Exercicio 01: funcionario com maior salário
CREATE VIEW fun_maior_sal
    AS SELECT fid, fnome, salario 
    FROM FUNCIONARIO
    WHERE salario = (
      SELECT MAX(salario) FROM FUNCIONARIO
    );
    
SELECT * FROM FUN_MAIOR_SAL;
  
-- Exercicio 02: DOIS Funcionarios com maior salário
CREATE VIEW fun_dois_maior_sal
  AS SELECT * 
  FROM FUNCIONARIO
    WHERE SALARIO IN(
    SELECT SALARIO FROM (
      SELECT SALARIO 
      FROM FUNCIONARIO
      ORDER BY SALARIO DESC
    )
    WHERE ROWNUM <= 3
  )
  ORDER BY SALARIO DESC;

SELECT * FROM FUN_DOIS_MAIOR_SAL;

-- Exercicio 03: IDS E NOMES CERTIFICADOS
CREATE VIEW cert_mil_milhas 
  AS SELECT fid, fnome,

  