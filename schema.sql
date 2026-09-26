CREATE DATABASE IF NOT EXISTS demo_sqli;
USE demo_sqli;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS products;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  category VARCHAR(50) NOT NULL
);

INSERT INTO users (username, password, role, email) VALUES
('administrator', 'AdminNusantara2026#', 'Administrator', 'admin@nusantara-tech.co.id'),
('budi.santoso', 'BudiSantoso99!', 'Client', 'budi.santoso@client-corp.id'),
('siti.rahma', 'SitiRahmaClient#88', 'Client', 'siti.rahma@mandiri-logistik.co.id'),
('agus.prasetio', 'AgusPass_2026', 'Staff', 'agus.p@nusantara-tech.co.id'),
('dewi.lestari', 'DewiLestariSecure$', 'Client', 'dewi@mitra-sejahtera.com');

INSERT INTO products (name, description, price, category) VALUES
('Nusantara Enterprise ERP Suite', 'Solusi terintegrasi pengelolaan resource perusahaan skala menengah hingga besar.', 15000000.00, 'Software'),
('Cloud Server Management Console', 'Panel kontrol mandiri untuk monitoring VPS dan cloud cluster perusahaan.', 4500000.00, 'Cloud Services'),
('Secure Gateway VPN Appliance', 'Perangkat enkripsi jaringan untuk koneksi kantor cabang jarak jauh.', 8500000.00, 'Hardware & Security'),
('Automated Backup & Disaster Recovery', 'Sistem backup otomatis dengan enkripsi tingkat militer ke cloud storage.', 3200000.00, 'Data Security'),
('AI Customer Support Bot API', 'Integrasi layanan pelanggan cerdas berbasis LLM untuk e-commerce.', 6000000.00, 'Artificial Intelligence');
