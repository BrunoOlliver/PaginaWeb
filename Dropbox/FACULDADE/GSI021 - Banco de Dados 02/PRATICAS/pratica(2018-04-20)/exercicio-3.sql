CREATE OR REPLACE PACKAGE pck_pedidos IS

  procedure pedido_em_nota(numpedido in integer);
  sequence seq_numero_nota;

END pck_pedidos;

CREATE OR REPLACE PACKAGE BODY pck_pedidos IS
  --sequence seq_numero_nota start with 1;
   PROCEDURE pedido_em_nota(numpedido integer) AS
      v_result varchar2(100);
      --qtd_estoque produto.estoque%type;
        pnum pedido.num%type;
        pcpf pedido.cpf%type;
        pdata pedido.data%type;
        pvalortotal pedido.valortotal%type;
     -- teste integer := seq_numero_nota.nextval;
      CURSOR ItensPedidoEstoque(num_pedido integer) IS
        SELECT *
        from itenspedido v_itens_pedido, produto v_produto
        where v_itens_pedido.num = num_pedido and v_produto.produto = v_itens_pedido.produto;
    BEGIN
             
       if SQL%notfound then
          DBMS_OUTPUT.PUT_LINE('Pedido não encontrado'); -- se put_line não sair no console, execute 'set serveroutput on;'
           end ;
        else
           DBMS_OUTPUT.PUT_LINE('Pedido ' || numpedido || ' encontrado');
        end if; 
        
        select num,cpf,data,valortotal into pnum, pcpf, pdata, pvalortotal from pedido where num = numpedido;
        insert into nota values(numpedido,pcpf,pdata,pvalortotal); -- (*)substituir numpedido por sequencia
       
      open ItensPedidoEstoque(numpedido); 
      
        LOOP
            FETCH ItensPedidoEstoque INTO v_result;
            EXIT WHEN ItensPedidoEstoque%NOTFOUND;
             if (v_result.quantidade <= v_result.estoque) then
                v_result.estoque := v_result.estoque - v_result.quantidade;
                insert into itensnota values(v_result.num,v_result.produto,v_result.quantidade,v_result.valorunitario,v_result.valortotal);
                update produto set estoque = v_result.estoque;
                DBMS_OUTPUT.PUT_LINE('Atualizado!');
              else
                DBMS_OUTPUT.PUT_LINE('Estoque insuficiente para o produto ' || v_result.produto);
             end if;
        end loop;
      close ItensPedidoEstoque;
  end;

end pck_pedidos;


