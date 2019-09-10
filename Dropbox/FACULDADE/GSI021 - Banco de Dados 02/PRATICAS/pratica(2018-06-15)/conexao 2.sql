--1)
--B)
--select * from aluno;

--2
--A)
--select * from aluno;
--C)
--select * from aluno;

--3)
--INSERT INTO aluno values(6,'Jose Ricardo Maria');
--commit;

--4)
--passo 2
--update aluno set nome = 'Juca Chaves Chapolim' where id = 4;
--passo 3
--update aluno set nome = 'Jose Roberto Marinho' where id = 3;commit;
--select * from aluno;

--5)
--leitura não repetitiva
--update aluno set nome = 'Armando Silva Nascimento' where id = 1;commit;
select * from aluno;

--leitura fantasma
--INSERT INTO aluno values(7,'Armando Augusto Pereira');
--INSERT INTO aluno values(7,'Armando da Cunha Neto');
--commit;


