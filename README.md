Anime Scraper 
===========
It allows you to fetch new anime and episodes and save them in your DB 

## MYSQL Schema


```sql
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

``` 

# Working


### Install DB 

```
cd anime-scraper-php
```

```
mysql -u root -p yourdb < dbschema.sql
```
### Make DB connection  in includes/connect.php

```php
$db_user='';
$password='';
$database='';

$con = mysqli_connect('localhost',"$user_name","$password","$database_name");


```

### Run scraper

```
 php main.php

```


