# 🎓 Университетска система за разписание

Това е уеб приложение за управление и генериране на университетски разписания и презентации. Проектът включва регистрация, вход, и управление на потребителски данни чрез PHP и MySQL.

---

## 📁 Структура на проекта

```
Presentation-Generator/
├── index.html              # Основна страница с login/register интерфейс
├── dashboard.html          # Страница за презентациите
├── style/
│   └── index.css           # Стилове за интерфейса
├── script/
│   └── index.js            # JavaScript логика за динамична работа с формите
│   └── login.js            # JavaScript логика за динамична работа с формите
│   └── logout.js           # JavaScript логика за динамична работа с формите
│   └── register.js         # JavaScript логика за динамична работа с формите
├── php/
│   ├── api.php             # Начална точка за всички заявки
│   ├── router.php          # Насочва заявките към съответните функции
│   ├── database.php        # Клас за работа с MySQL базата
│   ├── database-setup/     # db ddl commands for creation
│   │   └── db_schema_changelog.sql     # for db setup view the config.ini file in backend folder
│   ├── config/
│   │   └── config.ini      # Конфигурация за достъп до базата
│   ├── repository/
│   │   ├── user.php        # Клас за потребителски операции
│   ├── user_access/
│   │   ├── login.php       # Вход логика
│   │   ├── register.php    # Регистрация логика
│   │   └── logout.php      # Изход логика
│   └── utility.php         # Помощни функции за валидация
```

---

## 🚀 Как да стартираш проекта

1. Инсталирай [XAMPP](https://www.apachefriends.org/)
2. Копирай проекта в `htdocs/` директорията на XAMPP
3. Създай база данни `web_schedule` чрез phpMyAdmin
4. Добави следната структура в `config/config.ini`:

```ini
[db]
host = 127.0.0.1
name = web_schedule
user = root
password =
```

5. Стартирай Apache и MySQL от XAMPP
6. Посети `http://localhost/Presentation-Generator` в браузъра

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
