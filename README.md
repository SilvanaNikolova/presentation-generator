# 🎓 Университетска система за разписание

Това е уеб приложение за управление и генериране на университетски разписания и презентации. Проектът включва регистрация, вход, и управление на потребителски данни чрез PHP и MySQL.

---

## 📁 Структура на проекта

```
Presentation-Generator/
├── index.html              # Основна страница с login/register интерфейс
├── dashboard.html          # Страница за визуализация на презентациите
├── style/
│   └── index.css           # CSS стилове
├── script/
│   ├── index.js            # Основна JS логика
│   ├── login.js            # Скрипт за логин форма
│   ├── logout.js           # Скрипт за изход
│   └── register.js         # Скрипт за регистрация
├── php/
│   ├── api.php             # Главна точка за API заявки
│   ├── router.php          # Рутер на бекенда
│   ├── database.php        # Клас за MySQL свързаност
│   ├── database-setup/
│   │   └── db_schema_changelog.sql     # SQL скрипт за създаване на базата
│   ├── config/
│   │   └── config.ini      # Конфигурационен файл с достъп до базата и път до JSON файла
│   ├── repository/
│   │   ├── user.php        # Логика за потребители
│   │   └── presentation.php # Логика за презентации (добавяне, четене)
│   ├── presentation/
│   │   └── populate_presentations.php  # Скрипт за попълване на презентации от JSON
│   ├── user_access/
│   │   ├── login.php       # Логин логика
│   │   ├── register.php    # Регистрация логика
│   │   └── logout.php      # Изход логика
│   └── utility.php         # Помощни функции
```

---

## 🚀 Как да стартираш проекта

1. Инсталирай [XAMPP](https://www.apachefriends.org/)
2. Копирай проекта в `htdocs/` директорията на XAMPP
3. Стартирай Apache и MySQL от XAMPP Control Panel
4. Създай база данни `web_schedule` чрез phpMyAdmin
5. Добави следната структура в `config/config.ini`:

```ini
[db]
host = 127.0.0.1
name = web_schedule
user = root
password =
```

6. (По избор) Попълни базата с примерни презентации като посетиш `http://localhost/Presentation-Generator/php/presentation/populate_presentations.php`
7. Посети `http://localhost/Presentation-Generator` в браузъра

---

## 🧪 Функционалности

- 🔐 Регистрация с валидация
- 🔓 Вход с проверка и сесия
- 🚪 Изход
- 💾 Свързване към база данни с PDO
- 💡 Скриване и показване на форми чрез JavaScript

---

## 👩‍💻 Разработка

- PHP 8.x
- MySQL / MariaDB
- JavaScript (ES6 modules)
- CSS Flexbox + animation

---

## 📌 Бележки

- Формите са скрити по подразбиране и се показват само при натискане на бутон.
- Валидирането и съобщенията се обработват и на клиентско, и на сървърно ниво.

---
