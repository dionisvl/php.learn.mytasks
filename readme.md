# MyTasks
### Учебный проект
 - каждый пользователь может создавать задачи
 - админ может изменять 
 
 ### Требования
 - PHP >= 7.1
 - MySQL >= 5.6 
 
 ### Установка:
 - composer install
 - cp config.example.php config.php
 - Создать пустую БД
 - внести реквизиты доступа к БД в файл config.php
 - Выполнить SQL миграции из файла schema.sql
 

### Injection Dependency Container
(Service Container или IoC Container или Injector)  

Run:
http://localhost/testContainer.php
  
Sources:  
- Кратко о внедрение зависимостей и сервис контейнере https://tyapk.ru/blog/post/dependency-injection-and-service-container
- Как создать свой собственный Dependency Injection Container https://habr.com/ru/post/278049/
- https://github.com/sitepoint-editors/Container