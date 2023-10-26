# Vigrom

## Установка

Следуйте этим шагам, чтобы установить и запустить проект локально на вашем компьютере.

1. **Клонировать репозиторий**

   ```bash
   git clone https://github.com/Odilbukh/Vigrom.git
2. **Перейти в директорию проекта**

   ```bash
   cd path-to-project
3. **Установить зависимости**
    ```bash
   composer install
4. **Настроить файл окружения**
   <br>Копируйте файл <b>.env.example</b> в <b>.env</b> и настройте его с вашими параметрами, такими как подключение к базе данных и другие настройки.
<br><b>Обратите внимание на эти поля и заполните их правильно!</b><br>
  DB_CONNECTION=mysql<br>
   DB_HOST=127.0.0.1<br>
   DB_PORT=3306<br>
   DB_DATABASE=<br>
   DB_USERNAME=<br>
   DB_PASSWORD=<br><br>
5. **Генерировать ключ приложения**
    ```bash
   php artisan key:generate
   
6. **Запустить миграции и наполнение базы данных**
    ```bash
    php artisan migrate
    php artisan db:seed
   
7. **Запустить сервер**
    ```bash
   php artisan serve      
Ваше приложение будет доступно по адресу: http://127.0.0.1:8000

# Использование

## Список API

### Транзакции (Transactions)

- **GET** `api/transactions` - Получить список транзакций.
- **POST** `api/transactions` - Создать новую транзакцию.
- **GET** `api/transactions/{id}` - Получить конкретную транзакцию.

### Пользователи (Users)

- **GET** `api/users` - Получить список пользователей.
- **POST** `api/users` - Создать нового пользователя.
- **GET** `api/users/{id}` - Получить конкретного пользователя.
- **PUT** `api/users/{id}` - Обновить информацию о пользователе.
- **DELETE** `api/users/{user}` - Удалить пользователя.

### Кошельки (Wallets)

- **GET** `api/wallets` - Получить список кошельков.
- **POST** `api/wallets` - Создать новый кошелек.
- **GET** `api/wallets/{id}` - Получить информацию о конкретном кошельке.
