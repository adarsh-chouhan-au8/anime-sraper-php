-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 09, 2022 at 03:39 PM
-- Server version: 10.1.48-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `123m_anime`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` text,
  `password` text,
  `email` text,
  `domain` varchar(500) DEFAULT NULL,
  `activation_key` varchar(1000) DEFAULT NULL,
  `activation_status` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `pop_ads` text,
  `ads_1` text,
  `ads_2` text,
  `ads_3` text,
  `ads_4` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anime`
--

CREATE TABLE `anime` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `genre` text,
  `plot` text,
  `year` varchar(256) DEFAULT NULL,
  `status` varchar(256) DEFAULT NULL,
  `img_src` text,
  `category` varchar(500) DEFAULT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `anime_id` int(11) DEFAULT NULL,
  `name` varchar(2000) DEFAULT NULL,
  `video_src` text,
  `download` text,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `footer_1` text,
  `footer_2` text,
  `footer_3` text,
  `footer_4` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `general_setting`
--

CREATE TABLE `general_setting` (
  `title` text,
  `keywords` text,
  `description` text,
  `admin_email` text,
  `analytics` text,
  `api_key` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE `header` (
  `menu` text,
  `slider` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `domain` text,
  `requests` int(11) DEFAULT NULL,
  `api_key` text,
  `ip_address` text,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE `meta` (
  `movies_tit` text,
  `movies_desc` text,
  `movies_meta_tit` text,
  `tvseries_tit` text,
  `tvseries_desc` text,
  `tvseries_meta_tit` text,
  `latest_tit` text,
  `latest_desc` text,
  `latest_meta_tit` text,
  `onair_tit` text,
  `onair_desc` text,
  `onair_meta_tit` text,
  `search_tit` text,
  `search_desc` text,
  `search_meta_tit` text,
  `country_tit` text,
  `country_desc` text,
  `country_meta_tit` text,
  `genre_tit` text,
  `genre_desc` text,
  `genre_meta_tit` text,
  `stars_tit` text,
  `stars_desc` text,
  `stars_meta_tit` text,
  `release_tit` text,
  `release_desc` text,
  `release_meta_tit` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `movie_tit` text,
  `movie_desc` text,
  `movie_keywords` text,
  `show_tit` text,
  `show_desc` text,
  `show_keywords` text,
  `movie_url` text,
  `show_url` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `logo` varchar(500) DEFAULT NULL,
  `favicon` varchar(256) DEFAULT NULL,
  `facebook` text,
  `twitter` text,
  `youtube` text,
  `pagination_limit` int(11) DEFAULT NULL,
  `similar_movies` int(11) DEFAULT NULL,
  `home_share_content` text,
  `video_share_content` text,
  `comment` text,
  `custom_css` mediumtext,
  `custom_js` mediumtext,
  `bg_color` varchar(256) DEFAULT NULL,
  `main_color` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `auth_key` varchar(500) DEFAULT NULL,
  `server` varchar(40) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anime`
--
ALTER TABLE `anime`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`(767));

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `download` (`download`(700));

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anime`
--
ALTER TABLE `anime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
