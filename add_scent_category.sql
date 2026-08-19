-- Add scent_category column to products table
-- Run this SQL in your MySQL database (Azure MySQL Server)

ALTER TABLE products 
ADD COLUMN scent_category VARCHAR(50) DEFAULT NULL 
AFTER size;

-- Verify the column was added
DESCRIBE products;
