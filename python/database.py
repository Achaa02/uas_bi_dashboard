import os
from pathlib import Path
from sqlalchemy import create_engine
import mysql.connector

def get_env_credentials():
    env_path = Path(__file__).resolve().parent.parent / '.env'
    credentials = {
        'DB_HOST': '127.0.0.1',
        'DB_PORT': '3306',
        'DB_DATABASE': 'bi_dashboard',
        'DB_USERNAME': 'root',
        'DB_PASSWORD': ''
    }
    if env_path.exists():
        with open(env_path, 'r', encoding='utf-8') as f:
            for line in f:
                line = line.strip()
                if line and not line.startswith('#') and '=' in line:
                    key, val = line.split('=', 1)
                    key = key.strip()
                    val = val.strip().strip('"\'')
                    if key in credentials:
                        credentials[key] = val
    return credentials

def get_db_engine():
    c = get_env_credentials()
    user = c['DB_USERNAME']
    pwd = c['DB_PASSWORD']
    host = c['DB_HOST']
    port = c['DB_PORT']
    db = c['DB_DATABASE']
    connection_string = f"mysql+mysqlconnector://{user}:{pwd}@{host}:{port}/{db}"
    return create_engine(connection_string)

def get_mysql_connection():
    c = get_env_credentials()
    return mysql.connector.connect(
        host=c['DB_HOST'],
        port=int(c['DB_PORT']),
        user=c['DB_USERNAME'],
        password=c['DB_PASSWORD'],
        database=c['DB_DATABASE']
    )

if __name__ == '__main__':
    engine = get_db_engine()
    with engine.connect() as conn:
        print("Connected to MySQL database successfully via SQLAlchemy!")
