-- sample leads
INSERT INTO leads (name, email, phone, source, message) VALUES
('Himayya', 'himayya@example.com', '081234567890', 'utm_campaign=test1', 'This is a test lead');

-- sample error_logs
INSERT INTO error_logs (error_message, endpoint, status_code) VALUES
('Database connection error', '/api/leads', 500);
