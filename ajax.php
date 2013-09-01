<?php
/**
 * AJAX
 *
 * @package default
 */


include dirname( __FILE__ ).'/includes/header.php';

if (!isset($_GET['mode'])) {
    die;
}

switch ($_GET['mode']) {
case 'update':
    update_task($_GET);
    break;
case 'delete':
    echo delete_task($_GET['id']);
    break;
case 'create':
    $new_task = new_task($_GET);
    $tasks = get_tasks(array('id' => $new_task));
    $task_list = new displayList($tasks);
    echo $task_list->display_task($new_task);
    break;
default:
    die;
}
