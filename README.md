# Execução do projeto

Segue abaixo a menção de algumas etapas necessárias para configurar o projeto na execução local. de como configurar o projeto;

1. `composer init`
> Instalar as dependências do composer

2. `composer dump-autoload`
> Ajustar o autoloader

3. Executar o script SQL abaixo:

``` SQL
-- Tabela de Venda
DROP TABLE IF EXISTS `projetomvc`.`TBVenda`;

-- Tabela de Produto
DROP TABLE IF EXISTS `projetomvc`.`TBProduto`;

CREATE TABLE `projetomvc`.`TBProduto` (
  `PROcodigo` INT AUTO_INCREMENT NOT NULL,
  `PROcodigo_barras` VARCHAR(45) NOT NULL UNIQUE,
  `PROdescricao` VARCHAR(45) NOT NULL,
  `PROvalor_unitario` DECIMAL(10, 2) NOT NULL,
  `PROestoque` INT NOT NULL,
  `PROdata_ultima_venda` DATE NULL,
  `PROativo` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`PROcodigo`),
  CONSTRAINT `chk_proativo` CHECK (`PROativo` IN (0, 1))
) COMMENT = 'Tabela de produtos';

INSERT INTO
  projetomvc.TBProduto (PROcodigo_barras, PROdescricao, PROvalor_unitario, PROestoque, PROdata_ultima_venda, PROativo)
VALUES
  (111, 'Batata',  7.5, 5,  CURRENT_DATE, 1),
  (222, 'Maçã',    9.0, 15, CURRENT_DATE, 1),
  (333, 'Laranja', 3.5, 25, CURRENT_DATE, 1),
  (444, 'Banana',  0.5, 35, CURRENT_DATE, 1),
  (555, 'Cebola',  3.5, 45, CURRENT_DATE, 0);

SELECT
  *
FROM
  projetomvc.TBProduto;

CREATE TABLE `projetomvc`.`TBVenda` (
  `VENcodigo` INT AUTO_INCREMENT NOT NULL,
  `PROcodigo` INT NOT NULL,
  `VENquantidade` INT NOT NULL,
  `VENvalor_unitario` DECIMAL(10, 2) NOT NULL,
  `VENvalor_total` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`VENcodigo`),
  FOREIGN KEY (PROcodigo) REFERENCES projetomvc.TBProduto(PROcodigo)
) COMMENT = 'Tabela de vendas';

INSERT INTO
  projetomvc.TBVenda (PROcodigo, VENquantidade, VENvalor_unitario, VENvalor_total)
VALUES
  (1, 10, 1.5, 15),
  (2, 10, 1.5, 15),
  (3, 10, 1.5, 15),
  (4, 10, 1.5, 15),
  (5, 10, 1.5, 15);

SELECT
  *
FROM
  projetomvc.TBVenda;
```

4. Verificar se as definições de usuário/senha do MySQL estão coerentes. Veja em: `Conexao->__construct`;

# Observações

1. O projeto foi pensado e desenvolvido sob a arquitetura MVC;

2. Reduzido ao máximo o uso de "possíveis" ajax, priorizando sempre o processamento no back-end;
> Foco em performance, diminuindo tempo de espera e ociosidade das requisições.

3. Implementado uma gestão de "Rotas" simples para facilitar o uso de URL's amigáveis;
> O uso das rotas necessitou a criação do arquivo `.htacess`, portanto, é necessário verificar se o servidor que está rodando permite a reescrita de suas configurações.

4. Criadas classes "bases" para aumentar o reaproveitamento de código;

5. Implementadas interfaces para facilitar a comunicação entre as camadas;
> O intuito é garantir que algumas entidades sempre possuam métodos específicos e utilizados no seu gerenciamento, como é o caso das entidades "Model" que devem conter os métodos de "update, create, delete..."

7. Implementada a seguinte regra de negócio aos registros de produto: 
  1. Quando o usuário seleciona a ação "excluir", o status do registro é alterado para inativo, impedindo que seja utilizado nas rotinas e sendoa presentado apenas na rotina de "Lixeira";

  2. O intuito desta implementação é facilitar a gestão dos registros, permitindo que seja recuperada a informação com facilidade. Futuramente, pode ser implementada uma nova funcionalidade que faça a exclusão dos registros esporádicamente(a cada 15/30 dias) evitando o acumulo de informação não utilizada no SGBD;

8. A rotina de "Venda" foi desenvolvida sob a seguinte regra de negócio:
  1. Ao selecionar o registro de produto, o sistema identifica a quantidade em estoque e o valor unitário;
  
  2. O campo "Quantidade" recebe a definição de valor máximo permitido, evitando que o usuário faça a venda de mais produtos do que ele contém em estoque;
  
  3. O "Valor Total" sempre será calculado quando houverem alterações nos campos de "Quantidade" e "Valor Unitário";
  
  4. Ao marcar a flag "Atualizar valor unitário do produto" o sistema irá realizar a atualização do registro de produto, evitando a necessidade de acessar a rotina de "Produto".

9. Rotas disponíveis; 
  - `/`                            - Página inicial
  - `/home`                        - Página inicial
  - `/vendas`                      - Consulta de vendas"
  - `/produtos`                    - Consulta de produtos
  - `/produtos/cadastrar`          - Cadastro de produto
  - `/vendas/cadastrar`            - Cadastro de venda
  - `/produtos/alterar/([0-9]+)`   - Alterar produto
  - `/produtos/lixeira`            - Consulta da "Lixeira"
  - `/produtos/desativar/([0-9]+)` - Ação de "Excluir"
  - `/produtos/ativar/([0-9]+)`    - Ação de "Recuperar"
> Algumas rotas podem aparecer de forma "duplicada", estando presento nas rotas "GET" & "POST". Isto ocorre pois a primeira rota é responsável por carregar a tela de manutenção do registro(rota get) e posteriormente é realizado o processamento e armazenamento no banco(rota post).

# Comentários: 

1. O intuito do desenvolvimento de um "mini-framework" é para demonstrar domínio da linguagem e demais conhecimentos em desenvolvimento web;
> Usando um framework como Laravel/Symfony/Zend, os "maiores" desafios seriam facilmente contornados, o que tornaria o desenvolvimento do projeto muito simplificado.

2. Possíveis melhorias poderiam ser aplicadas no oprojeto visando qualidade de software, como:

   1. Uso de uma ORM para realizar validações e processamentos com dados do registro;

   2. Uso de um arquivo `.env` para definir "constantes" e valores editáveis a cada local de execução;
   
   3. Adição de mensagens de validação/informativas para aumentar a acessibilidade do sistema, atualizando o usuário sobre o que está acontecendo;
   
   4. Melhorar questões como carregamento automático de modelos no controller, realizando chamadas no padrão "Factory" para garantir que sempre haverá uma instância do model condizente com o controller;
   
   5. Construção de "ViewsComponente" para melhorar a criação de elementos dinâmicos(linhas da consulta, itens para selecionar...) evitando a manipulação de HTML de forma direta pelo PHP.
