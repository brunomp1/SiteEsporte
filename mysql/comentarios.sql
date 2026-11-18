-- Comentários da comunidade.

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `torcedor_id` int(11) NOT NULL,
  `campeonato_id` int(11) DEFAULT NULL,
  `texto` varchar(500) NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `torcedor_id` (`torcedor_id`),
  KEY `campeonato_id` (`campeonato_id`),
  -- ON DELETE CASCADE: se o torcedor for excluído, os comentários dele somem junto
  CONSTRAINT `comentarios_torcedor` FOREIGN KEY (`torcedor_id`) REFERENCES `torcedores` (`id`) ON DELETE CASCADE,
  -- ON DELETE SET NULL: se o campeonato for excluído, o comentário fica, mas sem campeonato
  CONSTRAINT `comentarios_campeonato` FOREIGN KEY (`campeonato_id`) REFERENCES `campeonatos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;