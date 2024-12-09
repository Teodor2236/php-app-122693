-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране: 25 ное 2024 в 21:08
-- Версия на сървъра: 10.4.27-MariaDB
-- Версия на PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `laptops`
--

-- --------------------------------------------------------

--
-- Структура на таблица `favorite_products_users`
--

CREATE TABLE `favorite_products_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL COMMENT 'Първичен ключ',
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `products`
--

INSERT INTO `products` (`id`, `title`, `image`, `price`) VALUES
(4, 'Lenovo ThinkPad X1 Carbon 123', 'https://cdn.izotcomputers.com/8270-large_default/laptop-vtora-upotreba-lenovo-thinkpad-x1-carbon-gen-9.jpg', '1499.99'),
(5, 'Asus ZenBook 13', 'https://laptop.bg/system/images/300015/normal/asus_zenbook_13_oled_ux325eaoledwb503r.jpg', '899.99'),
(6, 'Microsoft Surface Laptop 4', 'https://gfx3.senetic.com/akeneo-catalog/7/1/b/9/71b955b8b0f63a78a44c1a6a845adbf09e281afc_1684023_LDH_00031_image1.jpg', '999.99'),
(7, 'Acer Swift 3', 'https://ardes.bg/uploads/p/acer-swift-3-sf314-43-432825.jpg', '699.99'),
(8, 'Razor Blade 15', 'https://ardes.bg/uploads/original/razer-blade-15-rz09-0421-428703.jpg', '1599.99'),
(16, 'Нов продукт редактиран2', '1732556774_dell-xps-13-plus-9320-393691.jpg', '2200.99');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `names`, `email`, `password`) VALUES
(6, 'Симеон', 'simeon@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$QndnNTB3b0RmdUhTV2VVZQ$QfKHIMfaObI+KUoAMDhyxVKnxTQ3QvMBD+YYvy3Niks'),
(16, 'simeon', 'simeon2@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$YVVlU2x1b1dXVExaMmxiZQ$mlrDv6NwGJy10RN/uSLUjcko12TCTRg/Qvg0LaHVUSk');

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `favorite_products_users`
--
ALTER TABLE `favorite_products_users`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorite_products_users`
--
ALTER TABLE `favorite_products_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
