-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Jul-2021 às 23:44
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `devio`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `senha` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`admin_id`, `usuario`, `senha`) VALUES
(1, 'admin', 'f293dfa81677e04dd60c6cbd57f3db26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `cardapio_id` int(11) NOT NULL,
  `disponivel` int(11) DEFAULT 0,
  `prato_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

CREATE TABLE `comanda` (
  `pedido_fk` int(11) NOT NULL,
  `cardapio_fk` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `pedido_id` int(11) NOT NULL,
  `concluido` int(11) DEFAULT 0,
  `cliente_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prato`
--

CREATE TABLE `prato` (
  `prato_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  `preco` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `prato`
--

INSERT INTO `prato` (`prato_id`, `nome`, `descricao`, `imagem`, `preco`) VALUES
(1, 'Bruschetta', 'Feito à base de pão, é tostado em grelha com azeite e alho e tem muitas variações de recheio', 'bruschetta.png', '40.00'),
(2, 'Nhoque de Ricota com Espinafre', 'O nhoque é feito a partir de batata ou macaxeira com farinha de trigo. Pode ser servido com diversos tipos de molho, de acordo com o seu gosto, sendo os mais tradicionais sugo, bolonhesa ou branco.', 'nhoque.png', '25.00'),
(3, 'Lasanha com Polpetas', 'A massa também é conhecida por outras grafias similares como lasagne e lasagna. A massa folheada é uma queridinha em todo o mundo. Nesta receita, caso prefira, troque o molho pelo de queijo cremoso e a proteína por frango. ', 'lasanha.png', '35.90'),
(4, 'Fettuccine', 'Uma verdadeira macarronada feita com uma massa um pouco mais grossa que o tradicional espaguete.', 'fettuccine.png', '78.80'),
(5, 'Ravioli de Ricota e Espinafre com Molho de Açafrão', 'Estes pequenos pastéis de massa feitos com farinha de trigo e ovo, nesta receita, são recheados com ricota e espinafre. O prato é finalizado com molho de açafrão.', 'ravioli.png', '60.00'),
(6, 'Risoto Carbonara', 'Risoto é um prato típico da culinária italiana e seu nome significa literalmente arrozinho.', 'risoto.png', '15.00'),
(7, 'Ossobuco ao Forno', 'O ossobuco é um prato originário da região italiana chamada de Lombardia, em especial da cidade de Milão. Literalmente, o termo significa \"osso buraco\". A explicação é simples: no norte da Itália o chambão de vitela é cortado em rodelas juntamente com os ossos.', 'ossobuco.png', '45.60'),
(8, 'Cannoli', 'Cannoli é uma sobremesa originária da Sicília. Consiste em massa doce frita em formato de tubinhos e recheada com o doce que você preferir.', 'cannoli.png', '20.00'),
(9, 'Tiramisu', 'Tipicamente italiana, acredita-se que a sobremesa é originária da cidade de Treviso, na região do Vêneto. Consiste em camadas de biscoitos de champagne, que também podem ser substituídos por pão de ló, embebidas em café. Alguns chefs preferem usar a versão solúvel do grão por ela permitir maior precisão no controle da receita. As camadas de biscoito ou pão de ló são entremeadas por um creme à base de mascarpone. Por fim, é polvilhado cacau em pó e café.', 'tiramisu.png', '30.00'),
(10, 'Bisteca Fiorentina', 'Típica da região da Toscana, especialmente na capital, Florença, a Bisteca Fiorentina já entrou em diversos rankings de melhores carnes do mundo. Extraído de vacas da raça italiana Chianina, o corte da bisteca fiorentina engloba o que no Brasil conhecemos como filé mignon, contra filé e alcatra. A carne deve ser assada e, segundo a tradição, acompanhada de vinho Chianti, também de origem toscana.', 'bisteca.png', '50.65');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Índices para tabela `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`cardapio_id`),
  ADD KEY `fk_cardapio_prato_idx` (`prato_fk`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Índices para tabela `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`pedido_fk`,`cardapio_fk`),
  ADD KEY `fk_pedido_has_cardapio_cardapio1_idx` (`cardapio_fk`),
  ADD KEY `fk_pedido_has_cardapio_pedido1_idx` (`pedido_fk`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `fk_pedido_cliente1_idx` (`cliente_fk`);

--
-- Índices para tabela `prato`
--
ALTER TABLE `prato`
  ADD PRIMARY KEY (`prato_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `cardapio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `prato`
--
ALTER TABLE `prato`
  MODIFY `prato_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cardapio`
--
ALTER TABLE `cardapio`
  ADD CONSTRAINT `fk_cardapio_prato` FOREIGN KEY (`prato_fk`) REFERENCES `prato` (`prato_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `fk_pedido_has_cardapio_cardapio1` FOREIGN KEY (`cardapio_fk`) REFERENCES `cardapio` (`cardapio_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_has_cardapio_pedido1` FOREIGN KEY (`pedido_fk`) REFERENCES `pedido` (`pedido_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente_fk`) REFERENCES `cliente` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
