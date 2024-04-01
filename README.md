1. composer init
2. composer dump-autoload
3. Construção de views

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
