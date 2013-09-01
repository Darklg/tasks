<?php

class displayList {


    /**
     *
     *
     * @param array   $tasks
     */
    function __construct($tasks) {
        $this->tasks = $tasks;
    }

    function display(){
        return $this->display_sublist(0);
    }

    /**
     *
     *
     * @param int     $parent
     * @return string
     */
    function display_sublist($parent) {
        $return = '';
        $tasks = array();
        foreach ($this->tasks as $id => $task) {
            if ($task['parent_id'] == $parent) {
                $tasks[$id] = $task;
            }
        }
        if (!empty($tasks)) {
            $return .= '<ul>';
            foreach ($tasks as $id =>$task) {
                $return .= '<li class="task-container">';
                $return .= $this->display_task($id);
                $child_tasks = $this->display_sublist($id);
                if (!empty($child_tasks)) {
                    $return .= $child_tasks;
                }
                $return .= '</li>';
            }
            $return .= '</ul>';
        }
        return $return;
    }


    /**
     *
     *
     * @param int     $id
     * @return string
     */
    function display_task($id) {
        $task = $this->tasks[$id];
        $return = '<textarea class="task" contenteditable data-id="'.$id.'" data-list-id="'.$task['list_id'].'">';
        $return .= $task['content'];
        $return .= '</textarea>';
        return $return;
    }

}
