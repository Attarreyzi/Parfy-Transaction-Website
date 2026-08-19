-- Create user_addresses table
CREATE TABLE IF NOT EXISTS user_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    label VARCHAR(100),
    name VARCHAR(100),
    phone VARCHAR(20),
    street TEXT,
    city VARCHAR(100),
    city_id VARCHAR(100),
    province VARCHAR(100),
    province_id VARCHAR(100),
    postal_code VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(user_id)
);
