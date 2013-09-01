window.addEvent('domready', function() {
    edit_tasks_events();
});

/* ----------------------------------------------------------
  New task
---------------------------------------------------------- */

var new_task = function(el, relationship) {
    ajax_request('create', {
        'list_id': el.get('data-list-id')
    }, function(data) {
        var elInject = new Element('li.task-container');
        elInject.set('html', data);
        elInject.inject(el.getParent(), 'after');
        elInject.getChildren()[0].focus();
    });
};

/* ----------------------------------------------------------
  Delete task
---------------------------------------------------------- */

var delete_task = function(el) {
    ajax_request('delete', {
            id: el.get('data-id')
        },
        function(data) {
            if (data == 1) {
                el.getParent().remove();
            }
        });
};

/* ----------------------------------------------------------
  Edit Task
---------------------------------------------------------- */

var edit_tasks_events = function() {
    $$('.task-list').addEvents({
        'blur:relay(.task)': function() {
            edit_task($(this));
        },
        'keyup:relay(.task)': function(e) {
            if (e.code == 13) {
                edit_task($(this));
                new_task($(this));
                e.preventDefault();
            }
            else if ($(this).value === '') {
                delete_task($(this));
            }
        }
    });
};

var edit_task = function(el) {
    el.value = clean_task(el.value);
    ajax_request('update', {
        id: el.get('data-id'),
        content: el.value
    });
};

/* ----------------------------------------------------------
  Clean task
---------------------------------------------------------- */

var clean_task = function(text) {
    text = text.trim();
    text = text.stripScripts();
    text = text.clean();
    return text;
};
/* ----------------------------------------------------------
  AJAX
---------------------------------------------------------- */

var ajax_request = function(mode, datas, complete) {
    var data_send = Object.merge({}, datas, {
        'mode': mode
    });
    if (typeof complete === 'undefined') {
        complete = function(a) {
            console.log(mode, 'complete:', a);
        };
    }
    var req = new Request({
        method: 'get',
        url: '/tasks/ajax.php',
        data: data_send,
        onComplete: complete
    }).send();
};