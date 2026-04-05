# MVC Framework — Аспирантура

Простой MVC-фреймворк на PHP с собственной реализацией ядра, маршрутизации, middleware и аутентификации.

## 📋 Требования

- PHP 7.4+ / 8.0+
- MySQL 5.7+
- Composer
- Apache/Nginx (с поддержкой mod_rewrite)

## 🚀 Установка

1. **Клонируйте репозиторий:**
   ```bash
   git clone <repository-url>
   cd Checking_work1_Php
   ```

2. **Установите зависимости:**
   ```bash
   composer install
   ```

3. **Настройте базу данных:**
   Откройте файл `config/ex_db.php` и укажите параметры подключения:
   ```php
   return [
       'driver'    => 'mysql',
       'host'      => 'localhost',
       'port'      => 3306,
       'database'  => 'mvc',
       'username'  => 'root',
       'password'  => '',
       'charset'   => 'utf8mb4',
       'collation' => 'utf8mb4_unicode_ci',
       'prefix'    => '',
   ];
   ```

4. **Создайте базу данных:**
   ```sql
   CREATE DATABASE mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. **Настройте веб-сервер:**
   - Убедитесь, что документный корень указывает на корень проекта
   - Убедитесь, что модуль `mod_rewrite` включён (для Apache)

6. **Запустите проект:**
   ```
   http://localhost/Checking_work1_Php/go
   ```

## 📁 Структура проекта

```
Checking_work1_Php/
├── app/
│   ├── Controller/         # Контроллеры приложения
│   │   └── Site.php
│   ├── Middleware/         # Промежуточные обработчики
│   │   └── AuthMiddleware.php
│   └── Model/              # Модели данных (Eloquent ORM)
│       ├── Post.php
│       └── User.php
├── config/
│   ├── app.php             # Настройки приложения
│   ├── ex_db.php           # Настройки базы данных
│   └── path.php            # Настройки путей
├── core/
│   ├── Src/
│   │   ├── Auth/           # Компонент аутентификации
│   │   │   ├── Auth.php
│   │   │   └── IdentityInterface.php
│   │   ├── Traits/         # Переиспользуемые трейты
│   │   │   └── SingletonTrait.php
│   │   ├── Application.php # Точка входа приложения
│   │   ├── Middleware.php  # Система middleware
│   │   ├── Request.php     # Обработка HTTP-запроса
│   │   ├── Route.php       # Маршрутизация
│   │   ├── Session.php     # Работа с сессиями
│   │   ├── Settings.php    # Загрузка конфигурации
│   │   └── View.php        # Шаблонизатор
│   └── bootstrap.php       # Инициализация приложения
├── public/
│   ├── .htaccess
│   └── index.php           # Фронт-контроллер
├── routes/
│   └── web.php             # Определение маршрутов
├── views/
│   ├── layouts/
│   │   └── main.php        # Основной layout
│   └── site/
│       ├── hello.php
│       ├── login.php
│       ├── post.php
│       └── signup.php
├── composer.json
├── .htaccess
└── .gitignore
```

## 🛠️ Компоненты фреймворка

### Маршрутизация

Определение маршрутов в `routes/web.php`:

```php
use Src\Route;

// Простой маршрут
Route::add('GET', '/path', [Controller\Site::class, 'method']);

// Маршрут с middleware
Route::add('GET', '/protected', [Controller\Site::class, 'method'])
    ->middleware('auth');

// Несколько HTTP-методов
Route::add(['GET', 'POST'], '/form', [Controller\Site::class, 'handle']);

// Группировка маршрутов
Route::group('/admin', function() {
    Route::add('GET', '/dashboard', [AdminController::class, 'index']);
});
```

### Middleware

Создание middleware в `app/Middleware/`:

```php
namespace Middleware;

use Src\Request;

class ExampleMiddleware
{
    public function handle(Request $request)
    {
        // Логика middleware
        return $request;
    }
}
```

Регистрация в `config/app.php`:

```php
'routeMiddleware' => [
    'auth' => \Middleware\AuthMiddleware::class,
    'example' => \Middleware\ExampleMiddleware::class,
]
```

### Модели (Eloquent ORM)

ИспользованиеIlluminate Eloquent:

```php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'content'];
}
```

Использование в контроллере:

```php
use Model\Post;

// Получить все записи
$posts = Post::all();

// Поиск по условию
$post = Post::where('id', $id)->first();

// Создание
Post::create(['title' => 'Заголовок', 'content' => 'Текст']);
```

### Представления

Рендеринг в контроллере:

```php
use Src\View;

return new View('site.page', ['data' => $value]);
```

В шаблоне:

```php
<h2><?= $data ?? ''; ?></h2>
```

### Аутентификация

```php
use Src\Auth\Auth;

// Проверка авторизации
if (Auth::check()) {
    $user = Auth::user();
}

// Вход по учетным данным
Auth::attempt(['login' => $login, 'password' => $password]);

// Выход
Auth::logout();
```

### Редирект

```php
app()->route->redirect('/path');
```

## 📋 Предметная область

**Вариант 9: Аспирантура / Научный отдел**

Система для учёта научной деятельности аспирантов.

### Сущности

- **Аспиранты**
- **Научные руководители**
- **Диссертации** (тема, дата утверждения, статус, специальность ВАК)
- **Научные публикации** (название, издание, дата, индекс РИНЦ/Scopus)

### Роли пользователей

- **Администратор** — полный доступ к системе
- **Сотрудник научного отдела** — управление публикациями и отчётами

## 🔐 Безопасность

> **Внимание:** В текущей версии пароли хешируются алгоритмом MD5. Для production-окружения рекомендуется использовать `password_hash()` с алгоритмом bcrypt или argon2.

## 📝 Лицензия

MIT

## 👤 Автор

Artem Tulipov (dodo2larin@gmail.com)
