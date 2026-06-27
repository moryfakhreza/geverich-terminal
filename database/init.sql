CREATE TABLE IF NOT EXISTS trades (

id INTEGER PRIMARY KEY AUTOINCREMENT,

tanggal TEXT,

arah TEXT,

entry_price REAL,

sl_price REAL,

tp_price REAL,

lot REAL,

hasil TEXT,

profit_usd REAL,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);