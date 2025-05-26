# 🎓 Университетска система за разписание

Това е уеб приложение за управление и генериране на университетски разписания и презентации. Проектът включва регистрация, вход, и управление на потребителски данни чрез PHP и MySQL.

---

## 📁 Структура на проекта

```
Presentation-Generator/
├── index.html              # Основна страница с login/register интерфейс
├── dashboard.html          # Страница за визуализация на презентациите
├── style/
│   └── index.css           # CSS стилове за вход/регистрация
│   └── dashboard.css       # CSS стилове за визуализация на презентации
├── script/
│   ├── index.js            # Основна JS логика
│   └── dashboard.js        # Скрипт за зареждане на презентации
│   ├── login.js            # Скрипт за логин форма
│   ├── logout.js           # Скрипт за изход
│   └── register.js         # Скрипт за регистрация
├── php/
│   ├── api.php             # Главна точка за API заявки
│   ├── router.php          # Рутер на бекенда
│   ├── database.php        # Клас за MySQL свързаност
│   ├── database-setup/
│   │   └── db_schema_changelog.sql     # SQL скрипт за създаване на базата
│   │   └── database-destroy.sql        # SQL скрипт за изтриване на базата
│   ├── config/
│   │   └── config.ini      # Конфигурационен файл с достъп до базата и път до JSON файла
│   ├── repository/
│   │   ├── user.php         # Логика за потребители
│   │   └── presentation.php # Логика за презентации (добавяне, четене)
│   │   └── preference.php   # Логика за извличане на предпочитания на потребител
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
3. (По избор) Активирай възможност за .zip експорти:
   1. отиди в папка `xampp\php\` и потърси конфигурационен файл `php.ini`
   2. намери ред `;extension=zip` и премахни точката и запетаята в началото на реда, така че да стане `extension=zip`
   3. запази промените във файла
4. Стартирай Apache и MySQL от XAMPP Control Panel
5. Създай база данни `web_schedule` чрез phpMyAdmin, достъпвайки следната страница `http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=web_schedule&table=user`
6. Добави следната структура в `config/config.ini`:

```ini
[db]
host = 127.0.0.1
name = web_schedule
user = root
password =
```
7. (По избор) Попълни базата с примерни презентации като посетиш `http://localhost/Presentation-Generator/php/presentation/populate_presentations.php`
8. Посети `http://localhost/Presentation-Generator` в браузъра



---

## 🧪 Функционалности

- 🔐 Регистрация с валидация на данните
- 🔓 Вход с проверка и управление на сесии
- 🚪 Изход (logout)
- 💾 Свързване към база данни с PDO за по-сигурна работа
- 💡 Скриване и показване на форми чрез JavaScript за по-добро потребителско изживяване
- 📄 Визуализация на разписание във вид на HTML страница, подходяща за запазване като PDF (Print > Save as PDF)
- 📥 Експорт на разписание в CSV формат
- 📦 Експорт на разписание в ZIP архив с CSV файл

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
