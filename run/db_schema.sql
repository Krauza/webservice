SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `fiche_fiche` (
  `id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `group_id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `word` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `explain_word` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `fiche_group` (
  `id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `owner_id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(120) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `fiche_user` (
  `id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(120) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `fiche_user_fiche` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `fiche_id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `level` int(1) NOT NULL,
  `last_modified` datetime(6) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `fiche_user_group` (
  `group_id` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


ALTER TABLE `fiche_fiche`
ADD PRIMARY KEY (`id`);

ALTER TABLE `fiche_group`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `fiche_user`
ADD PRIMARY KEY (`id`);

ALTER TABLE `fiche_user_fiche`
ADD PRIMARY KEY (`id`);


ALTER TABLE `fiche_user_fiche`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;