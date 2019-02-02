<?php
declare(strict_types=1);

require_once('mysql_helper.php');

function include_template(string $name, array $data) : string {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function count_tasks(array $list_tasks, int $project) : int {
    $i = 0;
    
    foreach ($list_tasks as $value) {
        if (isset($value['project_id']) && $value['project_id'] === $project) {
            $i++;
        }
    }
    
    return $i;
}

function isLessThanDay(string $dateOfCompletion) : bool {
    if (($dateOfCompletion !== '') && ((strtotime($dateOfCompletion) + 86400 - time()) < 86400)) {
        return true;
    }
        return false;
}

function connectToMysql() {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_set_charset($link, "utf8");
    if (!$link) {
        die(mysqli_connect_error());
    }
    return $link;
}

function getProjects(int $id) : array {
    $link = connectToMysql();
    $sql = 'SELECT * FROM projects WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($link, $sql, [$id]);
    $categories = db_get_result_stmt($stmt);
    mysqli_close($link);
    return $categories;
}

function getTasks(int $userId, int $projectId = null) : array {
    $link = connectToMysql();
    $sql = 'SELECT * FROM tasks WHERE user_id = ?';
    $arguments = [$userId];
    if ($projectId !== null) {
        $sql .= ' AND project_id = ?';
        $arguments[] = $projectId;
    }
    $stmt = db_get_prepare_stmt($link, $sql, $arguments);
    $tasks = db_get_result_stmt($stmt);
    mysqli_close($link);
    return $tasks;
}

function validateDate($date, $format = 'd.m.Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}