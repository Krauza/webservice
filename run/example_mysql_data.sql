SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


INSERT INTO `fiche_fiche` (`id`, `group_id`, `word`, `explain_word`) VALUES
('5757354ccdde2', '5757353eab703', 'Color', 'Kolor'),
('5757355f83b9b', '5757353eab703', 'Computer', 'Komputer');

INSERT INTO `fiche_group` (`id`, `owner_id`, `name`) VALUES
('5757353eab703', '57573497bb692', 'Test Group');

INSERT INTO `fiche_user` (`id`, `name`, `email`, `password`) VALUES
('57573497bb692', 'test', 'test@test.test', 'password');

INSERT INTO `fiche_user_fiche` (`id`, `user_id`, `fiche_id`, `group_id`, `level`, `last_modified`, `archived`) VALUES
(40, '57573497bb692', '5757354ccdde2', '5757353eab703', 1, '2016-06-07 20:58:26.020731', 0),
(41, '57573497bb692', '5757355f83b9b', '5757353eab703', 2, '2016-06-07 20:58:21.491307', 0);

INSERT INTO `fiche_user_group` (`group_id`, `user_id`) VALUES
('5757353eab703', '57573497bb692');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;