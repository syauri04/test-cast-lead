-- leads table
CREATE TABLE leads (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  source TEXT,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- error_logs table
CREATE TABLE error_logs (
  id SERIAL PRIMARY KEY,
  error_message TEXT NOT NULL,
  endpoint VARCHAR(255),
  status_code INTEGER,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
