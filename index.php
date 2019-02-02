<?php

require_once('config.php');
require_once('functions.php');

date_default_timezone_set('Europe/Moscow');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$userId = 1;

if (!isset($_GET['project_id'])) {
    $title = 'Дела в порядке';
    $page_content =  include_template('index.php', [
        'tasks' => getTasks($userId),
        'show_complete_tasks' => $show_complete_tasks        
    ]);
} else {
    $tasks = getTasks($userId, (int) $_GET['project_id']);
    if (count($tasks) === 0) {
        $title = '404';
        http_response_code(404);
        $page_content = '404 - Страница не найдена';
    } else {
        $title = 'Дела в порядке - задачи по проекту';
        $page_content = include_template('index.php', [
            'tasks' => getTasks($userId, $_GET['project_id']),
            'show_complete_tasks' => $show_complete_tasks
        ]);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => getProjects($userId),
    'tasks' => getTasks($userId),
    'title' => $title
    ]);

print($layout_content);