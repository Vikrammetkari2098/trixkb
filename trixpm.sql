-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for trixpm
CREATE DATABASE IF NOT EXISTS `trixpm` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `trixpm`;

-- Dumping structure for table trixpm.activities
CREATE TABLE IF NOT EXISTS `activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `project_id` bigint unsigned DEFAULT NULL,
  `task_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`),
  KEY `activities_project_id_index` (`project_id`),
  KEY `activities_task_id_index` (`task_id`),
  KEY `activities_type_index` (`type`),
  CONSTRAINT `activities_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `activities_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.activities: ~8 rows (approximately)
INSERT INTO `activities` (`id`, `user_id`, `project_id`, `task_id`, `action`, `type`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
	(14, 1, NULL, NULL, 'deleted_task', NULL, NULL, NULL, '2025-07-23 00:27:46', '2025-07-23 00:27:46'),
	(15, 1, NULL, NULL, 'deleted_task', NULL, NULL, NULL, '2025-07-23 00:34:52', '2025-07-23 00:34:52'),
	(16, 1, NULL, NULL, 'updated_member', NULL, NULL, NULL, '2025-07-27 05:16:49', '2025-07-27 05:16:49'),
	(17, 1, NULL, NULL, 'deleted_task', NULL, NULL, NULL, '2025-08-10 03:16:45', '2025-08-10 03:16:45'),
	(18, 1, NULL, NULL, 'updated_member', NULL, NULL, NULL, '2025-08-10 03:48:31', '2025-08-10 03:48:31'),
	(19, 1, NULL, NULL, 'deleted_task', NULL, NULL, NULL, '2025-08-10 09:49:33', '2025-08-10 09:49:33'),
	(20, 1, NULL, NULL, 'updated_member', NULL, NULL, NULL, '2025-08-10 09:56:31', '2025-08-10 09:56:31'),
	(21, 1, NULL, NULL, 'updated_member', NULL, NULL, NULL, '2025-08-11 18:59:00', '2025-08-11 18:59:00'),
	(22, 1, 22, 4, 'completed_task', 'task', 'Completed task: "Implement User Authentication"', NULL, '2025-08-17 01:34:40', '2025-08-17 03:34:40'),
	(23, 2, 22, NULL, 'created_task', 'task', 'Created a new task in project: "EcoGrocer"', NULL, '2025-08-16 23:34:40', '2025-08-17 03:34:40'),
	(24, 1, 23, NULL, 'updated_project', 'project', 'Updated project details and timeline', NULL, '2025-08-16 21:34:40', '2025-08-17 03:34:40'),
	(25, 2, NULL, NULL, 'joined_team', 'team', 'Joined the development team', NULL, '2025-08-16 03:34:40', '2025-08-17 03:34:40'),
	(26, 1, 22, 5, 'commented_task', 'comment', 'Added comment to task discussion', NULL, '2025-08-15 03:34:40', '2025-08-17 03:34:40'),
	(27, 1, 22, 4, 'completed_task', 'task', 'Completed task: "Implement User Authentication"', NULL, '2025-08-17 01:41:46', '2025-08-17 03:41:46'),
	(28, 2, 22, NULL, 'created_task', 'task', 'Created a new task in project: "EcoGrocer"', NULL, '2025-08-16 23:41:46', '2025-08-17 03:41:46'),
	(29, 1, 23, NULL, 'updated_project', 'project', 'Updated project details and timeline', NULL, '2025-08-16 21:41:46', '2025-08-17 03:41:46'),
	(30, 2, NULL, NULL, 'joined_team', 'team', 'Joined the development team', NULL, '2025-08-16 03:41:46', '2025-08-17 03:41:46'),
	(31, 1, 22, 5, 'commented_task', 'comment', 'Added comment to task discussion', NULL, '2025-08-15 03:41:46', '2025-08-17 03:41:46');

-- Dumping structure for table trixpm.brainstorms
CREATE TABLE IF NOT EXISTS `brainstorms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `project_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk9_user_Id` (`created_by`),
  KEY `fk5_project_id` (`project_id`),
  CONSTRAINT `fk5_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk9_user_Id` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.brainstorms: ~0 rows (approximately)

-- Dumping structure for table trixpm.brainstorm_comment
CREATE TABLE IF NOT EXISTS `brainstorm_comment` (
  `brainstorm_id` bigint unsigned NOT NULL,
  `comment_id` bigint unsigned NOT NULL,
  KEY `fk1_brainstorm_id` (`brainstorm_id`),
  KEY `fk1_comment_id` (`comment_id`),
  CONSTRAINT `fk1_brainstorm_id` FOREIGN KEY (`brainstorm_id`) REFERENCES `brainstorms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk1_comment_id` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.brainstorm_comment: ~0 rows (approximately)

-- Dumping structure for table trixpm.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.cache: ~17 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel_cache_meeting_statuses', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:3:{i:0;O:24:"App\\Models\\MeetingStatus":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:16:"meeting_statuses";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:5:{s:2:"id";i:3;s:4:"name";s:9:"Cancelled";s:5:"color";s:5:"error";s:10:"created_at";s:19:"2025-07-27 10:50:46";s:10:"updated_at";s:19:"2025-07-27 10:50:46";}s:11:"\0*\0original";a:5:{s:2:"id";i:3;s:4:"name";s:9:"Cancelled";s:5:"color";s:5:"error";s:10:"created_at";s:19:"2025-07-27 10:50:46";s:10:"updated_at";s:19:"2025-07-27 10:50:46";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:2:{i:0;s:4:"name";i:1;s:5:"color";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:1;O:24:"App\\Models\\MeetingStatus":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:16:"meeting_statuses";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:5:{s:2:"id";i:1;s:4:"name";s:9:"Confirmed";s:5:"color";s:7:"success";s:10:"created_at";s:19:"2025-07-27 10:50:46";s:10:"updated_at";s:19:"2025-07-27 10:50:46";}s:11:"\0*\0original";a:5:{s:2:"id";i:1;s:4:"name";s:9:"Confirmed";s:5:"color";s:7:"success";s:10:"created_at";s:19:"2025-07-27 10:50:46";s:10:"updated_at";s:19:"2025-07-27 10:50:46";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:2:{i:0;s:4:"name";i:1;s:5:"color";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:2;O:24:"App\\Models\\MeetingStatus":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:16:"meeting_statuses";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:5:{s:2:"id";i:2;s:4:"name";s:7:"Pending";s:5:"color";s:7:"warning";s:10:"created_at";s:19:"2025-07-27 10:50:46";s:10:"updated_at";s:19:"2025-07-27 10:50:46";}s:11:"\0*\0original";a:5:{s:2:"id";i:2;s:4:"name";s:7:"Pending";s:5:"color";s:7:"warning";s:10:"created_at";s:19:"2025-07-27 10:50:46";s:10:"updated_at";s:19:"2025-07-27 10:50:46";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:2:{i:0;s:4:"name";i:1;s:5:"color";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755437165),
	('laravel_cache_meeting_types', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:3:{i:0;O:22:"App\\Models\\MeetingType":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:13:"meeting_types";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:4:{s:2:"id";i:3;s:4:"name";s:6:"hybrid";s:10:"created_at";s:19:"2025-06-26 05:58:32";s:10:"updated_at";s:19:"2025-06-26 05:58:32";}s:11:"\0*\0original";a:4:{s:2:"id";i:3;s:4:"name";s:6:"hybrid";s:10:"created_at";s:19:"2025-06-26 05:58:32";s:10:"updated_at";s:19:"2025-06-26 05:58:32";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:1:{i:0;s:4:"name";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:1;O:22:"App\\Models\\MeetingType":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:13:"meeting_types";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:4:{s:2:"id";i:2;s:4:"name";s:6:"online";s:10:"created_at";s:19:"2025-06-26 05:58:32";s:10:"updated_at";s:19:"2025-06-26 05:58:32";}s:11:"\0*\0original";a:4:{s:2:"id";i:2;s:4:"name";s:6:"online";s:10:"created_at";s:19:"2025-06-26 05:58:32";s:10:"updated_at";s:19:"2025-06-26 05:58:32";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:1:{i:0;s:4:"name";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:2;O:22:"App\\Models\\MeetingType":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:13:"meeting_types";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:4:{s:2:"id";i:1;s:4:"name";s:6:"person";s:10:"created_at";s:19:"2025-06-26 05:58:32";s:10:"updated_at";s:19:"2025-06-26 05:58:32";}s:11:"\0*\0original";a:4:{s:2:"id";i:1;s:4:"name";s:6:"person";s:10:"created_at";s:19:"2025-06-26 05:58:32";s:10:"updated_at";s:19:"2025-06-26 05:58:32";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:1:{i:0;s:4:"name";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755437165),
	('laravel_cache_meetings_future_1', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755435108),
	('laravel_cache_meetings_this_month_1', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755435108),
	('laravel_cache_meetings_this_week_1', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:0:{}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755435108),
	('laravel_cache_platforms', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:5:{i:0;O:19:"App\\Models\\Platform":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"platforms";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:7:{s:2:"id";i:3;s:4:"name";s:11:"Google Meet";s:4:"icon";s:18:"logos--google-meet";s:11:"url_pattern";s:15:"meet.google.com";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:11:"\0*\0original";a:7:{s:2:"id";i:3;s:4:"name";s:11:"Google Meet";s:4:"icon";s:18:"logos--google-meet";s:11:"url_pattern";s:15:"meet.google.com";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:4:{i:0;s:4:"name";i:1;s:4:"icon";i:2;s:9:"is_active";i:3;s:11:"url_pattern";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:1;O:19:"App\\Models\\Platform":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"platforms";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:7:{s:2:"id";i:2;s:4:"name";s:15:"Microsoft Teams";s:4:"icon";s:22:"logos--microsoft-teams";s:11:"url_pattern";s:19:"teams.microsoft.com";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:11:"\0*\0original";a:7:{s:2:"id";i:2;s:4:"name";s:15:"Microsoft Teams";s:4:"icon";s:22:"logos--microsoft-teams";s:11:"url_pattern";s:19:"teams.microsoft.com";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:4:{i:0;s:4:"name";i:1;s:4:"icon";i:2;s:9:"is_active";i:3;s:11:"url_pattern";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:2;O:19:"App\\Models\\Platform":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"platforms";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:7:{s:2:"id";i:5;s:4:"name";s:5:"Other";s:4:"icon";s:17:"fa6-solid:desktop";s:11:"url_pattern";N;s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:11:"\0*\0original";a:7:{s:2:"id";i:5;s:4:"name";s:5:"Other";s:4:"icon";s:17:"fa6-solid:desktop";s:11:"url_pattern";N;s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:4:{i:0;s:4:"name";i:1;s:4:"icon";i:2;s:9:"is_active";i:3;s:11:"url_pattern";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:3;O:19:"App\\Models\\Platform":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"platforms";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:7:{s:2:"id";i:4;s:4:"name";s:5:"Skype";s:4:"icon";s:15:"fa6-solid:phone";s:11:"url_pattern";s:9:"skype.com";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:11:"\0*\0original";a:7:{s:2:"id";i:4;s:4:"name";s:5:"Skype";s:4:"icon";s:15:"fa6-solid:phone";s:11:"url_pattern";s:9:"skype.com";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:4:{i:0;s:4:"name";i:1;s:4:"icon";i:2;s:9:"is_active";i:3;s:11:"url_pattern";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:4;O:19:"App\\Models\\Platform":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"platforms";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:7:{s:2:"id";i:1;s:4:"name";s:4:"Zoom";s:4:"icon";s:11:"logos--zoom";s:11:"url_pattern";s:7:"zoom.us";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:11:"\0*\0original";a:7:{s:2:"id";i:1;s:4:"name";s:4:"Zoom";s:4:"icon";s:11:"logos--zoom";s:11:"url_pattern";s:7:"zoom.us";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-07-27 12:09:08";s:10:"updated_at";s:19:"2025-07-27 12:09:08";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:4:{i:0;s:4:"name";i:1;s:4:"icon";i:2;s:9:"is_active";i:3;s:11:"url_pattern";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755437165),
	('laravel_cache_projects_for_meetings', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:7:{i:0;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:22;s:5:"title";s:9:"EcoGrocer";s:11:"description";s:128:"A responsive app that helps users find eco-friendly products, track their carbon footprint, and earn points for green purchases.";}s:11:"\0*\0original";a:3:{s:2:"id";i:22;s:5:"title";s:9:"EcoGrocer";s:11:"description";s:128:"A responsive app that helps users find eco-friendly products, track their carbon footprint, and earn points for green purchases.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:1;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:54;s:5:"title";s:17:"EduLearn Platform";s:11:"description";s:128:"Online learning platform with interactive courses, progress tracking, and certification management for educational institutions.";}s:11:"\0*\0original";a:3:{s:2:"id";i:54;s:5:"title";s:17:"EduLearn Platform";s:11:"description";s:128:"Online learning platform with interactive courses, progress tracking, and certification management for educational institutions.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:2;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:53;s:5:"title";s:14:"FinTracker Pro";s:11:"description";s:112:"Personal finance management app with budget tracking, expense categorization, and investment portfolio analysis.";}s:11:"\0*\0original";a:3:{s:2:"id";i:53;s:5:"title";s:14:"FinTracker Pro";s:11:"description";s:112:"Personal finance management app with budget tracking, expense categorization, and investment portfolio analysis.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:3;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:23;s:5:"title";s:10:"InsightCRM";s:11:"description";s:155:"A simple CRM for small businesses to manage leads, meetings, and follow-ups. Features include contact management, scheduling, and data export to Excel/PDF.";}s:11:"\0*\0original";a:3:{s:2:"id";i:23;s:5:"title";s:10:"InsightCRM";s:11:"description";s:155:"A simple CRM for small businesses to manage leads, meetings, and follow-ups. Features include contact management, scheduling, and data export to Excel/PDF.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:4;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:52;s:5:"title";s:11:"MediConnect";s:11:"description";s:118:"Healthcare platform connecting patients with doctors through secure video consultations and medical record management.";}s:11:"\0*\0original";a:3:{s:2:"id";i:52;s:5:"title";s:11:"MediConnect";s:11:"description";s:118:"Healthcare platform connecting patients with doctors through secure video consultations and medical record management.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:5;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:55;s:5:"title";s:10:"RetailEdge";s:11:"description";s:110:"E-commerce solution with inventory management, order processing, and customer analytics for retail businesses.";}s:11:"\0*\0original";a:3:{s:2:"id";i:55;s:5:"title";s:10:"RetailEdge";s:11:"description";s:110:"E-commerce solution with inventory management, order processing, and customer analytics for retail businesses.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:6;O:18:"App\\Models\\Project":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"projects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:41;s:5:"title";s:8:"TaskFlow";s:11:"description";s:146:"A web app to manage tasks, assign roles, and track team productivity. Includes real-time updates, role-based access, reminders, and activity logs.";}s:11:"\0*\0original";a:3:{s:2:"id";i:41;s:5:"title";s:8:"TaskFlow";s:11:"description";s:146:"A web app to manage tasks, assign roles, and track team productivity. Includes real-time updates, role-based access, reminders, and activity logs.";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:4:{s:10:"start_time";s:8:"datetime";s:8:"end_time";s:8:"datetime";s:10:"created_at";s:8:"datetime";s:10:"updated_at";s:8:"datetime";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:5:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:10:"start_time";i:3;s:8:"end_time";i:4;s:11:"priority_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755435105),
	('laravel_cache_task_overview_statistics_00843e82bdab4f6b0a773596095f1149', 'a:22:{s:10:"totalTasks";i:5;s:14:"completedTasks";i:2;s:13:"progressTasks";i:1;s:11:"reviewTasks";i:0;s:12:"overdueTasks";i:2;s:14:"completionRate";d:40;s:17:"avgCompletionTime";d:12.5;s:17:"highPriorityTasks";i:0;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:1;s:13:"completedTask";i:0;s:14:"completedIssue";i:1;s:15:"completedDesign";i:1;s:12:"progressTask";i:1;s:13:"progressIssue";i:0;s:14:"progressDesign";i:0;s:10:"reviewTask";i:0;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:0;s:11:"overdueTask";i:2;s:12:"overdueIssue";i:0;s:13:"overdueDesign";i:0;}', 1754970450),
	('laravel_cache_task_overview_statistics_2146d8f0497b7e362e3d0a350a15dd22', 'a:22:{s:10:"totalTasks";i:12;s:14:"completedTasks";i:3;s:13:"progressTasks";i:2;s:11:"reviewTasks";i:5;s:12:"overdueTasks";i:2;s:14:"completionRate";d:25;s:17:"avgCompletionTime";d:18;s:17:"highPriorityTasks";i:2;s:13:"tasksDueToday";i:1;s:16:"tasksDueThisWeek";i:4;s:13:"completedTask";i:1;s:14:"completedIssue";i:1;s:15:"completedDesign";i:1;s:12:"progressTask";i:2;s:13:"progressIssue";i:0;s:14:"progressDesign";i:0;s:10:"reviewTask";i:1;s:11:"reviewIssue";i:2;s:12:"reviewDesign";i:2;s:11:"overdueTask";i:1;s:12:"overdueIssue";i:0;s:13:"overdueDesign";i:1;}', 1754970396),
	('laravel_cache_task_overview_statistics_3520ca782cfd4432b9c084fa585e757a', 'a:22:{s:10:"totalTasks";i:1;s:14:"completedTasks";i:0;s:13:"progressTasks";i:0;s:11:"reviewTasks";i:0;s:12:"overdueTasks";i:0;s:14:"completionRate";d:0;s:17:"avgCompletionTime";d:0;s:17:"highPriorityTasks";i:0;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:1;s:13:"completedTask";i:0;s:14:"completedIssue";i:0;s:15:"completedDesign";i:0;s:12:"progressTask";i:0;s:13:"progressIssue";i:0;s:14:"progressDesign";i:0;s:10:"reviewTask";i:0;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:0;s:11:"overdueTask";i:0;s:12:"overdueIssue";i:0;s:13:"overdueDesign";i:0;}', 1754970431),
	('laravel_cache_task_overview_statistics_5a552ac6122e15ee221c25ce70393405', 'a:22:{s:10:"totalTasks";i:1;s:14:"completedTasks";i:0;s:13:"progressTasks";i:1;s:11:"reviewTasks";i:0;s:12:"overdueTasks";i:0;s:14:"completionRate";d:0;s:17:"avgCompletionTime";d:0;s:17:"highPriorityTasks";i:0;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:0;s:13:"completedTask";i:0;s:14:"completedIssue";i:0;s:15:"completedDesign";i:0;s:12:"progressTask";i:1;s:13:"progressIssue";i:0;s:14:"progressDesign";i:0;s:10:"reviewTask";i:0;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:0;s:11:"overdueTask";i:0;s:12:"overdueIssue";i:0;s:13:"overdueDesign";i:0;}', 1754968538),
	('laravel_cache_task_overview_statistics_739f108300e406f67c397228e4927d85', 'a:22:{s:10:"totalTasks";i:8;s:14:"completedTasks";i:1;s:13:"progressTasks";i:3;s:11:"reviewTasks";i:1;s:12:"overdueTasks";i:3;s:14:"completionRate";d:12.5;s:17:"avgCompletionTime";d:25;s:17:"highPriorityTasks";i:0;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:3;s:13:"completedTask";i:0;s:14:"completedIssue";i:0;s:15:"completedDesign";i:1;s:12:"progressTask";i:2;s:13:"progressIssue";i:1;s:14:"progressDesign";i:0;s:10:"reviewTask";i:0;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:1;s:11:"overdueTask";i:1;s:12:"overdueIssue";i:1;s:13:"overdueDesign";i:1;}', 1754979082),
	('laravel_cache_task_overview_statistics_871e62e6f5f37c1db1ffd730ff3d284e', 'a:22:{s:10:"totalTasks";i:6;s:14:"completedTasks";i:2;s:13:"progressTasks";i:1;s:11:"reviewTasks";i:0;s:12:"overdueTasks";i:2;s:14:"completionRate";d:33.3;s:17:"avgCompletionTime";d:24;s:17:"highPriorityTasks";i:0;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:0;s:13:"completedTask";i:0;s:14:"completedIssue";i:1;s:15:"completedDesign";i:1;s:12:"progressTask";i:1;s:13:"progressIssue";i:0;s:14:"progressDesign";i:0;s:10:"reviewTask";i:0;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:0;s:11:"overdueTask";i:2;s:12:"overdueIssue";i:0;s:13:"overdueDesign";i:0;}', 1754970327),
	('laravel_cache_task_overview_statistics_b0f560e63d5d8c5f39c46a4c22705384', 'a:22:{s:10:"totalTasks";i:8;s:14:"completedTasks";i:2;s:13:"progressTasks";i:3;s:11:"reviewTasks";i:1;s:12:"overdueTasks";i:3;s:14:"completionRate";d:25;s:17:"avgCompletionTime";d:19;s:17:"highPriorityTasks";i:0;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:3;s:13:"completedTask";i:0;s:14:"completedIssue";i:1;s:15:"completedDesign";i:1;s:12:"progressTask";i:2;s:13:"progressIssue";i:1;s:14:"progressDesign";i:0;s:10:"reviewTask";i:0;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:1;s:11:"overdueTask";i:1;s:12:"overdueIssue";i:1;s:13:"overdueDesign";i:1;}', 1754968548),
	('laravel_cache_task_overview_statistics_b78a034f874255a2b253f9681c7d0cdc', 'a:22:{s:10:"totalTasks";i:13;s:14:"completedTasks";i:2;s:13:"progressTasks";i:3;s:11:"reviewTasks";i:4;s:12:"overdueTasks";i:4;s:14:"completionRate";d:15.4;s:17:"avgCompletionTime";d:25;s:17:"highPriorityTasks";i:4;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:2;s:13:"completedTask";i:1;s:14:"completedIssue";i:0;s:15:"completedDesign";i:1;s:12:"progressTask";i:2;s:13:"progressIssue";i:1;s:14:"progressDesign";i:0;s:10:"reviewTask";i:1;s:11:"reviewIssue";i:1;s:12:"reviewDesign";i:2;s:11:"overdueTask";i:3;s:12:"overdueIssue";i:1;s:13:"overdueDesign";i:0;}', 1755050930),
	('laravel_cache_task_overview_statistics_e679bd5d6d20ee661a28c5b638495e2e', 'a:22:{s:10:"totalTasks";i:9;s:14:"completedTasks";i:2;s:13:"progressTasks";i:2;s:11:"reviewTasks";i:1;s:12:"overdueTasks";i:4;s:14:"completionRate";d:22.2;s:17:"avgCompletionTime";d:24;s:17:"highPriorityTasks";i:1;s:13:"tasksDueToday";i:0;s:16:"tasksDueThisWeek";i:1;s:13:"completedTask";i:0;s:14:"completedIssue";i:1;s:15:"completedDesign";i:1;s:12:"progressTask";i:1;s:13:"progressIssue";i:0;s:14:"progressDesign";i:1;s:10:"reviewTask";i:1;s:11:"reviewIssue";i:0;s:12:"reviewDesign";i:0;s:11:"overdueTask";i:3;s:12:"overdueIssue";i:0;s:13:"overdueDesign";i:1;}', 1754970294),
	('laravel_cache_users_for_meetings', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:8:{i:0;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:2;s:4:"name";s:12:"Ahmed Arabee";s:5:"email";s:18:"arabee@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:2;s:4:"name";s:12:"Ahmed Arabee";s:5:"email";s:18:"arabee@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:1;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:24;s:4:"name";s:9:"David Kim";s:5:"email";s:21:"david.kim@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:24;s:4:"name";s:9:"David Kim";s:5:"email";s:21:"david.kim@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:2;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:23;s:4:"name";s:15:"Elena Rodriguez";s:5:"email";s:19:"elena.r@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:23;s:4:"name";s:15:"Elena Rodriguez";s:5:"email";s:19:"elena.r@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:3;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:10;s:4:"name";s:11:"hello world";s:5:"email";s:17:"hello@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:10;s:4:"name";s:11:"hello world";s:5:"email";s:17:"hello@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:4;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:1;s:4:"name";s:15:"Izzat Saifullah";s:5:"email";s:17:"izzat@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:1;s:4:"name";s:15:"Izzat Saifullah";s:5:"email";s:17:"izzat@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:5;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:25;s:4:"name";s:13:"Lisa Thompson";s:5:"email";s:18:"lisa.t@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:25;s:4:"name";s:13:"Lisa Thompson";s:5:"email";s:18:"lisa.t@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:6;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:22;s:4:"name";s:14:"Marcus Johnson";s:5:"email";s:20:"marcus.j@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:22;s:4:"name";s:14:"Marcus Johnson";s:5:"email";s:20:"marcus.j@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}i:7;O:15:"App\\Models\\User":35:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:5:"users";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:3:{s:2:"id";i:21;s:4:"name";s:10:"Sarah Chen";s:5:"email";s:22:"sarah.chen@example.com";}s:11:"\0*\0original";a:3:{s:2:"id";i:21;s:4:"name";s:10:"Sarah Chen";s:5:"email";s:22:"sarah.chen@example.com";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:3:{s:17:"email_verified_at";s:8:"datetime";s:8:"password";s:6:"hashed";s:24:"notification_preferences";s:5:"array";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:2:{i:0;s:8:"password";i:1;s:14:"remember_token";}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:16:{i:0;s:4:"name";i:1;s:5:"email";i:2;s:8:"password";i:3;s:17:"email_verified_at";i:4;s:5:"phone";i:5;s:13:"profile_photo";i:6;s:7:"team_id";i:7;s:3:"bio";i:8;s:8:"location";i:9;s:7:"website";i:10;s:15:"github_username";i:11;s:17:"linkedin_username";i:12;s:6:"skills";i:13;s:8:"timezone";i:14;s:8:"language";i:15;s:24:"notification_preferences";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}s:19:"\0*\0authPasswordName";s:8:"password";s:20:"\0*\0rememberTokenName";s:14:"remember_token";}}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1755435105);

-- Dumping structure for table trixpm.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.cache_locks: ~0 rows (approximately)

-- Dumping structure for table trixpm.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk10_user_id` (`user_id`),
  CONSTRAINT `fk10_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.comments: ~2 rows (approximately)
INSERT INTO `comments` (`id`, `content`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'test comment', 1, '2025-07-21 23:01:19', '2025-07-21 23:03:32'),
	(2, 'test', 1, '2025-07-21 23:03:41', '2025-07-21 23:03:41'),
	(3, 'hello', 1, '2025-07-29 01:09:47', '2025-07-29 01:09:47');

-- Dumping structure for table trixpm.docs
CREATE TABLE IF NOT EXISTS `docs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `restricted` tinyint(1) DEFAULT NULL,
  `project_id` bigint unsigned NOT NULL,
  `task_id` bigint unsigned NOT NULL,
  `uploaded_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk4_project_id` (`project_id`),
  KEY `fk2_task_id` (`task_id`),
  KEY `fk7_user_Id` (`uploaded_by`),
  CONSTRAINT `fk2_task_id` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk4_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk7_user_Id` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.docs: ~0 rows (approximately)
INSERT INTO `docs` (`id`, `name`, `path`, `type`, `restricted`, `project_id`, `task_id`, `uploaded_by`, `created_at`, `updated_at`) VALUES
	(2, 'meeting.sql', 'attachments/Ab7qX2icCdnUl6VAJJWNnHMTyjxwdBjyoWTj9b0S.sql', 'application/octet-stream', 0, 22, 4, 1, '2025-07-29 01:09:20', '2025-07-29 01:09:20');

-- Dumping structure for table trixpm.doc_user
CREATE TABLE IF NOT EXISTS `doc_user` (
  `doc_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  KEY `fk1_doc_id` (`doc_id`),
  KEY `fk8_user_id` (`user_id`),
  CONSTRAINT `fk1_doc_id` FOREIGN KEY (`doc_id`) REFERENCES `docs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk8_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.doc_user: ~0 rows (approximately)

-- Dumping structure for table trixpm.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table trixpm.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.jobs: ~0 rows (approximately)

-- Dumping structure for table trixpm.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.job_batches: ~0 rows (approximately)

-- Dumping structure for table trixpm.meetings
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `platform_id` bigint unsigned DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `status_id` bigint unsigned DEFAULT NULL,
  `meeting_type_id` bigint unsigned DEFAULT NULL,
  `project_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk2_project_id` (`project_id`),
  KEY `fk1_user_id` (`created_by`),
  KEY `fk_meeting_type_id` (`meeting_type_id`),
  KEY `meetings_status_id_foreign` (`status_id`),
  KEY `meetings_platform_id_foreign` (`platform_id`),
  CONSTRAINT `fk1_user_id` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk2_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_type_id` FOREIGN KEY (`meeting_type_id`) REFERENCES `meeting_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `meetings_meeting_type_id_foreign` FOREIGN KEY (`meeting_type_id`) REFERENCES `meeting_types` (`id`) ON DELETE SET NULL,
  CONSTRAINT `meetings_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `meetings_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `meeting_statuses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.meetings: ~2 rows (approximately)

-- Dumping structure for table trixpm.meeting_statuses
CREATE TABLE IF NOT EXISTS `meeting_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primary',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_statuses_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.meeting_statuses: ~2 rows (approximately)
INSERT INTO `meeting_statuses` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
	(1, 'Confirmed', 'success', '2025-07-27 02:50:46', '2025-07-27 02:50:46'),
	(2, 'Pending', 'warning', '2025-07-27 02:50:46', '2025-07-27 02:50:46'),
	(3, 'Cancelled', 'error', '2025-07-27 02:50:46', '2025-07-27 02:50:46');

-- Dumping structure for table trixpm.meeting_types
CREATE TABLE IF NOT EXISTS `meeting_types` (
  `id` bigint unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trixpm.meeting_types: ~3 rows (approximately)
INSERT INTO `meeting_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'person', '2025-06-25 21:58:32', '2025-06-25 21:58:32'),
	(2, 'online', '2025-06-25 21:58:32', '2025-06-25 21:58:32'),
	(3, 'hybrid', '2025-06-25 21:58:32', '2025-06-25 21:58:32');

-- Dumping structure for table trixpm.meeting_user
CREATE TABLE IF NOT EXISTS `meeting_user` (
  `meeting_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`meeting_id`,`user_id`),
  KEY `fk5_user_id` (`user_id`),
  KEY `fk_meeting_id` (`meeting_id`),
  CONSTRAINT `fk5_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_meeting_id` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.meeting_user: ~4 rows (approximately)

-- Dumping structure for table trixpm.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.migrations: ~12 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_05_02_080950_create_telescope_entries_table', 2),
	(5, '2025_07_27_065639_add_indexes_to_tasks_table', 3),
	(6, '2025_07_27_074001_add_indexes_to_tasks_table', 4),
	(7, '2025_07_27_104444_improve_meetings_structure', 5),
	(8, '2025_07_27_121500_create_platforms_table', 6),
	(9, '2025_07_27_122000_remove_platform_name_from_meetings', 7),
	(10, '2025_08_10_122550_create_modules_table', 8),
	(11, '2025_08_10_122817_migrate_tags_to_modules', 9),
	(12, '2025_08_10_123324_cleanup_old_tag_system', 10),
	(13, '2025_08_10_132945_add_super_admin_role', 11),
	(14, '2025_08_11_182138_add_profile_fields_to_users_table', 12),
	(15, '2025_08_13_022403_change_tasks_status_to_integer', 13),
	(16, '2025_08_13_023036_add_project_and_task_to_activities_table', 14);

-- Dumping structure for table trixpm.modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'slate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modules_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.modules: ~12 rows (approximately)
INSERT INTO `modules` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
	(14, 'marketing', 'pink', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(15, 'livechat', 'green', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(16, 'knowledgebase', 'blue', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(17, 'telesales', 'purple', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(18, 'TrixVoice', 'indigo', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(19, 'TrixIPX', 'cyan', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(20, 'mobile app', 'orange', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(21, 'reporting', 'amber', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(22, 'chatbot', 'teal', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(23, 'helpdesk', 'red', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(24, 'survey', 'lime', '2025-08-10 04:42:09', '2025-08-10 04:42:09'),
	(25, 'debt collection', 'gray', '2025-08-10 04:42:09', '2025-08-10 04:42:09');

-- Dumping structure for table trixpm.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table trixpm.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.permissions: ~0 rows (approximately)

-- Dumping structure for table trixpm.platforms
CREATE TABLE IF NOT EXISTS `platforms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_pattern` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `platforms_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.platforms: ~5 rows (approximately)
INSERT INTO `platforms` (`id`, `name`, `icon`, `url_pattern`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Zoom', 'logos--zoom', 'zoom.us', 1, '2025-07-27 04:09:08', '2025-07-27 04:09:08'),
	(2, 'Microsoft Teams', 'logos--microsoft-teams', 'teams.microsoft.com', 1, '2025-07-27 04:09:08', '2025-07-27 04:09:08'),
	(3, 'Google Meet', 'logos--google-meet', 'meet.google.com', 1, '2025-07-27 04:09:08', '2025-07-27 04:09:08'),
	(4, 'Skype', 'fa6-solid:phone', 'skype.com', 1, '2025-07-27 04:09:08', '2025-07-27 04:09:08'),
	(5, 'Other', 'fa6-solid:desktop', NULL, 1, '2025-07-27 04:09:08', '2025-07-27 04:09:08');

-- Dumping structure for table trixpm.priorities
CREATE TABLE IF NOT EXISTS `priorities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.priorities: ~3 rows (approximately)
INSERT INTO `priorities` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'low', NULL, NULL),
	(2, 'medium', NULL, NULL),
	(3, 'high', NULL, NULL);

-- Dumping structure for table trixpm.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `priority_id` bigint unsigned NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_priority_id` (`priority_id`),
  CONSTRAINT `fk_priority_id` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.projects: ~7 rows (approximately)
INSERT INTO `projects` (`id`, `title`, `description`, `priority_id`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
	(22, 'EcoGrocer', 'A responsive app that helps users find eco-friendly products, track their carbon footprint, and earn points for green purchases.', 3, '2025-08-10 16:46:00', '2025-08-29 16:46:00', '2025-04-28 22:15:27', '2025-08-10 00:46:43'),
	(23, 'InsightCRM', 'A simple CRM for small businesses to manage leads, meetings, and follow-ups. Features include contact management, scheduling, and data export to Excel/PDF.', 2, '2025-08-10 16:47:00', '2025-09-11 16:47:00', '2025-04-28 22:15:42', '2025-08-10 00:47:11'),
	(41, 'TaskFlow', 'A web app to manage tasks, assign roles, and track team productivity. Includes real-time updates, role-based access, reminders, and activity logs.', 1, '2025-08-10 16:47:00', '2025-09-04 16:47:00', '2025-05-20 01:55:34', '2025-08-10 00:47:27'),
	(52, 'MediConnect', 'Healthcare platform connecting patients with doctors through secure video consultations and medical record management.', 3, '2025-08-16 17:52:28', '2025-09-25 17:52:28', '2025-07-22 09:52:28', '2025-07-28 09:52:28'),
	(53, 'FinTracker Pro', 'Personal finance management app with budget tracking, expense categorization, and investment portfolio analysis.', 2, '2025-08-21 17:52:28', '2025-10-10 17:52:28', '2025-07-19 09:52:28', '2025-07-25 09:52:28'),
	(54, 'EduLearn Platform', 'Online learning platform with interactive courses, progress tracking, and certification management for educational institutions.', 1, '2025-08-26 17:52:28', '2025-10-25 17:52:28', '2025-06-18 09:52:28', '2025-08-04 09:52:28'),
	(55, 'RetailEdge', 'E-commerce solution with inventory management, order processing, and customer analytics for retail businesses.', 3, '2025-08-14 17:52:28', '2025-09-20 17:52:28', '2025-06-24 09:52:28', '2025-08-09 09:52:28');

-- Dumping structure for table trixpm.project_module
CREATE TABLE IF NOT EXISTS `project_module` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_module_project_id_module_id_unique` (`project_id`,`module_id`),
  KEY `project_module_module_id_foreign` (`module_id`),
  CONSTRAINT `project_module_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_module_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.project_module: ~30 rows (approximately)
INSERT INTO `project_module` (`id`, `project_id`, `module_id`, `created_at`, `updated_at`) VALUES
	(9, 22, 15, NULL, NULL),
	(10, 22, 17, NULL, NULL),
	(11, 22, 16, NULL, NULL),
	(12, 23, 24, NULL, NULL),
	(13, 23, 20, NULL, NULL),
	(14, 23, 22, NULL, NULL),
	(15, 41, 25, NULL, NULL),
	(16, 41, 20, NULL, NULL),
	(17, 41, 23, NULL, NULL),
	(18, 41, 19, NULL, NULL),
	(19, 41, 18, NULL, NULL),
	(20, 41, 16, NULL, NULL),
	(21, 41, 15, NULL, NULL),
	(22, 41, 14, NULL, NULL),
	(23, 41, 17, NULL, NULL),
	(24, 22, 25, NULL, NULL),
	(25, 52, 14, NULL, NULL),
	(26, 52, 15, NULL, NULL),
	(27, 52, 16, NULL, NULL),
	(28, 52, 18, NULL, NULL),
	(29, 53, 20, NULL, NULL),
	(30, 53, 21, NULL, NULL),
	(31, 53, 22, NULL, NULL),
	(32, 54, 16, NULL, NULL),
	(33, 54, 20, NULL, NULL),
	(34, 54, 24, NULL, NULL),
	(35, 55, 14, NULL, NULL),
	(36, 55, 19, NULL, NULL),
	(37, 55, 21, NULL, NULL),
	(38, 55, 25, NULL, NULL);

-- Dumping structure for table trixpm.project_user
CREATE TABLE IF NOT EXISTS `project_user` (
  `project_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  KEY `fk1_project_id` (`project_id`),
  KEY `fk6_user_id` (`user_id`),
  CONSTRAINT `fk1_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk6_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.project_user: ~18 rows (approximately)
INSERT INTO `project_user` (`project_id`, `user_id`) VALUES
	(23, 1),
	(41, 1),
	(22, 1),
	(52, 23),
	(52, 10),
	(52, 1),
	(52, 2),
	(53, 23),
	(53, 2),
	(53, 24),
	(53, 22),
	(54, 10),
	(54, 24),
	(54, 25),
	(55, 2),
	(55, 21),
	(55, 24),
	(55, 1);

-- Dumping structure for table trixpm.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.roles: ~2 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', NULL, NULL),
	(2, 'basic', NULL, NULL),
	(3, 'super_admin', '2025-08-10 05:30:42', '2025-08-10 05:30:42');

-- Dumping structure for table trixpm.role_user
CREATE TABLE IF NOT EXISTS `role_user` (
  `role_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  KEY `fk_role_id` (`role_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.role_user: ~8 rows (approximately)
INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
	(3, 1),
	(2, 2),
	(1, 10),
	(2, 21),
	(2, 22),
	(2, 23),
	(1, 24),
	(2, 25);

-- Dumping structure for table trixpm.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('v9gywAQVc9LvCypcRx18nWrx8AtzSB6PSd822Y8h', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWmh1cmU2VkY0WlM5cVhUZmgyck1HSElLU0RIYW9HM2VYR2ZnNDF0SyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDA1Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwNS9tZWV0aW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1755434863);

-- Dumping structure for table trixpm.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `priority_id` bigint unsigned NOT NULL,
  `task_type_id` bigint unsigned NOT NULL,
  `status` int unsigned NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk4_user_id` (`created_by`),
  KEY `fk1_priority_id` (`priority_id`),
  KEY `fk_task_type_id` (`task_type_id`) USING BTREE,
  KEY `tasks_status_index` (`status`),
  KEY `tasks_task_type_id_index` (`task_type_id`),
  KEY `tasks_project_id_index` (`project_id`),
  KEY `tasks_assigned_to_index` (`assigned_to`),
  KEY `tasks_status_task_type_id_index` (`status`,`task_type_id`),
  KEY `tasks_due_date_status_index` (`status`),
  CONSTRAINT `fk1_priority_id` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk4_user_id` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_task_type_id` FOREIGN KEY (`task_type_id`) REFERENCES `task_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_status_foreign` FOREIGN KEY (`status`) REFERENCES `task_statuses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.tasks: ~57 rows (approximately)
INSERT INTO `tasks` (`id`, `project_id`, `assigned_to`, `title`, `description`, `priority_id`, `task_type_id`, `status`, `start_time`, `end_time`, `created_by`, `created_at`, `updated_at`) VALUES
	(4, 22, 2, 'Implement User Authentication', 'Develop login, registration, and password reset features using Laravel\'s built-in authentication scaffolding.', 2, 1, 1, '2025-08-15 18:11:00', '2025-08-29 18:11:00', 1, '2025-07-23 00:27:33', '2025-08-10 05:03:27'),
	(5, 23, 1, 'Set Up Project Database', 'Create the initial database schema including tables for users, tasks, issues, and roles. Use migrations to define the structure.', 3, 1, 4, '2025-08-10 18:39:00', '2025-08-27 18:39:00', 1, '2025-07-23 00:28:34', '2025-08-10 02:40:00'),
	(6, 41, 1, 'Integrate Third-Party Email Services', 'Configure SMTP settings and implement email notifications using a provider like Mailgun or SendGrid.', 1, 1, 1, '2025-08-10 18:34:00', '2025-08-22 18:34:00', 1, '2025-07-23 00:29:04', '2025-08-11 06:23:47'),
	(7, 41, 1, 'Cannot Upload Files in Task Module', 'When users attempt to upload files to a task, the upload fails silently. Console logs show a 500 server error.', 1, 2, 2, '2025-08-10 18:40:00', '2025-08-28 18:40:00', 1, '2025-07-23 00:29:57', '2025-08-11 06:23:41'),
	(8, 23, 2, 'Login Session Expires Too Quickly', 'User sessions expire after only 5 minutes of inactivity, requiring frequent logins. Adjust session lifetime settings.', 2, 2, 3, '2025-08-10 18:33:00', '2025-08-21 18:33:00', 1, '2025-07-23 00:31:27', '2025-08-10 02:33:45'),
	(9, 23, 1, 'Dashboard Fails to Load in Safari', 'The dashboard page does not load correctly in Safari, displaying a blank screen with no error messages.', 1, 2, 3, '2025-08-10 20:48:00', '2025-11-19 20:48:00', 1, '2025-07-23 00:32:28', '2025-08-10 04:48:24'),
	(10, 22, 2, 'Task Detail Page UI', 'A clean and functional layout for viewing and editing task information, attachments, and comments.', 3, 3, 4, '2025-08-10 20:48:00', '2025-09-17 20:48:00', 1, '2025-07-23 00:33:09', '2025-08-10 04:48:46'),
	(12, 23, 1, 'Mobile Navigation Menu', 'Responsive mobile menu design for quick access to tasks, projects, and user settings.', 3, 3, 3, '2025-08-10 19:13:00', '2025-08-22 19:13:00', 1, '2025-07-23 00:34:26', '2025-08-10 09:50:26'),
	(15, 22, 1, 'Database Schema Optimization', 'Optimize database queries and implement proper indexing for better performance.', 3, 1, 2, '2025-07-12 17:52:28', '2025-08-01 17:52:28', 2, '2025-07-12 09:52:28', '2025-08-11 09:52:28'),
	(16, 22, 21, 'Security Audit Implementation', 'Implement security best practices including input validation, CSRF protection, and secure authentication.', 3, 1, 1, '2025-07-31 17:52:28', '2025-08-16 17:52:28', 22, '2025-07-31 09:52:28', '2025-08-10 09:52:28'),
	(17, 22, 10, 'Mobile Responsive Design', 'Ensure all components are fully responsive and provide optimal user experience on mobile devices.', 2, 3, 2, '2025-07-10 17:52:28', '2025-07-22 17:52:28', 23, '2025-07-10 09:52:28', '2025-08-10 09:52:28'),
	(18, 22, 24, 'Performance Issues on Large Datasets', 'Application becomes slow when handling datasets with more than 10,000 records. Need to implement pagination and lazy loading.', 3, 2, 1, '2025-08-04 17:52:28', '2025-08-26 17:52:28', 22, '2025-08-04 09:52:28', '2025-08-11 09:52:28'),
	(19, 22, 2, 'Memory Leak in Background Tasks', 'Background job processes consuming excessive memory and not releasing resources properly.', 3, 2, 4, '2025-07-11 17:52:28', '2025-07-24 17:52:28', 2, '2025-07-11 09:52:28', '2025-08-10 09:52:28'),
	(20, 22, 1, 'Integration Testing Suite', 'Develop comprehensive integration tests covering all API endpoints and user workflows.', 2, 1, 1, '2025-07-11 17:52:28', '2025-07-29 17:52:28', 10, '2025-07-11 09:52:28', '2025-08-08 09:52:28'),
	(21, 22, 22, 'User Dashboard Analytics', 'Implement analytics dashboard with charts and reports for user activity and system metrics.', 1, 1, 3, '2025-07-20 17:52:28', '2025-08-05 17:52:28', 21, '2025-07-20 09:52:28', '2025-08-11 09:52:28'),
	(22, 23, 1, 'Database Schema Optimization', 'Optimize database queries and implement proper indexing for better performance.', 3, 1, 2, '2025-07-30 17:52:28', '2025-08-17 17:52:28', 24, '2025-07-30 09:52:28', '2025-08-10 09:52:28'),
	(23, 23, 24, 'User Interface Wireframes', 'Create detailed wireframes for all major user interface components and user flows.', 2, 3, 3, '2025-07-26 17:52:28', '2025-08-09 17:52:28', 10, '2025-07-26 09:52:28', '2025-08-09 09:52:28'),
	(24, 23, 10, 'Security Audit Implementation', 'Implement security best practices including input validation, CSRF protection, and secure authentication.', 3, 1, 1, '2025-08-04 17:52:28', '2025-08-13 17:52:28', 23, '2025-08-04 09:52:28', '2025-08-10 09:52:28'),
	(25, 23, 22, 'Memory Leak in Background Tasks', 'Background job processes consuming excessive memory and not releasing resources properly.', 3, 2, 4, '2025-07-25 17:52:28', '2025-08-13 17:52:28', 23, '2025-07-25 09:52:28', '2025-08-09 09:52:28'),
	(26, 23, 2, 'Integration Testing Suite', 'Develop comprehensive integration tests covering all API endpoints and user workflows.', 2, 1, 1, '2025-07-27 17:52:28', '2025-08-15 17:52:28', 24, '2025-07-27 09:52:28', '2025-08-11 09:52:28'),
	(27, 23, 2, 'User Dashboard Analytics', 'Implement analytics dashboard with charts and reports for user activity and system metrics.', 1, 1, 3, '2025-07-31 17:52:28', '2025-08-12 17:52:28', 22, '2025-07-31 09:52:28', '2025-08-09 09:52:28'),
	(28, 23, 2, 'Email Notification Templates', 'Design and implement responsive email templates for user notifications and system alerts.', 1, 3, 4, '2025-07-19 17:52:28', '2025-08-05 17:52:28', 24, '2025-07-19 09:52:28', '2025-08-09 09:52:28'),
	(29, 23, 22, 'Data Export Functionality', 'Allow users to export their data in multiple formats (CSV, Excel, PDF) with custom filtering options.', 2, 1, 2, '2025-07-25 17:52:28', '2025-08-03 17:52:28', 23, '2025-07-25 09:52:28', '2025-08-08 09:52:28'),
	(30, 41, 25, 'API Design & Documentation', 'Design RESTful API endpoints and create comprehensive documentation using OpenAPI specifications.', 2, 1, 1, '2025-07-17 17:52:28', '2025-07-28 17:52:28', 10, '2025-07-17 09:52:28', '2025-08-10 09:52:28'),
	(31, 41, 25, 'Database Schema Optimization', 'Optimize database queries and implement proper indexing for better performance.', 3, 1, 2, '2025-07-15 17:52:28', '2025-07-30 17:52:28', 10, '2025-07-15 09:52:28', '2025-08-09 09:52:28'),
	(32, 41, 1, 'User Interface Wireframes', 'Create detailed wireframes for all major user interface components and user flows.', 2, 3, 3, '2025-08-03 17:52:28', '2025-08-18 17:52:28', 2, '2025-08-03 09:52:28', '2025-08-11 09:52:28'),
	(33, 41, 2, 'Performance Issues on Large Datasets', 'Application becomes slow when handling datasets with more than 10,000 records. Need to implement pagination and lazy loading.', 3, 2, 1, '2025-08-06 17:52:28', '2025-08-17 17:52:28', 2, '2025-08-06 09:52:28', '2025-08-08 09:52:28'),
	(34, 41, 21, 'Cross-browser Compatibility Bug', 'Date picker component fails to work properly in Firefox and Safari browsers.', 2, 2, 2, '2025-08-03 17:52:28', '2025-08-15 17:52:28', 23, '2025-08-03 09:52:28', '2025-08-10 09:52:28'),
	(35, 41, 24, 'Memory Leak in Background Tasks', 'Background job processes consuming excessive memory and not releasing resources properly.', 3, 2, 4, '2025-07-23 17:52:28', '2025-08-08 17:52:28', 21, '2025-07-23 09:52:28', '2025-08-11 09:52:28'),
	(36, 41, 10, 'Email Notification Templates', 'Design and implement responsive email templates for user notifications and system alerts.', 1, 3, 4, '2025-07-15 17:52:28', '2025-07-27 17:52:28', 24, '2025-07-15 09:52:28', '2025-08-09 09:52:28'),
	(37, 52, 10, 'API Design & Documentation', 'Design RESTful API endpoints and create comprehensive documentation using OpenAPI specifications.', 2, 1, 1, '2025-07-30 17:52:28', '2025-08-11 17:52:28', 25, '2025-07-30 09:52:28', '2025-08-08 09:52:28'),
	(38, 52, 1, 'Database Schema Optimization', 'Optimize database queries and implement proper indexing for better performance.', 3, 1, 1, '2025-08-03 17:52:28', '2025-08-20 17:52:28', 24, '2025-08-03 09:52:28', '2025-08-11 22:06:44'),
	(39, 52, 10, 'User Interface Wireframes', 'Create detailed wireframes for all major user interface components and user flows.', 2, 3, 3, '2025-07-14 17:52:28', '2025-07-29 17:52:28', 21, '2025-07-14 09:52:28', '2025-08-09 09:52:28'),
	(40, 52, 24, 'Cross-browser Compatibility Bug', 'Date picker component fails to work properly in Firefox and Safari browsers.', 2, 2, 2, '2025-07-19 17:52:28', '2025-08-07 17:52:28', 10, '2025-07-19 09:52:28', '2025-08-08 09:52:28'),
	(41, 52, 25, 'Memory Leak in Background Tasks', 'Background job processes consuming excessive memory and not releasing resources properly.', 3, 2, 1, '2025-07-29 17:52:28', '2025-08-20 17:52:28', 2, '2025-07-29 09:52:28', '2025-08-11 22:06:19'),
	(42, 52, 22, 'Integration Testing Suite', 'Develop comprehensive integration tests covering all API endpoints and user workflows.', 2, 1, 1, '2025-07-26 17:52:28', '2025-08-15 17:52:28', 24, '2025-07-26 09:52:28', '2025-08-11 09:52:28'),
	(43, 52, 24, 'Email Notification Templates', 'Design and implement responsive email templates for user notifications and system alerts.', 1, 3, 4, '2025-07-17 17:52:28', '2025-08-02 17:52:28', 2, '2025-07-17 09:52:28', '2025-08-11 09:52:28'),
	(44, 52, 22, 'Data Export Functionality', 'Allow users to export their data in multiple formats (CSV, Excel, PDF) with custom filtering options.', 2, 1, 2, '2025-08-04 17:52:28', '2025-08-17 17:52:28', 23, '2025-08-04 09:52:28', '2025-08-08 09:52:28'),
	(45, 53, 23, 'Security Audit Implementation', 'Implement security best practices including input validation, CSRF protection, and secure authentication.', 3, 1, 1, '2025-07-20 17:52:28', '2025-07-31 17:52:28', 10, '2025-07-20 09:52:28', '2025-08-09 09:52:28'),
	(46, 53, 2, 'Performance Issues on Large Datasets', 'Application becomes slow when handling datasets with more than 10,000 records. Need to implement pagination and lazy loading.', 3, 2, 1, '2025-08-04 17:52:28', '2025-08-16 17:52:28', 23, '2025-08-04 09:52:28', '2025-08-11 09:52:28'),
	(47, 53, 21, 'Memory Leak in Background Tasks', 'Background job processes consuming excessive memory and not releasing resources properly.', 3, 2, 4, '2025-08-06 17:52:28', '2025-08-29 17:52:28', 23, '2025-08-06 09:52:28', '2025-08-09 09:52:28'),
	(48, 53, 2, 'Email Notification Templates', 'Design and implement responsive email templates for user notifications and system alerts.', 1, 3, 4, '2025-07-18 17:52:28', '2025-08-02 17:52:28', 22, '2025-07-18 09:52:28', '2025-08-09 09:52:28'),
	(49, 53, 24, 'Data Export Functionality', 'Allow users to export their data in multiple formats (CSV, Excel, PDF) with custom filtering options.', 2, 1, 2, '2025-07-08 17:52:28', '2025-08-01 17:52:28', 22, '2025-07-08 09:52:28', '2025-08-08 09:52:28'),
	(50, 54, 23, 'Database Schema Optimization', 'Optimize database queries and implement proper indexing for better performance.', 3, 1, 2, '2025-07-30 17:52:28', '2025-08-12 17:52:28', 22, '2025-07-30 09:52:28', '2025-08-08 09:52:28'),
	(51, 54, 23, 'User Interface Wireframes', 'Create detailed wireframes for all major user interface components and user flows.', 2, 3, 3, '2025-07-16 17:52:28', '2025-07-26 17:52:28', 23, '2025-07-16 09:52:28', '2025-08-10 09:52:28'),
	(52, 54, 10, 'Mobile Responsive Design', 'Ensure all components are fully responsive and provide optimal user experience on mobile devices.', 2, 3, 2, '2025-07-23 17:52:28', '2025-08-12 17:52:28', 1, '2025-07-23 09:52:28', '2025-08-08 09:52:28'),
	(53, 54, 10, 'Performance Issues on Large Datasets', 'Application becomes slow when handling datasets with more than 10,000 records. Need to implement pagination and lazy loading.', 3, 2, 1, '2025-07-22 17:52:28', '2025-08-06 17:52:28', 21, '2025-07-22 09:52:28', '2025-08-08 09:52:28'),
	(54, 54, 24, 'Integration Testing Suite', 'Develop comprehensive integration tests covering all API endpoints and user workflows.', 2, 1, 1, '2025-07-25 17:52:28', '2025-08-14 17:52:28', 21, '2025-07-25 09:52:28', '2025-08-11 09:52:28'),
	(55, 54, 1, 'User Dashboard Analytics', 'Implement analytics dashboard with charts and reports for user activity and system metrics.', 1, 1, 3, '2025-07-10 17:52:28', '2025-07-23 17:52:28', 25, '2025-07-10 09:52:28', '2025-08-08 09:52:28'),
	(56, 54, 2, 'Email Notification Templates', 'Design and implement responsive email templates for user notifications and system alerts.', 1, 3, 4, '2025-07-13 17:52:28', '2025-08-02 17:52:28', 2, '2025-07-13 09:52:28', '2025-08-08 09:52:28'),
	(57, 54, 24, 'Data Export Functionality', 'Allow users to export their data in multiple formats (CSV, Excel, PDF) with custom filtering options.', 2, 1, 2, '2025-08-06 17:52:28', '2025-08-15 17:52:28', 24, '2025-08-06 09:52:28', '2025-08-09 09:52:28'),
	(58, 55, 1, 'API Design & Documentation', 'Design RESTful API endpoints and create comprehensive documentation using OpenAPI specifications.', 2, 2, 1, '2025-07-26 17:52:00', '2025-08-12 17:52:00', 1, '2025-07-26 09:52:28', '2025-08-11 19:18:11'),
	(59, 55, 23, 'User Interface Wireframes', 'Create detailed wireframes for all major user interface components and user flows.', 2, 3, 3, '2025-07-10 17:52:28', '2025-07-23 17:52:28', 2, '2025-07-10 09:52:28', '2025-08-11 09:52:28'),
	(60, 55, 25, 'Mobile Responsive Design', 'Ensure all components are fully responsive and provide optimal user experience on mobile devices.', 2, 3, 2, '2025-08-08 17:52:28', '2025-08-17 17:52:28', 2, '2025-08-08 09:52:28', '2025-08-08 09:52:28'),
	(61, 55, 21, 'Performance Issues on Large Datasets', 'Application becomes slow when handling datasets with more than 10,000 records. Need to implement pagination and lazy loading.', 3, 2, 1, '2025-07-23 17:52:28', '2025-08-16 17:52:28', 1, '2025-07-23 09:52:28', '2025-08-10 09:52:28'),
	(62, 55, 22, 'Memory Leak in Background Tasks', 'Background job processes consuming excessive memory and not releasing resources properly.', 3, 2, 4, '2025-07-20 17:52:28', '2025-08-09 17:52:28', 24, '2025-07-20 09:52:28', '2025-08-08 09:52:28'),
	(63, 55, 1, 'Email Notification Templates', 'Design and implement responsive email templates for user notifications and system alerts.', 1, 3, 4, '2025-07-10 17:52:28', '2025-07-31 17:52:28', 22, '2025-07-10 09:52:28', '2025-08-11 09:52:28');

-- Dumping structure for table trixpm.task_comment
CREATE TABLE IF NOT EXISTS `task_comment` (
  `task_id` bigint unsigned NOT NULL,
  `comment_id` bigint unsigned NOT NULL,
  KEY `fk3_task_id` (`task_id`),
  KEY `fk2_comment_id` (`comment_id`),
  CONSTRAINT `fk2_comment_id` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk3_task_id` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.task_comment: ~0 rows (approximately)
INSERT INTO `task_comment` (`task_id`, `comment_id`) VALUES
	(4, 3);

-- Dumping structure for table trixpm.task_statuses
CREATE TABLE IF NOT EXISTS `task_statuses` (
  `id` int unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trixpm.task_statuses: ~4 rows (approximately)
INSERT INTO `task_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'To-do', '2025-07-02 04:03:34', '2025-07-02 04:03:34'),
	(2, 'In-Progress', '2025-07-02 04:03:34', '2025-07-02 04:03:34'),
	(3, 'In Review', '2025-07-02 04:03:34', '2025-07-02 04:03:34'),
	(4, 'Completed', '2025-07-02 04:03:34', '2025-07-02 04:03:34');

-- Dumping structure for table trixpm.task_types
CREATE TABLE IF NOT EXISTS `task_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.task_types: ~3 rows (approximately)
INSERT INTO `task_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'task', 1, '2025-07-06 15:55:27', '2025-07-06 15:55:29'),
	(2, 'issue', 1, '2025-07-06 15:55:38', '2025-07-06 15:55:39'),
	(3, 'design', 1, '2025-07-06 15:55:46', '2025-07-06 15:55:48');

-- Dumping structure for table trixpm.task_user
CREATE TABLE IF NOT EXISTS `task_user` (
  `task_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  KEY `fk1_task_id` (`task_id`),
  KEY `fk2_user_id` (`user_id`),
  CONSTRAINT `fk1_task_id` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk2_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table trixpm.task_user: ~0 rows (approximately)

-- Dumping structure for table trixpm.teams
CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trixpm.teams: ~5 rows (approximately)
INSERT INTO `teams` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'PHP', '2025-08-04 02:35:50', '2025-08-04 02:35:50'),
	(2, '.Net', '2025-08-04 02:35:50', '2025-08-04 02:35:50'),
	(3, 'UI/UX', '2025-08-04 02:35:50', '2025-08-04 02:35:50'),
	(4, 'QA', '2025-08-04 02:35:50', '2025-08-04 02:35:50'),
	(5, 'Marketing', '2025-08-04 02:35:50', '2025-08-04 02:35:50');

-- Dumping structure for table trixpm.telescope_entries
CREATE TABLE IF NOT EXISTS `telescope_entries` (
  `sequence` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_family_hash_index` (`family_hash`),
  KEY `telescope_entries_created_at_index` (`created_at`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB AUTO_INCREMENT=105072 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.telescope_entries: ~58 rows (approximately)
INSERT INTO `telescope_entries` (`sequence`, `uuid`, `batch_id`, `family_hash`, `should_display_on_index`, `type`, `content`, `created_at`) VALUES
	(105014, '9f061323-650c-4e95-a77d-5e94b8ae30f4', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:38'),
	(105015, '9f061326-977d-49d9-84c8-2aaaefe38b01', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `meetings` limit 1","time":"1.24","slow":false,"file":"Command line code","line":1,"hash":"fd7db0f74b42336332305d9f1179deaa","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105016, '9f061326-a47a-4a43-8d46-ec86ed25433d', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `permissions` limit 1","time":"10.88","slow":false,"file":"Command line code","line":1,"hash":"51e9d969f17c78f90d8e7681004a1de9","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105017, '9f061326-ac42-4885-8a0b-961411d9a353', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `priorities` limit 1","time":"1.26","slow":false,"file":"Command line code","line":1,"hash":"7cf177a081eee8344354720e0a8fd926","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105018, '9f061326-ac96-471c-913f-218d7457fcac', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Priority","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105019, '9f061326-b650-4055-ad31-8a00948ea9ba', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `projects` limit 1","time":"4.55","slow":false,"file":"Command line code","line":1,"hash":"ab5539b5c81f6bce8d9a0876b9fcbeb1","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105020, '9f061326-b6b1-42b2-be1a-b3e75552595d', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Project","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105021, '9f061326-be8c-401d-beb0-e49de84e892b', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `roles` limit 1","time":"0.73","slow":false,"file":"Command line code","line":1,"hash":"7b92920f696a1378bfc848f6d6479bb6","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105022, '9f061326-bedc-4481-a2d9-9ffad416ce5b', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Role","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105023, '9f061326-c607-48d8-bdbe-f95f2665591f', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `tags` limit 1","time":"1.29","slow":false,"file":"Command line code","line":1,"hash":"70d2158ff6fc7d32a51e43b5a8bc10ff","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105024, '9f061326-c651-463b-ba4b-6238d2ae3f0e', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Tag","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105025, '9f061326-d10a-41d8-866b-81739ccee563', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `tasks` limit 1","time":"8.68","slow":false,"file":"Command line code","line":1,"hash":"e8422a13d47e22db27e2bbe3b7e95c7e","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105026, '9f061327-0122-4e5c-b99c-9111169c12aa', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `users` limit 1","time":"1.09","slow":false,"file":"Command line code","line":1,"hash":"26d128571acc3ade5f7d4401c1737345","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105027, '9f061327-017b-47d4-a01e-bb1c0968b4f2', '9f061327-efde-4e9e-9a78-21e6f5b9d503', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\User","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105028, '9f061327-5a59-471e-a036-f69654127948', '9f061327-fe76-4ca2-ad62-cb25ccf32119', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105029, '9f061327-8d59-484f-8c70-1ce4fd98f687', '9f061327-fe27-448e-8021-12468d0539fc', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:39'),
	(105030, '9f061328-e852-4a33-94cd-158d59e9c433', '9f061328-f8b5-4fb1-a51c-adaef8864242', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:40'),
	(105031, '9f06132c-1115-4cdb-af82-f96e44635c3e', '9f06132c-20b0-4d59-a164-3687d67170f1', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:42'),
	(105032, '9f06133b-18c3-4574-92ce-5552ac458874', '9f06133b-243d-49c7-b5d8-7d19ee204dbe', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:52'),
	(105033, '9f06133c-2bd6-485d-a8ff-a122ec130956', '9f06133c-3b63-4556-b896-82221ff95b48', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:53'),
	(105034, '9f06133c-31e4-453f-b5ac-0e14db7ab6e4', '9f06133c-4bf6-4bc8-b090-7b1675c62382', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:06:53'),
	(105035, '9f061387-facc-4e6b-bdbb-f24a36bcf95d', '9f061388-105a-4c1c-860a-9445867fcfd8', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105036, '9f061388-182d-4407-a62d-00be520c453e', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105037, '9f061388-366c-4fd4-a4ca-a94fe0e266d0', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `meetings` limit 1","time":"4.10","slow":false,"file":"Command line code","line":1,"hash":"fd7db0f74b42336332305d9f1179deaa","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105038, '9f061388-4114-4e06-840e-fbe52a25ce1c', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `permissions` limit 1","time":"1.89","slow":false,"file":"Command line code","line":1,"hash":"51e9d969f17c78f90d8e7681004a1de9","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105039, '9f061388-48f9-4434-92a0-19cb4ee6f224', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `priorities` limit 1","time":"1.75","slow":false,"file":"Command line code","line":1,"hash":"7cf177a081eee8344354720e0a8fd926","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105040, '9f061388-494a-444c-b5d1-ee5a4295f891', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Priority","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105041, '9f061388-5240-4cca-9f44-1d1fba1c83d8', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `projects` limit 1","time":"4.36","slow":false,"file":"Command line code","line":1,"hash":"ab5539b5c81f6bce8d9a0876b9fcbeb1","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105042, '9f061388-5296-4020-833d-f212c1ed623b', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Project","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105043, '9f061388-58fc-4df5-96b5-c742f83cc9c4', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `roles` limit 1","time":"1.17","slow":false,"file":"Command line code","line":1,"hash":"7b92920f696a1378bfc848f6d6479bb6","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105044, '9f061388-5950-4546-87d5-3e8f0804b380', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Role","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105045, '9f061388-609b-47b6-8b0d-5ac1dd40f3d1', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `tags` limit 1","time":"1.89","slow":false,"file":"Command line code","line":1,"hash":"70d2158ff6fc7d32a51e43b5a8bc10ff","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105046, '9f061388-60e7-4326-b3c6-54727668c82c', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Tag","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105047, '9f061388-687c-48c0-8938-a3c18682988d', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `tasks` limit 1","time":"1.33","slow":false,"file":"Command line code","line":1,"hash":"e8422a13d47e22db27e2bbe3b7e95c7e","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105048, '9f061388-7ad7-4c2a-a4fa-e7bf97f8e14a', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `users` limit 1","time":"0.93","slow":false,"file":"Command line code","line":1,"hash":"26d128571acc3ade5f7d4401c1737345","hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105049, '9f061388-7b22-4008-8599-fc94319db7d7', '9f061388-8a01-4a06-a628-d0353f5cb2ad', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\User","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:43'),
	(105050, '9f06138c-2a0e-45b6-8174-32a6d8a1fc84', '9f06138c-36f3-46cf-85c5-a2de73d1bcd1', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:45'),
	(105051, '9f061398-a58b-4459-a889-8d76d4dbcc99', '9f061398-ae54-430c-bead-e59792d8a8ab', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:53'),
	(105052, '9f061398-a2aa-4755-87e0-581f66504c53', '9f061398-aeab-4cf6-8ce1-01dfa312a24b', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-05-29 02:07:53'),
	(105053, '9f715497-23d6-41f9-bf05-2413a4b50034', '9f715497-9353-4827-a9d9-ccc7bd39289f', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105054, '9f715497-8a6b-4df8-aa40-29389d85cae5', '9f715497-a13b-46c8-935e-9c9bf774dc4f', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105055, '9f715497-b0f1-470e-81d5-0cfddfc0d502', '9f715497-cd97-40c0-b074-74fc5b5971e5', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105056, '9f715497-91a5-489e-9f45-a5610e664c68', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105057, '9f715497-d07d-4b08-b4ea-43e023dfcff5', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `meetings` limit 1","time":"6.66","slow":false,"file":"Command line code","line":1,"hash":"fd7db0f74b42336332305d9f1179deaa","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105058, '9f715497-daa0-40e7-b4a4-c25e472665c7', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `permissions` limit 1","time":"1.33","slow":false,"file":"Command line code","line":1,"hash":"51e9d969f17c78f90d8e7681004a1de9","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105059, '9f715497-e128-4a88-bbe0-ab2620862b2d', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `priorities` limit 1","time":"1.20","slow":false,"file":"Command line code","line":1,"hash":"7cf177a081eee8344354720e0a8fd926","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105060, '9f715497-e186-415c-8914-b835911256aa', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Priority","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105061, '9f715497-e96e-4541-9b96-254805372bcb', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `projects` limit 1","time":"1.69","slow":false,"file":"Command line code","line":1,"hash":"ab5539b5c81f6bce8d9a0876b9fcbeb1","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105062, '9f715497-ea15-4880-9130-82e91e6b5f39', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Project","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105063, '9f715497-f0e9-4365-b58b-49dbe3d3d1c4', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `roles` limit 1","time":"1.54","slow":false,"file":"Command line code","line":1,"hash":"7b92920f696a1378bfc848f6d6479bb6","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105064, '9f715497-f143-40ee-b32a-a7830fb2fee6', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Role","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105065, '9f715497-f847-427b-a78b-5dd6fd3f2d35', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `tags` limit 1","time":"1.17","slow":false,"file":"Command line code","line":1,"hash":"70d2158ff6fc7d32a51e43b5a8bc10ff","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105066, '9f715497-f898-4e01-9a63-e57ab7e8f6b1', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Tag","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105067, '9f715497-ff07-40b0-9525-923758bab486', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `tasks` limit 1","time":"1.16","slow":false,"file":"Command line code","line":1,"hash":"e8422a13d47e22db27e2bbe3b7e95c7e","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105068, '9f715497-ff5f-47aa-9a37-81a5fb85eed0', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\Task","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105069, '9f715498-0d0f-4de1-8b27-bb1e51735c9b', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'query', '{"connection":"mysql","bindings":[],"sql":"select * from `users` limit 1","time":"1.22","slow":false,"file":"Command line code","line":1,"hash":"26d128571acc3ade5f7d4401c1737345","hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105070, '9f715498-0d60-4ab2-91a4-92fba99ac5d4', '9f715498-14dd-4b46-911e-78aa79f66613', NULL, 1, 'model', '{"action":"retrieved","model":"App\\\\Models\\\\User","count":1,"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:13'),
	(105071, '9f71549a-6d19-4974-a787-e2aa0e1ce478', '9f71549a-7915-4ccc-88e3-1fbeabc1d039', NULL, 1, 'command', '{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"DESKTOP-M2I1PKI"}', '2025-07-21 09:43:15');

-- Dumping structure for table trixpm.telescope_entries_tags
CREATE TABLE IF NOT EXISTS `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.telescope_entries_tags: ~16 rows (approximately)
INSERT INTO `telescope_entries_tags` (`entry_uuid`, `tag`) VALUES
	('9f061326-ac96-471c-913f-218d7457fcac', 'App\\Models\\Priority'),
	('9f061388-494a-444c-b5d1-ee5a4295f891', 'App\\Models\\Priority'),
	('9f715497-e186-415c-8914-b835911256aa', 'App\\Models\\Priority'),
	('9f061326-b6b1-42b2-be1a-b3e75552595d', 'App\\Models\\Project'),
	('9f061388-5296-4020-833d-f212c1ed623b', 'App\\Models\\Project'),
	('9f715497-ea15-4880-9130-82e91e6b5f39', 'App\\Models\\Project'),
	('9f061326-bedc-4481-a2d9-9ffad416ce5b', 'App\\Models\\Role'),
	('9f061388-5950-4546-87d5-3e8f0804b380', 'App\\Models\\Role'),
	('9f715497-f143-40ee-b32a-a7830fb2fee6', 'App\\Models\\Role'),
	('9f061326-c651-463b-ba4b-6238d2ae3f0e', 'App\\Models\\Tag'),
	('9f061388-60e7-4326-b3c6-54727668c82c', 'App\\Models\\Tag'),
	('9f715497-f898-4e01-9a63-e57ab7e8f6b1', 'App\\Models\\Tag'),
	('9f715497-ff5f-47aa-9a37-81a5fb85eed0', 'App\\Models\\Task'),
	('9f061327-017b-47d4-a01e-bb1c0968b4f2', 'App\\Models\\User'),
	('9f061388-7b22-4008-8599-fc94319db7d7', 'App\\Models\\User'),
	('9f715498-0d60-4ab2-91a4-92fba99ac5d4', 'App\\Models\\User');

-- Dumping structure for table trixpm.telescope_monitoring
CREATE TABLE IF NOT EXISTS `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.telescope_monitoring: ~0 rows (approximately)

-- Dumping structure for table trixpm.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `notification_preferences` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_team_id` (`team_id`),
  CONSTRAINT `fk_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table trixpm.users: ~8 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `profile_photo`, `bio`, `location`, `website`, `github_username`, `linkedin_username`, `skills`, `timezone`, `language`, `notification_preferences`, `email_verified_at`, `password`, `remember_token`, `team_id`, `created_at`, `updated_at`) VALUES
	(1, 'Izzat Saifullah', 'izzat@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$nUjnxZlfK3gXu8NPwvA5HekepbxvAd0rSrhFQEWJ3fPMnliBQZK2W', NULL, 1, '2025-04-17 19:43:02', '2025-08-10 03:48:31'),
	(2, 'Ahmed Arabee', 'arabee@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$flF.rVcWqTJwlg4IQZJJp.509tB3t2JmrEBiLsS5vv9oKw5ADgzr6', NULL, 1, '2025-04-20 04:30:38', '2025-08-10 09:56:31'),
	(10, 'hello world', 'hello@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$dNvVYHXk2w7hPuMbQQmlNOab7i/Vb1hsEyZxmEt5Xp7xS0jIxVkHO', NULL, 2, '2025-05-05 17:34:03', '2025-08-11 18:59:00'),
	(21, 'Sarah Chen', 'sarah.chen@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$8WqWlOaMwjsCDy.Il7Dajup6fbiZyljNndwLDBoSCRrQjmds93mfq', NULL, 2, '2025-06-24 09:52:27', '2025-07-20 09:52:27'),
	(22, 'Marcus Johnson', 'marcus.j@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$4YMUSJr6l1CaSKOnJvpcY.zYGBEAT0g0xc0V8WzA7EeYpoIs7J0T6', NULL, 3, '2025-06-10 09:52:27', '2025-08-01 09:52:27'),
	(23, 'Elena Rodriguez', 'elena.r@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$PkMtmv0K5by11UU7uFtA/OVrpVU3IYX9iH4gES9r2kVNjNH5Nqm0e', NULL, 4, '2025-05-19 09:52:27', '2025-07-20 09:52:27'),
	(24, 'David Kim', 'david.kim@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$59sC4tyCO93ARfVaO0n43OYsHqIEvQNHsUVeV9HYDTI431FbuYSdK', NULL, 1, '2025-06-22 09:52:28', '2025-07-24 09:52:28'),
	(25, 'Lisa Thompson', 'lisa.t@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 'en', NULL, NULL, '$2y$12$Ii//oENGgeCFajLhOm4Nmuq4sNUQAtuCjBVMUcAQYBVhcjnhB3mEm', NULL, 5, '2025-06-03 09:52:28', '2025-08-01 09:52:28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
