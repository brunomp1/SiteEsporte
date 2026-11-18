-- Campeonatos e os times de cada campeonato.
-- tabela 1: campeonatos
CREATE TABLE IF NOT EXISTS `campeonatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `ano` int(11) NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela 2: os times de cada campeonato (Muitos paarr muito)
CREATE TABLE IF NOT EXISTS `campeonato_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campeonato_id` int(11) NOT NULL,
  `time_nome` varchar(90) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campeonato_id` (`campeonato_id`),
  CONSTRAINT `campeonato_times_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonatos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;