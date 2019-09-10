/*
--1):

create table aluno (id integer primary key, nome varchar(50));
INSERT into aluno values (1, 'Armando Nascimento');
INSERT into aluno values (2, 'Jose Raimundo');
INSERT into aluno values (3, 'Joao Marinho');
INSERT into aluno values (4, 'Juca Chaves');
INSERT into aluno values (5, 'Marina Silva');
commit;
*/

--A)
--UPDATE aluno set nome = 'Jose Raimundo da Silva' where id = 2;
--select * from aluno;

--C)
--ROLLBACK;

--2)
--B
--UPDATE aluno set nome = 'Jose Raimundo da Silva' where id = 2;
--commit;

--3)
--select * from aluno where NOME LIKE 'J%';

--4)
--passo 1
--update aluno set nome = 'Joao Roberto Marinho' where id = 3;
--passo 4
--update aluno set nome = 'Chaves Chapolim Colorado' where id = 4;commit;
--select * from aluno;
--ALTER SESSION SET ISOLATION_LEVEL = SERIALIZABLE;

--5)
--leitura não repetitiva
select * from aluno;

--leitura fantasma
--passo 1
select * from aluno;
--passo 
select * from aluno where NOME LIKE 'A%';


