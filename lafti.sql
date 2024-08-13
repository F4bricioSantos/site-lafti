-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/08/2024 às 16:39
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lafti`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `email` varchar(130) NOT NULL,
  `senha` varchar(25) NOT NULL,
  `situaçao` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `usertype`, `email`, `senha`, `situaçao`) VALUES
(1, 'admin', 'lafti@gmail.com', '1234', 'pago'),
(22, 'admin', 'ftft@gmail.com', '1234', 'mensal'),
(22, 'admin', 'ftft@gmail.com', '1234', 'mensal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(30) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `nome` varchar(130) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `cnpj` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `tipo_pagamento` varchar(10) NOT NULL,
  `data_pagamento` date NOT NULL,
  `estado` varchar(13) NOT NULL,
  `aberto` time NOT NULL,
  `fechado` time NOT NULL,
  `dias` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `usertype`, `foto`, `nome`, `endereco`, `cnpj`, `email`, `telefone`, `senha`, `tipo_pagamento`, `data_pagamento`, `estado`, `aberto`, `fechado`, `dias`) VALUES
(1, 'empresa', 'img/OIP (1).jpg', 'Mercado Central', 'Rua das Flores, 123', '12.345.678/0001-92', 'empresa@gmail.com', '(88) 98165-4827', '123', 'mensal', '2024-07-01', 'desbloqueado', '06:00:00', '23:00:00', 'segunda, terça, quarta, quinta, sexta'),
(2, 'empresa', 'img/OIP (2).jpg', 'Supermercado Mais', 'Avenida Paulista, 456', '23.456.789/0001-82', 'contato@supermercadomais.com', '(88) 98176-5820', 'senha456', 'anual', '2024-07-01', 'desbloqueado', '06:00:00', '20:00:00', 'segunda,terça,quarta,quinta,sexta,sábado'),
(3, 'empresa', '', 'Hipermercado Boa Compra', 'Rua dos Andradas, 789', '34.567.890/0001-73', 'contato@boacompra.com', '(88) 98134-5421', 'senha789', 'mensal', '2024-07-01', 'desbloqueado', '07:00:00', '22:00:00', 'sábado,domingo'),
(4, 'empresa', '', 'Mercadinho Popular', 'Travessa Oliveira, 321', '45.678.901/0001-64', 'contato@mercadinhopopular.com', '(88) 98145-6803', 'senha321', 'anual', '2024-07-01', 'desbloqueado', '06:00:00', '23:00:00', 'segunda,terça,quarta,quinta,sexta,sábado,domingo'),
(5, 'empresa', '', 'Supermercado Econômico', 'Praça da Sé, 654', '56.789.012/0001-55', 'contato@supermercadoeconomico.com', '(88) 98169-7264', 'senha654', 'mensal', '2024-07-01', 'desbloqueado', '10:00:00', '19:00:00', 'segunda,terça,quarta,quinta,sexta'),
(6, 'empresa', '', 'Empresa E', 'Endereço E', '12.345.678/0001-90', 'emailE@empresa.com', '(88)98108-9900', 'senhaE', 'anual', '2024-08-05', 'desbloqueado', '08:00:00', '18:00:00', 'sábado,domingo'),
(7, 'empresa', '', 'Empresa F', 'Endereço F', '98.765.432/0001-12', 'emailF@empresa.com', '(88)98199-0011', 'senhaF', 'anual', '2024-08-06', 'desbloqueado', '09:00:00', '19:00:00', 'sábado,domingo'),
(8, 'empresa', '', 'Empresa G', 'Endereço G', '23.456.789/0001-34', 'emailG@empresa.com', '(88)98130-1122', 'senhaG', 'anual', '2024-08-07', 'desbloqueado', '07:00:00', '17:00:00', 'sábado,domingo'),
(9, 'empresa', '', 'Empresa H', 'Endereço H', '87.654.321/0001-56', 'emailH@empresa.com', '(88)98101-2233', 'senhaH', 'mensal', '2024-08-08', 'desbloqueado', '10:00:00', '20:00:00', 'sábado,domingo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico`
--

CREATE TABLE `historico` (
  `id` int(110) NOT NULL,
  `user_id` int(110) DEFAULT NULL,
  `id_empresa` int(150) DEFAULT NULL,
  `user_nome` varchar(255) DEFAULT NULL,
  `user_endereco` varchar(255) DEFAULT NULL,
  `user_n` varchar(50) DEFAULT NULL,
  `user_complemento` varchar(255) DEFAULT NULL,
  `telefone` varchar(12) NOT NULL,
  `produtos` text DEFAULT NULL,
  `preco_total` decimal(10,2) DEFAULT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico`
--

INSERT INTO `historico` (`id`, `user_id`, `id_empresa`, `user_nome`, `user_endereco`, `user_n`, `user_complemento`, `telefone`, `produtos`, `preco_total`, `data_pedido`) VALUES
(1, 2, 1, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 300', '', '(21) 92345-6', 'Arroz Branco 1kg (x1), Sabão em Pó 1kg (x1), Feijão Preto 1kg (x1), Macarrão Espaguete 500g (x1)', 23.90, '2024-08-06 15:23:33'),
(2, 2, 1, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 300', '', '(21) 92345-6', 'Feijão Preto 1kg (x1), Sabão em Pó 1kg (x1), Macarrão Espaguete 500g (x3), Óleo de Soja 900ml (x1), Leite Integral 1L (x1)', 32.60, '2024-08-06 15:27:25'),
(3, 2, 1, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 100', '', '(21) 92345-6', 'Macarrão Espaguete 500g (x1), Óleo de Soja 900ml (x3), Açúcar Cristal 1kg (x1)', 19.80, '2024-08-09 13:50:20'),
(4, 2, 2, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 100', '', '(21) 92345-6', 'Óleo de Soja 900ml (x1), Açúcar Cristal 1kg (x1), Farinha de Trigo 1kg (x1), Chocolate em Pó 200g (x1)', 20.00, '2024-08-09 13:51:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `user_nome` varchar(255) DEFAULT NULL,
  `user_endereco` varchar(255) DEFAULT NULL,
  `user_n` varchar(50) DEFAULT NULL,
  `user_complemento` varchar(255) DEFAULT NULL,
  `telefone` varchar(12) NOT NULL,
  `produtos` text DEFAULT NULL,
  `preco_total` decimal(10,2) DEFAULT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `user_id`, `id_empresa`, `user_nome`, `user_endereco`, `user_n`, `user_complemento`, `telefone`, `produtos`, `preco_total`, `data_pedido`) VALUES
(1, 2, 1, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 300', '', '(21) 92345-6', 'Arroz Branco 1kg (x1), Sabão em Pó 1kg (x1), Feijão Preto 1kg (x1), Macarrão Espaguete 500g (x1)', 23.90, '2024-08-06 15:23:33'),
(2, 2, 1, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 300', '', '(21) 92345-6', 'Feijão Preto 1kg (x1), Sabão em Pó 1kg (x1), Macarrão Espaguete 500g (x3), Óleo de Soja 900ml (x1), Leite Integral 1L (x1)', 32.60, '2024-08-06 15:27:25'),
(3, 2, 1, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 100', '', '(21) 92345-6', 'Macarrão Espaguete 500g (x1), Óleo de Soja 900ml (x3), Açúcar Cristal 1kg (x1)', 19.80, '2024-08-09 13:50:20'),
(4, 2, 2, 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 100', '', '(21) 92345-6', 'Óleo de Soja 900ml (x1), Açúcar Cristal 1kg (x1), Farinha de Trigo 1kg (x1), Chocolate em Pó 200g (x1)', 20.00, '2024-08-09 13:51:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `cod_produto` int(11) NOT NULL,
  `id_empresa` varchar(3) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nomeproduto` varchar(80) NOT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`cod_produto`, `id_empresa`, `foto`, `nomeproduto`, `preco`) VALUES
(2, '1', 'img/4491_1.jpg', 'Feijão Preto 1kg', 7.50),
(3, '1', 'img/macarrao-espaguete.jpg', 'Macarrão Espaguete 500g', 3.90),
(4, '1', 'img/oleo-de-soja-soya.jpg', 'Óleo de Soja 900ml', 4.30),
(5, '1', 'img/açucar.webp', 'Açúcar Cristal 1kg', 3.00),
(6, '1', 'img/leite integral.jpg', 'Leite Integral 1L', 2.60),
(7, '1', '', 'Café em Pó 250g', 10.00),
(8, '1', '', 'Sabão em Pó 1kg', 6.50),
(9, '2', 'img/macarrao.jpg', 'Macarrão Penne 500g', 4.50),
(10, '2', 'img/farinha.jpg', 'Farinha de Trigo 1kg', 3.20),
(11, '2', 'img/leite.jpg', 'Leite Desnatado 1L', 2.80),
(12, '2', 'img/chocolate-em-po.jpg', 'Chocolate em Pó 200g', 9.50),
(13, '2', 'img/queijo.webp', 'Queijo Mussarela 300g', 13.00),
(14, '2', 'img/mussarela.webp', 'Presunto Peito de Peru 200g', 9.30),
(15, '2', '', 'Margarina 500g', 3.60),
(16, '2', '', 'Suco de Laranja 1L', 4.20),
(17, '2', '', 'Cereal Matinal 300g', 6.50),
(18, '2', '', 'Papel Toalha 2 Unidades', 6.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `date` date NOT NULL,
  `usertype` varchar(9) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `endereco` varchar(80) NOT NULL,
  `n` varchar(10) NOT NULL,
  `complemento` varchar(200) DEFAULT NULL,
  `telefone` varchar(16) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `estado` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `date`, `usertype`, `nome`, `endereco`, `n`, `complemento`, `telefone`, `email`, `senha`, `estado`) VALUES
(1, '2004-07-31', 'user', 'Ana Silva', 'Rua das Acácias, 100', 'Apto 101', 'Bloco A', '(11) 91234-5564', 'ana.silva@example.com', 'senhaAna123', 'desbloqueado'),
(2, '2002-07-31', 'user', 'Carlos Pereira', 'Avenida Brasil, 2000', 'Sala 101', '', '(21) 92345-6764', 'user@gmail.com', '123', 'desbloqueado'),
(3, '1996-07-15', 'user', 'Ana Silva', 'Rua das Palmeiras, 123', 'AP 45', 'Centro', '(31) 93456-7849', 'novoemail@exemplo.com', 'senhaMaria789', 'desbloqueado');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`cod_produto`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(110) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
