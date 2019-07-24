-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.15 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных food
CREATE DATABASE IF NOT EXISTS `food` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `food`;

-- Дамп структуры для таблица food.dish
CREATE TABLE IF NOT EXISTS `dish` (
  `id_dish` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `img_path` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `recipe` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_dish`),
  KEY `FK_dish_dish_categories` (`category_id`),
  CONSTRAINT `FK_dish_dish_categories` FOREIGN KEY (`category_id`) REFERENCES `dish_categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Основная информация о блюдах';

-- Дамп данных таблицы food.dish: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT IGNORE INTO `dish` (`id_dish`, `name`, `category_id`, `img_path`, `recipe`) VALUES
	(2, 'Борщ', 2, '/img/dish_img/borsch.jpg', '1. Сварить мясной бульон.\r\n2. Свеклу, морковь, петрушку и лук нарезать соломкой, положить в суповую кастрюлю, добавить помидоры или томат-пюре, уксус, сахар и немного бульона с жиром (или добавить 1-2 ст. ложки масла), закрыть крышкой и поставить овощи тушить. Овощи перемешивать, чтобы не пригорели, прибавляя, если нужно, немного бульона или воды.\r\n3. Через 15-20 минут добавить нашинкованную капусту, все перемешать и тушить еще 20 минут.\r\n4. Затем овощи залить подготовленным мясным бульоном, положить перец, лавровый лист, соль, добавить по вкусу немного уксуса и варить до полной готовности овощей. При подаче на стол в борщ положить сметану.\r\n5. В борщ при варке добавляют картофель в целом виде или нарезанный дольками, а также свежие помидоры. Их также нарезают дольками и кладут в борщ за 5-10 минут до окончания варки. В готовый борщ кроме мяса можно положить вареную ветчину, сосиски или колбасу.\r\n6. Для подкрашивания борща можно сделать свекольный настой. Для этого одну свеклу нарезать ломтиками, залить стаканом горячего бульона, добавить чайную ложку уксуса и поставить на 10-15 минут на слабый огонь и довести до кипения. После этого настой процедить и влить в борщ перед подачей на стол.'),
	(4, 'Паста карбонара', 3, '/img/dish_img/carbonara.jpg', '1. Спагетти варить 7-10 минут в кипящей подсоленной воде и откинуть на дуршлаг.\r\n2. В сковороде разогрейте оливковое масло, положите чеснок и слегка подрумяньте.\r\n3. Ветчину/бекон мелко нарежьте, добавьте к чесноку и обжаривайте 5 минут.\r\n4. Сыр пармезан натрите на мелкой терке. Желтки взбить со сливками, немного подсолить.\r\n5. Спагетти переложить в сотейник с чесноком и ветчиной/беконом.\r\n6. Добавить взбитые желтки и тёртый сыр, перемешать. Держать на огне 3 минуты.\r\n7. Посыпать молотым перцем, украсить зеленью и подавать на стол.'),
	(5, 'Салат «Мимоза»', 4, '/img/dish_img/mimoza.jpg', '1. Содержимое банки рыбных консервов размять и выложить на плоское блюдо. Покрыть этот слой майонезом.\r\n2. Затем положить слой мелко нарубленного репчатого лука, затем вновь майонез.\r\n3. Потом слой мелко нарубленных яиц, снова майонез.\r\n4. Потом слой натертой на крупной терке вареной моркови, и вновь слой майонеза.\r\n5. Сверху украсить салат тертым на мелкой терке сыром и мелко порубленным зеленым луком. Этот салат должен часа полтора постоять в холодильнике. После этого он становится очень нежным. Раскладывать его надо, как торт, захватывая все слои.'),
	(6, 'Мясные котлеты', 5, '/img/dish_img/kotleta.jpg', '1. Мясо прокрутить в мясорубке через крупную решетку, либо купить крупно прокрученный фарш.\r\n2. Лук мелко нарезать кубиками примерно по 4–5 мм. Ни в коем случае не прокручивайте лук, котлеты будут намного хуже. Нарезанный лук добавить в фарш.\r\n3. Хлеб размочить в воде, отжать из него всю воду и добавить в фарш. Основная тема в котлетах — количество хлеба. Примерно на килограмм фарша я кладу чуть больше трети нарезного батона. Если хлеба добавлять в котлеты мало, то они получаются жесткие и невкусные.\r\n4. Яйцо вбить в фарш — оно не даст котлетам разваливаться на сковородке.\r\n5. Посолить, поперчить по вкусу, далее замесить фарш так, чтобы была однородная масса.\r\n6. Немного нагреть сковороду, налить подсолнечного масла либо оливкового, выложить сформованные котлеты. Не стоит делать котлеты большими и слишком толстыми, их придется дольше жарить и из них уйдет весь сок, толщина примерно в 1,5 см будет достаточной. Когда котлеты подрумянятся с одной стороны, перевернуть их. Котлеты нужно еще пару раз перевернуть. Ни в коем случае не наливайте воды и не накрывайте крышкой — так вы их отварите. 7–8 минут вполне достаточно, для того чтобы котлета толщиной 1,5 см прожарилась.');
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;

-- Дамп структуры для таблица food.dish_categories
CREATE TABLE IF NOT EXISTS `dish_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Категории блюд';

-- Дамп данных таблицы food.dish_categories: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `dish_categories` DISABLE KEYS */;
INSERT IGNORE INTO `dish_categories` (`category_id`, `category_name`) VALUES
	(2, 'Супы'),
	(3, 'Гарниры'),
	(4, 'Салаты'),
	(5, 'Основные блюда');
/*!40000 ALTER TABLE `dish_categories` ENABLE KEYS */;

-- Дамп структуры для таблица food.ingredients
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id_product` int(11) NOT NULL DEFAULT '0',
  `id_dish` int(11) NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  `unit_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `Unique` (`id_product`,`id_dish`),
  KEY `FK_ingredients_products` (`id_product`),
  KEY `FK_ingredients_units` (`unit_id`),
  KEY `FK_ingredients_dish` (`id_dish`),
  CONSTRAINT `FK_ingredients_dish` FOREIGN KEY (`id_dish`) REFERENCES `dish` (`id_dish`) ON DELETE CASCADE,
  CONSTRAINT `FK_ingredients_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`),
  CONSTRAINT `FK_ingredients_units` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Ингредиенты и их количество для блюд';

-- Дамп данных таблицы food.ingredients: ~27 rows (приблизительно)
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT IGNORE INTO `ingredients` (`id_product`, `id_dish`, `number`, `unit_id`) VALUES
	(1, 2, 200, 1),
	(33, 2, 300, 1),
	(34, 2, 1, 2),
	(34, 5, 1, 2),
	(34, 6, 1, 2),
	(35, 2, 2, 3),
	(36, 2, 1, 3),
	(37, 2, 1, 3),
	(38, 2, 500, 1),
	(38, 6, 1000, 1),
	(39, 4, 400, 1),
	(40, 4, 6, 3),
	(41, 4, 2, 4),
	(42, 4, 300, 1),
	(43, 4, 4, 2),
	(44, 4, 100, 1),
	(45, 4, 200, 5),
	(46, 4, 0, 6),
	(47, 4, 0, 6),
	(48, 5, 200, 1),
	(49, 5, 100, 1),
	(50, 5, 2, 2),
	(51, 5, 1, 7),
	(52, 5, 3, 2),
	(52, 6, 1, 2),
	(53, 5, 1, 8),
	(54, 6, 300, 1);
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;

-- Дамп структуры для таблица food.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `link` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Меню сайта';

-- Дамп данных таблицы food.menu: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT IGNORE INTO `menu` (`id_item`, `name`, `link`) VALUES
	(1, 'Главная', '/index.php'),
	(5, 'Кулинарная книга', '/index.php?controller=cookbook'),
	(6, 'Мой холодильник', '/index.php?controller=fridge'),
	(7, 'Мое меню', '/index.php?controller=menu');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Дамп структуры для таблица food.products
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Справочник продуктов';

-- Дамп данных таблицы food.products: ~23 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT IGNORE INTO `products` (`id_product`, `product_name`) VALUES
	(1, 'белокочанная капуста'),
	(33, 'свекла'),
	(34, 'лук репчатый'),
	(35, 'томатная паста'),
	(36, 'уксус'),
	(37, 'сахар'),
	(38, 'мясо'),
	(39, 'спагетти'),
	(40, 'оливковое масло'),
	(41, 'чеснок'),
	(42, 'ветчина'),
	(43, 'яичный желток'),
	(44, 'сыр пармезан'),
	(45, 'сливки 10%-ные'),
	(46, 'соль'),
	(47, 'перец черный молотый'),
	(48, 'майонез'),
	(49, 'сыр'),
	(50, 'морковь'),
	(51, 'зеленый лук'),
	(52, 'яйцо куриное'),
	(53, 'рыбные консервы'),
	(54, 'белый хлеб');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица food.units
CREATE TABLE IF NOT EXISTS `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Справочник мер';

-- Дамп данных таблицы food.units: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT IGNORE INTO `units` (`unit_id`, `unit_name`) VALUES
	(1, 'гр.'),
	(2, 'шт.'),
	(3, 'ст. л.'),
	(4, 'зубч.'),
	(5, 'мл.'),
	(6, 'по вкусу'),
	(7, 'пучок(-ка)'),
	(8, 'банка(-ки)');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;

-- Дамп структуры для таблица food.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Список пользователей';

-- Дамп данных таблицы food.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT IGNORE INTO `users` (`user_id`, `login`, `pass`, `is_admin`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Дамп структуры для таблица food.user_cookbook
CREATE TABLE IF NOT EXISTS `user_cookbook` (
  `user_id` int(11) DEFAULT NULL,
  `id_dish` int(11) DEFAULT NULL,
  UNIQUE KEY `Unique` (`user_id`,`id_dish`),
  KEY `FK_user_cookbook_dish` (`id_dish`),
  KEY `FK_user_cookbook_users` (`user_id`),
  CONSTRAINT `FK_user_cookbook_dish` FOREIGN KEY (`id_dish`) REFERENCES `dish` (`id_dish`),
  CONSTRAINT `FK_user_cookbook_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы food.user_cookbook: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user_cookbook` DISABLE KEYS */;
INSERT IGNORE INTO `user_cookbook` (`user_id`, `id_dish`) VALUES
	(1, 2),
	(1, 4);
/*!40000 ALTER TABLE `user_cookbook` ENABLE KEYS */;

-- Дамп структуры для таблица food.user_fridge
CREATE TABLE IF NOT EXISTS `user_fridge` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `id_product` int(11) NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  `unit_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `Unique` (`user_id`,`id_product`),
  KEY `FK_user_fridge_products` (`id_product`),
  KEY `FK_user_fridge_units` (`unit_id`),
  CONSTRAINT `FK_user_fridge_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`),
  CONSTRAINT `FK_user_fridge_units` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`),
  CONSTRAINT `FK_user_fridge_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы food.user_fridge: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user_fridge` DISABLE KEYS */;
INSERT IGNORE INTO `user_fridge` (`user_id`, `id_product`, `number`, `unit_id`) VALUES
	(1, 1, 200, 1),
	(1, 38, 3000, 1),
	(1, 46, 200, 1);
/*!40000 ALTER TABLE `user_fridge` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
