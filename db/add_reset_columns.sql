-- Thêm các cột cho chức năng reset password
ALTER TABLE users 
ADD COLUMN reset_code VARCHAR(6) NULL AFTER last_login,
ADD COLUMN reset_expiry DATETIME NULL AFTER reset_code,
ADD COLUMN reset_token VARCHAR(64) NULL AFTER reset_expiry;

-- Thêm index cho reset_code
ALTER TABLE users ADD INDEX idx_reset_code (reset_code);

SELECT '✅ Đã thêm các cột reset_code, reset_expiry, reset_token vào bảng users' as status;
