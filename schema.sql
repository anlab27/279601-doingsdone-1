CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
    
USE doingsdone;

CREATE TABLE projects (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` CHAR(128) NOT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL
);

CREATE TABLE tasks (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `completed_at` DATETIME DEFAULT NULL,
    `completed_status` INT(11) UNSIGNED,
    `name` CHAR(255) NOT NULL,
    `file_path` CHAR(255),
    `deadline` DATETIME  DEFAULT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `project_id` INT(11) UNSIGNED NOT NULL
);

CREATE TABLE users (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `email` CHAR(128) NOT NULL UNIQUE,
    `name` CHAR(255) NOT NULL,
    `password` CHAR(255)
);

CREATE INDEX p_user ON projects(user_id);
CREATE INDEX t_user ON tasks(user_id);
CREATE INDEX t_project ON tasks(project_id);