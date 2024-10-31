CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "google_id" varchar not null default ''
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "biodatas"(
  "id" integer primary key autoincrement not null,
  "user_id" varchar not null,
  "first_name" varchar not null,
  "last_name" varchar not null,
  "whatsapp" integer not null,
  "email" varchar not null,
  "last_education" varchar not null,
  "gender" varchar not null,
  "location" varchar not null,
  "month_start" varchar not null,
  "year_start" varchar not null,
  "month_end" varchar not null,
  "year_end" varchar not null,
  "about" text not null
);
CREATE UNIQUE INDEX "biodatas_user_id_unique" on "biodatas"("user_id");
CREATE TABLE IF NOT EXISTS "job_titles"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime,
  "section" varchar
);
CREATE UNIQUE INDEX "jobtitle_jobtitle_unique" on "job_titles"("name");
CREATE TABLE IF NOT EXISTS "division"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "updated_at" datetime,
  "deleted_at" datetime,
  "created_at" datetime
);
CREATE UNIQUE INDEX "division_division_unique" on "division"("name");
CREATE TABLE IF NOT EXISTS "department"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE UNIQUE INDEX "department_department_unique" on "department"("name");
CREATE TABLE IF NOT EXISTS "position"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE UNIQUE INDEX "position_position_unique" on "position"("name");
CREATE TABLE IF NOT EXISTS "sales"(
  "id" integer primary key autoincrement not null,
  "month" varchar not null,
  "year" varchar not null,
  "person" varchar not null,
  "qtyAllin" integer not null,
  "qtyMakloon" integer not null,
  "total" integer not null,
  "created_at" datetime not null,
  "updated_at" datetime not null,
  "deleted_at" datetime not null
);
CREATE TABLE IF NOT EXISTS "presence_summary"(
  "id" integer primary key autoincrement not null,
  "eid" varchar not null,
  "name" varchar not null,
  "late_arrival" integer not null,
  "late_checkin" integer not null,
  "total_latecheckin" integer not null,
  "total_overtime" integer not null,
  "average_overtime" integer not null,
  "average_working_hour" integer not null,
  "total_chekout_early" integer not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime not null
);
CREATE UNIQUE INDEX "presence_summary_eid_unique" on "presence_summary"("eid");
CREATE TABLE IF NOT EXISTS "performance"(
  "id" integer primary key autoincrement not null,
  "eid" varchar not null,
  "employee_name" varchar not null,
  "kpi" integer not null,
  "pa" integer not null,
  "grade" integer,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime not null
);
CREATE UNIQUE INDEX "performance_eid_unique" on "performance"("eid");
CREATE TABLE IF NOT EXISTS "on_day_calendar"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "jan" varchar not null,
  "feb" varchar not null,
  "mar" varchar not null,
  "apr" varchar not null,
  "may" varchar not null,
  "jun" varchar not null,
  "jul" varchar not null,
  "aug" varchar not null,
  "sep" varchar not null,
  "oct" varchar not null,
  "nov" varchar not null,
  "dec" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "on_day_calendar_name_unique" on "on_day_calendar"("name");
CREATE TABLE IF NOT EXISTS "sales_person"(
  "id" integer primary key autoincrement not null,
  "eid" varchar,
  "employee_name" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE UNIQUE INDEX "sales_person_eid_unique" on "sales_person"("eid");
CREATE TABLE IF NOT EXISTS "options"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "type" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime not null,
  "deleted" datetime
);
CREATE TABLE IF NOT EXISTS "work_schedule"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "start_at" time not null,
  "end_at" time not null,
  "created_at" datetime not null,
  "deleted_at" datetime,
  "updated_at" datetime,
  "arrival" time
);
CREATE UNIQUE INDEX "work_load_name_unique" on "work_schedule"("name");
CREATE TABLE IF NOT EXISTS "employee_status"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE UNIQUE INDEX "employee_status_name_unique" on "employee_status"("name");
CREATE TABLE IF NOT EXISTS "overtime"(
  "id" integer primary key autoincrement not null,
  "eid" varchar,
  "employee_name" varchar not null,
  "date" date not null,
  "start_at" time not null,
  "end_at" time not null,
  "total" integer,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime
);
CREATE TABLE IF NOT EXISTS "employees"(
  "id" integer primary key autoincrement not null,
  "eid" varchar,
  "name" varchar not null,
  "position" varchar not null,
  "jobTitle" varchar not null,
  "division" varchar not null,
  "department" varchar not null,
  "joiningDate" varchar not null,
  "workSchedule" varchar not null,
  "workCalendar" varchar not null,
  "employeeStatus" varchar not null,
  "salesStatus" varchar not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime,
  "status" varchar,
  "city" varchar
);
CREATE UNIQUE INDEX "employees_eid_unique" on "employees"("eid");
CREATE TABLE IF NOT EXISTS "presences"(
  "id" integer primary key autoincrement not null,
  "eid" varchar,
  "employee_name" varchar not null,
  "date" date not null,
  "check_in" time not null,
  "check_out" time not null,
  "created_at" datetime not null,
  "updated_at" datetime,
  "deleted_at" datetime,
  "lateness" integer not null default ''
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2024_07_10_134838_add_colung',2);
INSERT INTO migrations VALUES(5,'2024_07_06_155535_biodatas',3);
INSERT INTO migrations VALUES(6,'2024_07_06_160824_biodatas',3);
INSERT INTO migrations VALUES(7,'2024_08_19_140550_employees',4);
INSERT INTO migrations VALUES(8,'2024_08_20_064824_addemployee',5);
INSERT INTO migrations VALUES(9,'2024_08_20_070117_tableemplo',6);
INSERT INTO migrations VALUES(10,'2024_08_20_070330_deleteeid',7);
INSERT INTO migrations VALUES(11,'2024_08_20_070928_editeid',8);
INSERT INTO migrations VALUES(12,'2024_08_20_071302_del',9);
INSERT INTO migrations VALUES(13,'2024_08_20_072959_options',10);
INSERT INTO migrations VALUES(14,'2024_08_20_091219_editposition',11);
INSERT INTO migrations VALUES(15,'2024_08_20_091617_epo',12);
INSERT INTO migrations VALUES(16,'2024_08_21_023638_editjobtitle',13);
INSERT INTO migrations VALUES(17,'2024_08_21_024527_edijob',14);
INSERT INTO migrations VALUES(18,'2024_08_21_060700_renamjob',15);
INSERT INTO migrations VALUES(19,'2024_08_21_060901_renamjobb',16);
INSERT INTO migrations VALUES(20,'2024_08_21_063036_renampos',17);
INSERT INTO migrations VALUES(21,'2024_08_21_071821_updatedivision',18);
INSERT INTO migrations VALUES(22,'2024_08_21_072010_aaupdatedivision',19);
INSERT INTO migrations VALUES(23,'2024_08_21_073031_editdepartment',20);
INSERT INTO migrations VALUES(24,'2024_08_21_073649_edepert',21);
INSERT INTO migrations VALUES(25,'2024_08_22_022406_sales',22);
INSERT INTO migrations VALUES(26,'2024_08_22_042954_presence',23);
INSERT INTO migrations VALUES(27,'2024_08_22_082816_on_day_calendar',24);
INSERT INTO migrations VALUES(28,'2024_08_22_084642_edit_on_day_calendar',25);
INSERT INTO migrations VALUES(29,'2024_08_22_112501_editsalesperson',26);
INSERT INTO migrations VALUES(30,'2024_08_22_112746_edittsales',27);
INSERT INTO migrations VALUES(31,'2024_08_22_113028_edittsaless',28);
INSERT INTO migrations VALUES(32,'2024_08_22_113330_edittsalessss',29);
INSERT INTO migrations VALUES(33,'2024_08_23_071804_aaposition',30);
INSERT INTO migrations VALUES(34,'2024_08_23_090756_jobposkuwalik',31);
INSERT INTO migrations VALUES(35,'2024_08_23_091244_addsecjob',32);
INSERT INTO migrations VALUES(36,'2024_08_24_043241_options',33);
INSERT INTO migrations VALUES(37,'2024_08_26_040243_workload',34);
INSERT INTO migrations VALUES(38,'2024_08_26_040953_rename_work',35);
INSERT INTO migrations VALUES(39,'2024_08_26_044255_sales_edit',36);
INSERT INTO migrations VALUES(40,'2024_08_26_044602_ssales_edit',37);
INSERT INTO migrations VALUES(41,'2024_08_27_043959_employee_status',38);
INSERT INTO migrations VALUES(42,'2024_08_27_061027_add_status_employee',39);
INSERT INTO migrations VALUES(43,'2024_08_28_024740_schedulee',40);
INSERT INTO migrations VALUES(44,'2024_08_28_081151_overrr',41);
INSERT INTO migrations VALUES(45,'2024_08_28_104043_oover',42);
INSERT INTO migrations VALUES(46,'2024_08_28_104450_ooover',43);
INSERT INTO migrations VALUES(47,'2024_08_28_132959_city_employee',44);
INSERT INTO migrations VALUES(48,'2024_08_28_134704_city_employeedd',45);
INSERT INTO migrations VALUES(49,'2024_08_28_165052_eidpres',46);
INSERT INTO migrations VALUES(50,'2024_08_28_165238_eidpresaa',47);
INSERT INTO migrations VALUES(51,'2024_08_28_165338_eidpresaaaa',48);
INSERT INTO migrations VALUES(52,'2024_08_29_043619_presenlate',49);
INSERT INTO migrations VALUES(53,'2024_08_29_081018_presns',50);
