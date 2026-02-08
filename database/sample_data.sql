USE tracker;

INSERT INTO clients (company_name, contact_name, email, phone, address)
VALUES ('Acme Co', 'Sara Ahmed', 'sara@acme.com', '+971 555-1234', 'Dubai, UAE');

INSERT INTO users (name, email, password_hash, role, client_id, twofa_enabled)
VALUES
('Admin User', 'admin@tracker.com', '$2y$12$ZCH2wh0h3xZ1vL9Zyxsj3uE0eGjt/FJSFntnG2B/zrESIa9VQ9t2S', 'admin', NULL, 1),
('Staff User', 'staff@tracker.com', '$2y$12$GcdPXzXljpLExDwVDNCf1.bC9GftEFq73amQ9cTEB8ZHR5E8F57cC', 'staff', NULL, 0),
('Client User', 'client@tracker.com', '$2y$12$VCzDKA3CPxJUiKbxWHW5meHp94rnzEYaPh3uf4fZGjv4.MnExPI2O', 'client', 1, 0);

INSERT INTO projects (client_id, name, description, status, progress_percent, public_token, start_date, due_date)
VALUES
(1, 'Website Redesign', 'Modern responsive redesign of company website.', 'Active', 65, 'TOKEN1234567890', '2024-01-15', '2024-06-30');

INSERT INTO project_staff (project_id, user_id)
VALUES (1, 2);

INSERT INTO phases (project_id, title, summary, due_date)
VALUES
(1, 'Discovery', 'Gather requirements and define scope.', '2024-02-01'),
(1, 'Design', 'Create UI/UX designs and prototypes.', '2024-03-01');

INSERT INTO tasks (phase_id, title, status, due_date, comments)
VALUES
(1, 'Stakeholder interviews', 'Done', '2024-01-25', 'Completed with client team.'),
(1, 'Technical audit', 'In Progress', '2024-01-31', 'Reviewing current stack.'),
(2, 'Homepage layout', 'To Do', '2024-02-15', 'Pending brand assets.');

INSERT INTO expenses (project_id, title, amount, incurred_at)
VALUES (1, 'Hosting plan', 120.00, '2024-01-20');

INSERT INTO invoices (project_id, invoice_number, amount, status, issued_at, due_at)
VALUES (1, 'INV-1001', 1500.00, 'Pending', '2024-02-01', '2024-02-15');

INSERT INTO notes (project_id, note, visibility, created_by)
VALUES
(1, 'Internal note about timeline risk.', 'private', 2),
(1, 'Client-facing update ready for review.', 'client', 2);

INSERT INTO passwords (project_id, label, username, password_encrypted, type)
VALUES (1, 'FTP Access', 'ftp_user', 'ENCRYPTED_SAMPLE', 'FTP');

INSERT INTO files (project_id, file_name, file_path, uploaded_by)
VALUES (1, 'requirements.pdf', 'storage/uploads/requirements.pdf', 2);

INSERT INTO messages (project_id, sender_id, message)
VALUES (1, 2, 'Kickoff meeting scheduled for Monday.');

INSERT INTO logs (user_id, action)
VALUES (1, 'Admin created project Website Redesign');
