CREATE TABLE trades (

id INTEGER PRIMARY KEY AUTOINCREMENT,

tanggal TEXT NOT NULL,

pair TEXT NOT NULL,

direction TEXT NOT NULL,

entry_price REAL NOT NULL,

sl REAL,

tp REAL,

exit_price REAL,

lot REAL,

profit_usd REAL DEFAULT 0,

hasil TEXT,

emotion TEXT,

note TEXT,

created_at DATETIME DEFAULT CURRENT_TIMESTAMP

);