-- SkillSwap Lite database (import this in phpMyAdmin)
CREATE DATABASE IF NOT EXISTS skillswap_lite;
USE skillswap_lite;

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  college VARCHAR(120) DEFAULT '',
  branch VARCHAR(60) DEFAULT '',
  year VARCHAR(10) DEFAULT '',
  skills_offered VARCHAR(255) DEFAULT '',
  skills_wanted VARCHAR(255) DEFAULT '',
  bio TEXT
);

CREATE TABLE IF NOT EXISTS requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  from_id INT NOT NULL,
  to_id INT NOT NULL,
  status VARCHAR(10) DEFAULT 'pending'
);
