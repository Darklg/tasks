<?php
/**
 * /tmp/phptidy-sublime-buffer.php
 *
 * @package default
 */

include dirname( __FILE__ ).'/includes/header.php';
$tasks = get_tasks(array('list_id' => 1));
$task_list = new displayList($tasks);
?>
<!DOCTYPE HTML>
<html lang="fr-FR">
    <head>
    <script src="//ajax.googleapis.com/ajax/libs/mootools/1.4/mootools-yui-compressed.js"></script>
    <script src="assets/events.js"></script>
    <meta charset="UTF-8" />
    <title>Tasks</title>
    <style>
* {
    margin: 0;
    line-height: 1.2;
}

body {
    padding: 20px;
}

.task {
    height: 15px;
    overflow: hidden;
    white-space: nowrap;
    resize: none;
}
    </style>
    </head>
    <body>
        <div class="task-list">
            <?php echo $task_list->display(); ?>
        </div>
    </body>
</html>
