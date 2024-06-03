-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 03/06/2024 às 00:27
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `patinhas`
--
CREATE DATABASE IF NOT EXISTS `patinhas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `patinhas`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento_servico`
--

DROP TABLE IF EXISTS `agendamento_servico`;
CREATE TABLE IF NOT EXISTS `agendamento_servico` (
  `idAgendamento` int NOT NULL AUTO_INCREMENT,
  `idServico` int DEFAULT NULL,
  `idCliente` int DEFAULT NULL,
  `Data_Agendamento` date NOT NULL,
  `Horario_Agendamento` time NOT NULL,
  `Observacoes_Adicionais` text COLLATE utf8mb4_general_ci,
  `Status_Agendamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Pendente',
  PRIMARY KEY (`idAgendamento`),
  KEY `idServico` (`idServico`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `CPF` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `Numero_Telefone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `Nome`, `CPF`, `Numero_Telefone`) VALUES
(1, 'Maria da Silva', '12345678901', '(11) 91234-5678'),
(2, 'João Pereira', '23456789012', '(21) 98765-4321'),
(3, 'Ana Souza', '34567890123', '(31) 97654-3210'),
(4, 'Carlos Santos', '45678901234', '(41) 96543-2109'),
(5, 'Fernanda Lima', '56789012345', '(51) 95432-1098'),
(6, 'Ricardo Oliveira', '67890123456', '(61) 94321-0987'),
(7, 'Beatriz Mendes', '78901234567', '(71) 93210-9876'),
(8, 'Roberto Nogueira', '89012345678', '(81) 92109-8765'),
(9, 'Juliana Araújo', '90123456789', '(91) 91098-7654'),
(10, 'Felipe Costa', '01234567890', '(62) 99999-9999');

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

DROP TABLE IF EXISTS `endereco`;
CREATE TABLE IF NOT EXISTS `endereco` (
  `idEndereco` int NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Numero` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Complemento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Bairro` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Cidade` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Estado` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `CEP` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `idCliente` int DEFAULT NULL,
  PRIMARY KEY (`idEndereco`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`idEndereco`, `logradouro`, `Numero`, `Complemento`, `Bairro`, `Cidade`, `Estado`, `CEP`, `idCliente`) VALUES
(1, 'Rua Doutor Deodato Wertheimer', '150', 'Apto 12', 'Centro', 'Mogi das Cruzes', 'SP', '08710-150', 1),
(2, 'Avenida Vereador Narciso Yague Guimarães', '200', 'Bloco A', 'Parque Monte Líbano', 'Mogi das Cruzes', 'SP', '08780-000', 10),
(3, 'Rua Ipiranga', '250', 'Casa', 'Vila Vitória', 'Mogi das Cruzes', 'SP', '08730-000', 2),
(4, 'Rua Otto Unger', '300', 'Apto 23', 'Jardim Santista', 'Mogi das Cruzes', 'SP', '08720-090', 9),
(5, 'Avenida João XXIII', '350', '', 'Vila Industrial', 'Mogi das Cruzes', 'SP', '08710-260', 3),
(6, 'Rua Professor Flaviano de Melo', '400', 'Sala 45', 'Centro', 'Mogi das Cruzes', 'SP', '08710-370', 8),
(7, 'Rua Coronel Cardoso Siqueira', '450', '', 'Alto Ipiranga', 'Mogi das Cruzes', 'SP', '08730-080', 4),
(8, 'Rua José Bonifácio', '500', 'Apto 67', 'Centro', 'Mogi das Cruzes', 'SP', '08710-290', 7),
(9, 'Avenida Prefeito Carlos Ferreira Lopes', '550', 'Bloco B', 'Mogi Moderno', 'Mogi das Cruzes', 'SP', '08775-000', 5),
(10, 'Rua Presidente Campos Salles', '600', 'Apto 89', 'Jardim Camila', 'Mogi das Cruzes', 'SP', '08725-000', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `entradas`
--

DROP TABLE IF EXISTS `entradas`;
CREATE TABLE IF NOT EXISTS `entradas` (
  `idEntrada` int NOT NULL AUTO_INCREMENT,
  `idProduto` int NOT NULL,
  `Quantidade_Entrada` int NOT NULL,
  `Data_Entrada` date NOT NULL,
  PRIMARY KEY (`idEntrada`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `entradas`
--

INSERT INTO `entradas` (`idEntrada`, `idProduto`, `Quantidade_Entrada`, `Data_Entrada`) VALUES
(1, 1, 100, '2024-06-01'),
(2, 2, 200, '2024-06-02'),
(3, 3, 150, '2024-06-03'),
(4, 4, 80, '2024-06-04'),
(5, 5, 120, '2024-06-05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `idFornecedor` int NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Endereco` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Numero_Telefone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idFornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`idFornecedor`, `Nome`, `Endereco`, `Email`, `Numero_Telefone`) VALUES
(1, 'Maria da Silva', 'Rua Doutor Deodato Wertheimer, 150, Apto 12, Centro, Mogi das Cruzes, SP, 08710-150', 'maria.silva@example.com', '(11) 91234-5678'),
(2, 'João Pereira', 'Avenida Vereador Narciso Yague Guimarães, 200, Bloco A, Parque Monte Líbano, Mogi das Cruzes, SP, 08780-000', 'joao.pereira@example.com', '(11) 98765-4321'),
(3, 'Ana Souza', 'Rua Ipiranga, 250, Casa, Vila Vitória, Mogi das Cruzes, SP, 08730-000', 'ana.souza@example.com', '(11) 97654-3210'),
(4, 'Carlos Santos', 'Rua Otto Unger, 300, Apto 23, Jardim Santista, Mogi das Cruzes, SP, 08720-090', 'carlos.santos@example.com', '(11) 96543-2109'),
(5, 'Fernanda Lima', 'Avenida João XXIII, 350, Vila Industrial, Mogi das Cruzes, SP, 08710-260', 'fernanda.lima@example.com', '(11) 95432-1098'),
(6, 'Ricardo Oliveira', 'Rua Professor Flaviano de Melo, 400, Sala 45, Centro, Mogi das Cruzes, SP, 08710-370', 'ricardo.oliveira@example.com', '(11) 94321-0987'),
(7, 'Beatriz Mendes', 'Rua Coronel Cardoso Siqueira, 450, Alto Ipiranga, Mogi das Cruzes, SP, 08730-080', 'beatriz.mendes@example.com', '(11) 93210-9876'),
(8, 'Roberto Nogueira', 'Rua José Bonifácio, 500, Apto 67, Centro, Mogi das Cruzes, SP, 08710-290', 'roberto.nogueira@example.com', '(11) 92109-8765'),
(9, 'Juliana Araújo', 'Avenida Prefeito Carlos Ferreira Lopes, 550, Bloco B, Mogi Moderno, Mogi das Cruzes, SP, 08775-000', 'juliana.araujo@example.com', '(11) 91098-7654'),
(10, 'Felipe Costa', 'Rua Presidente Campos Salles, 600, Apto 89, Jardim Camila, Mogi das Cruzes, SP, 08725-000', 'felipe.costa@example.com', '(11) 99999-9999');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `idFuncionario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cargo` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idFuncionario`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`idFuncionario`, `nome`, `username`, `cargo`, `senha`) VALUES
(1, 'Isabelli Camargo de Oliveira', '11241405163', 'Administradora', 'admin'),
(2, 'Aline Figueiredo Ferreira', '11232200646', 'Caixa', 'admin'),
(3, 'Lucas Henrique Guissi Ferreira Lopes', '11232101497', 'Repositor', 'admin'),
(4, 'Lucas Rodrigues Silva', '11232100457', 'Atendente', 'admin'),
(5, 'Vitor Ovesso Campos', '11232102091', 'Repositor', 'admin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itempedido`
--

DROP TABLE IF EXISTS `itempedido`;
CREATE TABLE IF NOT EXISTS `itempedido` (
  `id_item_pedido` int NOT NULL AUTO_INCREMENT,
  `idVenda` int DEFAULT NULL,
  `idProduto` int DEFAULT NULL,
  `Quantidade_Vendida` int DEFAULT NULL,
  PRIMARY KEY (`id_item_pedido`),
  KEY `idVenda` (`idVenda`),
  KEY `idProduto` (`idProduto`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itempedido`
--

INSERT INTO `itempedido` (`id_item_pedido`, `idVenda`, `idProduto`, `Quantidade_Vendida`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 2, 3, 3),
(4, 3, 4, 1),
(5, 3, 5, 2),
(6, 4, 6, 2),
(7, 5, 7, 1),
(8, 6, 8, 2),
(9, 6, 9, 1),
(10, 7, 10, 3),
(11, 7, 11, 1),
(12, 8, 12, 1),
(13, 8, 13, 2),
(14, 9, 14, 2),
(15, 10, 15, 3),
(16, 11, 16, 1),
(17, 11, 17, 2),
(18, 12, 18, 2),
(19, 13, 19, 1),
(20, 13, 20, 2),
(21, 14, 21, 3),
(22, 15, 22, 1),
(23, 15, 23, 2),
(24, 16, 24, 2),
(25, 17, 25, 1),
(26, 17, 1, 2),
(27, 18, 2, 3),
(28, 19, 3, 1),
(29, 20, 4, 2),
(30, 21, 5, 2),
(31, 21, 6, 1),
(32, 22, 7, 3),
(33, 23, 8, 1),
(34, 23, 9, 2),
(35, 24, 10, 2),
(36, 25, 11, 1),
(37, 25, 12, 2),
(38, 26, 13, 3),
(39, 27, 14, 1),
(40, 28, 15, 2),
(41, 29, 16, 2),
(42, 29, 17, 1),
(43, 30, 18, 3),
(44, 31, 19, 1),
(45, 31, 20, 2),
(46, 32, 21, 2),
(47, 33, 22, 1),
(48, 33, 23, 2),
(49, 34, 24, 3),
(50, 35, 25, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE IF NOT EXISTS `pagamento` (
  `idPagamento` int NOT NULL AUTO_INCREMENT,
  `idVenda` int DEFAULT NULL,
  `Metodo_Pagamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Data_Pagamento` date DEFAULT NULL,
  `Valor_Pago` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idPagamento`),
  KEY `idVenda` (`idVenda`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`idPagamento`, `idVenda`, `Metodo_Pagamento`, `Data_Pagamento`, `Valor_Pago`) VALUES
(1, 1, 'Cartão de Crédito', '2024-06-02', 100.00),
(2, 2, 'Dinheiro', '2024-06-03', 150.00),
(3, 3, 'Transferência Bancária', '2024-06-04', 200.00),
(4, 4, 'Dinheiro', '2024-06-05', 120.00),
(5, 5, 'Dinheiro', '2024-06-06', 180.00),
(6, 6, 'Cartão de Crédito', '2024-06-07', 220.00),
(7, 7, 'Transferência Bancária', '2024-06-08', 300.00),
(8, 8, 'Dinheiro', '2024-06-09', 90.00),
(9, 9, 'Cartão de Crédito', '2024-06-10', 130.00),
(10, 10, 'Cartão de Débito', '2024-06-11', 250.00),
(11, 11, 'Transferência Bancária', '2024-06-12', 180.00),
(12, 12, 'Dinheiro', '2024-06-13', 190.00),
(13, 13, 'Cartão de Crédito', '2024-06-14', 210.00),
(14, 14, 'Dinheiro', '2024-06-15', 280.00),
(15, 15, 'Cartão de Débito', '2024-06-16', 150.00),
(16, 16, 'Transferência Bancária', '2024-06-17', 200.00),
(17, 17, 'Dinheiro', '2024-06-18', 110.00),
(18, 18, 'Cartão de Crédito', '2024-06-19', 90.00),
(19, 19, 'Cartão de Débito', '2024-06-20', 130.00),
(20, 20, 'Transferência Bancária', '2024-06-21', 220.00),
(21, 21, 'Dinheiro', '2024-06-22', 180.00),
(22, 22, 'Cartão de Crédito', '2024-06-23', 250.00),
(23, 23, 'Dinheiro', '2024-06-24', 280.00),
(24, 24, 'Transferência Bancária', '2024-06-25', 190.00),
(25, 25, 'Cartão de Débito', '2024-06-26', 200.00),
(26, 26, 'Cartão de Crédito', '2024-06-27', 220.00),
(27, 27, 'Transferência Bancária', '2024-06-28', 150.00),
(28, 28, 'Dinheiro', '2024-06-29', 160.00),
(29, 29, 'Cartão de Crédito', '2024-06-30', 180.00),
(30, 30, 'Dinheiro', '2024-07-01', 210.00),
(31, 31, 'Cartão de Débito', '2024-07-02', 250.00),
(32, 32, 'Transferência Bancária', '2024-07-03', 180.00),
(33, 33, 'Dinheiro', '2024-07-04', 300.00),
(34, 34, 'Cartão de Crédito', '2024-07-05', 220.00),
(35, 35, 'Transferência Bancária', '2024-07-06', 200.00),
(36, 36, 'Dinheiro', '2024-07-07', 150.00),
(37, 37, 'Cartão de Débito', '2024-07-08', 180.00),
(38, 38, 'Cartão de Crédito', '2024-07-09', 200.00),
(39, 39, 'Transferência Bancária', '2024-07-10', 220.00),
(40, 40, 'Dinheiro', '2024-07-11', 250.00),
(41, 41, 'Cartão de Crédito', '2024-07-12', 180.00),
(42, 42, 'Cartão de Débito', '2024-07-13', 190.00),
(43, 43, 'Transferência Bancária', '2024-07-14', 210.00),
(44, 44, 'Dinheiro', '2024-07-15', 280.00),
(45, 45, 'Cartão de Crédito', '2024-07-16', 150.00),
(46, 46, 'Dinheiro', '2024-07-17', 200.00),
(47, 47, 'Transferência Bancária', '2024-07-18', 110.00),
(48, 48, 'Cartão de Débito', '2024-07-19', 90.00),
(49, 49, 'Dinheiro', '2024-07-20', 130.00),
(50, 50, 'Cartão de Crédito', '2024-07-21', 220.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pet`
--

DROP TABLE IF EXISTS `pet`;
CREATE TABLE IF NOT EXISTS `pet` (
  `idPet` int NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Especie` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Raca` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Genero` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idCliente` int DEFAULT NULL,
  PRIMARY KEY (`idPet`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pet`
--

INSERT INTO `pet` (`idPet`, `Nome`, `Especie`, `Raca`, `Genero`, `idCliente`) VALUES
(1, 'Bobby', 'Cachorro', 'Golden Retriever', 'Macho', 1),
(2, 'Luna', 'Cachorro', 'Labrador', 'Fêmea', 2),
(3, 'Mimi', 'Gato', 'Persa', 'Fêmea', 3),
(4, 'Rex', 'Cachorro', 'Pastor Alemão', 'Macho', 4),
(5, 'Bella', 'Gato', 'Siamês', 'Fêmea', 5),
(6, 'Charlie', 'Cachorro', 'Bulldog', 'Macho', 6),
(7, 'Max', 'Cachorro', 'Poodle', 'Macho', 7),
(8, 'Lily', 'Gato', 'Maine Coon', 'Fêmea', 8),
(9, 'Oscar', 'Cachorro', 'Beagle', 'Macho', 9),
(10, 'Daisy', 'Gato', 'Ragdoll', 'Fêmea', 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `idProduto` int NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Descricao` text COLLATE utf8mb4_general_ci,
  `Preco` decimal(10,2) NOT NULL,
  `Quantidade_Estoque` int NOT NULL,
  `Quantidade_Minima` int NOT NULL,
  `idFornecedor` int DEFAULT NULL,
  PRIMARY KEY (`idProduto`),
  KEY `idFornecedor` (`idFornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `Nome`, `Descricao`, `Preco`, `Quantidade_Estoque`, `Quantidade_Minima`, `idFornecedor`) VALUES
(1, 'Ração para Cachorros', 'Ração premium para cachorros adultos de 15kg', 120.00, 100, 20, 1),
(2, 'Ração para Gatos', 'Ração premium para gatos adultos de 10kg', 90.00, 80, 15, 2),
(3, 'Shampoo para Cães', 'Shampoo neutro para cães de todas as raças, 500ml', 25.00, 200, 30, 3),
(4, 'Coleira Antipulgas', 'Coleira antipulgas e carrapatos, duração de 8 meses', 60.00, 150, 25, 4),
(5, 'Brinquedo para Gatos', 'Brinquedo interativo para gatos, formato de ratinho', 15.00, 300, 50, 5),
(6, 'Caminha para Cachorros', 'Caminha acolchoada para cachorros de porte médio', 100.00, 50, 10, 6),
(7, 'Areia para Gatos', 'Areia sanitária para gatos, pacote de 5kg', 20.00, 120, 20, 7),
(8, 'Petiscos para Cachorros', 'Petiscos sabor carne para adestramento, 500g', 30.00, 250, 40, 8),
(9, 'Comedouro para Cães', 'Comedouro de aço inoxidável para cães de grande porte', 40.00, 70, 15, 9),
(10, 'Coleira para Gatos', 'Coleira ajustável com guizo para gatos', 12.00, 180, 30, 10),
(11, 'Ração para Filhotes de Cachorro', 'Ração especial para filhotes, 10kg', 85.00, 90, 15, 1),
(12, 'Ração para Filhotes de Gato', 'Ração especial para filhotes, 5kg', 70.00, 100, 20, 2),
(13, 'Condicionador para Cães', 'Condicionador para pelagem macia, 500ml', 30.00, 150, 25, 3),
(14, 'Antipulgas em Gotas', 'Antipulgas em gotas para cães e gatos', 50.00, 200, 30, 4),
(15, 'Arranhador para Gatos', 'Arranhador com brinquedos pendurados', 80.00, 60, 10, 5),
(16, 'Caminha para Gatos', 'Caminha acolchoada para gatos', 70.00, 80, 15, 6),
(17, 'Tapete Higiênico para Cachorros', 'Tapete higiênico descartável, pacote com 30', 40.00, 200, 35, 7),
(18, 'Petiscos para Gatos', 'Petiscos crocantes para gatos, 300g', 20.00, 150, 25, 8),
(19, 'Bebedouro Automático', 'Bebedouro automático para cães e gatos', 60.00, 50, 10, 9),
(20, 'Brinquedo de Borracha para Cães', 'Brinquedo resistente de borracha para cães', 25.00, 180, 30, 10),
(21, 'Ração Hipoalergênica para Cachorros', 'Ração para cachorros com alergia, 10kg', 150.00, 70, 10, 1),
(22, 'Ração Hipoalergênica para Gatos', 'Ração para gatos com alergia, 5kg', 130.00, 80, 10, 2),
(23, 'Shampoo Medicinal para Cães', 'Shampoo medicinal para tratamento de pele, 500ml', 35.00, 90, 15, 3),
(24, 'Spray Antipulgas', 'Spray antipulgas para cães e gatos', 45.00, 110, 20, 4),
(25, 'Brinquedo Interativo para Cães', 'Brinquedo interativo para cães, em formato de bola', 20.00, 200, 30, 5),
(26, 'Caminha para Filhotes', 'Caminha especial para filhotes de cães e gatos', 60.00, 40, 10, 6),
(27, 'Granulado Higiênico para Gatos', 'Granulado higiênico biodegradável, 5kg', 25.00, 120, 20, 7),
(28, 'Petiscos Naturais para Cachorros', 'Petiscos naturais desidratados, 500g', 40.00, 150, 25, 8),
(29, 'Comedouro Inteligente', 'Comedouro automático com timer para cães e gatos', 150.00, 30, 5, 9),
(30, 'Coleira de Treinamento', 'Coleira com controle remoto para treinamento de cães', 100.00, 50, 10, 10),
(31, 'Ração para Cães Sênior', 'Ração para cães idosos, 10kg', 110.00, 60, 10, 1),
(32, 'Ração para Gatos Sênior', 'Ração para gatos idosos, 5kg', 95.00, 70, 10, 2),
(33, 'Shampoo para Filhotes', 'Shampoo suave para filhotes, 500ml', 20.00, 100, 20, 3),
(34, 'Coleira Antiparasita', 'Coleira antiparasita para cães e gatos, 6 meses de proteção', 55.00, 80, 15, 4),
(35, 'Brinquedo de Pelúcia para Cães', 'Brinquedo macio de pelúcia para cães', 35.00, 120, 20, 5),
(36, 'Caminha de Luxo para Cães', 'Caminha de luxo com almofada, tamanho grande', 200.00, 20, 5, 6),
(37, 'Areia Perfuma para Gatos', 'Areia sanitária perfumada, pacote de 5kg', 30.00, 110, 20, 7),
(38, 'Petiscos para Gatos Sênior', 'Petiscos para gatos idosos, 200g', 25.00, 130, 25, 8),
(39, 'Bebedouro Portátil', 'Bebedouro portátil para passeios, 500ml', 15.00, 70, 15, 9),
(40, 'Brinquedo com Catnip', 'Brinquedo para gatos com catnip, formato de peixe', 12.00, 150, 25, 10),
(41, 'Ração Vegetariana para Cachorros', 'Ração vegetariana para cães, 10kg', 140.00, 50, 10, 1),
(42, 'Ração Grain-Free para Gatos', 'Ração sem grãos para gatos, 5kg', 120.00, 60, 10, 2),
(43, 'Shampoo Antipulgas para Cães', 'Shampoo antipulgas e carrapatos, 500ml', 28.00, 90, 15, 3),
(44, 'Antipulgas Oral', 'Comprimido antipulgas para cães e gatos', 75.00, 70, 10, 4),
(45, 'Brinquedo Inteligente para Gatos', 'Brinquedo inteligente com laser para gatos', 40.00, 100, 20, 5),
(46, 'Caminha Ortodôntica para Cães', 'Caminha ortopédica para cães com problemas articulares', 180.00, 25, 5, 6),
(47, 'Granulado de Madeira para Gatos', 'Granulado higiênico de madeira, 5kg', 35.00, 80, 10, 7),
(48, 'Petiscos para Cães de Raças Pequenas', 'Petiscos sabor frango para cães de raças pequenas, 300g', 20.00, 150, 25, 8),
(49, 'Fonte de Água para Gatos', 'Fonte de água com filtro para gatos', 120.00, 40, 10, 9),
(50, 'Coleira de Couro para Cães', 'Coleira de couro ajustável para cães de grande porte', 60.00, 70, 15, 10),
(51, 'Ração para Cães Esportistas', 'Ração energética para cães esportistas, 10kg', 160.00, 55, 10, 1),
(52, 'Ração para Gatos com Problemas Renais', 'Ração especial para gatos com problemas renais, 5kg', 150.00, 65, 10, 2),
(53, 'Shampoo Condicionador para Cães', 'Shampoo e condicionador 2 em 1, 500ml', 30.00, 85, 15, 3),
(54, 'Antipulgas em Spray', 'Spray antipulgas para ambientes, 500ml', 40.00, 90, 20, 4),
(55, 'Brinquedo para Roer', 'Brinquedo resistente para cães que gostam de roer', 25.00, 140, 20, 5),
(56, 'Caminha para Gatos com Arranhador', 'Caminha com arranhador integrado para gatos', 90.00, 35, 5, 6),
(57, 'Areia para Gatos com Controle de Odor', 'Areia com controle de odor, pacote de 5kg', 25.00, 95, 20, 7),
(58, 'Petiscos Saudáveis para Cachorros', 'Petiscos sem conservantes, 500g', 35.00, 110, 20, 8),
(59, 'Comedouro Antiformiga', 'Comedouro especial que evita formigas', 50.00, 60, 10, 9),
(60, 'Coleira com Identificação para Gatos', 'Coleira com plaquinha de identificação, ajustável', 18.00, 100, 20, 10),
(61, 'Ração para Cães de Raça Grande', 'Ração para cães de raça grande, 15kg', 170.00, 45, 10, 1),
(62, 'Ração para Gatos com Sobrepeso', 'Ração light para gatos, 5kg', 140.00, 55, 10, 2),
(63, 'Shampoo Suave para Gatos', 'Shampoo suave e sem fragrância para gatos, 500ml', 25.00, 100, 20, 3),
(64, 'Coleira com LED', 'Coleira com LED para passeios noturnos, recarregável', 50.00, 75, 10, 4),
(65, 'Brinquedo de Corda para Cães', 'Brinquedo de corda resistente para cães', 20.00, 150, 25, 5),
(66, 'Caminha com Almofada', 'Caminha acolchoada com almofada removível, tamanho médio', 70.00, 40, 10, 6),
(67, 'Areia Ecológica para Gatos', 'Areia ecológica biodegradável, pacote de 5kg', 30.00, 85, 15, 7),
(68, 'Petiscos para Gatos Filhotes', 'Petiscos sabor peixe para filhotes, 200g', 18.00, 130, 20, 8),
(69, 'Bebedouro com Filtro de Carvão', 'Bebedouro com filtro de carvão ativado, 1L', 100.00, 50, 10, 9),
(70, 'Coleira com GPS para Cães', 'Coleira com rastreador GPS, ajustável', 200.00, 25, 5, 10),
(71, 'Ração para Cães Ativos', 'Ração premium para cães ativos, 12kg', 150.00, 60, 10, 1),
(72, 'Ração para Gatos Sensíveis', 'Ração especial para gatos com pele sensível, 5kg', 130.00, 70, 10, 2),
(73, 'Shampoo para Peles Sensíveis', 'Shampoo para peles sensíveis, 500ml', 28.00, 95, 15, 3),
(74, 'Antipulgas em Pipeta', 'Antipulgas em pipeta para cães e gatos', 55.00, 85, 10, 4),
(75, 'Brinquedo com Apito', 'Brinquedo de borracha com apito para cães', 22.00, 160, 25, 5),
(76, 'Caminha Impermeável', 'Caminha impermeável para cães, tamanho grande', 100.00, 30, 5, 6),
(77, 'Granulado Silica para Gatos', 'Granulado de sílica para gatos, 3,5kg', 35.00, 90, 15, 7),
(78, 'Petiscos para Cães Sensíveis', 'Petiscos para cães com estômagos sensíveis, 300g', 25.00, 140, 20, 8),
(79, 'Fonte de Água com LED', 'Fonte de água com luz LED para gatos', 130.00, 40, 10, 9),
(80, 'Coleira de Nylon para Cães', 'Coleira de nylon resistente, ajustável', 20.00, 110, 20, 10),
(81, 'Ração para Cães com Problemas Digestivos', 'Ração especial para problemas digestivos, 10kg', 160.00, 55, 10, 1),
(82, 'Ração para Gatos com Problemas Urinários', 'Ração especial para problemas urinários, 5kg', 150.00, 60, 10, 2),
(83, 'Shampoo Desembaraçador para Cães', 'Shampoo desembaraçador de pelos, 500ml', 30.00, 80, 15, 3),
(84, 'Spray Repelente para Móveis', 'Spray repelente para cães e gatos, 500ml', 40.00, 85, 20, 4),
(85, 'Brinquedo Educativo para Cães', 'Brinquedo educativo interativo para cães', 35.00, 100, 20, 5),
(86, 'Caminha com Cobertura', 'Caminha com cobertura removível para gatos', 85.00, 35, 5, 6),
(87, 'Areia com Cristais para Gatos', 'Areia com cristais de sílica, 3,5kg', 40.00, 75, 15, 7),
(88, 'Petiscos Funcionais para Cães', 'Petiscos funcionais para saúde dental, 400g', 30.00, 120, 20, 8),
(89, 'Bebedouro com Sensor', 'Bebedouro automático com sensor de movimento, 1,5L', 140.00, 30, 5, 9),
(90, 'Coleira para Gatos com Reflector', 'Coleira com refletor para segurança noturna', 15.00, 100, 20, 10),
(101, 'Banho', NULL, 50.00, 0, 0, NULL),
(102, 'Banho e tosa higienica', 'A tosa higiênica não tem restrições em relação à raça. Ela é feita para reduzir o comprimento dos pelos em lugares específicos do corpo do animal, como patas, barriga e genitália. Afinal, esses lugares estão mais propensos a acumular sujeira.', 55.00, 0, 0, NULL),
(103, 'Banho e tosa bebê', 'Apesar do nome, não quer dizer que essa tosa seja para cães filhotes. O objetivo da tosa bebê é deixar o cão com aparência infantil, com pelos curtos e arredondados, além de facilitar a escovação.', 65.00, 0, 0, NULL),
(104, 'Banho e tosa verão', 'Esse tipo de tosa é indicado de acordo com a avaliação do esteticista, e geralmente acontece quando o pet está com muito nós. Para garantir seu bem-estar e diminuir as chances de ocasionar fungos na pele, essa tosa é a melhor opção. Porem visto que exista uma complexidade e riscos, o tutor deve ter conhecimento e autorizar os serviços.', 90.00, 0, 0, NULL),
(105, 'Banho e tosa de raça', 'A tosa de raça mantém as características próprias da raça. No Schnauzer, por exemplo, o aspecto de saia na parte traseira é mantido pelo corte dos pelos. No Poodle, os pompons nas patas lembram o aspecto fofinho dos seus pelos.', 80.00, 0, 0, NULL),
(106, 'Ração para Cachorros Pedigre', 'Ração premium para cachorros adultos de 25kg', 200.00, 50, 10, NULL),
(107, 'Ração para Cachorros Pedigre', 'Ração premium para cachorros adultos de 25kg', 200.00, 50, 10, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico`
--

DROP TABLE IF EXISTS `servico`;
CREATE TABLE IF NOT EXISTS `servico` (
  `idServico` int NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Descricao` text COLLATE utf8mb4_general_ci,
  `Preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idServico`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servico`
--

INSERT INTO `servico` (`idServico`, `Nome`, `Descricao`, `Preco`) VALUES
(1, 'Banho', NULL, 50.00),
(2, 'Banho e tosa higienica', 'Tem o objetivo de diminuir a pelagem no local onde se acumula mais sujeira. Geralmente, ela é feita na região genital e nas patas, entre os dedos. Nos machos, a barriga também é tosada.', 55.00),
(3, 'Banho e tosa bebê', 'Esse tipo deixa o pêlo similar ao que era quando o cão era filhote. Recomendados para raças como Maltês, Lhasa Apso e Shih Tzu.', 65.00),
(4, 'Banho e tosa geral com máquina', 'O pêlo fica mais rente à pele e pode variar de tamanho, conforme a lâmina utilizada.', 90.00),
(5, 'Banho e tosa de raça', 'Muito parecida com a tosa estética, por ter o mesmo objetivo de manter o padrão da raça. Muito indicada para poodles, Schnauzer e Yorkshires.', 80.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

DROP TABLE IF EXISTS `venda`;
CREATE TABLE IF NOT EXISTS `venda` (
  `idVenda` int NOT NULL AUTO_INCREMENT,
  `Data_Venda` date NOT NULL,
  `idCliente` int DEFAULT NULL,
  `Total_Venda` decimal(10,2) NOT NULL,
  `Total_Produtos` decimal(10,2) DEFAULT NULL,
  `Total_Servicos` decimal(10,2) DEFAULT NULL,
  `Metodo_Pagamento` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Status_Pagamento` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idVenda`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venda`
--

INSERT INTO `venda` (`idVenda`, `Data_Venda`, `idCliente`, `Total_Venda`, `Total_Produtos`, `Total_Servicos`, `Metodo_Pagamento`, `Status_Pagamento`) VALUES
(1, '2024-05-02', 1, 100.00, 80.00, 20.00, 'Cartão de Crédito', 'Completo'),
(2, '2024-05-03', 2, 150.00, 120.00, 30.00, 'Dinheiro', 'Completo'),
(3, '2024-05-04', 3, 200.00, 160.00, 40.00, 'Transferência Bancária', 'Completo'),
(4, '2024-05-05', 5, 120.00, 100.00, 20.00, 'Cartão de Débito', 'Pendente'),
(5, '2024-05-06', 4, 180.00, 140.00, 40.00, 'Dinheiro', 'Completo'),
(6, '2024-05-07', 8, 220.00, 180.00, 40.00, 'Cartão de Crédito', 'Completo'),
(7, '2024-05-08', 2, 300.00, 240.00, 60.00, 'Transferência Bancária', 'Completo'),
(8, '2024-04-09', 7, 90.00, 70.00, 20.00, 'Dinheiro', 'Completo'),
(9, '2024-04-10', 2, 130.00, 100.00, 30.00, 'Cartão de Crédito', 'Pendente'),
(10, '2024-04-11', 7, 250.00, 200.00, 50.00, 'Cartão de Débito', 'Completo'),
(11, '2024-04-12', 9, 180.00, 140.00, 40.00, 'Transferência Bancária', 'Pendente'),
(12, '2024-04-13', 7, 190.00, 150.00, 40.00, 'Dinheiro', 'Completo'),
(13, '2024-04-14', 3, 210.00, 170.00, 40.00, 'Cartão de Crédito', 'Completo'),
(14, '2024-03-15', 7, 280.00, 220.00, 60.00, 'Dinheiro', 'Completo'),
(15, '2024-03-16', 4, 150.00, 120.00, 30.00, 'Cartão de Débito', 'Completo'),
(16, '2024-03-17', 6, 200.00, 160.00, 40.00, 'Transferência Bancária', 'Completo'),
(17, '2024-03-18', 7, 110.00, 90.00, 20.00, 'Dinheiro', 'Pendente'),
(18, '2024-03-19', 8, 90.00, 70.00, 20.00, 'Cartão de Crédito', 'Pendente'),
(19, '2024-03-20', 10, 130.00, 100.00, 30.00, 'Cartão de Débito', 'Completo'),
(20, '2024-03-21', 5, 220.00, 180.00, 40.00, 'Transferência Bancária', 'Completo'),
(21, '2024-03-22', 6, 180.00, 140.00, 40.00, 'Dinheiro', 'Completo'),
(22, '2024-03-23', 2, 250.00, 200.00, 50.00, 'Cartão de Crédito', 'Completo'),
(23, '2024-02-24', 6, 280.00, 220.00, 60.00, 'Dinheiro', 'Pendente'),
(24, '2024-02-25', 7, 190.00, 150.00, 40.00, 'Transferência Bancária', 'Completo'),
(25, '2024-06-26', 8, 200.00, 160.00, 40.00, 'Cartão de Débito', 'Completo'),
(26, '2024-06-27', 9, 220.00, 180.00, 40.00, 'Cartão de Crédito', 'Completo'),
(27, '2024-06-28', 4, 150.00, 120.00, 30.00, 'Transferência Bancária', 'Pendente'),
(28, '2024-06-29', 9, 160.00, 130.00, 30.00, 'Dinheiro', 'Completo'),
(29, '2024-06-30', 10, 180.00, 140.00, 40.00, 'Cartão de Crédito', 'Completo'),
(30, '2024-07-01', 5, 210.00, 170.00, 40.00, 'Dinheiro', 'Completo'),
(31, '2024-07-02', 7, 250.00, 200.00, 50.00, 'Cartão de Débito', 'Pendente'),
(32, '2024-07-03', 4, 180.00, 140.00, 40.00, 'Transferência Bancária', 'Completo'),
(33, '2024-07-04', 6, 300.00, 240.00, 60.00, 'Dinheiro', 'Completo'),
(34, '2024-07-05', 8, 220.00, 180.00, 40.00, 'Cartão de Crédito', 'Completo'),
(35, '2024-07-06', 7, 200.00, 160.00, 40.00, 'Transferência Bancária', 'Completo'),
(36, '2024-07-07', 8, 150.00, 120.00, 30.00, 'Dinheiro', 'Completo'),
(37, '2024-07-08', 6, 180.00, 140.00, 40.00, 'Cartão de Débito', 'Completo'),
(38, '2024-07-09', 4, 200.00, 160.00, 40.00, 'Cartão de Crédito', 'Pendente'),
(39, '2024-07-10', 4, 220.00, 180.00, 40.00, 'Transferência Bancária', 'Completo'),
(40, '2024-07-11', 2, 250.00, 200.00, 50.00, 'Dinheiro', 'Completo'),
(41, '2024-07-12', 3, 180.00, 140.00, 40.00, 'Cartão de Crédito', 'Completo'),
(42, '2024-07-13', 4, 190.00, 150.00, 40.00, 'Cartão de Débito', 'Pendente'),
(43, '2024-07-14', 4, 210.00, 170.00, 40.00, 'Transferência Bancária', 'Completo'),
(44, '2024-07-15', 5, 280.00, 220.00, 60.00, 'Dinheiro', 'Completo'),
(45, '2024-07-16', 8, 150.00, 120.00, 30.00, 'Cartão de Crédito', 'Completo'),
(46, '2024-07-17', 4, 200.00, 160.00, 40.00, 'Dinheiro', 'Pendente'),
(47, '2024-07-18', 6, 110.00, 90.00, 20.00, 'Transferência Bancária', 'Completo'),
(48, '2024-07-19', 8, 90.00, 70.00, 20.00, 'Cartão de Débito', 'Pendente'),
(49, '2024-07-20', 7, 130.00, 100.00, 30.00, 'Dinheiro', 'Completo'),
(50, '2024-07-21', 6, 220.00, 180.00, 40.00, 'Cartão de Crédito', 'Completo');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD CONSTRAINT `agendamento_servico_ibfk_1` FOREIGN KEY (`idServico`) REFERENCES `servico` (`idServico`),
  ADD CONSTRAINT `agendamento_servico_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Restrições para tabelas `itempedido`
--
ALTER TABLE `itempedido`
  ADD CONSTRAINT `itempedido_ibfk_1` FOREIGN KEY (`idVenda`) REFERENCES `venda` (`idVenda`),
  ADD CONSTRAINT `itempedido_ibfk_2` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`idVenda`) REFERENCES `venda` (`idVenda`);

--
-- Restrições para tabelas `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idFornecedor`) REFERENCES `fornecedor` (`idFornecedor`);

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
