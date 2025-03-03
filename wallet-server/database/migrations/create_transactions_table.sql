CREATE TABLE IF NOT EXISTS transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    wallet_id INT NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    type ENUM('deposit', 'withdrawal', 'transfer', 'payment') NOT NULL,
    recipient_id INT DEFAULT NULL,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (wallet_id) REFERENCES wallets(id),
    FOREIGN KEY (recipient_id) REFERENCES users(id)
);