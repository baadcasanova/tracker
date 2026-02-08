CREATE DATABASE IF NOT EXISTS tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tracker;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'client') NOT NULL,
    client_id INT NULL,
    twofa_enabled TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    status ENUM('Active', 'On Hold', 'Completed') DEFAULT 'Active',
    progress_percent INT DEFAULT 0,
    public_token VARCHAR(64) UNIQUE NOT NULL,
    start_date DATE,
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

CREATE TABLE project_staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE phases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    summary TEXT,
    due_date DATE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phase_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    status ENUM('To Do', 'In Progress', 'Done') DEFAULT 'To Do',
    due_date DATE,
    comments TEXT,
    FOREIGN KEY (phase_id) REFERENCES phases(id) ON DELETE CASCADE
);

CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    incurred_at DATE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    invoice_number VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Paid', 'Overdue') DEFAULT 'Pending',
    issued_at DATE,
    due_at DATE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    note TEXT NOT NULL,
    visibility ENUM('private', 'client') DEFAULT 'private',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE passwords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    label VARCHAR(150) NOT NULL,
    username VARCHAR(150) NOT NULL,
    password_encrypted TEXT NOT NULL,
    type ENUM('Hosting', 'FTP', 'Emails') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    uploaded_by INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
