/*
DROP PROCEDURE SELECT_CLIENTE;

CREATE OR REPLACE PROCEDURE SELECT_CLIENTE AS
    v_codcli CLIENTE.CODCLI%TYPE;
    v_nomecli CLIENTE.NOMECLI%TYPE;
    v_endercli CLIENTE.ENDERECO%TYPE;
    
    CURSOR cursor_cliente IS
        SELECT Cli.CODCLI,Cli.NOMECLI,Cli.ENDERECO FROM CLIENTE Cli;
    BEGIN
        OPEN cursor_cliente;
        LOOP
            FETCH cursor_cliente INTO v_codcli,v_nomecli,v_endercli;
            EXIT WHEN cursor_cliente%NOTFOUND;
            dbms_output.put_line(v_codcli || v_nomecli || v_endercli);
        END LOOP;
        CLOSE cursor_cliente;
    END SELECT_CLIENTE;


*/
create or replace procedure criarnota(numpedido integer) is
    pnum pedido.num%type;
    pcpf pedido.cpf%type;
    soma decimal(10,2);
    cursor cpedido (nump integer) is 
       select num, cpf 
         from pedido 
        where num = nump;
    cursor citenspedido (nump integer) is 
       select i.produto, i.quantidade, p.valorunitario, p.estoque
         from itenspedido i join produto p on (i.produto = p.produto) 
        where num = nump;
begin
    open cpedido(numpedido);
    fetch cpedido into pnum, pcpf;
    if cpedido%notfound then
       DBMS_OUTPUT.PUT_LINE('Pedido ' || numpedido || ' não encontrado');
    else
       DBMS_OUTPUT.PUT_LINE('Pedido ' || numpedido || ' encontrado');
       select sum(valortotal) into soma
         from itenspedido
        where num = numpedido;

       insert into nota values (seq_num_nota.nextval, pcpf, sysdate, soma);
       DBMS_OUTPUT.PUT_LINE('Nota gerada numero ' || seq_num_nota.currval);

       for i in citenspedido(numpedido) loop
           if i.estoque < i.quantidade then
               DBMS_OUTPUT.PUT_LINE('Produto ' || i.produto || ' quantidade insuficiente estoque ' || i.estoque || ' qtde pedido ' || i.quantidade || ' Valor ' || i.valorunitario || ' Total ' || i.quantidade * i.valorunitario);
           else
               update produto set estoque = estoque - i.quantidade
               where produto = i.produto;

               insert into itensnota 
               values (seq_num_nota.currval, i.produto, i.quantidade, i.valorunitario, i.quantidade * i.valorunitario);
               DBMS_OUTPUT.PUT_LINE('Produto ' || i.produto || ' Quantidade ' || i.quantidade || ' estoque ' || i.estoque || ' Valor ' || i.valorunitario || ' Total ' || i.quantidade * i.valorunitario);
           end if;
       end loop;
    end if;
end;


