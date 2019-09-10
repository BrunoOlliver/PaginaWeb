-------------------------------
-- Tabelas:
-- CLIENTE (CODCLI, NOME, ENDERECO, CIDADE, CEP, UF, CGC)
-- VENDEDOR (CODVEND, NOME, SALFIXO, FAIXACOMIS CHAR)
-- PRODUTO (CODPROD, DESCRI, AUTOR, VALUNIT)
-- PEDIDO (NUMPED, PRAZOENTR, CODCLI, CODVEND, VALORTOTAL, DATA)
-- ITEMPED (NUMPED, CODPROD, QUANT)

-----------------------------------------------------------------------------------------------------------
-- Consulta 1
-- O atributo PEDIDO.VALORTOTAL é redundante pois contém valores calculados a partir de outros atributos.
-- Como o estagiário não criou um trigger para mantê-lo atualizado, atualmente contém valores que não condizem com o total de cada pedido.
-- Atualize em todos os pedidos o campo PEDIDO.VALORTOTAL com a agregação do ITEMPED.QUANT * PRODUTO.VALUNIT utilizando o update a seguir.

update pedido P1
   set VALORTOTAL = (
            select sum(quant*valunit)
              from cliente c, pedido p, itemped i, produto pr
             where c.codcli = p.codcli
               and p.numped = i.numped
               and i.codprod = pr.codprod
               and p.numped = P1.numped);

-- Analise o plano de consulta do comando UPDATE. Verifique se os indices de chave primária são empregados. 
-- Apresente e explique o algoritmo utilizado pelo Oracle para fazer a junção entre Produto e ItemPedido.
-- Veja a explicação do algoritmo de junção pelo fabricante no documento Aula10b_OracleExplainTheExplainPlan.pdf enviado.



-----------------------------------------------------------------------------------------------------------
-- Consulta 2
-- Selecione os clientes que compraram entre 01/05/18 e 10/05/18, apresente o valor total dos pedidos por cliente e 
-- a quantidade de pedidos realizados por cliente.
-- Ordene o resultado em ordem descendente de valor total para permitir encontrar os maiores compradores.
-- Não utilize no calculo o atributo PEDIDO.VALORTOTAL pois ainda não há um trigger para mantê-lo atualizado.

alter session set nls_date_format = 'DD/MM/YYYY';

select c.nome, count(distinct(p.NUMPED)), sum(quant*valunit) as soma
from cliente c, pedido p, itemped i, produto pr
where c.codcli = p.codcli
and p.numped = i.numped
and i.codprod = pr.codprod
and p.data between '01/05/2018' and '10/05/2018'
group by c.nome
order by soma desc;

-- Analise o plano de consulta do comando SELECT. Verifique se os indices de chave primária são empregados. 
-- Verifique se a criação (ou a remoção caso ele ja exista) do indice:
CREATE INDEX PEDIDO_DATA ON PEDIDO(DATA);
-- ou
DROP INDEX PEDIDO_DATA;
-- melhora (ou piora) o desempenho dessa consulta. Comente o resultado. 
-- Qual o tempo (em segundos) e o custo (explain plan) para executar a consulta sem o indice e com o indice?

-----------------------------------------------------------------------------------------------------------
-- Consulta 3
-- Verifique se o Oracle utiliza o indice composto PEDIDO_PRAZO_DATA para execução da consulta abaixo considerando a existencia ou nao do indice PEDIDO_DATA. Comente o resultado.

select * from pedido where prazoentr between 15 and 25 and data between '01/05/2018' and '30/06/2018';

CREATE INDEX PEDIDO_PRAZO_DATA ON PEDIDO(DATA,PRAZOENTR);
DROP INDEX PEDIDO_PRAZO_DATA;
