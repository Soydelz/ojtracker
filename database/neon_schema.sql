-- OJTracker PostgreSQL Schema
-- Run this in Neon SQL Editor to create all tables

CREATE TABLE IF NOT EXISTS "users" (
    "id" bigserial PRIMARY KEY,
    "name" varchar(255) NOT NULL,
    "username" varchar(255) NOT NULL UNIQUE,
    "email" varchar(255) NOT NULL UNIQUE,
    "email_verified_at" timestamp NULL,
    "required_hours" integer NOT NULL DEFAULT 590,
    "school" varchar(255) NULL,
    "password" varchar(255) NOT NULL,
    "profile_picture" varchar(255) NULL,
    "cover_photo" varchar(255) NULL,
    "face_descriptor" text NULL,
    "remember_token" varchar(100) NULL,
    "created_at" timestamp NULL,
    "updated_at" timestamp NULL
);

CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
    "email" varchar(255) PRIMARY KEY,
    "token" varchar(255) NOT NULL,
    "created_at" timestamp NULL
);

CREATE TABLE IF NOT EXISTS "failed_jobs" (
    "id" bigserial PRIMARY KEY,
    "uuid" varchar(255) NOT NULL UNIQUE,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS "personal_access_tokens" (
    "id" bigserial PRIMARY KEY,
    "tokenable_type" varchar(255) NOT NULL,
    "tokenable_id" bigint NOT NULL,
    "name" varchar(255) NOT NULL,
    "token" varchar(64) NOT NULL UNIQUE,
    "abilities" text NULL,
    "last_used_at" timestamp NULL,
    "expires_at" timestamp NULL,
    "created_at" timestamp NULL,
    "updated_at" timestamp NULL
);

CREATE INDEX IF NOT EXISTS "personal_access_tokens_tokenable_index" ON "personal_access_tokens" ("tokenable_type", "tokenable_id");

CREATE TABLE IF NOT EXISTS "dtr_logs" (
    "id" bigserial PRIMARY KEY,
    "user_id" bigint NOT NULL,
    "date" date NOT NULL,
    "time_in" time NULL,
    "time_out" time NULL,
    "break_hours" decimal(5,2) NOT NULL DEFAULT 0.00,
    "total_hours" decimal(5,2) NOT NULL DEFAULT 0.00,
    "status" varchar(255) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','completed')),
    "notes" text NULL,
    "face_photo" varchar(255) NULL,
    "face_confidence" decimal(5,2) NULL,
    "created_at" timestamp NULL,
    "updated_at" timestamp NULL,
    UNIQUE ("user_id", "date"),
    FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS "accomplishments" (
    "id" bigserial PRIMARY KEY,
    "user_id" bigint NOT NULL,
    "date" date NOT NULL,
    "task_description" text NOT NULL,
    "tools_used" varchar(255) NULL,
    "created_at" timestamp NULL,
    "updated_at" timestamp NULL,
    FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS "accomplishments_user_id_date_index" ON "accomplishments" ("user_id", "date");

CREATE TABLE IF NOT EXISTS "notifications" (
    "id" bigserial PRIMARY KEY,
    "user_id" bigint NOT NULL,
    "type" varchar(255) NOT NULL,
    "title" varchar(255) NOT NULL,
    "message" text NOT NULL,
    "icon" varchar(255) NULL,
    "link" varchar(255) NULL,
    "is_read" boolean NOT NULL DEFAULT false,
    "created_at" timestamp NULL,
    "updated_at" timestamp NULL,
    FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS "notifications_user_id_is_read_index" ON "notifications" ("user_id", "is_read");

CREATE TABLE IF NOT EXISTS "sessions" (
    "id" varchar(255) PRIMARY KEY,
    "user_id" bigint NULL,
    "ip_address" varchar(45) NULL,
    "user_agent" text NULL,
    "payload" text NOT NULL,
    "last_activity" integer NOT NULL
);

CREATE INDEX IF NOT EXISTS "sessions_user_id_index" ON "sessions" ("user_id");
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" ON "sessions" ("last_activity");

CREATE TABLE IF NOT EXISTS "migrations" (
    "id" serial PRIMARY KEY,
    "migration" varchar(255) NOT NULL,
    "batch" integer NOT NULL
);

-- Insert migration records so Laravel won't re-run them
INSERT INTO "migrations" ("migration", "batch") VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_reset_tokens_table', 1),
('2019_08_19_000000_create_failed_jobs_table', 1),
('2019_12_14_000001_create_personal_access_tokens_table', 1),
('2026_01_13_052539_create_dtr_logs_table', 2),
('2026_01_13_144800_add_break_hours_to_dtr_logs_table', 2),
('2026_01_14_090238_create_accomplishments_table', 2),
('2026_01_14_151048_add_required_hours_and_school_to_users_table', 2),
('2026_01_15_101649_add_profile_and_cover_photos_to_users_table', 2),
('2026_01_15_104926_create_notifications_table', 2),
('2026_01_23_112124_add_face_recognition_fields_to_users_and_dtr_logs', 2),
('2026_02_13_000000_create_sessions_table', 3),
('2026_02_13_105349_create_sessions_table', 3)
ON CONFLICT DO NOTHING;
