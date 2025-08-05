-- Création de la base de données et utilisateur admin
DROP DATABASE IF EXISTS inventory_manager;
CREATE DATABASE IF NOT EXISTS inventory_manager DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventory_manager;

-- Table des utilisateurs (admins/employés)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee') NOT NULL DEFAULT 'employee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des entrepôts
CREATE TABLE warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des employés (liés à un entrepôt)
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE CASCADE
);

-- Table des produits
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table d'inventaire par entrepôt
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    product_id INT,
    quantity INT DEFAULT 0,
    UNIQUE (warehouse_id, product_id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
-- Table d'historique des transactions
CREATE TABLE transaction_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    product_id INT NOT NULL,
    warehouse_id_from INT DEFAULT NULL,
    warehouse_id_to INT DEFAULT NULL,
    operation_type ENUM('transfert', 'ajout', 'suppression', 'modification') NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (warehouse_id_from) REFERENCES warehouses(id) ON DELETE SET NULL,
    FOREIGN KEY (warehouse_id_to) REFERENCES warehouses(id) ON DELETE SET NULL
);

-- Insertion de l'utilisateur admin par défaut, mot de passe = admin
INSERT INTO users (name, email, password, role)
VALUES (
  'admin',
  'admin@example.com',
  '$2y$10$DbLT1BfAZpJZObXSHN0GReWAkkzhrCnW2W3oWZl09MO6MrZuXMN/e', 
  'admin'
);