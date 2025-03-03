CREATE TABLE IF NOT EXISTS identity_verifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    document_path VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    admin_notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);