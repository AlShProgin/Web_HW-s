# Отчет по итоговому проекту "Многостраничное веб-приложение на Symfony"  
## Описание предметной области  
**Моделируемая система** чат-форум, надстройка над предыдущими лабораторными  
  
**Перечень объектов**  
--*Нотация (<>/<>) отражает название таблицы в БД и соответствующего ей класса в php
1. пользователь (user/User); 
2. сообщения (message/Message);
3. чаты (chat/Chat);
4. история имен пользователей (username_record/UsernameRecord);
5. системные ошибки (error_code/ErrorCode);
6. связка юзер-чат (user_chat_list/UserChatList)).
[схема](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/FinalProjectDS.png)  
  
**Краткая характеристика системы**   
    Сайт моделирует работу простого чат-форума, предоставляющего возможности пользователям как писать в общий, глобальный чат, так и пользоваться беседами/чатами, предоставляющими возможность общаться выбранным пользователям. Перед началом работы каждый пользователь должен пройти авторизацию, а при отсутствии аккаунта - создать его. После авторизации становится доступно рабочее пространство пользователя, из которого можно просмотреть глобальный чат и свои собственные сообщения в нем и отправить новое сообщение. Там же расположен переход в личный профиль, где можно поменять свои логин/пароль, а также посмотреть историю своих имен (все ранее использованные имена).  
    Возможность удалить свой аккаунт или свои сообщения не предусмотрена, как и возможность у пользователелей создавать чаты и приглашать туда других пользователей.  
    
**Зависимости между объектами**  
+ Каждый пользователь *может* отправить *одно или много* сообщений - как в глобальный чат, так и "локальные";
+ Каждое сообщение *обязательно* привязано к некоторому пользователю, *опционально* - к некоторому чату;
+ Каждая история некнеймов *обязательно* привязана к некоторому пользователю;
+ Пользователь *может* иметь *множество* историй никнеймов;
+ Каждый чат *обязательно* создается для *одного или нескольких* пользователей;
+ Каждый пользователь *может* быть участником *одного или нескольких* чатов;
+ Системные ошибки существуют сами по себе и, честно говоря, могли иметь лучшую программную реализацию, не таблицу (возникает привязка обработки ошибок на все сайте к конкретной БД, что не есть хорошо).
## Описание реализации  
**Перечень возможностей**  
Обобщая описание системы, можно выделить следующие действия, доступные пользователям:  
+ создание аккаунта ( пара <логин>/<пароль> );
+ вход в аккаунт по логину/паролю;
+ выход из аккаунта;
+ просмотр истории сообщений глобального чата;
+ отправка сообщений в глобальный чат;
+ просмотр своих сообщений в глобальном чате;
+ переход в доступные личные переписки/собрания и просмотр сообщений в них, без возможности отправки - не сложно, но не сделано (беседы созданы системой заранее для конкретных пользователей);
+ переход в профиль пользователя с возможностью просмотра своей истории имен;
+ смена имени;
+ смена пароля.
**Структура сайта**  
Проект представляет из себя сайт с адресом http://localhost:4001 (увы, локальный). Описанные выше возможности распределены между 5-ю страницами:
1. [страница авторизации](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/1_StartingPage.png) (/loggedOut);

2. [страница создания аккаунта](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/4_SignInPage.png) (/signIn);

3. [рабочее пространство](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/5_UserWorkSpace.png) (/loggedIn);

4. [личный профиль](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/10_ProfileSettings.png) (/profile);

5. [чат](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/9_ChatMsgs.png) (/chat/{id}); 
 
\*Примечение: подстраивание шаблонных страниц "рабочее пространство" и "профиль" под конкретного пользователя происходит посредством чтения имени пользователя, хранящегося в cookie, которое попадает туда лишь в процессе авторизации. Переход в чаты же возможен при добавлении адреса запроса /chat/{id}, где id - идентификатор чата в БД. Данная уязвимость ничем не обоснована и могла решиться как хранением id в cookie, так и передачей id в контроллер через post-форму с последующей маршрутизацией. 
  
**Демонстрация работы заявленного функционала**  
Далее представлен список ситуаций, возникающих в ходе использование возможностей сайта, с показательными скриншотами:  
1. начальная страница:
    1. [общий вид](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/1_StartingPage.png)
    2. [неверный логин](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/2_LoginDenied.png)
    3. [неверный пароль](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/3_PasswordDenied.png)
2. окно создание профиля:
    1. [общий вид](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/4_SignInPage.png)
3. рабочее пространство пользователя:
    1. [общий вид](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/5_UserWorkSpace.png)
    1. [все сообщения](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/6_AllMsgs.png)
    2. [собственные сообщения](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/7_PersonalMsgs.png)
    3. [добавление сообщения](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/8_PostingMsg.png)
4. беседа:
    1. [общий вид](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/9_ChatMsgs.png)
5. личный профиль:
    1. [общий вид](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/10_ProfileSettings.png)
    2. [форма изменения имени](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/11_ChangingName.png)
    3. [форма изменения пароля](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/12_ChangingPassword.png)
    4. [пароль непринят](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/13_PswdChangeDenied.png)
    5. [пароль непринят v2](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/14_PswdChangeDenied2.png)
    6. [меняем имя](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/15_NameChange.png)
    7. [имя изменено успешно](https://github.com/AlShProgin/imageSource/blob/main/FinalProject_SS/16_NameChangeDone.png)
