-- =====================================================
-- PARFY.ID Database Schema for MySQL
-- PHP 8.2.12 + XAMPP
-- =====================================================

CREATE DATABASE IF NOT EXISTS parfy_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE parfy_db;

-- =====================================================
-- Table: users
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    phone VARCHAR(20) DEFAULT '',
    gender VARCHAR(20) DEFAULT NULL,
    birth_date DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- Table: user_addresses
-- =====================================================
CREATE TABLE IF NOT EXISTS user_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    label VARCHAR(50),
    name VARCHAR(100),
    phone VARCHAR(20),
    street TEXT,
    city VARCHAR(100),
    city_id VARCHAR(10),
    province VARCHAR(100),
    province_id VARCHAR(10),
    postal_code VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Table: products
-- =====================================================
CREATE TABLE IF NOT EXISTS products (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(100),
    category ENUM('Pria', 'Wanita', 'Unisex') DEFAULT 'Unisex',
    price INT NOT NULL DEFAULT 0,
    stock INT DEFAULT 0,
    size VARCHAR(20),
    aroma TEXT,
    description TEXT,
    image VARCHAR(500),
    sold INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- Table: carts
-- =====================================================
CREATE TABLE IF NOT EXISTS carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    product_id VARCHAR(20) NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_cart_item (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Table: transactions
-- =====================================================
CREATE TABLE IF NOT EXISTS transactions (
    id VARCHAR(20) PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    user_name VARCHAR(100),
    total INT DEFAULT 0,
    shipping_cost INT DEFAULT 0,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'lunas') DEFAULT 'pending',
    payment_method VARCHAR(50) DEFAULT 'QRIS',
    shipping_address TEXT,
    cancel_reason TEXT,
    cancelled_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Table: transaction_items
-- =====================================================
CREATE TABLE IF NOT EXISTS transaction_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id VARCHAR(20) NOT NULL,
    product_id VARCHAR(20),
    product_name VARCHAR(255),
    quantity INT DEFAULT 1,
    price INT DEFAULT 0,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Table: reviews
-- =====================================================
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    product_id VARCHAR(20) NOT NULL,
    rating INT CHECK(rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Insert Default Admin User
-- Password: admin123 (hashed with password_hash)
-- =====================================================
INSERT INTO users (id, name, email, password, role, created_at) VALUES
('user-001', 'Admin PARFY', 'admin@parfy.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW());

-- =====================================================
-- Insert Sample Products (from products.json)
-- =====================================================
INSERT INTO products (id, name, brand, category, price, stock, size, aroma, description, image, sold) VALUES
('PRD001', 'Mykonos – Stilettos Eau de Parfum 50ml', 'Mykonos', 'Wanita', 170000, 24, '50ml', 'Musky, Fruity, Bold, Sweet', 'Top notes: red fruits, citrus; middle notes: floral bouquet; base notes: musk, amber, vanilla. Daya tahan ±6–8 jam.', 'https://placehold.co/300x300/e91e63/white?text=Stilettos', 46),
('PRD002', 'Mykonos – Baby Love Eau de Parfum 50ml', 'Mykonos', 'Unisex', 135000, 28, '50ml', 'Powdery, Clean, Fresh, Soapy', 'Top notes: citrus, aldehydes; middle notes: white florals; base notes: powdery notes, musk. Daya tahan 5–7 jam.', 'https://placehold.co/300x300/ffb6c1/333?text=Baby+Love', 40),
('PRD003', 'Mykonos – Blossom Eau de Parfum 50ml', 'Mykonos', 'Wanita', 140000, 14, '50ml', 'Floral, Feminine, Soft, Sweet', 'Top notes: bergamot, mandarin; middle notes: rose, peony, jasmine; base notes: musk, amber. Daya tahan ±6–8 jam.', 'https://placehold.co/300x300/ff69b4/white?text=Blossom', 53),
('PRD004', 'Mykonos – Pink Beach Eau de Parfum 50ml', 'Mykonos', 'Wanita', 140000, 18, '50ml', 'Fruity, Fresh, Sweet, Tropical', 'Top notes: citrus, red berries; middle notes: tropical fruits; base notes: musk, soft woods. Daya tahan ±5–7 jam.', 'https://placehold.co/300x300/ff7f50/white?text=Pink+Beach', 33),
('PRD005', 'Mykonos – Utopia Eau de Parfum 100ml', 'Mykonos', 'Unisex', 314000, 15, '100ml', 'White Floral, Fresh, Aquatic', 'Top notes: bergamot, white tea, citrus; middle notes: ylang-ylang, iris, jasmine sambac; base notes: aquatic notes, musk. Daya tahan 6–8 jam.', 'https://placehold.co/300x300/87ceeb/333?text=Utopia', 28),
('PRD006', 'Mykonos – XOXO Rosy Eau de Parfum 50ml', 'Mykonos', 'Wanita', 150000, 20, '50ml', 'Rose, Floral, Citrus, Powdery', 'Top notes: citrus; middle notes: rose, floral bouquet; base notes: powdery notes, musk. Daya tahan ±6–8 jam.', 'https://placehold.co/300x300/db7093/white?text=XOXO+Rosy', 43),
('PRD007', 'Mykonos – Sparkling Rosé Eau de Parfum 100ml', 'Mykonos', 'Wanita', 280000, 10, '100ml', 'Rose, Fruity, Floral, Sweet', 'Top notes: rose, plum; middle notes: floral notes; base notes: patchouli, musk, amber. Daya tahan 6–8 jam.', 'https://placehold.co/300x300/c71585/white?text=Sparkling+Rose', 21),
('PRD008', 'Mykonos – Moroccan Vanilla Eau de Parfum 100ml', 'Mykonos', 'Unisex', 290000, 14, '100ml', 'Vanilla, Rose, Warm, Sweet', 'Top notes: Moroccan vanilla, Bulgarian rose; middle notes: lemon, floral notes; base notes: white musk, vanilla. Daya tahan ±8–10 jam.', 'https://placehold.co/300x300/d2691e/white?text=Moroccan+Vanilla', 35),
('PRD009', 'Mykonos – Down to Earth Extrait de Parfum 50ml', 'Mykonos', 'Unisex', 160000, 16, '50ml', 'Green, Earthy, Fresh, Woody', 'Top notes: green grass, citrus; middle notes: wet leaves accords; base notes: earthy woods, musk. Daya tahan 8–10 jam.', 'https://placehold.co/300x300/228b22/white?text=Down+to+Earth', 27),
('PRD010', 'Mykonos – California Signature Eau de Parfum 100ml', 'Mykonos', 'Unisex', 450000, 7, '100ml', 'Fresh, Citrus, Aquatic, Slightly Sweet', 'Top notes: lemon, bergamot, sea breeze; middle notes: neroli, white florals; base notes: musk, driftwood. Daya tahan ±6–8 jam.', 'https://placehold.co/300x300/ffd700/333?text=California', 16),
('PRD011', 'HMNS – ORGSM Eau de Parfum 100ml', 'HMNS', 'Unisex', 350000, 19, '100ml', 'Fruity, Floral, Vanilla, Sweet, Warm', 'Top notes: red apple; middle notes: rose, jasmine, peony; base notes: vanilla beans, amber. Daya tahan ±6–8 jam.', 'https://placehold.co/300x300/8b0000/white?text=ORGSM', 90),
('PRD012', 'HMNS – Essence of the Sun (EOS) Eau de Parfum 100ml', 'HMNS', 'Unisex', 370000, 18, '100ml', 'Warm, Solar, Creamy, Citrus-Floral', 'Top notes: bergamot, coriander seeds, pink pepper; middle notes: jasmine sambac, Turkish rose, tiare flower; base notes: tonka bean, ambrette, cedarwood. Daya tahan 6–8 jam.', 'https://placehold.co/300x300/ff8c00/white?text=EOS', 67),
('PRD013', 'HMNS – The Perfection Eau de Parfum 100ml', 'HMNS', 'Pria', 385000, 15, '100ml', 'Spicy Fougere, Woody, Aromatic, Masculine', 'Top notes: bergamot, elemi, Indonesian clove, nutmeg; middle notes: lavender, tagetes, lily of the valley; base notes: driftwood, sandalwood, leather. Daya tahan ±7–9 jam.', 'https://placehold.co/300x300/2f4f4f/white?text=The+Perfection', 54),
('PRD014', 'HMNS – Alpha Eau de Parfum 100ml', 'HMNS', 'Pria', 307000, 22, '100ml', 'Citrus, Green, Fresh, Tea, Woody', 'Top notes: citrus, grass; middle notes: green tea, woody accords; base notes: cedarwood, vetiver. Daya tahan 5–7 jam.', 'https://placehold.co/300x300/006400/white?text=Alpha', 48),
('PRD015', 'HMNS – Farhampton Extrait de Parfum 100ml', 'HMNS', 'Pria', 355000, 12, '100ml', 'Fresh, Aromatic, Amber, Woody, Masculine', 'Top notes: bergamot, ripe fruit; middle notes: lavender, orange blossom; base notes: labdanum amber, cedar wood, tonka bean. Daya tahan ±8–10 jam.', 'https://placehold.co/300x300/4682b4/white?text=Farhampton', 42),
('PRD016', 'HMNS – Darker Shade of ORGSM Eau de Parfum 100ml', 'HMNS', 'Unisex', 365000, 14, '100ml', 'Smoky, Gourmand, Vanilla, Caramel, Woody', 'Top notes: orange blossom, apple, pepper; middle notes: cypriol, caramel, patchouli; base notes: vanilla beans, cedarwood, amber, vetiver. Daya tahan 7–9 jam.', 'https://placehold.co/300x300/4b0082/white?text=Darker+ORGSM', 61),
('PRD017', 'HMNS – Unrosed Eau de Parfum 100ml', 'HMNS', 'Unisex', 365000, 16, '100ml', 'Musky, Earthy, Woody', 'Rose tanpa mawar - Abstract floral accord dengan earthy notes dan musky woody base. Daya tahan ±6–8 jam.', 'https://placehold.co/300x300/708090/white?text=Unrosed', 37),
('PRD018', 'HMNS – Addict Eau de Parfum 100ml', 'HMNS', 'Unisex', 369000, 19, '100ml', 'Sweet, Gourmand, Warm, Fruity-Floral', 'Top notes: berry; middle notes: red rose, coffee; base notes: patchouli, amber, tonka beans. Daya tahan ±6 jam.', 'https://placehold.co/300x300/800020/white?text=Addict', 55),
('PRD019', 'HMNS – The Prestige Eau de Parfum 100ml', 'HMNS', 'Pria', 398000, 10, '100ml', 'Tobacco, Spicy, Woody, Masculine', 'Top notes: grapefruit, pink pepper; middle notes: tobacco leaves, aromatic spices; base notes: woody amber, musk. Daya tahan 7–9 jam.', 'https://placehold.co/300x300/1a1a2e/white?text=The+Prestige', 31),
('PRD020', 'HMNS – Ambar Janma Eau de Parfum 100ml', 'HMNS', 'Pria', 510000, 8, '100ml', 'Ambery, Warm, Spicy, Woody', 'Top notes: citrus and spices; middle notes: warm resinous amber; base notes: woods, musk. Daya tahan ±7–9 jam.', 'https://placehold.co/300x300/b8860b/white?text=Ambar+Janma', 22);
