-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.29 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table online_book_library.book
CREATE TABLE IF NOT EXISTS `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `generated_id` varchar(45) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `book_genre_id` int NOT NULL,
  `is_taken` tinyint DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `generated_id_UNIQUE` (`generated_id`),
  KEY `fk_books_book_genre_idx` (`book_genre_id`),
  CONSTRAINT `fk_books_book_genre` FOREIGN KEY (`book_genre_id`) REFERENCES `book_genre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table online_book_library.book: ~10 rows (approximately)
INSERT INTO `book` (`id`, `generated_id`, `title`, `description`, `book_genre_id`, `is_taken`, `price`) VALUES
	(7, 'D1001', 'Dune', 'A science fiction novel by Frank Herbert about a distant future amidst a huge interstellar empire, where noble families vie for control of the desert planet Arrakis.', 1, 0, 100),
	(8, 'D1002', '1984', 'A dystopian novel by George Orwell, set in a totalitarian regime where surveillance and censorship are pervasive.', 1, 0, 100),
	(9, 'D1003', 'Pride and Prejudice', 'A classic novel by Jane Austen that explores the issues of class, marriage, and morality in early 19th century England.', 2, 0, 100),
	(10, 'D1004', 'To Kill a Mockingbird', 'A novel by Harper Lee set in the racially charged atmosphere of the American South during the 1930s, exploring themes of justice and morality.', 2, 0, 100),
	(11, 'D1005', 'The Hobbit', 'A fantasy novel by J.R.R. Tolkien that follows the adventures of Bilbo Baggins, a hobbit who joins a quest to reclaim a stolen treasure.', 3, 0, 100),
	(12, 'D1006', 'The Catcher in the Rye', 'A novel by J.D. Salinger that follows the story of Holden Caulfield, a teenager who experiences a profound sense of alienation in post-World War II New York City.', 2, 0, 100),
	(13, 'D1007', 'Brave New World', 'A dystopian novel by Aldous Huxley that explores the implications of a technologically advanced society driven by pleasure and conformity.', 1, 1, 100),
	(14, 'D1008', 'The Great Gatsby', 'A novel by F. Scott Fitzgerald that examines the American Dream through the life of Jay Gatsby and his pursuit of wealth and status in the Roaring Twenties.', 2, 0, 100),
	(15, 'D1009', 'Ender\'s Game', 'A science fiction novel by Orson Scott Card about a young boy who is trained to become a military leader in a future war against an alien species.', 1, 1, 100),
	(16, 'D1010', 'The Chronicles of Narnia', 'A series of fantasy novels by C.S. Lewis that take place in the magical land of Narnia and follow the adventures of children who discover this world.', 3, 0, 100);

-- Dumping structure for table online_book_library.book_genre
CREATE TABLE IF NOT EXISTS `book_genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table online_book_library.book_genre: ~3 rows (approximately)
INSERT INTO `book_genre` (`id`, `name`) VALUES
	(1, 'Fiction'),
	(2, 'Non-Fiction'),
	(3, 'Science Fiction');

-- Dumping structure for table online_book_library.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table online_book_library.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `password`, `created_at`, `email`) VALUES
	(1, 'ragbag', '$2y$12$sWopCJywUfIwrHdXECjidOk6090U27Vvs41llxazh8/hZChwDIauy', '2024-07-20 05:07:28', 'rag@gmail.com'),
	(4, 'taker', '$2y$12$cprBfzq.wyU.D6.v.IxjnO1nwqegBHRJ6dTNiHw3176/SqovkpqCW', '2024-07-21 12:46:24', 'taker@gmail.com');

-- Dumping structure for table online_book_library.user_took_book
CREATE TABLE IF NOT EXISTS `user_took_book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taken_at` datetime DEFAULT NULL,
  `books_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_took_book_books1_idx` (`books_id`),
  KEY `fk_user_took_book_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_took_book_books1` FOREIGN KEY (`books_id`) REFERENCES `book` (`id`),
  CONSTRAINT `fk_user_took_book_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table online_book_library.user_took_book: ~3 rows (approximately)
INSERT INTO `user_took_book` (`id`, `taken_at`, `books_id`, `user_id`) VALUES
	(42, '2024-07-21 12:46:34', 15, 4),
	(43, '2024-07-21 13:28:41', 13, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
