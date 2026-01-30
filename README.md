# Book Catalog

Каталог книг на Yii 1.x с Docker, RabbitMQ и SMS-уведомлениями.

## Требования

- Docker
- Docker Compose

### Клонирование репозитория
```bash
git clone https://github.com/petrrrnikitin/infotech-test-task.git
cd infotech-test-task
```

### Настройка окружения
```bash
cp .env.example .env
```

Заполните `.env`:
```env
# Database
DB_HOST=mysql
DB_NAME=book_catalog
DB_USER=root
DB_PASSWORD=secret

# RabbitMQ
RABBITMQ_HOST=rabbitmq
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest

# Gii
GII_PASSWORD=your_secure_password

# SMS Pilot API
SMSPILOT_API_KEY=your_api_key
```

### Запуск
```bash
docker-compose up -d --build
```

### Миграции
```bash
docker exec book-catalog-php php /var/www/html/protected/yiic.php migrate --interactive=0
```

### Тестовые данные
```bash
docker exec book-catalog-php php /var/www/html/protected/yiic.php seed
```
