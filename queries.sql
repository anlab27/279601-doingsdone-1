-- Добавление пользователей

INSERT INTO users SET email = 'anlab@mail.ru', name = 'Анастасия', password = 'xcdfrt56';
INSERT INTO users SET email = 'evgeniy2@mail.ru', name = 'Евгений', password = 'bnhjui89';
INSERT INTO users SET email = 'olga3@mail.ru', name = 'Ольга', password = 'cvdfer34';

-- Добавление списка проектов

INSERT INTO projects SET name = 'Входящие', user_id = 1;
INSERT INTO projects SET name = 'Учеба', user_id = 1;
INSERT INTO projects SET name = 'Работа', user_id = 1;
INSERT INTO projects SET name = 'Домашние дела', user_id = 1;
INSERT INTO projects SET name = 'Авто', user_id = 1;
INSERT INTO projects SET name = 'Английский', user_id = 2;
INSERT INTO projects SET name = 'SEO', user_id = 2;
INSERT INTO projects SET name = 'Книги', user_id = 2;

-- Добавление список задач

INSERT INTO tasks SET completed_status = 0, name = 'Собеседование в IT компании', deadline = '2018-12-02', user_id = 1, project_id = 3;
INSERT INTO tasks SET completed_status = 0, name = 'Выполнить тестовое задание', deadline = '2018-12-25', user_id = 1, project_id = 3;
INSERT INTO tasks SET completed_status = 1, name = 'Сделать задание первого раздела', deadline = '2018-12-21', user_id = 1, project_id = 2;
INSERT INTO tasks SET completed_status = 0, name = 'Встреча с другом', deadline = '2018-12-22', user_id = 1, project_id = 1;
INSERT INTO tasks SET completed_status = 0, name = 'Купить корм для кота', user_id = 1, project_id = 4;
INSERT INTO tasks SET completed_status = 0, name = 'Заказать пиццу', user_id = 1, project_id = 4;
INSERT INTO tasks SET completed_status = 0, name = 'Пройти тест на уровень владения английским', deadline = '2018-12-20', user_id = 2, project_id = 6;
INSERT INTO tasks SET completed_status = 0, name = 'Семь тучных лет', deadline = '2018-12-13', user_id = 2, project_id = 8;
INSERT INTO tasks SET completed_status = 0, name = 'Слепота', deadline = '2018-12-03', user_id = 2, project_id = 8;

-- Получить список из всех проектов для одного пользователя

SELECT * FROM projects WHERE user_id = 1;

-- Получить список из всех задач для одного проекта

SELECT * FROM tasks WHERE project_id = 3;

-- Пометить задачу как выполненную

UPDATE tasks SET completed_status = 1, completed_at = CURDATE() WHERE id = 4;

-- Получить все задачи для завтрашнего дня

SELECT * FROM tasks WHERE deadline = DATE_ADD(CURDATE(), INTERVAL 1 DAY);

-- Обновить название задачи по её идентификатору

UPDATE tasks SET name = 'Купить обратный билет на Ласточку' WHERE id = 5;
