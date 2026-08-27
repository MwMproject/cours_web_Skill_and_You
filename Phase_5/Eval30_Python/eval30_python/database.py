import sqlite3

class Database:
    def __init__(self):
        self.connection = sqlite3.connect('users.db')

    def __del__(self):
        self.connection.close()

    def create_table(self):
        cursor = self.connection.cursor()
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL
            )
        ''')
        self.connection.commit()