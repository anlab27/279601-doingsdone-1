<?php

require_once('config.php');
require_once('functions.php');

date_default_timezone_set('Europe/Moscow');

$userId = 1;
$show_complete_tasks = rand(0, 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;
    
    $required = ['name', 'project'];
    $dict = ['name' => 'Название', 'project' => 'Проект', 'date' => 'Дата выполнения', 'preview' => 'Файл'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($task[$key])) {
            $errors[$key] = 'Это поле должно быть заполнено';
        }
    }
    
    if (isset($task['project'])) {
        $link = connectToMysql();
        $project = mysqli_real_escape_string($link, $task['project']);
        $sql = "SELECT * FROM projects WHERE id = '$project'";
        $res = mysqli_query($link, $sql);
        mysqli_close($link);
        
        if (!$res) {
            $errors['project'] = 'Указанный проект не найден';
        }
    }
    
//    if ($task['date'] === '') {
//    $task['date'] = NULL;
//     } 
//else {
//    $task['date'] = $task['date'];
//}
      
    
    if (isset($task['date'])) {
        if (validateDate($task['date'])) {
            $errors['date'] = 'Введите дату в формате ДД.ММ.ГГГГ';
        }
    }
    
    if (count($errors)) {
        $page_content = include_template('add.php', [
            'categories' => getProjects($userId),
            'task' => $task,
            'errors' => $errors,
            'dict' => $dict
        ]);
    } else {
        if (isset($_FILES['preview']['name'])) {
            $tmp_name = $_FILES['preview']['tmp_name'];
		    $path = $_FILES['preview']['name'];
        
            move_uploaded_file($tmp_name, 'uploads/' . $path);
            $task['path'] = $path;
        }
        
        $link = connectToMysql();
        $sql = 'INSERT INTO tasks (created_at, completed_status, name, file_path, deadline, user_id, project_id) VALUES (NOW(), 0, ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$task['name'], $task['path'], $task['date'], $userId, $task['project']]);
        $res = mysqli_stmt_execute($stmt);
        mysqli_close($link);
        
        if (!$res) {
            die('Ошибка MySQL ' . mysqli_stmt_error($stmt) . ' в файле ' . __FILE__ . ' в строке ' . __LINE__);
        } else {
            header("Location: /index.php");
        }       
        
    }
    
} else {
    $page_content = include_template('add.php', [
        'categories' => getProjects($userId)
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => getProjects($userId),
    'tasks' => getTasks($userId),
    'title' => 'Дела в порядке - добавление задачи'
    ]);

print($layout_content);