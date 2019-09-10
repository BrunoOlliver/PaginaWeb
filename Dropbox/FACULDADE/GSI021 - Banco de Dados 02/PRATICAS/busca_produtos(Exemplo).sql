drop package PCK_CLIENT_PROD;
drop package body PCK_CLIENT_PROD;
/*
CREATE OR REPLACE PACKAGE PCK_CLIENT_PROD IS
    CURSOR CPROD_CLIENT(cpf INTEGER);
END PCK_CLIENT_PROD;

CREATE OR REPLACE PACKAGE BODY PCK_CLIENT_PROD IS
    total VARCHAR(100);
    CURSOR CPROD_CLIENT (cpf INTEGER) IS
        SELECT produto, descricao, valorunitario, SUM(valorunitario) AS total
        FROM cliente C INNER JOIN (
            pedido P INNER JOIN itempedido I
            ON P.num = I.num) ON C.cpf = P.cpf;
    busca VARCHAR(100);
    BEGIN
        OPEN CPROD_CLIENT(cpf);
        FETCH CPROD_CLIENT INTO BUSCA LOOP;
            dbms_output.put_line('CPF: '||cpf||'produto: '||busca);
            WHERE CPROD_CLIENT%NOTFOUND;
            END LOOP;
        CLOSE CPROD_CLIENT(cpf);
    END;
END PCK_CLIENT_PROD;


SELECT C.CPF, P.produto, P.descricao, P.valorunitario
FROM produto P, cliente C
WHERE C.cpf IN (
    SELECT Ped.cpf 
    FROM Pedido Ped, Itenspedido Item
    WHERE Ped.num = Item.num)
ORDER BY C.cpf;
*/


