CREATE DATABASE IF NOT EXISTS digital_wallet_DB;
USE digital_wallet_DB;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    address TEXT,
    role ENUM('user', 'admin') DEFAULT 'user',
    tier ENUM('basic', 'verified', 'premium') DEFAULT 'basic',
    verified_at DATETIME DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);