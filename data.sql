-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 17 May 2021, 23:29:52
-- Sunucu sürümü: 10.4.18-MariaDB
-- PHP Sürümü: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `izovi_spinner`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `statistics`
--

CREATE TABLE `statistics` (
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `statistics`
--

INSERT INTO `statistics` (`counter`) VALUES
(1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `word` varchar(90) CHARACTER SET utf8 NOT NULL,
  `synonym` varchar(90) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `words`
--

INSERT INTO `words` (`id`, `word`, `synonym`) VALUES
(1, 'siyah', 'kara'),
(2, 'ak', 'beyaz'),
(3, 'beyaz', 'ak'),
(4, 'acele', 'çabuk'),
(5, 'kara', 'koyu');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
