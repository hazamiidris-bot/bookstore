-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2026 at 06:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `author`, `book_id`, `description`, `image`) VALUES
(3, 'Good Bye Eri', 'Tatsuki Fujimoto', 1, 'Goodbye Eri adalah manga satu jilid karya Tatsuki Fujimoto yang mengisahkan seorang remaja laki-laki bernama Yuta yang merekam hari-hari terakhir ibunya yang sakit sakral, lalu bertemu dengan seorang gadis misterius bernama Eri yang membantunya menyunting film tersebut sekaligus memintanya untuk merekam dirinya sendiri hingga akhir hayatnya, menciptakan sebuah narasi emosional yang mengaburkan batas antara dokumenter realitas dan fiksi sinematik.', '1788396622_GERI.jpg'),
(4, 'My Hero Academy', 'Kohei Horikoshi', 4, 'My Hero Academy mengisahkan perjalanan Izuku Midoriya, seorang anak tanpa kekuatan super di dunia yang dipenuhi manusia berkekuatan khusus, yang mewarisi kemampuan dari pahlawan nomor satu demi mewujudkan impiannya menjadi simbol perdamaian dunia.', '1788396670_boku_no_hero1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `author` varchar(150) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `price`, `stock`, `description`, `cover`, `category_id`) VALUES
(1, 'Good Bye Eri', 'Tatsuki Fujimoto', 42000, 100, ' (Sayonara Eri) adalah komik one-shot karya Tatsuki Fujimoto, pencipta Chainsaw Man. Ceritanya mengikuti Yuta, remaja yang merekam hari-hari terakhir ibunya yang sakit. Setelah ibunya wafat, Yuta bertemu gadis misterius bernama Eri, dan bersama-sama mereka membuat film yang mengaburkan batas antara kenyataan dan fiksi.', '1785908574_goodbye_eri.jpeg', 2),
(2, '99+ resep masakan  rumahan', 'Radiantri & Ratuhani', 115000, 50, 'Nikmatnya menu-menu masakan yang dibuat sendiri di rumah. Pastinya lebih lezat, bergizi, dan tentunya higienis. Menu-menu masakan ini pun cocok untuk dijadikan sarapan, makan siang, makan malam, atau acara spesial. Resep dalam buku ini juga cepat, mudah, dan praktis, serta tidak menggunakan peralatan yang terlalu banyak.\r\n\r\nTidak perlu pusing untuk memikirkan masak apa hari ini? Semua ada, semua lengkap!\r\nBuku ini berisi lebih dari 99 resep rumahan. Terdiri dari resep ayam, daging, ikan, telur, dan seafood dengan teknik yang mudah sehingga dapat dilakukan di rumah anda.', '1787795569_images.jpg', 5),
(3, '350 resep masakan sehari-hari', 'Radiantri & Ratuhani', 125000, 50, 'Nikmatnya menu-menu masakan yang dibuat sendiri di rumah. Pastinya lebih lezat, bergizi, dan tentunya higienis. Menu-menu masakan ini pun cocok untuk dijadikan sarapan, makan siang, makan malam, atau acara spesial. Resep dalam buku ini juga cepat, mudah, dan praktis, serta tidak menggunakan peralatan yang terlalu banyak.\r\n\r\nTidak perlu pusing untuk memikirkan masak apa hari ini? Semua ada, semua lengkap!\r\nBuku ini berisi lebih dari 350 resep rumahan. Terdiri dari resep ayam, daging, ikan, telur, dan seafood dengan teknik yang mudah sehingga dapat dilakukan di rumah anda.', '1787797671_DE001340.jpg', 5),
(4, 'My Hero Academy', 'Kohei Horikoshi', 50000, 100, 'Volume 1 dari manga Boku no Hero Academia karya Kohei Horikoshi menceritakan awal mula perjalanan Izuku Midoriya, seorang remaja tanpa Quirk yang mewarisi kekuatan One For All dari All Might demi mewujudkan impiannya menjadi pahlawan di U.A. High School.', '1788396097_25074597.jpg', 2),
(5, 'Love Pieces Amelia', 'akuuswah_', 20000, 100, 'Ini adalah kisah seorang gadis yang memiliki masalah hidup yang runyam.\r\nPercintaan, persaudaraan, persahabatan semua menjadi satu dalam kisah ini.\r\nAmelia Karisa Ayuwinda Hermawan, seorang gadis yang melupakan seluruh memori semasa hidupnya karena kejadian nahas yang ia alami.\r\n', '1788397626_223342396-256-k682081.jpg', 1),
(6, 'KUTU BUKU', 'Wlnrmd15', 25000, 100, 'ALEXA KIMBERLY adalah siswi baru di Bellatrix High School. Gadis berkacamata, kutu buku dan pastinya pintar. Namun, dia bukan sembarang kutu buku, dia lebih dari itu. Wajahnya cantik dan kulitnya putih bersih, dia juga tegas dan pemberani. \r\n\r\nBeberapa hari sekolah di sana, Alexa langsung tidak menyukai sekolah itu. Dia membenci semua orang yang ada di sana. Baginya ada tiga jenis manusia di sekolah itu, si penguasa, si lemah dan si tak acuh.\r\n\r\nAlexa semakin tidak menyukai sekolah itu saat tau ada sebuah geng bernama Kings and Queens. Geng yang suka berbuat seenaknya hanya karena orang tua mereka adalah donatur sekolah. \r\n\r\nIni cukup merepotkan dan jika bukan karena alasan itu, Alexa tidak mau bersekolah di sana. Kira-kira apa alasannya yah? Dan apa yang akan Alexa lakukan untuk menghadapi orang-orang seperti mereka?\r\n\r\n\"Gue benci orang yang sok berkuasa. Gue benci sama orang lemah dan pengecut. Gue juga benci sama mereka yang seolah-olah buta dan tuli. Tapi gue lebih benci kalau gue juga sama kayak mereka.\"\r\n\r\n~ Alexa Kimberly\r\n', '1788397694_248191626-256-k3594.jpg', 1),
(7, 'Pendidikan Berbasis Pengalaman; Filosofi Pendidikan Progresif', 'John Dewey', 100000, 50, 'Pendidikan Berbasis Pengalaman adalah karya penting dari filsuf dan pendidik Amerika, John Dewey, yang menawarkan pemikiran mendalam tentang teori pendidikan progresif. Dalam buku ini, Dewey mengkritik pendekatan tradisional dalam pendidikan yang menurutnya terlalu menekankan hafalan, disiplin kaku, dan pengetahuan yang terpisah dari pengalaman nyata siswa.\r\nDewey tidak hanya menolak pendidikan tradisional, tetapi juga meninjau secara kritis praktik pendidikan progresif yang kala itu sedang populer, mengingat tidak semua pendekatan “progresif” benar-benar berakar pada pengalaman yang bermakna.\r\nPada akhirnya, buku ini merupakan pernyataan paling ringkas dari sang ahli teori pendidikan besar mengenai kebutuhan, permasalahan, dan kemungkinan dalam dunia pendidikan – ditulis setelah pengalamannya dengan sekolah-sekolah progresif dan dengan mempertimbangkan kritik terhadap teorinya.', '1788397780_1752481703_-.jpg', 4),
(8, ' Transformasi Ki Hadjar Dewantara dan Y.B. Mangunwijaya untuk Milenial Baru', 'Francis Wahono', 70000, 74, 'Dunia pendidikan di Indonesia saat ini seakan jalan di tempat karena adanya pandemi Covid-19, yang juga melanda seluruh dunia. Pembelajaran secara jarak jauh (dalam jaringan) sudah lebih dari satu tahun berlangsung. Sampai saat ini belum seluruh sekolah melakukan pembelajaran secara tatap muka demi keamanan para guru dan peserta didik. Juga untuk memutus rantai penularan Covid-19. Para siswa belajar di rumah.\r\n\r\nPara guru dan sekolah berinovasi membuat pembelajaran jarak jauh dengan mengandalkan teknologi internet. Selama anak-anak peserta didik belajar di rumah, tentu saja peran orang tua sebagai pendamping dan pembimbing berkontribusi terhadap kesuksesan proses belajar jarak jauh ini. Mau tidak mau dunia pendidikan di Indonesia dan tentu saja juga di belahan dunia lain harus beradaptasi dan berinovasi menghadapi dampak pandemic Covid-19 ini.\r\n\r\nTerkait dengan proses belajar mengajar, jelaslah bahwa buku berjudul “Pendidikan yang Memerdekakan“ ini sangat relevan untuk menjadi acuan dan panduan baik bagi guru maupun bagi orang tua, untuk memahami sejarah, seluk beluk, strategi dan juga proses belajar mengajar yang “merdeka” bagi peserta didik sekolah, khususnya di Indonesia.', '1788397880_Pendidikan-Memerdekakan.jpeg', 4),
(9, 'Orb on The Movement of The Earth', 'Uoto', 150000, 25, 'Orb on the Movement of the Earth adalah sebuah seri manga sejarah karya Uozo yang berlatar di Eropa abad ke-15, menceritakan perjuangan menegangkan dan pengorbanan dramatis para cendekiawan bidah yang mempertaruhkan nyawa mereka demi membuktikan teori heliosentrisme di bawah ancaman persekusi kejam dari pihak gereja.', '1788398034_143245050.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Novel'),
(2, 'Manga'),
(4, 'Pendidikan'),
(5, 'Resep masakan');

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_posts`
--

INSERT INTO `community_posts` (`id`, `user_id`, `title`, `content`, `created_at`) VALUES
(1, 3, 'rating good bye eri', 'bagus bintang 5 tapi bukan ancaman', '2026-08-20 01:52:55'),
(2, 3, 'gak penting', 'rating  1 jelek', '2026-08-27 02:52:11'),
(3, 3, 'ridho', 'hazami baik', '2026-08-27 02:52:28'),
(4, 4, 'Hai', 'boleh kenalan kakak', '2026-09-03 01:22:12'),
(5, 3, 'bales hai zharan', 'hai juga boleh kok ini ig aku @Phran', '2026-09-03 01:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` enum('Pending','Paid','Cancelled') DEFAULT 'Pending',
  `shipping_proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `shipping_proof`, `created_at`) VALUES
(11, 4, 50000, 'Paid', '1788396965_piso.jpg', '2026-09-03 00:54:20'),
(16, 3, 70000, 'Pending', NULL, '2026-09-03 01:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `qty`, `price`) VALUES
(11, 11, 4, 1, 50000),
(16, 16, 8, 1, 70000);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('Pending','Verified','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `proof_image`, `payment_method`, `payment_status`, `created_at`) VALUES
(10, 11, '1788396877_bintang-removebg-preview (1).png', 'QRIS', 'Verified', '2026-09-03 00:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `bank_account_name` varchar(100) DEFAULT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `ewallet_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `bank_name`, `bank_account_number`, `bank_account_name`, `qris_image`, `ewallet_info`) VALUES
(1, 'BCA', '1234567890', 'Zook BookStore', '1787793480_drupal-project-barcodes.png', '...');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `website_name` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `photo`, `password`, `role`, `created_at`) VALUES
(2, 'M.Hazami Idris 22', 'Hazami', 'hazamiidris@gmail.com', NULL, '$2y$10$3g5dqwtEpnk0inNG2JpT6eCUBIoXFKTkZlE7p00KBH2m8M7SaWfIa', 'admin', '2026-08-05 04:22:28'),
(3, 'gilang jahat', 'gilang', 'gilang@gmail.com', '1787792184_sayur.jpg', '$2y$10$Dr2hXja9CBlkDpY59N1NPuKDCHBojUOTvfF8h6nD0DzG/Yu7unzgq', 'user', '2026-08-20 01:00:08'),
(4, 'phranh', 'zhafran baik', 'zhafram@gmail.com', '1788400430_GERI.jpg', '$2y$10$lyI9xb4WuUPtCr3/ulrJseDaJd1fZT25ecENv7iwMYMXjGXEdDVde', 'user', '2026-09-03 00:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `theme` enum('light','dark') DEFAULT 'light',
  `language` varchar(20) DEFAULT 'id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `book_id`) VALUES
(2, 3, 1),
(3, 4, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
