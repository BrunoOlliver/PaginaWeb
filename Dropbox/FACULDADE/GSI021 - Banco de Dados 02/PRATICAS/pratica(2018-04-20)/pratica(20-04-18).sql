
CREATE OR REPLACE PACKAGE pck_dados_pedido IS
    PROCEDURE insere_pedido(num_pedido INTEGER);
END pck_dados_pedido;

CREATE OR REPLACE PACKAGE BODY pck_dados_pedido IS
    presult integer;
    PROCEDURE insere_pedido(num_pedido INTEGER) AS
        pnum pedido.num%type;
        pcpf pedido.cpf%type;
        pdata pedido.data%type;
        pvalor_total nota.valortotal%type;
    CURSOR ItensPedidoEstoque(numpedido INTEGER) IS
    SELECT * 
    FROM itenspedido INNER JOIN produto
    ON itenspedido.produto = produto.produto;
    
    BEGIN
    OPEN ItensPedidoEstoque(numpedido);
    FOR i IN ItensPedidoEstoque(numpedido) LOOP
    presult := i;
    END LOOP
    
    IF itenspedido.quantidade >= presult THEN
        INSERT INTO nota VALUES(pnum,pcpf,pdata, pvalor_total);
    ELSE
        NULL;
    END IF;
    END;
END pck_dados_pedido;






