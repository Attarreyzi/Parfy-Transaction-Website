-- Migration: Add Midtrans columns to transactions table
-- Run this in phpMyAdmin or MySQL client

ALTER TABLE transactions 
ADD COLUMN snap_token VARCHAR(255) NULL AFTER payment_method,
ADD COLUMN midtrans_transaction_id VARCHAR(100) NULL AFTER snap_token,
ADD COLUMN updated_at TIMESTAMP NULL AFTER created_at;

-- Update existing rows
UPDATE transactions SET updated_at = created_at WHERE updated_at IS NULL;
