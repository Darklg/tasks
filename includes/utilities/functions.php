<?php
/**
 * /tmp/phptidy-sublime-buffer.php
 *
 * @package default
 * @return unknown
 */


function get_bdd() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', 'root');
    }


    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }


    return $bdd;
}


/**
 * Get tasks
 *
 * @param array   $query (optional)
 * @return array
 */
function get_tasks($query = array()) {
    $bdd = get_bdd();

    $sql_query = 'SELECT * FROM tasks WHERE 1=1';

    if (isset($query['id']) && is_numeric($query['id'])) {
        $sql_query .= ' AND id = '.$query['id'];
    }

    if (isset($query['list_id']) && is_numeric($query['list_id'])) {
        $sql_query .= ' AND list_id = '.$query['list_id'];
    }
    $sql_query .= ' ORDER BY menu_order';
    $tasks = array();
    $reponse = $bdd->query($sql_query);
    while ($task = $reponse->fetch()) {
        $tasks[$task['id']] = $task;
    }
    $reponse->closeCursor();
    return $tasks;
}


/**
 * Update details of a task
 *
 * @param array   $datas (optional)
 */
function update_task($datas = array()) {

    $bdd = get_bdd();
    $fields = array();
    $request = array();
    if (isset($datas['content'])) {
        $request[] = 'content = ?';
        $fields[] = clean_task($datas['content']);
    }
    if (isset($datas['details'])) {
        $request[] = 'details = ?';
        $fields[] = $datas['details'];
    }
    if (isset($datas['id']) && is_numeric($datas['id'])) {
        $fields[] = $datas['id'];
    }
    if (!empty($request)) {
        $req = $bdd->prepare('UPDATE tasks SET '.implode('', $request).' WHERE id = ?');
        $req->execute($fields);
    }
}


/**
 * Returns the id for a new task
 *
 * @param array   $datas (optional)
 * @return int
 */
function new_task($datas = array()) {
    $bdd = get_bdd();
    $fields = array();
    $request = array();
    if (isset($datas['list_id']) && is_numeric($datas['list_id'])) {
        $fields[] = $datas['list_id'];
        $request[] = 'list_id';
    }

    if (!empty($request)) {
        $req = $bdd->prepare('INSERT INTO tasks('.implode('', $request).') VALUES (?)');
        $req->execute($fields);
        return $bdd->lastInsertId();
    }
    return 0;
}


/**
 * Delete a task
 *
 * @param int     $id
 * @return unknown
 */
function delete_task($id) {
    $bdd = get_bdd();
    if (is_numeric($id)) {
        $req = $bdd->prepare('DELETE FROM tasks WHERE id = ?');
        $req->execute(array($id));
        return 1;
    }
    return 0;
}


/* ----------------------------------------------------------
  Clean task
---------------------------------------------------------- */


/**
 * Clean task
 *
 * @param string $content
 */
function clean_task($content) {
    return trim(strip_tags($content));
}
