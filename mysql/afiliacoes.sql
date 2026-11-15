-- Tabela das afiliações (torcedor + time + plano + pagamento + hora do pagamento).
-- No phpMyAdmin: escolha o banco cartao_amarelo, aba SQL, cole e execute.
-- Se a tabela já existe, não acontece nada.

CREATE TABLE IF NOT EXISTS `afiliacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `torcedor_id` int(11) NOT NULL,
  `time_clube` varchar(90) NOT NULL,
  `plano` varchar(30) NOT NULL,
  `pagamento` varchar(30) NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `torcedor_id` (`torcedor_id`),
  CONSTRAINT `afiliacoes_torcedor` FOREIGN KEY (`torcedor_id`) REFERENCES `torcedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;