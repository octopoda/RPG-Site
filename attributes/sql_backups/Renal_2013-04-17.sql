# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29)
# Database: Renal
# Generation Time: 2013-04-17 20:39:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address1` varchar(60) DEFAULT NULL,
  `address2` varchar(60) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `zip` int(15) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;

INSERT INTO `address` (`address_id`, `address1`, `address2`, `city`, `state_id`, `zip`)
VALUES
	(1,'2721 Pinto  Dr','','Denton',44,76210),
	(35,'1234 Oak St','','Anytown',44,78628);

/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table addressForUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `addressForUser`;

CREATE TABLE `addressForUser` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `addressForUser` WRITE;
/*!40000 ALTER TABLE `addressForUser` DISABLE KEYS */;

INSERT INTO `addressForUser` (`address_id`, `user_id`)
VALUES
	(1,1);

/*!40000 ALTER TABLE `addressForUser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table adminNavigation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `adminNavigation`;

CREATE TABLE `adminNavigation` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `adminNavigation` WRITE;
/*!40000 ALTER TABLE `adminNavigation` DISABLE KEYS */;

INSERT INTO `adminNavigation` (`admin_id`, `title`, `link`, `access`, `position`, `published`, `parent_id`)
VALUES
	(1,'Dashboard','forms/dashboard.php',3,0,1,0),
	(2,'Site','forms/site/info_site.php',4,1,1,0),
	(3,'Navigation','forms/navigation/navigation.php',3,2,1,0),
	(4,'Content','forms/content/list_content.php',3,3,1,0),
	(5,'Users','forms/users/list_users.php',4,4,1,0),
	(6,'Media','forms/media/media.php',3,5,1,0),
	(7,'Site information','forms/site/info_site.php',5,0,1,2),
	(8,'Contact Information','forms/site/info_contact.php',4,1,1,2),
	(9,'Navigation','forms/navigation/navigation.php',3,0,1,3),
	(10,'Menus','forms/navigation/menus.php',3,1,1,3),
	(11,'Edit Navigation','forms/navigation/form_navigation.php',3,3,1,3),
	(12,'List Content','forms/content/list_content.php',3,0,1,4),
	(13,'Edit Content','forms/content/form_content.php',3,1,1,4),
	(14,'News','forms/content/list_news.php',3,4,1,4),
	(15,'Advertisments','forms/content/list_ads.php',3,5,1,4),
	(16,'Search Users','forms/users/list_users.php',4,0,1,5),
	(17,'Edit User','forms/users/form_users.php',4,1,1,5),
	(18,'Change Password','forms/users/change_password.php',4,2,1,5),
	(19,'Your Media','forms/media/media.php',3,0,1,6),
	(20,'Upload Media','forms/media/upload.php',3,1,1,6),
	(21,'Applications','forms/refills/list_refills.php',3,6,0,0),
	(26,'Social Networks','forms/site/info_social.php',3,2,1,2),
	(27,'Admin','forms/admin/list_roles.php',200,20,1,0),
	(28,'User Groups','forms/admin/list_roles.php',200,0,1,27),
	(29,'Edit Groups','forms/admin/form_roles.php',200,1,1,27),
	(30,'Site Configuation','forms/site/configuration.php',5,2,1,2),
	(31,'Archives','forms/archives/list_archives.php',3,7,1,0),
	(32,'Issues','forms/archives/list_archives.php',3,0,1,31),
	(33,'Topic Groups','forms/topics/list_categories.php',3,1,1,31),
	(34,'Topics','forms/topics/list_sub_categories.php',3,2,1,31),
	(35,'Online Store','forms/products/list_product.php',3,8,1,0),
	(36,'Products','forms/products/list_product.php',3,0,1,35),
	(37,'Enter Product','forms/products/form_product.php',3,1,1,35),
	(38,'Store Setup','forms/commerce/info_commerce.php',3,2,1,35),
	(39,'Transactions','forms/commerce/list_transactions.php',3,3,1,35),
	(40,'Product Categories','forms/products/list_productcategories.php',3,4,1,35),
	(41,'Front Page ','forms/frontpage/list_frontpage.php',3,6,1,4);

/*!40000 ALTER TABLE `adminNavigation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `ad_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `published` int(2) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `image` text,
  `link` text,
  `placement` int(11) DEFAULT NULL,
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;

INSERT INTO `ads` (`ad_id`, `title`, `published`, `user_id`, `image`, `link`, `placement`)
VALUES
	(1,'Fake IKEA Ad',1,1,'/images/ads/ikea_fake.png','http://ikea.com',0);

/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table archive
# ------------------------------------------------------------

DROP TABLE IF EXISTS `archive`;

CREATE TABLE `archive` (
  `archive_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `archive_title` varchar(60) DEFAULT NULL,
  `published` int(2) DEFAULT NULL,
  `datePublished` datetime DEFAULT NULL,
  `archive_link` varchar(250) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `issue` int(11) DEFAULT NULL,
  PRIMARY KEY (`archive_id`),
  KEY `archive_title` (`archive_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `archive` WRITE;
/*!40000 ALTER TABLE `archive` DISABLE KEYS */;

INSERT INTO `archive` (`archive_id`, `archive_title`, `published`, `datePublished`, `archive_link`, `volume`, `issue`)
VALUES
	(9,'RNF Spring 2011',1,'2011-03-01 12:00:00','/forum_admin/files/Renal_Spring11_FINAL.pdf',30,2),
	(10,'RNF Summer 2011',1,'2011-06-01 12:00:00','/forum_admin/files/RNFSummer2011_FINAL.pdf',30,3),
	(11,'RNF Winter 2011',1,'2011-01-01 12:00:00','/forum_admin/files/RNF_Winter_2011_final.pdf',30,1),
	(12,'RNF Fall 2010',1,'2010-09-01 12:00:00','/forum_admin/files/RNFFall2010Full_issue.pdf',29,4),
	(13,'RNF Summer 2010',1,'2010-06-01 12:00:00','/forum_admin/files/RNF_Summer_2010_Final.pdf',29,3),
	(14,'RNF Spring 2010',1,'2010-03-01 12:00:00','/forum_admin/files/Renal_Spring10.pdf',29,2),
	(15,'RNF Winter 2010',1,'2010-01-01 12:00:00','/forum_admin/files/RNF_2010_Winter_Forum_v_Final.pdf',29,1),
	(16,'RNF Fall 2009',1,'2009-09-01 12:00:00','/forum_admin/files/Renal_Fall_ForumFINAL_full_issue.pdf',28,4),
	(17,'RNF Summer 2009',1,'2009-06-01 12:00:00','/forum_admin/files/RNF_Summer _09_issue.pdf',28,3),
	(18,'RNF Spring 2009',1,'2009-03-01 12:00:00','/forum_admin/files/Final_proof_erratum_updates_spring09.pdf',28,2),
	(19,'RNF Winter 2009',1,'2009-01-01 12:00:00','/forum_admin/files/RNF_Winter_2009.pdf',28,1),
	(20,'RNF Fall 2008',1,'2008-09-01 12:00:00','/forum_admin/files/Renal_Fall08.pdf',27,4),
	(21,'RNF Summer 2008',1,'2008-06-01 12:00:00','/forum_admin/files/rnf_summer_2008_issue.pdf',27,3),
	(22,'RNF Spring 2008',1,'2008-03-01 12:00:00','/forum_admin/files/rnf_spring_2008.pdf',27,2),
	(23,'RNF Winter 2008',1,'2008-01-01 12:00:00','/forum_admin/files/Renal_Winter_2008.pdf',27,1),
	(24,'RNF Fall 2007',1,'2007-09-01 12:00:00','/forum_admin/files/Renal_Fall07.pdf',26,4),
	(25,'RNF Summer 2007',1,'2007-06-01 12:00:00','/forum_admin/files/Renal_Summer07.pdf',26,3),
	(26,'RNF Spring 2007',1,'2007-03-01 12:00:00','/forum_admin/files/Renal_Spring_2007.pdf',26,2),
	(27,'RNF Winter 2007',1,'2007-01-01 12:00:00','/forum_admin/files/Renal_Winter_2007.pdf',26,1),
	(28,'RNF Fall 2006',1,'2006-09-01 12:00:00','/forum_admin/files/Renal_Fall_2006.pdf',25,4),
	(29,'RNF Summer 2006',1,'2006-06-01 12:00:00','/forum_admin/files/Renal_Summer06.pdf',25,3),
	(30,'RNF Spring 2006',1,'2006-03-01 12:00:00','/forum_admin/files/Renal_Spring_2006.pdf',25,2),
	(31,'RNF Winter 2006',1,'2006-01-01 12:00:00','/forum_admin/files/Renal_Winter_2006.pdf',25,1),
	(32,'RNF Fall 2005',1,'2005-09-01 12:00:00','/forum_admin/files/Renal_Fall_2005.pdf',24,4),
	(33,'RNF Summer 2005',1,'2005-06-01 12:00:00','/forum_admin/files/Renal_Summer_2005.pdf',24,3),
	(34,'RNF Spring 2005',1,'2005-03-01 12:00:00','/forum_admin/files/Renal_Spring_2005.pdf',24,2),
	(35,'RNF Winter 2005',1,'2005-01-01 12:00:00','/forum_admin/files/Renal_Winter_2005.pdf',24,1),
	(36,'RNF Fall 2004',1,'2004-09-01 12:00:00','/forum_admin/files/Renal_Fall_2004.pdf',23,4),
	(37,'RNF Summer 2004',1,'2004-06-01 12:00:00','/forum_admin/files/Renal_Summer_2004.pdf',23,3),
	(38,'RNF Spring 2004',1,'2004-03-01 12:00:00','/forum_admin/files/Renal_Spring_2004.pdf',23,2),
	(39,'RNF Fall 2003',1,'2003-09-01 12:00:00','/forum_admin/files/Renal_Fall_2003.pdf',22,4),
	(40,'RNF Summer 2003',1,'2003-06-01 12:00:00','/forum_admin/files/Renal_Summer_2003.pdf',22,3),
	(41,'RNF Fall 2011',1,'2011-09-01 12:00:00','/forum_admin/files/RNF_Fall_2011_Issue_Final.pdf',30,4),
	(43,'RNF Spring 2012',1,'2012-03-01 12:00:00','/forum_admin/files/RNF_Spring2012_Final.pdf',31,2),
	(44,'RNF  Summer 2012',1,'2012-06-01 12:00:00','/forum_admin/files/RNF_Summer_2012_Final.pdf',31,3),
	(45,'RNF Fall 2012',1,'2012-09-01 12:00:00','forum_pdf/RNF_Final_Vol 31_No4_2012.pdf',31,4),
	(47,'RNF 2013',1,'2013-01-01 12:00:00','http://www.renalnutrition.org/members_only/forum_pdf/Vol 32_No1 2012_F.pdf',32,1);

/*!40000 ALTER TABLE `archive` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `article_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_title` varchar(500) DEFAULT NULL,
  `article_link` varchar(250) DEFAULT NULL,
  `published` int(2) DEFAULT NULL,
  `description` text,
  `author` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  KEY `article_title` (`article_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;

INSERT INTO `article` (`article_id`, `article_title`, `article_link`, `published`, `description`, `author`)
VALUES
	(21,'Feature Article: Niacin: A Method of Control for Hyperphosph','/forum_admin/files/RNFFall2010FeatureArticleCPEU.pdf',1,'<p>Feature Article: Niacin: A Method of Control for Hyperphosphatemia in Chronic Kidney Disease Stage 5 Patients<br />By Stacey Phillips</p>','Stacey Phillips'),
	(22,'Feature Article: Niacin: A Method of Control for Hyperphosph','/forum_admin/files/RNFFall2010FeatureArticleCPEU.pdf',1,'<p>Feature Article: Niacin: A Method of Control for Hyperphosphatemia in Chronic Kidney Disease Stage 5 Patients<br />by Stacey Phillips</p>','Stacey Phillips'),
	(23,'Advances in Practice: Addressing the Growing Need for Chroni','/forum_admin/files/RNFFall2010AdvancesinPracticeArticle.pdf',1,'<p>Advances in Practice: Addressing the Growing Need for Chronic Kidney Disease (CKD) Medical Nutrition Therapy in Primary Care Settings: Update on the National Kidney Disease Education Program&rsquo;s CKD Diet Initiative<br />by Eileen P.Newman and Anna Zawislanski</p>','Eileen P.Newman and Anna Zawislanski'),
	(24,'Feature Article: Malnutrition in a Maintenance Hemodialysis ','/forum_admin/files/RNF_Winter_2011_Feature_article.pdf',1,'<p>Feature Article: Malnutrition in a Maintenance Hemodialysis Patient is Improved with Intradialytic Parenteral Nutrition (IDPN): A Case Study<br />by Mona Soucy</p>','Mona Soucy'),
	(25,'Advances in Practice: Nutritionally Focused Intradialytic Pa','/forum_admin/files/RNF_Winter_2011_Adv_Prac_article.pdf',1,'<p>Advances in Practice: Nutritionally Focused Intradialytic Parenteral Nutrition (IDPN) Initiation<br />Jessianna Rose</p>','Jessianna Rose'),
	(27,'Feature Article: Vitamin A Deficiency in a Hemodialysis Pati','/forum_admin/files/RNF_Spring_2011_Feature_Article.pdf',1,'<p>Feature Article: Vitamin A Deficiency in a Hemodialysis Patient &ndash; A Case Review<br />Rachael R. Majorowicz</p>','Rachael R. Majorowicz'),
	(28,'Feature Article: The Supplemented Vegan Low Protein Diet in ','/forum_admin/files/RNF_Summer_2011-Feature_CPEU_article.pdf',1,'<p>Feature Article: The Supplemented Vegan Low Protein Diet in Chronic Kidney Disease Jennifer Moore and Roschelle Heuberger</p>','Jennifer Moore and Roschelle Heuberger'),
	(29,'Advances in Practice: Nutritional Assessment of an Adult Rec','/forum_admin/files/RNF_Summer_2011_Adv_in_Practice_CPEU_article_1.pdf',1,'<p>Advances in Practice: Nutritional Assessment of an Adult Receiving Dialysis<br />Erin Ghaffari</p>','Erin Ghaffari'),
	(30,'Advances in Practice: Chronic Kidney Disease Medical Nutriti','/forum_admin/files/RNF_Spring_2011_Adv_Practices.pdf',1,'<p>Advances in Practice: Chronic Kidney Disease Medical Nutrition Therapy: Guidelines for Effective Management<br />Amy Braglia Tarpey</p>','Amy Braglia Tarpey'),
	(31,'Feature Article: Effect of Short Daily Hemodialysis and Nigh','/forum_admin/files/RNF_Summer_2010_CPEU_Feature Article.pdf',1,'<p>Feature Article: Effect of Short Daily Hemodialysis and Nightly Home Hemodialysis on Phosphorus Status<br />Jennifer Sullivan</p>','Jennifer Sullivan'),
	(32,'Advances in Practice: Management of Cardiovascular Disease i','/forum_admin/files/RNF_Summer_2010_CPEU_Advances in Practice.pdf',1,'<p>Advances in Practice: Management of Cardiovascular Disease in Patients With Impaired Renal Function<br />Heidi D. Mathes</p>','Heidi D. Mathes'),
	(33,'Feature Article: Benefits of Vitamin D Supplementation on Ph','/forum_admin/files/Renal_Spring10_Feature.pdf',1,'<p>Feature Article: Benefits of Vitamin D Supplementation on Physical Function in Chronic Kidney Disease (CKD) Patients<br />Josefine Lampasona and Jack Logomarsino</p>','Josefine Lampasona and Jack Logomarsino'),
	(34,'Advances in Practice: Nutrition and the Pediatric Renal Pati','/forum_admin/files/Renal_Spring10_Advances.pdf',1,'<p>Advances in Practice: Nutrition and the Pediatric Renal Patient<br />Cynthia J. Terrill</p>','Cynthia J. Terrill'),
	(35,'Feature Article: A Dietitian’s Review of the RIFLE Classific','/forum_admin/files/rnf_a_dietitian_review_of_rifle_winter2010.pdf',1,'<p>Feature Article: A Dietitian&rsquo;s Review of the RIFLE Classification of Acute Renal Failure and What It Means for Nutrition Therapy<br />Julie Hemann</p>','Julie Hemann'),
	(36,'Advances in Practice: Oral Nutrition Supplements and Outcome','/forum_admin/files/advances_in_practice_oral_nutrition_winter2010.pdf',1,'<p>Advances in Practice: Oral Nutrition Supplements and Outcomes in Patients on Maintenance Dialysis<br />Philippa Norton-Feiertag</p>','Philippa Norton-Feiertag'),
	(37,'Feature Article: Eating Disorder Counseling in the Hemodialy','/forum_admin/files/Renal_FallFeatureFINAL_09.pdf',1,'<p>Feature Article: Eating Disorder Counseling in the Hemodialysis Population: A Perspective Summary</p>\r\n<p>Dana M. Kiker, MA, MS, RD, LD</p>','Dana M. Kiker'),
	(38,'Advances in Practice: Case Study: An Accidental Overdose of ','/forum_admin/files/Renal_Fall_CStudy-FINAL_09.pdf',1,'<p>Advances in Practice: Case Study: An Accidental Overdose of Ergocalciferol</p>\r\n<p>Raymond Campbell IV, RD, LD</p>','Raymond Campbell'),
	(39,'Feature Article: Diabesity, Fatabetes, or Metabolic Syndrome','/forum_admin/files/featured_article_summer09.pdf',1,'<p>Feature Article: Diabesity, Fatabetes, or Metabolic Syndrome: Different Names . . . Same Condition?</p>\r\n<p>Susan L. Barlow, RD, CDE</p>','Susan L. Barlow'),
	(40,'Advances in Practices: An Introduction to Nutrigenomics for ','/forum_admin/files/andvances_in_practice_sum09.pdf',1,'<p>Advances in Practices: An Introduction to Nutrigenomics for the Renal Dietetics Professional<br />Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(41,'Feature Article: Reducing Inflammation through Micronutrient','/forum_admin/files/Inflammation_CPE_article_updated_spring09.pdf',1,'<p>Feature Article: Reducing Inflammation through Micronutrient Therapy for Chronic Kidney Disease<br />Becky C. Williamson and Deepa Handu, PhD, RD, LDN</p>','Becky C. Williamson and Deepa Handu'),
	(42,'Advances in Practices: Prevalence of RDs Publishing in Selec','/forum_admin/files/rnf_spring2009_advances.pdf',1,'<p>Advances in Practices: Prevalence of RDs Publishing in Select Nutrition Journals<br />Debra Eisenbarth, MS, Brenda Walsh, MS, RD, and Alison Steiber, PhD, RD, LD</p>','Debra Eisenbarth, Brenda Walsh and Alison Steiber'),
	(43,'Feature Article: Medical Nutrition Therapy in Liver and Rena','/forum_admin/files/RNF_Winter_2009_insert.pdf',1,'<p>Feature Article: Medical Nutrition Therapy in Liver and Renal Failure: Conflicts and Commonalities<br />Sara Di Cecco, MS, RD, LD</p>','Sara Di Cecco'),
	(44,'Advances in Practice: Applying Theories of Behavioral Change','/forum_admin/files/RNF_Winter_Adv_Practice_Insert_2009.pdf',1,'<p>Advances in Practice: Applying Theories of Behavioral Change to Manage Interdialytic Fluid Gains in Patients Undergoing Maintenance Hemodialysis Therapy<br />Phillipa Norton-Feiertag, MEd, RD, LD</p>','Phillipa Norton-Feiertag'),
	(45,'Feature Article: Renal Tubular Dysfunction and Failure to Th','/forum_admin/files/Renal_Fall08feature.pdf',1,'<p>Feature Article: Renal Tubular Dysfunction and Failure to Thrive in Children: A Case Study<br />Linda Phelan RD, CSR, LD</p>','Linda Phelan'),
	(46,'Advances in Practice:  If the Media Calls, Are You Ready?','/forum_admin/files/Renal_Fall08advances.pdf',1,'<p>Advances in Practice: Nutrition Management of a Chronic Kidney Disease Patient with Obesity and Diabetes: A Case Study<br />Lynn K. Munson, RD, LD</p>','Christine M. Palumbo'),
	(47,'Feature Article: Hidden Phosphorus: A New Challenge for the ','/forum_admin/files/summer2008_featured_vol27_no3.pdf',1,'<p>Feature Article: Hidden Phosphorus: A New Challenge for the Nephrology Dietitian<br />Lisa Gutekunst, MSEd, RD, CSR, CDN</p>','Lisa Gutekunst'),
	(48,'Advances in Practice: Nutrition Management of a Chronic Kidn','/forum_admin/files/summer2008_advances_vol27_no3.pdf',1,'<p>Advances in Practice: Nutrition Management of a Chronic Kidney Disease Patient with Obesity and Diabetes: A Case Study<br />Lynn K. Munson, RD, LD</p>','Lynn K. Munson'),
	(49,'Summer 2008 Feature Article: Hidden Phosphorus, Figure 1','/forum_admin/files/figure1_kidney_friendly_food_shelf_rnf_summer08.pdf',1,'<p>Summer 2008 Feature Article: Hidden Phosphorus, Figure 1<br />Lisa Gutekunst MSEd, RD, CSR, CDN</p>','Lisa Gutekunst'),
	(50,'Feature Article: The Impact of Alternative Medicine Therapie','/forum_admin/files/spring2008_featured_vol27_no2.pdf',1,'<p>Feature Article: The Impact of Alternative Medicine Therapies on the Nutrition and Well-being of the Chronic Kidney Disease (CKD) Stage 5 Patient<br />Mona Soucy RD, CSR</p>','Mona Soucy'),
	(52,'Advances in Practice: Nutritional Strategies for Managing Ca','/forum_admin/files/spring2008_advanced_vol27_no2.pdf',1,'<p>Advances in Practice: Nutritional Strategies for Managing Cardiovascular Disease in Adult Patients with Kidney Transplants<br />Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(53,'Feature Article: Impact of Evidence-Based Practice ”Web-Base','/forum_admin/files/winter2008_featured_vol27_no1.pdf',1,'<p>Feature Article: mpact of Evidence-Based Practice &rdquo;Web-Based Modules on Perceptions, Attitudes and Knowledge of Evidence-Based Practice&rdquo;among Members of the Dietitians in Nutrition Support and Renal Dietitians Dietetic Practice Groups.<br />Anna R. Parker MS, RD, CDE, CNSD; Laura Byham-Gray Ph.D, RD, CNSD; Riva Touger-Decker Ph.D, RD; Julie O\\\'Sullivan-Maillet Ph.D RD; Diane Rigassio Radler Ph.D, RD<br /><br /></p>','Anna R. Parker, Laura Byham-Gray, Riva Touger-Decker, Julie '),
	(54,'Advances in Practice: Megestrol Acetate Therapy and Anorexia','/forum_admin/files/winter2008_advances_vol27_no1.pdf',1,'<p>Advances in Practice: Megestrol Acetate Therapy and Anorexia in Patients with Chronic Kidney Disease Undergoing Maintenance Dialysis<br />Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(55,'Feature Article: Medical Nutrition Therapy for the Predialys','/forum_admin/files/MNTforthePatientwithEarlyCKD_RNF_Fall_2007v.website.pdf',1,'<p>Feature Article: Medical Nutrition Therapy for the Predialysis CKD Patient<br />Lynn K. Munson, RD, LD</p>','Lynn K. Munson'),
	(56,'Advances in Practice: How to Increase Early Nutrition Interv','/forum_admin/files/CKDRDRoundtableArticle_RNF_Fall_2007v.website.pdf',1,'<p>Advances in Practice: How to Increase Early Nutrition Intervention with CKD Patients<br />This article summarizes key insights from a roundtable discussion with renal dietitians. This article is written by Andrew S. Narva, MD, FACP, director of the National Kidney Disease Education Program at the National Institutes of Health<br />Andrew S. Narva, MD, FACP</p>','Andrew S. Narva'),
	(57,'Feature Article: Leaching Potassium from Tuberous Root Veget','/forum_admin/files/Renal_Summer07feature.pdf',1,'<p>Feature Article: Leaching Potassium from Tuberous Root Vegetables <br />Jerrilynn D. Burrowes, PhD, RD, CDN</p>','Jerrilynn D. Burrowes'),
	(58,'Advances in Practice: Actual intake vs. prescribed diet in a','/forum_admin/files/Renal_Summer07advance.pdf',1,'<p>Advances in Practice: Actual intake vs. prescribed diet in a hemodialysis population: Comparison using a two-day dietary recall<br />By Mary Sundell, RD, LD, CCRP</p>','Mary Sundell'),
	(59,'Summer 2007 Patient Education Tool','/forum_admin/files/Renal_Summer_2007_color.pdf',1,'<p>Summer 2007 Patient Education Tool<br />By Mary Sundell, RD, LD, CCRP</p>','Mary Sundell'),
	(60,'Feature Article: An In-Depth Review of the Use of IV Vitamin','/forum_admin/files/Renal_Spring_2007feature.pdf',1,'<p>Feature Article: An In-Depth Review of the Use of IV Vitamin D Analogs and Parathyroidectomy in the Management of Secondary Hyperparathyroidism to Treat Calcific Uremic Arteriolopathy in Dialysis Patients.<br />By Wai Yin Ho, R.D., L.D.</p>','Wai Yin Ho'),
	(61,'Advances in Practice: Leptin and Nutritional Status in Patie','/forum_admin/files/Renal_Spring_2007practice.pdf',1,'<p>Advances in Practice: Leptin and Nutritional Status in Patients with CKD<br />By Philippa Norton Feiertag</p>','Philippa Norton Feiertag'),
	(62,'Feature Article: Vitamin and Mineral Recommendations for Old','/forum_admin/files/Renal_Winter_2007feature.pdf',1,'<p>Feature Article: Vitamin and Mineral Recommendations for Older People with Chronic Kidney Disease<br />Tiffany Sellers, MS, RD, Melinda Bell, BS, Graduate Assistant and Dietetic Intern Elizabeth M. Speer, BS<br /><br /></p>','Tiffany Sellers, MS, RD, Melinda Bell, BS, Graduate Assistan'),
	(63,'Advances in Practice: Botanical supplement use and potential','/forum_admin/files/Renal_Winter_2007advance.pdf',1,'<p>Advances in Practice: Botanical supplement use and potential side effects in patients with chronic kidney disease<br />By Phillipa Norton-Feirtag</p>','Phillipa Norton-Feirtag'),
	(64,'Feature Article: Impact Of Nutritional Supplements On Albumi','/forum_admin/files/Renal_Fall_2006feature.pdf',1,'<p>Feature Article: Impact Of Nutritional Supplements On Albumin Levels Of Dialysis Patients: Nutrition Supplement Grant Program National Kidney Foundation Of South Carolina<br />By Roxanne G. Poole, RD, Abdullah Hamad, MD, Lynn Thomas, DrPH, RD, CNSD, Peggy Strawhorn</p>','Roxanne G. Poole,  Abdullah Hamad, Lynn Thomas, Peggy Strawh'),
	(65,'Feature Article: Potassium Management in Peritoneal Dialysis','/forum_admin/files/Renal_Summer06feature.pdf',1,'<p>Feature Article: Potassium Management in Peritoneal Dialysis Patients: Can an Increased Potassium Diet Maintain a Normal Serum Potassium without a Potassium Supplement?<br />By Karen F. Factor, MBA, RD, LDN</p>','Karen F. Factor'),
	(66,'Feature Article: Nutritional Management of the Chronic Kidne','/forum_admin/files/Renal_Spring_2006feature.pdf',1,'<p>Feature Article: Nutritional Management of the Chronic Kidney Disease Patient<br />By LeeAnn Smith, MPH, RD</p>','LeeAnn Smith'),
	(67,'Advances in Practice: Dietary supplement use in patients wit','/forum_admin/files/Renal_Spring_2006advance.pdf',1,'<p>Advances in Practice: Dietary supplement use in patients with chronic kidney disease<br />By Philippa Norton Feiertag, MEd, RD, LD.</p>','Philippa Norton Feiertag'),
	(68,'Feature Article: Biotin in the Treatment of Uremic Neurologi','/forum_admin/files/Renal_Winter_2007feature.pdf',1,'<p>Feature Article: Biotin in the Treatment of Uremic Neurologic Disorders<br />By Joy Lutz-Mizar, MS, RD, CNIS</p>','Joy Lutz-Mizar'),
	(69,'Advances in Practice: Strategies for optimizing nutritional ','/forum_admin/files/Renal_Winter_2006advance.pdf',1,'<p>Advances in Practice: Strategies for optimizing nutritional intake and improving functional status in elderly patients undergoing maintenance dialysis therapy.<br />By Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(70,'Feature Article: The Effects of Alcohol on the Chronic Kidne','/forum_admin/files/Renal_Fall_2005feature.pdf',1,'<p>Feature Article: The Effects of Alcohol on the Chronic Kidney Disease Population<br />By LeeAnn Smith, MPH, RD</p>','LeeAnn Smith'),
	(71,'Advances in Practice: IMPACT OF GHRELIN ON NUTRITIONAL STATU','/forum_admin/files/Renal_Fall_2005advance.pdf',1,'<p>Advances in Practice: IMPACT OF GHRELIN ON NUTRITIONAL STATUS IN PATIENTS WITH CHRONIC KIDNEY DISEASE<br />Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(72,'Feature Article: Nutrition Management of the Patient with Ac','/forum_admin/files/Renal_Summer_2005feature.pdf',1,'<p>Feature Article: Nutrition Management of the Patient with Acute Renal Failure<br />By Marcia Kalista-Richards, MPH, RD, CNSD, Robert Pursell, MD, Robert Gayner, MD</p>','Marcia Kalista-Richards, Robert Pursell, Robert Gayner'),
	(73,'Advances in Practice: Therapeutic Benefits of Fish Oils for ','/forum_admin/files/Renal_Summer_2005advance.pdf',1,'<p>Advances in Practice: Therapeutic Benefits of Fish Oils for Patients with Chronic Kidney Disease<br />By Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(74,'Feature Article: The Use of Appetite Stimulants and Anabolic','/forum_admin/files/Renal_Spring_2005feature.pdf',1,'<p>Feature Article: The Use of Appetite Stimulants and Anabolic Agents in Hemodialysis Patients<br />By Cheryl W. Gullickson, MS, RD, LD, CNSD</p>','Cheryl W. Gullickson'),
	(75,'Advances in Practice: Impact of Infection and the Immune Res','/forum_admin/files/Renal_Spring_2005advance.pdf',1,'<p>Advances in Practice: Impact of Infection and the Immune Response on Nutritional Status in Patients with Chronic Kidney Disease Undergoing Maintenance Dialysis Therapy<br />By Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(76,'Feature Article: Impact of Metabolic Acidosis on Clinical Ou','/forum_admin/files/Renal_Winter_2005feature.pdf',1,'<p>Feature Article: Impact of Metabolic Acidosis on Clinical Outcomes in Patients with Chronic Kidney Disease<br />By Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(77,'Feature Article: Nutrition and Nephrolithiasis','/forum_admin/files/Renal_Fall_2004feature.pdf',1,'<p>Feature Article: Nutrition and Nephrolithiasis<br />Mansi Mehta</p>','Mansi Mehta'),
	(78,'Advances in Practice: New Approaches for Managing Bone Metab','/forum_admin/files/Renal_Fall_2004advance.pdf',1,'<p>Advances in Practice: New Approaches for Managing Bone Metabolism and Disease in Chronic Kidney Disease<br />By Philippa Norton Feiertag, MEd, RD, CSR, LD</p>','Philippa Norton Feiertag'),
	(79,'Feature Article: Advances in the Treatment of Hyperphosphate','/forum_admin/files/Renal_Summer_2004feature.pdf',1,'<p>Feature Article: Advances in the Treatment of Hyperphosphatemia: The Role of Lanthanum Carbonate<br />By William F. Finn, MD</p>','William F. Finn, MD'),
	(80,'Advances in Practice: Implications and Treatment Options for','/forum_admin/files/Renal_Summer_2004advance.pdf',1,'<p>Advances in Practice: Implications and Treatment Options for Overweight and Obese Patients with Chronic Kidney Disease<br />By Philippa Norton Feiertag, MEd, RD, LD</p>','Philippa Norton Feiertag'),
	(81,'Feature Article: Assessing Readiness To Lose Weight','/forum_admin/files/Renal_Spring_2004feature.pdf',1,'<p>Feature Article: Assessing Readiness To Lose Weight<br />Eve Gehling MEd, RD, CDE, Systems Manager, Center for Health Promotion, HealthPartners, Inc., Minneapolis, Minn.<br /><br /></p>','Eve Gehling'),
	(82,'Advances in Practice: Impact of different protein sources on','/forum_admin/files/Renal_Spring_2004advance.pdf',1,'<p>Advances in Practice: Impact of different protein sources on health outcomes in adults with kidney disease<br />By Philippa Norton Feiertag, MEd, RD, CSR, LD.</p>','Philippa Norton Feiertag'),
	(83,'Feature Article: The Effectiveness of Lifestyle Intervention','/forum_admin/files/Renal_Fall_2003feature.pdf',1,'<p>Feature Article: The Effectiveness of Lifestyle Intervention in the Diabetes Prevention Program: Application In Diverse Ethinic Groups<br />Linda Delahanty, MS, RD, Shandiin R. Begay, MPH, Norman Coocyate, Mary Hoskin, MS, RD, Mae Isonaga, RD, MPH, Erma J. Levy, MPH, RD, LDN, Kathy Mikami, RD, Sharon Ka`iulani Odom, MPH, RD, Kati Szamos, BS, RD<br /><br /></p>','Linda Delahanty, Shandiin R. Begay, Norman Coocyate, Mary Ho'),
	(84,'Advances in Practice: Carnitine supplementation in patients ','/forum_admin/files/Renal_Fall_2003advance.pdf',1,'<p>Advances in Practice: Carnitine supplementation in patients undergoing maintenance dialysis therapy<br />Philippa Norton Feiertag, MEd, RD, CSR, LD</p>','Philippa Norton Feiertag'),
	(85,'Feature Article: Homocysteine: The Newest Uremic Toxin?','/forum_admin/files/Renal_Summer_2003feature.pdf',1,'<p>Feature Article: Homocysteine: The Newest Uremic Toxin?<br />By Louise Clement, MS, RD, CSR, LD</p>','Louise Clement'),
	(86,'Advances in Practice: Improving health outcomes with exercis','/forum_admin/files/Renal_Summer_2003advance.pdf',1,'<p>Advances in Practice: Improving health outcomes with exercise in patients with end-stage renal disease<br />Philippa Norton Feiertag, MEd, RD, CSR, LD</p>','Philippa Norton Feiertag'),
	(87,'Advances in Practice: Adoption of Evidence-Based Guidelines ','/forum_admin/files/RNF_Fall_2011AdvPracArticle.pdf',1,'<p>Adoption of Evidence-Based Guidelines by Renal Dietitians in the United States<br />Megan Antosik, RD, Elizabeth Bancroft, MS, RD, LD, Nicole Ng, RD, and Jessie Pavlinac, MS, RD, CSR, LD</p>','Megan Antosik, Elizabeth Bancroft, Nicole Ng and Jessie Pavl'),
	(88,'Feature Article: The Benefits of Vegetarian Diets in Chronic','/forum_admin/files/RNF_Fall_2011_Feature_Article.pdf',1,'<p>The Benefits of Vegetarian Diets in Chronic Kidney Disease<br />Joan Brookhyser Hogan, RD, CSR, CD</p>','Joan Brookhyser Hogan, RD, CSR, CD'),
	(89,'Feature Article: Nutrition Management of Gastric Bypass Pati','/forum_admin/files/RNF_Spring_2012_Final.pdf',1,'<p><em><span class=\\\"maintitle\\\" style=\\\"font-weight: bold; text-align: left;\\\"><em>FEATURED ARTICLE</em></span><br /> Nutrition Management of Gastric Bypass Patients with Chronic Kidney Disease</em><br /> <span class=\\\"highlight\\\">Rachael Majorowicz, RD, LD</span><br /> <span class=\\\"copy\\\">1 hour, level 3<br /> </span></p>','Rachael Majorowicz, RD, LD'),
	(90,'Advance Practive: Developing the Research Question and Study','/forum_admin/files/RNF_Spring2012_advance.pdf',1,'<p><em><span class=\\\"maintitle\\\"><em><strong>ADVANCES IN PRACTICE ARTICLE</strong></em></span><em></em><br /> Developing the Research Question and Study Design</em><br /> <span class=\\\"highlight\\\">Lauren M. Beckman, MS, RD and Carrie P. Earthman, PhD, RD</span><br /> <span class=\\\"copy\\\">1 hour, level 3</span></p>','Lauren M. Beckman, MS, RD and Carrie P. Earthman, PhD, RD'),
	(91,'Featured Article: Reimbursement in Multidisciplinary Medical','/forum_admin/files/RNF_Summer_2012_featured_article.pdf',1,'<p>Featured Article: Reimbursement in Multidisciplinary Medical Practice<br />Mary Ann Hodorowicz, MBA, RD, CDE<br />1 hour, level 3</p>','Mary Ann Hodorowicz'),
	(92,'Advances in Practice: Pica: An Important & Unrecognized Prob','/forum_admin/files/RNF_Summer_2012_adv_practice.pdf',1,'<p>Advances in Practice: Pica: An Important &amp; Unrecognized Problem in Pediatric Dialysis Patients<br />Chryso Pefkaros Katsoufis MD, Myerly Kertis RD, Judith McCullough PhD, Tanya Pereira MD, Wacharee Seeherunvong MD, Jayanthi Chandar MD, Gaston Zilleruelo, MD, and Carolyn Abitbol MD<br />1 hour, level 3</p>','Chryso Pefkaros Katsoufis, Myerly Kertis, Judith McCullough,'),
	(94,'Feature Article: Binder Bracelet Activity','/forum_admin/files/RNF_FeatureArticle_Vol 31_No4_2012.pdf',1,'<p>Feature Article: Binder Bracelet Activity to Help Improve Binder Medication Compliance and Serum Phosphorus In Hemodialysis Patients<br />By Molly Ennis, RD, LD, Mildred Mattfeldt-Beman, PhD, RD, LD, Amy R. Moore, MPH, MS, RD, LD, Ajlina Karamehic-Muratovic, PhD</p>','Molly Ennis, Mildred Mattfeldt-Beman, Amy R. Moore and Ajlin'),
	(95,'Advances in Practice: Nutrition-focused Physical Exam','/forum_admin/files/RNF_AdvPractice_Vol 31_No4_2012.pdf',1,'<p>Advances in Practice: Nutrition-focused Physical Examination: Skin, Nails, Hair, Eyes, and Oral Cavity<br />By Cassandra Pogatshnik, RD, LD, CNSC and Cindy Hamilton, MS, RD, LD, CNSD</p>','Cassandra Pogatshnik and Cindy Hamilton'),
	(96,'Featured Article: Utilizing the Nutrition Care Process and N','/forum_admin/files/RPG2013Vol32No1FEATUREArticle.pdf',1,'<p>Featured Article: Utilizing the Nutrition Care Process and Nutrition-Focused Physical Exam in the Care of the Medically Complex Patient on Hemodialysis</p>\\r\\n<p>Mona Therrien, MSB, RD, CSR, LD<br /><br /></p>','Mona Therrien, MSB, RD, CSR, LD'),
	(97,'Advances in Practice: Rethinking Renal: A Coach Approach Cha','/forum_admin/files/RPG2013Vol 32No1ADVANCESPracArticle.pdf',1,'<p>Advances in Practice: Rethinking Renal: A Coach Approach Challenging Treatment Norms and Incorporating Motivational Techniques<br />Desiree de Waal, MS, RD, CD, Kathe LeBeau, BA, Sharon Stall, MPH, RD, CSR, and Joan Hogan, RD, CSR, CD, CLT</p>','Desiree de Waal, MS, RD, CD, Kathe LeBeau, BA, Sharon Stall,');

/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table articlesearch
# ------------------------------------------------------------

DROP VIEW IF EXISTS `articlesearch`;

CREATE TABLE `articlesearch` (
   `article_title` VARCHAR(500) DEFAULT NULL,
   `article_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
   `description` TEXT DEFAULT NULL,
   `sub_name` VARCHAR(60) DEFAULT NULL
) ENGINE=MyISAM;



# Dump of table articlesForArchive
# ------------------------------------------------------------

DROP TABLE IF EXISTS `articlesForArchive`;

CREATE TABLE `articlesForArchive` (
  `article_id` int(11) unsigned NOT NULL,
  `archive_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `articlesForArchive` WRITE;
/*!40000 ALTER TABLE `articlesForArchive` DISABLE KEYS */;

INSERT INTO `articlesForArchive` (`article_id`, `archive_id`)
VALUES
	(21,12),
	(22,0),
	(23,12),
	(24,11),
	(25,11),
	(27,9),
	(28,10),
	(29,10),
	(30,9),
	(31,13),
	(32,13),
	(33,14),
	(34,14),
	(35,15),
	(36,15),
	(37,16),
	(38,16),
	(39,17),
	(40,17),
	(41,18),
	(42,18),
	(43,19),
	(44,19),
	(45,20),
	(46,20),
	(47,21),
	(48,21),
	(49,21),
	(50,22),
	(52,22),
	(53,23),
	(54,23),
	(55,24),
	(56,24),
	(57,25),
	(58,25),
	(59,25),
	(60,26),
	(61,26),
	(62,27),
	(63,27),
	(64,28),
	(65,29),
	(66,30),
	(67,30),
	(68,31),
	(69,31),
	(70,32),
	(71,32),
	(72,33),
	(73,33),
	(74,34),
	(75,34),
	(76,35),
	(77,36),
	(78,36),
	(79,37),
	(80,37),
	(81,38),
	(82,38),
	(83,39),
	(84,39),
	(85,40),
	(86,40),
	(87,41),
	(88,41),
	(89,43),
	(90,43),
	(91,44),
	(92,44),
	(94,45),
	(95,45),
	(96,47),
	(97,47);

/*!40000 ALTER TABLE `articlesForArchive` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(60) DEFAULT NULL,
  `published` int(2) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `category_name` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`category_id`, `category_name`, `published`)
VALUES
	(1,'Author',1),
	(3,'Disease or Condition',1),
	(7,'Diet & Nutrition',1),
	(8,'CKD Stages 1-5',1),
	(9,'Nutrients, Additives & Supplements',1),
	(10,'Populations or Groups',1),
	(11,'Results or Outcomes',1),
	(12,'Treatments & Interventions',1),
	(13,'Dialysis',1),
	(14,'Interactions',1);

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categoriesForArticle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categoriesForArticle`;

CREATE TABLE `categoriesForArticle` (
  `category_id` int(11) unsigned NOT NULL,
  `article_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `categoriesForArticle` WRITE;
/*!40000 ALTER TABLE `categoriesForArticle` DISABLE KEYS */;

INSERT INTO `categoriesForArticle` (`category_id`, `article_id`)
VALUES
	(3,14),
	(6,14),
	(5,14),
	(4,14),
	(2,15),
	(1,1),
	(2,1),
	(3,1),
	(8,1),
	(6,11),
	(7,11),
	(1,16),
	(2,16),
	(8,17),
	(2,17),
	(8,18),
	(2,18),
	(0,22),
	(50,27),
	(52,27),
	(56,24),
	(57,24),
	(58,25),
	(59,21),
	(60,21),
	(62,31),
	(63,31),
	(64,31),
	(65,32),
	(166,32),
	(67,33),
	(68,33),
	(69,34),
	(53,34),
	(70,35),
	(71,35),
	(72,36),
	(73,36),
	(74,37),
	(73,37),
	(75,38),
	(76,38),
	(77,39),
	(78,39),
	(79,40),
	(80,40),
	(81,41),
	(82,41),
	(83,41),
	(84,42),
	(86,44),
	(87,44),
	(88,45),
	(89,45),
	(90,45),
	(93,47),
	(94,47),
	(95,48),
	(96,48),
	(97,48),
	(98,49),
	(99,50),
	(100,50),
	(65,50),
	(65,52),
	(101,52),
	(102,53),
	(103,53),
	(104,53),
	(105,54),
	(106,54),
	(107,54),
	(53,56),
	(55,56),
	(110,57),
	(111,57),
	(112,58),
	(113,58),
	(114,59),
	(115,60),
	(116,60),
	(117,60),
	(118,60),
	(123,63),
	(124,63),
	(72,64),
	(125,64),
	(126,65),
	(127,65),
	(130,67),
	(132,67),
	(133,68),
	(134,68),
	(138,71),
	(139,71),
	(140,72),
	(53,72),
	(141,73),
	(142,73),
	(143,74),
	(144,74),
	(145,74),
	(145,75),
	(146,75),
	(167,75),
	(147,76),
	(148,76),
	(53,78),
	(151,78),
	(60,79),
	(152,79),
	(53,80),
	(153,80),
	(154,81),
	(155,81),
	(156,82),
	(157,82),
	(158,82),
	(159,83),
	(160,83),
	(161,83),
	(162,84),
	(145,84),
	(163,85),
	(41,28),
	(43,28),
	(44,28),
	(48,28),
	(49,28),
	(177,88),
	(170,88),
	(168,88),
	(53,30),
	(55,30),
	(172,30),
	(168,87),
	(169,87),
	(140,87),
	(173,87),
	(174,87),
	(175,87),
	(176,87),
	(172,87),
	(61,23),
	(53,23),
	(172,23),
	(85,43),
	(53,43),
	(172,43),
	(128,66),
	(129,66),
	(172,66),
	(137,70),
	(172,70),
	(45,29),
	(46,29),
	(47,29),
	(171,29),
	(121,62),
	(122,62),
	(171,62),
	(119,61),
	(120,61),
	(171,61),
	(108,55),
	(109,55),
	(171,55),
	(135,69),
	(136,69),
	(171,69),
	(149,77),
	(150,77),
	(171,77),
	(164,86),
	(145,86),
	(91,46),
	(92,46),
	(88,92),
	(178,94),
	(179,94),
	(180,94),
	(181,94),
	(182,94),
	(73,96),
	(45,96);

/*!40000 ALTER TABLE `categoriesForArticle` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table commerce
# ------------------------------------------------------------

DROP TABLE IF EXISTS `commerce`;

CREATE TABLE `commerce` (
  `site_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sales_tax` float DEFAULT NULL,
  `shipping_cost` float DEFAULT NULL,
  `auth_id` varchar(200) DEFAULT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `commerce` WRITE;
/*!40000 ALTER TABLE `commerce` DISABLE KEYS */;

INSERT INTO `commerce` (`site_id`, `sales_tax`, `shipping_cost`, `auth_id`, `trans_id`)
VALUES
	(1,0,0,'123','123');

/*!40000 ALTER TABLE `commerce` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contactInformation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contactInformation`;

CREATE TABLE `contactInformation` (
  `contact_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  `faxnumber` varchar(45) DEFAULT NULL,
  `summary` text,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `contactInformation` WRITE;
/*!40000 ALTER TABLE `contactInformation` DISABLE KEYS */;

INSERT INTO `contactInformation` (`contact_id`, `email`, `address_id`, `phonenumber`, `faxnumber`, `summary`)
VALUES
	(1,'zack@octopodinteractive.com',35,'469.556.9406','','<p class=\"sprites-color_logo ir\">Renal Dietitians (RPG)</p><p>Renal Dietitians (RPG) consists of Registered Dietitians and other clinicians who provide renal nutrition therapy interventions and counseling in dialysis facilities, freestanding clinics, hospitals, private practice, and hospitals.</p><p>Renal Dietitians is a dietetic practice group of the Academy of Nutrition and Dietetics.</p>');

/*!40000 ALTER TABLE `contactInformation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(60) DEFAULT NULL,
  `access` int(60) DEFAULT NULL,
  `content` text,
  `modified_by` int(11) DEFAULT NULL,
  `searchable` text,
  `summary` text,
  `directLink` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`content_id`),
  FULLTEXT KEY `title` (`title`,`searchable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;

INSERT INTO `content` (`content_id`, `user_id`, `created_on`, `published`, `modified_on`, `title`, `access`, `content`, `modified_by`, `searchable`, `summary`, `directLink`)
VALUES
	(1,'2','2011-09-09 12:00:00',1,'2013-04-05 05:10:22','What is Black Ink?',2,'<dl><dd><code>{! productcategories:Webinars !}</code></dd></dl><div><code><br /></code></div><div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</div><p>Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh.</p><p>Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit.</p><p>Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris.</p><p>Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet.</p>',1,'{! productcategories:Webinars !}\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\nCurabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh.\r\nQuisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit.\r\nSed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris.\r\nMorbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh.','what-is-black-ink'),
	(14,'2','2011-09-09 12:00:00',1,'2013-04-05 05:01:20','Black Ink.',1,'<p><img style=\"float: left; margin: 10px;\" title=\"iPhone\" src=\"../files/uploads/ipiphone.png\" alt=\"iPhone\" width=\"286\" height=\"470\" /></p><p>&nbsp;</p><p>{! Products:1 !}</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p><p>Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh.</p><p>Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit.</p><p>Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris.</p><p>Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet.</p>',1,'\r\n&nbsp;\r\n{! Products:1 !}\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\nCurabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh.\r\nQuisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit.\r\nSed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris.\r\nMorbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.','black-ink');

/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table frontPage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `frontPage`;

CREATE TABLE `frontPage` (
  `front_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image_url` varchar(200) DEFAULT NULL,
  `published` tinyint(3) NOT NULL DEFAULT '1',
  `link` varchar(200) DEFAULT NULL,
  `content` text,
  `position` int(11) DEFAULT NULL,
  `title` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`front_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `frontPage` WRITE;
/*!40000 ALTER TABLE `frontPage` DISABLE KEYS */;

INSERT INTO `frontPage` (`front_id`, `image_url`, `published`, `link`, `content`, `position`, `title`)
VALUES
	(1,'/images/front_page/fp_1.jpg',1,'','<p>Check out this new hot topic at FNCE</p>',1,'Phosphorus the new Trans Fat? '),
	(2,'/images/front_page/fp_2.jpg',1,'#','<p>Lorem ipsum dolor sit amet, consectetuer adipiscing\n              elit. Aenean commodo ligula eget dolor. Aenean massa</p>',2,'Tab Numero Dos'),
	(3,'/images/front_page/fp_3.jpg',1,'#','<p>Lorem ipsum dolor sit amet, consectetuer adipiscing\n              elit. Aenean commodo ligula eget dolor. Aenean massa</p>',3,'Third Time is the Charm');

/*!40000 ALTER TABLE `frontPage` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `keyword_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;

INSERT INTO `keywords` (`keyword_id`, `keyword`)
VALUES
	(1,'keywords'),
	(2,'hello'),
	(3,'Black Ink'),
	(4,'Content Management System'),
	(5,'This si a keyword'),
	(6,'Content Mangament System'),
	(7,'Welcome'),
	(8,'content');

/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table keywordsForContent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywordsForContent`;

CREATE TABLE `keywordsForContent` (
  `keyword_id` int(11) NOT NULL,
  `content_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `keywordsForContent` WRITE;
/*!40000 ALTER TABLE `keywordsForContent` DISABLE KEYS */;

INSERT INTO `keywordsForContent` (`keyword_id`, `content_id`)
VALUES
	(1,13),
	(2,13),
	(2,7),
	(3,1),
	(4,1),
	(5,1),
	(3,14),
	(6,14),
	(7,14),
	(8,15);

/*!40000 ALTER TABLE `keywordsForContent` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(250) DEFAULT NULL,
  `file_link` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;

INSERT INTO `media` (`media_id`, `file_name`, `file_link`)
VALUES
	(7,'pwords.docx','/files/products/pwords.docx');

/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(30) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;

INSERT INTO `menus` (`menu_id`, `menu_name`, `published`, `access`)
VALUES
	(1,'Main Menu',1,1),
	(2,'Quick Menu',1,1),
	(3,'About RPG',1,1);

/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table navigation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `navigation`;

CREATE TABLE `navigation` (
  `navigation_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `parent_id` int(5) DEFAULT NULL,
  `access` int(5) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `link` varchar(60) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `default_page` int(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `directLink` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`navigation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `navigation` WRITE;
/*!40000 ALTER TABLE `navigation` DISABLE KEYS */;

INSERT INTO `navigation` (`navigation_id`, `title`, `parent_id`, `access`, `position`, `published`, `link`, `menu_id`, `default_page`, `type`, `directLink`)
VALUES
	(1,'About RPG',0,1,0,1,'',1,0,1,'about-rpg'),
	(22,'Drop Down 1',3,1,1,1,'',1,0,1,'drop-down-1'),
	(23,'Drop Down 2',3,1,1,1,'',1,0,1,'drop-down-2'),
	(24,'Drop Down 3',3,1,1,1,'',1,0,1,'drop-down-3'),
	(25,'Drop Down 4',3,1,1,1,'',1,0,1,'drop-down-4'),
	(31,'Login',0,1,0,1,'#',2,0,2,'login'),
	(32,'Join',0,1,1,1,'/users/join.html',2,0,2,'join'),
	(33,'Black Ink',0,3,1,1,'/staff/login.php',2,0,2,'black-ink'),
	(37,'Contact Us',0,1,1,1,'/contact_us.html',2,0,2,'contact-us'),
	(88,'Home',0,1,10,0,'',1,1,1,'home'),
	(89,'Profile',0,2,1,0,'/profile.html',2,0,2,'profile'),
	(128,'Drop Down 5',3,1,4,1,'',1,0,1,'drop-down-5'),
	(129,'Drop down 6',3,1,5,1,'',1,0,1,'drop-down-6'),
	(130,'Archives',0,1,3,1,'/archives.html',1,0,2,'archives'),
	(131,'Areas of Expertise',0,1,4,1,'',1,0,1,'areas-of-expertise'),
	(132,'E-Learning',0,1,6,1,'',1,0,1,'e-learning'),
	(133,'Careers & Students',0,1,5,1,'',1,0,1,'careers-students'),
	(134,'Events',0,1,6,1,'/calendar.html',1,0,2,'events'),
	(135,'Nutrition Info',0,1,7,0,'',1,0,1,'nutrition-info'),
	(136,'Sponsors',0,1,8,1,'',1,0,1,'sponsors'),
	(137,'Store',0,1,9,1,'/rpg_store.html',1,0,2,'store'),
	(140,'The Board',0,1,1,1,'',3,0,1,'the-board'),
	(141,'Office Descriptions',140,1,1,1,'',3,0,1,'office-descriptions'),
	(142,'Benefits of Membership',0,1,2,1,'',3,0,1,'benefits-of-membership'),
	(143,'Join/Renew Membership',0,1,3,1,'',3,0,1,'joinrenew-membership'),
	(144,'Awards & Stipends',0,1,4,1,'',3,0,1,'awards-stipends'),
	(145,'Nomination Information',144,1,1,1,'',3,0,1,'nomination-information'),
	(146,'Public Policy MNT & HOD Updates',0,1,5,1,'',3,0,1,'public-policy-mnt-hod-updates'),
	(147,'Annual Report',0,1,6,1,'',3,0,1,'annual-report');

/*!40000 ALTER TABLE `navigation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table navigationForContent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `navigationForContent`;

CREATE TABLE `navigationForContent` (
  `navigation_id` int(11) NOT NULL DEFAULT '0',
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`navigation_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `navigationForContent` WRITE;
/*!40000 ALTER TABLE `navigationForContent` DISABLE KEYS */;

INSERT INTO `navigationForContent` (`navigation_id`, `content_id`)
VALUES
	(1,1),
	(129,1),
	(130,1),
	(142,1),
	(24,2),
	(13,4),
	(25,4),
	(36,5),
	(115,5),
	(22,7),
	(90,8),
	(23,9),
	(88,14),
	(131,14),
	(141,14),
	(40,15),
	(41,15),
	(26,16),
	(38,23),
	(39,23),
	(99,23),
	(100,24),
	(107,25),
	(101,26);

/*!40000 ALTER TABLE `navigationForContent` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `published` int(2) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `title` varchar(60) NOT NULL,
  `access` int(5) DEFAULT NULL,
  `summary` text,
  `directLink` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;

INSERT INTO `news` (`news_id`, `content`, `published`, `user_id`, `created_on`, `title`, `access`, `summary`, `directLink`)
VALUES
	(9,'<p>News Story</p>',1,2,'0000-00-00 00:00:00','Black Ink is Live',1,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.</p>','/news/.html'),
	(11,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.</p>\r\n<p>Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus.</p>\r\n<p>Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris.</p>\r\n<p>Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci.</p>',1,2,'0000-00-00 00:00:00','New Blog Plugin Added',1,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.</p>','');

/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `transaction_id` int(200) unsigned NOT NULL,
  `authorization_id` int(200) DEFAULT NULL,
  `first_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `billing_address_id` int(11) DEFAULT NULL,
  `shipping_address_id` int(11) DEFAULT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `sales_tax` varchar(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `tracking_number` varchar(200) DEFAULT NULL,
  `totalPrice` varchar(11) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `card_type` varchar(60) DEFAULT NULL,
  `account_number` varchar(60) DEFAULT NULL,
  `voided` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phone
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phone`;

CREATE TABLE `phone` (
  `phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `phonenumber` varchar(45) DEFAULT NULL,
  `phone_type` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`phone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;

INSERT INTO `phone` (`phone_id`, `phonenumber`, `phone_type`)
VALUES
	(1,'469-556-9406','OP'),
	(32,'972.535.4040','HP');

/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phoneForUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phoneForUser`;

CREATE TABLE `phoneForUser` (
  `user_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phoneForUser` WRITE;
/*!40000 ALTER TABLE `phoneForUser` DISABLE KEYS */;

INSERT INTO `phoneForUser` (`user_id`, `phone_id`)
VALUES
	(1,1),
	(1,32);

/*!40000 ALTER TABLE `phoneForUser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phoneType
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phoneType`;

CREATE TABLE `phoneType` (
  `id` int(11) DEFAULT NULL,
  `phone_type` varchar(2) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phoneType` WRITE;
/*!40000 ALTER TABLE `phoneType` DISABLE KEYS */;

INSERT INTO `phoneType` (`id`, `phone_type`, `name`)
VALUES
	(1,'HP','Home'),
	(2,'CP','Cell'),
	(3,'FX','Fax'),
	(4,'OP','Office');

/*!40000 ALTER TABLE `phoneType` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table productCategories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `productCategories`;

CREATE TABLE `productCategories` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `directLink` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `productCategories` WRITE;
/*!40000 ALTER TABLE `productCategories` DISABLE KEYS */;

INSERT INTO `productCategories` (`category_id`, `category_name`, `published`, `directLink`)
VALUES
	(1,'Webinars',1,'webinars'),
	(2,'Videos',1,'videos');

/*!40000 ALTER TABLE `productCategories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(250) DEFAULT NULL,
  `content` text,
  `NM_price` float DEFAULT NULL,
  `M_price` float DEFAULT NULL,
  `I_price` float DEFAULT NULL,
  `featured` tinyint(11) NOT NULL DEFAULT '0',
  `directLink` varchar(250) DEFAULT NULL,
  `shipping` float DEFAULT NULL,
  `external` varchar(600) DEFAULT NULL,
  `type` tinyint(11) DEFAULT NULL,
  `download` varchar(600) DEFAULT NULL,
  `published` tinyint(3) NOT NULL DEFAULT '1',
  `front_page` tinyint(3) NOT NULL DEFAULT '0',
  `out_of_stock` tinyint(3) NOT NULL DEFAULT '0',
  `quantity` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_id`),
  KEY `product_name` (`product_name`),
  KEY `featured` (`featured`),
  KEY `frontpage` (`front_page`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`product_id`, `product_name`, `content`, `NM_price`, `M_price`, `I_price`, `featured`, `directLink`, `shipping`, `external`, `type`, `download`, `published`, `front_page`, `out_of_stock`, `quantity`)
VALUES
	(1,'Product 1','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.</p>',4.99,10.2,20,0,'product-1',0,'',0,'/files/products/pwords.docx',1,0,0,1),
	(2,'Product 2','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. </p>',35,20,NULL,1,'product-2',0,NULL,NULL,NULL,1,1,0,0),
	(3,'Product 3','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.</p>',10,12,NULL,0,'product-3',10.99,'1',0,NULL,1,0,0,0),
	(4,'Product 4','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. </p>',20,12,NULL,1,'product-4',NULL,NULL,NULL,NULL,1,0,0,0),
	(5,'Product 5','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. </p>',15,1,NULL,1,'product-5',NULL,NULL,NULL,NULL,1,0,0,0);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table productsForCategories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `productsForCategories`;

CREATE TABLE `productsForCategories` (
  `product_id` int(11) unsigned NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `productsForCategories` WRITE;
/*!40000 ALTER TABLE `productsForCategories` DISABLE KEYS */;

INSERT INTO `productsForCategories` (`product_id`, `category_id`)
VALUES
	(1,2),
	(2,1),
	(3,2);

/*!40000 ALTER TABLE `productsForCategories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `site`;

CREATE TABLE `site` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `siteName` varchar(60) NOT NULL,
  `siteDescription` text,
  `googleCode` varchar(60) DEFAULT NULL,
  `keywords` varchar(250) DEFAULT NULL,
  `siteURL` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `site` WRITE;
/*!40000 ALTER TABLE `site` DISABLE KEYS */;

INSERT INTO `site` (`site_id`, `siteName`, `siteDescription`, `googleCode`, `keywords`, `siteURL`)
VALUES
	(1,'Renal Nutition','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis, tortor in viverra dapibus, diam neque aliquet ligula, vel rhoncus metus eros sed turpis. Donec eleifend consectetur urna, a faucibus odio rutrum quis. Cras auctor massa et tortor adipiscing luctus. Fusce quam quam, vestibulum id eleifend eget, convallis nec risus. Donec sit amet nunc vel lectus aliquam mollis eu et mauris. Ut bibendum purus a eros tempor eleifend. Curabitur vel pulvinar nulla. Cras hendrerit auctor nunc condimentum tincidunt. Sed nec quam urna, sit amet aliquet est.','UA-38112684-1','','dev.renal.com');

/*!40000 ALTER TABLE `site` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table siteConfiguration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `siteConfiguration`;

CREATE TABLE `siteConfiguration` (
  `site_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Ads` int(11) DEFAULT NULL,
  `News` int(11) DEFAULT NULL,
  `Search` int(11) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `siteConfiguration` WRITE;
/*!40000 ALTER TABLE `siteConfiguration` DISABLE KEYS */;

INSERT INTO `siteConfiguration` (`site_id`, `Ads`, `News`, `Search`)
VALUES
	(1,1,0,1);

/*!40000 ALTER TABLE `siteConfiguration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table social
# ------------------------------------------------------------

DROP TABLE IF EXISTS `social`;

CREATE TABLE `social` (
  `social_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facebook_url` varchar(250) DEFAULT NULL,
  `twitter_url` varchar(250) DEFAULT NULL,
  `linkedin_url` varchar(250) DEFAULT NULL,
  `foursquare_url` varchar(250) DEFAULT NULL,
  `last_fm_url` varchar(250) DEFAULT NULL,
  `tumblr_url` varchar(250) DEFAULT NULL,
  `google_url` varchar(250) DEFAULT NULL,
  `pinterest_url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`social_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `social` WRITE;
/*!40000 ALTER TABLE `social` DISABLE KEYS */;

INSERT INTO `social` (`social_id`, `facebook_url`, `twitter_url`, `linkedin_url`, `foursquare_url`, `last_fm_url`, `tumblr_url`, `google_url`, `pinterest_url`)
VALUES
	(1,'http://facebook.com','http://twitter.com','http://linkedin.com','','','','http://googleplus.google.com',NULL);

/*!40000 ALTER TABLE `social` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table states
# ------------------------------------------------------------

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statename` varchar(45) NOT NULL,
  `code` varchar(3) NOT NULL,
  `country` varchar(25) NOT NULL,
  PRIMARY KEY (`state_id`),
  UNIQUE KEY `state_id_UNIQUE` (`state_id`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;

INSERT INTO `states` (`state_id`, `statename`, `code`, `country`)
VALUES
	(1,'Alabama','AL','USA'),
	(2,'Alaska','AK','USA'),
	(3,'Arizona','AZ','USA'),
	(4,'Arkansas','AR','USA'),
	(5,'California','CA','USA'),
	(6,'Colorado','CO','USA'),
	(7,'Connecticut','CT','USA'),
	(8,'Delaware','DE','USA'),
	(9,'District of Columbia','DC','USA'),
	(10,'Florida','FL','USA'),
	(11,'Georgia','GA','USA'),
	(12,'Hawaii','HI','USA'),
	(13,'Idaho','ID','USA'),
	(14,'Illinois','IL','USA'),
	(15,'Indiana','IN','USA'),
	(16,'Iowa','IA','USA'),
	(17,'Kansas','KS','USA'),
	(18,'Kentucky','KY','USA'),
	(19,'Louisiana','LA','USA'),
	(20,'Maine','ME','USA'),
	(21,'Maryland','MD','USA'),
	(22,'Massachusetts','MA','USA'),
	(23,'Michigan','MI','USA'),
	(24,'Minnesota','MN','USA'),
	(25,'Mississippi','MS','USA'),
	(26,'Missouri','MO','USA'),
	(27,'Montana','MT','USA'),
	(28,'Nebraska','NE','USA'),
	(29,'Nevada','NV','USA'),
	(30,'New Hampshire','NH','USA'),
	(31,'New Jersey','NJ','USA'),
	(32,'New Mexico','NM','USA'),
	(33,'New York','NY','USA'),
	(34,'North Carolina','NC','USA'),
	(35,'North Dakota','ND','USA'),
	(36,'Ohio','OH','USA'),
	(37,'Oklahoma','OK','USA'),
	(38,'Oregon','OR','USA'),
	(39,'Pennsylvania','PA','USA'),
	(40,'Rhode Island','RI','USA'),
	(41,'South Carolina','SC','USA'),
	(42,'South Dakota','SD','USA'),
	(43,'Tennessee','TN','USA'),
	(44,'Texas','TX','USA'),
	(45,'Utah','UT','USA'),
	(46,'Vermont','VT','USA'),
	(47,'Virginia','VA','USA'),
	(48,'Washington','WA','USA'),
	(49,'West Virginia','WV','USA'),
	(50,'Wisconsin','WI','USA'),
	(51,'Wyoming','WY','USA'),
	(52,'American Samoa','AS','USA'),
	(53,'Guam','GU','USA'),
	(54,'Northern Mariana Islands','MP','USA'),
	(55,'Puerto Rico','PR','USA'),
	(56,'Virgin Islands','VI','USA');

/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subCats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subCats`;

CREATE TABLE `subCats` (
  `sub_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub_name` varchar(60) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  PRIMARY KEY (`sub_id`),
  KEY `sub_name` (`sub_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `subCats` WRITE;
/*!40000 ALTER TABLE `subCats` DISABLE KEYS */;

INSERT INTO `subCats` (`sub_id`, `sub_name`, `published`)
VALUES
	(41,'Vegan Diet',1),
	(43,'SVLPD - Supplemented Vegan Low Protein Diet',1),
	(44,'Ketoanalogues',1),
	(45,'Nutrition Assessment',1),
	(46,'Stage 5 CKD',1),
	(47,'Erin Ghaffari',1),
	(48,'Jennifer Moore',1),
	(49,'Roschelle Heuberger',1),
	(50,'Vitamin A Deficiency',1),
	(52,'CKD Stage 5 Case Study',1),
	(53,'MNT',1),
	(55,'CKD Stages 1-4',1),
	(56,'IDPN',1),
	(57,'Malnutrition CKD Stage 5',1),
	(58,'IDPN Initiation',1),
	(59,'Niacin',1),
	(60,'Hyperphosphatemia',1),
	(61,'NKDEP - National Kidney Disease Education Program',1),
	(62,'Home Dialysis',1),
	(63,'Nocturnal Dialysis',1),
	(64,'Phosphorus Status',1),
	(65,'Cardiovascular Disease',1),
	(67,'Vitamin D Supplementation',1),
	(68,'Elderly Population/Physical Function',1),
	(69,'Pediatric Population',1),
	(70,'RIFLE Classification',1),
	(71,'ARF',1),
	(72,'Oral Nutrition Supplementation',1),
	(73,'Hemodialysis',1),
	(74,'Eating Disorder Counseling',1),
	(75,'Ergocalciferol Overdose',1),
	(76,'Hemodialysis Case Study',1),
	(77,'Metabolic Syndrome',1),
	(78,'Cardiometabolic Risk',1),
	(79,'Nutrigenomics',1),
	(80,'Genetics',1),
	(81,'Micronutrients',1),
	(82,'Inflammation indicators',1),
	(83,'Antioxidants',1),
	(84,'Publication of Research - RD\'s',1),
	(85,'Concurrent Liver/Renal Failure',1),
	(86,'Interdialytic Weight Gains',1),
	(87,'Behavioral Change',1),
	(88,'Pediatric Renal Nutrition',1),
	(89,'Renal Tubular Dysfunction',1),
	(90,'FTT - Failure to Thrive',1),
	(91,'Media Relations',1),
	(92,'Interviewing Tips',1),
	(93,'Hidden Phosphorus',1),
	(94,'Phosphate Additives',1),
	(95,'MNT Case Study',1),
	(96,'Obesity',1),
	(97,'Diabetes',1),
	(98,'The Kidney Friendly Grocery Shelf',1),
	(99,'Alternative Medicine',1),
	(100,'Depression',1),
	(101,'Kidney Transplant',1),
	(102,'Evidence-Based Practice Webinars',1),
	(103,'Renal RD’s',1),
	(104,'Dietetic Practice Groups',1),
	(105,'Megestrol Acetate',1),
	(106,'Anorexia',1),
	(107,'CKD Stage 5',1),
	(108,'Nutrition Intervention in CKD',1),
	(109,'RD Roundtable Discussions',1),
	(110,'K+ leaching',1),
	(111,'Tuberous Root Vegetables',1),
	(112,'2-day diet recalls',1),
	(113,'Prescribed vs. Actual Dietary Intake',1),
	(114,'How to Leach K+ From Tuberous Root Vegetables',1),
	(115,'IV Vitamin D Analogues',1),
	(116,'Parathyroidectomy',1),
	(117,'Secondary Hyperparathyroidism',1),
	(118,'Calciphylaxis',1),
	(119,'Leptin',1),
	(120,'Nutrition Intake',1),
	(121,'Vitamin and Mineral intake recommendations',1),
	(122,'Elderly Renal Nutrition',1),
	(123,'Botanicals',1),
	(124,'Herbal Supplements',1),
	(125,'Albumin Status',1),
	(126,'K+ status',1),
	(127,'Peritoneal Dialysis',1),
	(128,'MNT CKD Stages 1-5',1),
	(129,'Transplant',1),
	(130,'Dietary Supplement Recommendations',1),
	(132,'CKD Stages 1-5',1),
	(133,'Biotin Supplementation/Deficiency',1),
	(134,'Uremic Neurologic Disorders',1),
	(135,'Nutrient Intake',1),
	(136,'Elderly Hemodialysis population',1),
	(137,'Ethanol Intake and Medication Interactions',1),
	(138,'Ghrelin',1),
	(139,'Protein Energy Malnutrition',1),
	(140,'Evidence Based Guidelines',1),
	(141,'Fish Oil Supplementation',1),
	(142,'IgA Nephropathy',1),
	(143,'Appetite Stimulants',1),
	(144,'Anabolic Agents',1),
	(145,'Hemodialysis Population',1),
	(146,'Infection',1),
	(147,'Metabolic Acidosis',1),
	(148,'Clinical Outcomes',1),
	(149,'Nephrolithiasis',1),
	(150,'Nutrition Intervention ',1),
	(151,'Bone Metabolism',1),
	(152,'Lanthanum Carbonate',1),
	(153,'Obesity/Weight Control',1),
	(154,'Weight Loss Counseling',1),
	(155,'Assessing Readiness to Lose Weight',1),
	(156,'Oligosaccharides',1),
	(157,'Protein Sources',1),
	(158,'Health Outcomes',1),
	(159,'Lifestyle Interventions',1),
	(160,'DPP -Diabetes Prevention Program',1),
	(161,'Diverse Ethnic Populations',1),
	(162,'L-Carnitine',1),
	(163,'Homocysteine',1),
	(164,'Benefits of Exercise',1),
	(166,'TLC - Therapeutic Lifestyle Changes',1),
	(167,'Immune Response',1),
	(168,'Chronic Kidney Disease',1),
	(169,'Evidence Analysis Library',1),
	(170,'vegetarian',1),
	(171,'nutrition',1),
	(172,'kidney',1),
	(173,'Megan Antosik',1),
	(174,'Elizabeth Bancroft',1),
	(175,'Nicole Ng',1),
	(176,'Jessie Pavl',1),
	(177,'Joan Brookhyser Hogan',1),
	(178,'Serum phosphorus',1),
	(179,'binder medication',1),
	(180,'compliance',1),
	(181,'bracelet reminder',1),
	(182,'learning tool',1);

/*!40000 ALTER TABLE `subCats` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subCatsForCat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subCatsForCat`;

CREATE TABLE `subCatsForCat` (
  `category_id` int(11) unsigned NOT NULL,
  `sub_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `subCatsForCat` WRITE;
/*!40000 ALTER TABLE `subCatsForCat` DISABLE KEYS */;

INSERT INTO `subCatsForCat` (`category_id`, `sub_id`)
VALUES
	(10,104),
	(10,161),
	(10,136),
	(10,145),
	(10,165),
	(10,69),
	(14,140),
	(14,106),
	(14,143),
	(14,87),
	(14,164),
	(14,78),
	(14,85),
	(14,100),
	(14,68),
	(14,75),
	(14,137),
	(14,90),
	(14,146),
	(14,82),
	(14,86),
	(14,147),
	(14,149),
	(14,96),
	(14,64),
	(14,117),
	(14,129),
	(14,134),
	(14,50),
	(11,164),
	(11,148),
	(11,160),
	(11,169),
	(11,140),
	(11,102),
	(11,158),
	(11,159),
	(11,91),
	(11,45),
	(11,150),
	(11,84),
	(11,109),
	(11,166),
	(3,106),
	(3,71),
	(3,151),
	(3,118),
	(3,78),
	(3,65),
	(3,168),
	(3,85),
	(3,97),
	(3,75),
	(3,90),
	(3,80),
	(3,62),
	(3,56),
	(3,142),
	(3,146),
	(3,82),
	(3,101),
	(3,77),
	(3,149),
	(3,61),
	(3,116),
	(3,127),
	(3,89),
	(3,117),
	(3,46),
	(3,129),
	(3,134),
	(3,50),
	(7,112),
	(7,143),
	(7,155),
	(7,74),
	(7,122),
	(7,86),
	(7,159),
	(7,135),
	(7,171),
	(7,45),
	(7,120),
	(7,150),
	(7,108),
	(7,96),
	(7,153),
	(7,72),
	(7,88),
	(7,139),
	(7,41),
	(7,170),
	(7,50),
	(7,121),
	(7,154),
	(8,168),
	(8,107),
	(8,52),
	(8,55),
	(8,132),
	(8,172),
	(8,128),
	(8,46),
	(13,136),
	(13,73),
	(13,76),
	(13,145),
	(13,165),
	(13,62),
	(13,172),
	(13,63),
	(13,127),
	(1,174),
	(1,47),
	(1,48),
	(1,176),
	(1,177),
	(1,173),
	(1,175),
	(1,49),
	(9,83),
	(9,123),
	(9,141),
	(9,138),
	(9,124),
	(9,93),
	(9,115),
	(9,110),
	(9,126),
	(9,162),
	(9,105),
	(9,81),
	(9,72),
	(9,94),
	(9,139),
	(9,178),
	(9,121),
	(9,67),
	(12,99),
	(12,164),
	(12,179),
	(12,181),
	(12,52),
	(12,130),
	(12,160),
	(12,114),
	(12,110),
	(12,101),
	(12,182),
	(12,159),
	(12,61),
	(12,135),
	(12,45),
	(12,120),
	(12,150),
	(12,108),
	(12,72),
	(12,116),
	(12,121),
	(12,67);

/*!40000 ALTER TABLE `subCatsForCat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userGroups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userGroups`;

CREATE TABLE `userGroups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(45) NOT NULL DEFAULT '',
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `userGroups` WRITE;
/*!40000 ALTER TABLE `userGroups` DISABLE KEYS */;

INSERT INTO `userGroups` (`group_id`, `groupname`, `position`)
VALUES
	(1,'public',1),
	(2,'registered',2),
	(3,'staff',4),
	(4,'admin',5),
	(5,'super admin',6),
	(6,'Batman',200),
	(7,'Members',3);

/*!40000 ALTER TABLE `userGroups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userInGroups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userInGroups`;

CREATE TABLE `userInGroups` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `userInGroups` WRITE;
/*!40000 ALTER TABLE `userInGroups` DISABLE KEYS */;

INSERT INTO `userInGroups` (`group_id`, `user_id`)
VALUES
	(6,1),
	(5,7),
	(5,3),
	(5,4);

/*!40000 ALTER TABLE `userInGroups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(30) DEFAULT NULL,
  `last` varchar(30) DEFAULT NULL,
  `password` varchar(65) NOT NULL,
  `email` varchar(250) NOT NULL,
  `guid` varchar(25) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `prev_login` datetime DEFAULT NULL,
  `memberNumber` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `first` (`first`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `first`, `last`, `password`, `email`, `guid`, `company`, `last_login`, `created_on`, `prev_login`, `memberNumber`, `active`)
VALUES
	(1,'Zack ','Davis','daca2e606a283e5a6bcfbdbae311d823ee173401','zack@2721west.com','4f3d2bc1dd1c48.62722795','Octopoda Interactive','2013-04-17 15:30:20','2012-04-27 16:21:53','2013-04-17 15:30:20',12345,1),
	(3,'Ajay','Shaw','174cdecda5e84e2077e281132dac508403e39551','ajaykshaw@gmail.com','5162ea3ab403a3.46590154','','2013-04-08 11:05:48','2013-04-08 11:03:06','2013-04-08 11:05:48',54321,1),
	(4,'Melissa','Clemmons','b5bd1ab0682910c96a5fadbdab4d1817bbe4054d','melissa@webnoxious.com','516f0118c39197.45616096','','0000-00-00 00:00:00','2013-04-17 15:07:52','0000-00-00 00:00:00',123456,0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userSalts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userSalts`;

CREATE TABLE `userSalts` (
  `user_id` int(11) unsigned NOT NULL,
  `salt` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `userSalts` WRITE;
/*!40000 ALTER TABLE `userSalts` DISABLE KEYS */;

INSERT INTO `userSalts` (`user_id`, `salt`)
VALUES
	(1,'b32de679e7b74563104e231ea0b0f0ce2dff3b1e'),
	(3,'94c272a3a584378dba0fe33abfbd8ed40c33c019'),
	(4,'65fbe74292ad7980fdbd17aa8e65d0f66a258f50'),
	(7,'7647cac8c4eb1a2d1a5db61ce1a4e066030fcbed');

/*!40000 ALTER TABLE `userSalts` ENABLE KEYS */;
UNLOCK TABLES;




# Replace placeholder table for articlesearch with correct view syntax
# ------------------------------------------------------------

DROP TABLE `articlesearch`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `articlesearch`
AS SELECT
   `A`.`article_title` AS `article_title`,
   `A`.`article_id` AS `article_id`,
   `A`.`description` AS `description`,
   `S`.`sub_name` AS `sub_name`
FROM (((`article` `A` left join `categoriesforarticle` `CA` on((`A`.`article_id` = `CA`.`article_id`))) left join `categories` `C` on((`CA`.`category_id` = `C`.`category_id`))) left join `subcats` `S` on((`S`.`sub_id` = `CA`.`category_id`)));

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
