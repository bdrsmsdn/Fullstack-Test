CREATE TABLE IF NOT EXISTS patients (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Sex ENUM('Male','Female') NOT NULL,
    Religion VARCHAR(50),
    Phone VARCHAR(20),
    Address TEXT,
    NIK VARCHAR(16) UNIQUE NOT NULL,
    CreatedTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO patients (Name, Sex, Religion, Phone, Address, NIK) VALUES
('Badra', 'Male', 'Islam', '081234567890', 'Jl. ABC', '3213213213213123'),
('Ananda', 'Female', 'Islam', '081234567891', 'JL. DEF', '3213213213122'),
('Rahmat', 'Male', 'Christian', '081234567892', 'Jl. GHI', '3213213123211');