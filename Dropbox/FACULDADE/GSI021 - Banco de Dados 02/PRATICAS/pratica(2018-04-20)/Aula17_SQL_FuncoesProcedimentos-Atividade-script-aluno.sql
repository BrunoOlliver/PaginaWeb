drop sequence seq_num_nota;
drop sequence seq_num_pedido;
drop table itensnota;
drop table nota;
drop table itenspedido;
drop table pedido;
drop table produto;
drop table cliente;

create table cliente (
   cpf decimal(11) primary key, 
   nome varchar(20) not null
);

insert into cliente values(12345,'Natuza Nery');
insert into cliente values(23456,'Mariana Godoy');
insert into cliente values(34567,'Elisabete Pacheco');
insert into cliente values(45678,'Heraldo Pereira');

create table produto (
   produto decimal(10) primary key, 
   descricao varchar(30),
   valorunitario decimal(10,2), 
   estoque decimal(10,2) default 0
);

insert into produto values(1,'Almanaque da Monica',4.99, 40);
insert into produto values(2,'Almanaque do Cebolinha',4.99, 5);
insert into produto values(3,'Almanaque do Cascao',4.99, 35);
insert into produto values(4,'Almanaque da Magali',3.99, 20);
insert into produto values(5,'Almanaque do Chico Bento',3.99, 50);
insert into produto values(6,'Gibi da Monica',2.99, 150);
insert into produto values(7,'Gibi do Cebolinha',2.99, 5);
insert into produto values(8,'Gibi do Cascao',1.99, 200);
insert into produto values(9,'Gibi da Magali',1.99, 50);
insert into produto values(10,'Gibi do Chico Bento',1.99, 75);

create table pedido (
   num decimal(10) primary key,
   cpf decimal(11) not null references cliente(cpf),
   data date,
   notagerada decimal(10) default null
);

create table itenspedido (
   num decimal(10) references pedido(num),
   produto decimal(10) references produto(produto) not null,
   quantidade decimal(10,2) not null,
   valorunitario decimal(10,2),
   valortotal decimal(10,2),
   primary key (num,produto)
);

create sequence seq_num_pedido start with 1;

insert into pedido values (seq_num_pedido.nextval, 23456, sysdate, null);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 1, 10);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 2, 12);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 3, 1);

insert into pedido values (seq_num_pedido.nextval, 12345, sysdate, null);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 2, 5);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 3, 6);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 4, 7);

insert into pedido values (seq_num_pedido.nextval, 34567, sysdate, null);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 4, 7);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 5, 8);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 6, 9);
insert into itenspedido (num,produto,quantidade) values (seq_num_pedido.currval, 7, 10);

select * from itenspedido;

create sequence seq_num_nota start with 1;

create table nota (
   num decimal(10) primary key,
   cpf decimal(11) not null references cliente(cpf),
   data date,
   valortotal decimal(10,2)
);

create table itensnota (
   num decimal(10) references nota(num),
   produto decimal(10) references produto(produto) not null,
   quantidade decimal(10,2) not null,
   valorunitario decimal(10,2) not null,
   valortotal decimal(10,2) not null,
   primary key (num,produto)
);

set serveroutput on;

create or replace procedure criarnota(numpedido integer) is
begin
    select num, cpf into pnum, pcpf from pedido where num = numpedido;
    if SQL%notfound then
       DBMS_OUTPUT.PUT_LINE('Pedido não encontrado'); -- se put_line não sair no console, execute 'set serveroutput on;'
    else
       DBMS_OUTPUT.PUT_LINE('Pedido ' || numpedido || ' encontrado');
       -- fazer insert into nota
       -- para cada item de noto
          -- fazer inserts into itensnota
          -- fazer update no estoque do produto
    end if;
end;

--execute criarnota(1);
--execute criarnota(10);
