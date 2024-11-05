START TRANSACTION;
CREATE TABLE IF NOT EXISTS `biodatas`(
  `id` INT primary key AUTO_INCREMENT not null,
  `user_id` VARCHAR(255) not null,
  `first_name` VARCHAR(255) not null,
  `last_name` VARCHAR(255) not null,
  `whatsapp` INT not null,
  `email` VARCHAR(255) not null,
  `last_education` VARCHAR(255) not null,
  `gender` VARCHAR(255) not null,
  `location` VARCHAR(255) not null,
  `month_start` VARCHAR(255) not null,
  `year_start` VARCHAR(255) not null,
  `month_end` VARCHAR(255) not null,
  `year_end` VARCHAR(255) not null,
  `about` text not null
);
CREATE TABLE IF NOT EXISTS `cache`(
  `key` VARCHAR(255) not null,
  `value` text not null,
  `expiration` INT not null,
  primary key(`key`)
);
CREATE TABLE IF NOT EXISTS `cache_locks`(
  `key` VARCHAR(255) not null,
  `owner` VARCHAR(255) not null,
  `expiration` INT not null,
  primary key(`key`)
);
CREATE TABLE IF NOT EXISTS `department`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `created_at` datetime,
  `updated_at` datetime,
  `deleted_at` datetime
);
CREATE TABLE IF NOT EXISTS `division`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `updated_at` datetime,
  `deleted_at` datetime,
  `created_at` datetime
);
CREATE TABLE IF NOT EXISTS `employee_status`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime
);
CREATE TABLE IF NOT EXISTS `employees`(
  `id` INT primary key AUTO_INCREMENT not null,
  `eid` VARCHAR(255),
  `name` VARCHAR(255) not null,
  `position` VARCHAR(255) not null,
  `jobTitle` VARCHAR(255) not null,
  `division` VARCHAR(255) not null,
  `department` VARCHAR(255) not null,
  `joiningDate` VARCHAR(255) not null,
  `workSchedule` VARCHAR(255) not null,
  `workCalendar` VARCHAR(255) not null,
  `employeeStatus` VARCHAR(255) not null,
  `salesStatus` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime,
  `status` VARCHAR(255),
  `city` VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS `failed_jobs`(
  `id` INT primary key AUTO_INCREMENT not null,
  `uuid` VARCHAR(255) not null,
  `connection` text not null,
  `queue` text not null,
  `payload` text not null,
  `exception` text not null,
  `failed_at` datetime not null default CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS `grade_pa` (`id` INT primary key AUTO_INCREMENT not null, `eid` INT not null, `month` INT not null, `year` INT not null, `appraisal_id` INT not null, `grade` INT not null, `created_at` datetime, `updated_at` datetime, foreign key(`appraisal_id`) references `performance_appraisal`(`id`) on delete cascade, foreign key(`eid`) references `employees`(`id`) on delete cascade);
CREATE TABLE IF NOT EXISTS `job_batches`(
  `id` VARCHAR(255) not null,
  `name` VARCHAR(255) not null,
  `total_jobs` INT not null,
  `pending_jobs` INT not null,
  `failed_jobs` INT not null,
  `failed_job_ids` text not null,
  `options` text,
  `cancelled_at` INT,
  `created_at` INT not null,
  `finished_at` INT,
  primary key(`id`)
);
CREATE TABLE IF NOT EXISTS `job_titles`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime,
  `section` VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS `jobs`(
  `id` INT primary key AUTO_INCREMENT not null,
  `queue` VARCHAR(255) not null,
  `payload` text not null,
  `attempts` INT not null,
  `reserved_at` INT,
  `available_at` INT not null,
  `created_at` INT not null
);
CREATE TABLE IF NOT EXISTS `migrations`(
  `id` INT primary key AUTO_INCREMENT not null,
  `migration` VARCHAR(255) not null,
  `batch` INT not null
);
CREATE TABLE IF NOT EXISTS `on_day_calendar`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `jan` VARCHAR(255) not null,
  `feb` VARCHAR(255) not null,
  `mar` VARCHAR(255) not null,
  `apr` VARCHAR(255) not null,
  `may` VARCHAR(255) not null,
  `jun` VARCHAR(255) not null,
  `jul` VARCHAR(255) not null,
  `aug` VARCHAR(255) not null,
  `sep` VARCHAR(255) not null,
  `oct` VARCHAR(255) not null,
  `nov` VARCHAR(255) not null,
  `dec` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime
);
CREATE TABLE IF NOT EXISTS `options`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `type` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime not null,
  `deleted` datetime
);
CREATE TABLE IF NOT EXISTS `overtime`(
  `id` INT primary key AUTO_INCREMENT not null,
  `eid` VARCHAR(255),
  `employee_name` VARCHAR(255) not null,
  `date` date not null,
  `start_at` time not null,
  `end_at` time not null,
  `total` INT,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime
);
CREATE TABLE IF NOT EXISTS `password_reset_tokens`(
  `email` VARCHAR(255) not null,
  `token` VARCHAR(255) not null,
  `created_at` datetime,
  primary key(`email`)
);
CREATE TABLE IF NOT EXISTS `payroll_options` (`id` INT primary key AUTO_INCREMENT not null, `eid` VARCHAR(255) not null, `name` VARCHAR(255) not null, `basic` INT not null, `health` INT not null, `meal` INT not null, `dicipline` INT not null, `performance` INT not null, `comission` INT not null, `overtime` INT not null, `uang_pisah` INT not null, `leave_cahsed` INT not null, `absence` INT not null, `lateness` INT not null, `meal_deduction` INT not null, `dicipline_deduction` INT not null, `check_out_early` INT not null, `penalty` INT not null, `comission_deduction` INT not null, `loan` INT not null, `sallary_adjustment` INT not null, `kpi_percent` INT not null, `pa_percent` INT not null, `created_at` datetime, `updated_at` datetime, foreign key(`eid`) references `employees`(`eid`) on delete cascade, foreign key(`name`) references `employees`(`name`) on delete cascade);
CREATE TABLE IF NOT EXISTS `performance`(
  `id` INT primary key AUTO_INCREMENT not null,
  `eid` VARCHAR(255) not null,
  `employee_name` VARCHAR(255) not null,
  `kpi` INT not null,
  `pa` INT not null,
  `grade` INT,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime not null
);
CREATE TABLE IF NOT EXISTS `performance_appraisal` (`id` INT primary key AUTO_INCREMENT not null, `name` VARCHAR(255) not null, `description` VARCHAR(255), `created_at` datetime, `updated_at` datetime);
CREATE TABLE IF NOT EXISTS `performance_kpis` (`id` INT primary key AUTO_INCREMENT not null, `name` VARCHAR(255) not null, `target` INT not null, `bobot` INT not null, `created_at` datetime, `updated_at` datetime, `position_id` VARCHAR(255) not null);
CREATE TABLE IF NOT EXISTS `position`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime
);
CREATE TABLE IF NOT EXISTS `presence_summary`(
  `id` INT primary key AUTO_INCREMENT not null,
  `eid` VARCHAR(255) not null,
  `name` VARCHAR(255) not null,
  `late_arrival` INT not null,
  `late_checkin` INT not null,
  `total_latecheckin` INT not null,
  `total_overtime` INT not null,
  `average_overtime` INT not null,
  `average_working_hour` INT not null,
  `total_chekout_early` INT not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime not null
);
CREATE TABLE IF NOT EXISTS `presences`(
  `id` INT primary key AUTO_INCREMENT not null,
  `eid` VARCHAR(255),
  `employee_name` VARCHAR(255) not null,
  `date` date not null,
  `check_in` time not null,
  `check_out` time not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime,
  `lateness` INT not null default ''
);
CREATE TABLE IF NOT EXISTS `sales`(
  `id` INT primary key AUTO_INCREMENT not null,
  `month` VARCHAR(255) not null,
  `year` VARCHAR(255) not null,
  `person` VARCHAR(255) not null,
  `qtyAllin` INT not null,
  `qtyMakloon` INT not null,
  `total` INT not null,
  `created_at` datetime not null,
  `updated_at` datetime not null,
  `deleted_at` datetime not null
);
CREATE TABLE IF NOT EXISTS `sales_person`(
  `id` INT primary key AUTO_INCREMENT not null,
  `eid` VARCHAR(255),
  `employee_name` VARCHAR(255) not null,
  `created_at` datetime not null,
  `updated_at` datetime,
  `deleted_at` datetime
);
CREATE TABLE IF NOT EXISTS `sessions`(
  `id` VARCHAR(255) not null,
  `user_id` INT,
  `ip_address` VARCHAR(255),
  `user_agent` text,
  `payload` text not null,
  `last_activity` INT not null,
  primary key(`id`)
);
CREATE TABLE IF NOT EXISTS `users`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `email` VARCHAR(255) not null,
  `email_verified_at` datetime,
  `password` VARCHAR(255) not null,
  `remember_token` VARCHAR(255),
  `created_at` datetime,
  `updated_at` datetime,
  `google_id` VARCHAR(255) not null default ''
);
CREATE TABLE IF NOT EXISTS `work_schedule`(
  `id` INT primary key AUTO_INCREMENT not null,
  `name` VARCHAR(255) not null,
  `start_at` time not null,
  `end_at` time not null,
  `created_at` datetime not null,
  `deleted_at` datetime,
  `updated_at` datetime,
  `arrival` time
);
CREATE UNIQUE INDEX `biodatas_user_id_unique` on `biodatas`(`user_id`);
CREATE UNIQUE INDEX `department_department_unique` on `department`(`name`);
CREATE UNIQUE INDEX `division_division_unique` on `division`(`name`);
CREATE UNIQUE INDEX `employee_status_name_unique` on `employee_status`(`name`);
CREATE UNIQUE INDEX `employees_eid_unique` on `employees`(`eid`);
CREATE UNIQUE INDEX `failed_jobs_uuid_unique` on `failed_jobs`(`uuid`);
CREATE INDEX `jobs_queue_index` on `jobs`(`queue`);
CREATE UNIQUE INDEX `jobtitle_jobtitle_unique` on `job_titles`(`name`);
CREATE UNIQUE INDEX `on_day_calendar_name_unique` on `on_day_calendar`(`name`);
CREATE UNIQUE INDEX `payroll_options_eid_unique` on `payroll_options` (`eid`);
CREATE UNIQUE INDEX `performance_eid_unique` on `performance`(`eid`);
CREATE UNIQUE INDEX `position_position_unique` on `position`(`name`);
CREATE UNIQUE INDEX `presence_summary_eid_unique` on `presence_summary`(`eid`);
CREATE UNIQUE INDEX `sales_person_eid_unique` on `sales_person`(`eid`);
CREATE INDEX `sessions_last_activity_index` on `sessions`(`last_activity`);
CREATE INDEX `sessions_user_id_index` on `sessions`(`user_id`);
CREATE UNIQUE INDEX `users_email_unique` on `users`(`email`);
CREATE UNIQUE INDEX `work_load_name_unique` on `work_schedule`(`name`);
CREATE INDEX `work_schedule_name_index` on `work_schedule` (`name`);
COMMIT;
