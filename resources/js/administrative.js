import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: parseInt(import.meta.env.VITE_REVERB_PORT),
    wssPort: parseInt(import.meta.env.VITE_REVERB_PORT),
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === "https",
    enabledTransports: ["ws", "wss"],
});

window.Echo.private('test').listen('.TestEvent', function (e) {
    console.log(e);
});

window.Echo.private('assistant.process').listen('.AssistantProcessEvent', function(e) {
    var command = e.process;
    var output = document.getElementById('command-output');

    if (!output) {
        output = createCommandDashboard();
    }

    var row = document.getElementById('action-command-' + command.id);

    if (row) {
        row.querySelector('.progress-number').textContent = command.progress + '%';
        if (row.className !== command.status) {
            row.className = command.status;
            createCommandButtons(row.querySelector('.button-actions'), command);
        }

        return;
    }

    output.prepend(createCommandRow(command));
});


window.Echo.private('assistant.command').listen('.AssistantCommandEvent', function(e) {
    var command = e.command;
    var console = document.getElementById('command-console');

    if (!console) {
        createCommandDashboard();
        console = document.getElementById('command-console');
    }

    var item = document.createElement('li');

    item.className = 'log-' + command.type;
    item.textContent = command.message;

    console.querySelector('ul').prepend(item);
    console.scrollTop = 0;
});

function createCommandDashboard() {
    var empty = document.querySelector('.console');

    if (empty) {
        empty.remove();
    }

    var row = document.querySelector('.row');
    var left = document.createElement('div');
    left.className = 'col-md-4';

    var box = document.createElement('div');
    box.className = 'box';

    var table = document.createElement('table');
    table.className = 'table table-hover';

    var thead = document.createElement('thead');
    var tr = document.createElement('tr');
    var th = document.createElement('th');
    th.colSpan = 2;
    th.textContent = 'Procesos';

    tr.append(th);
    thead.append(tr);

    var tbody = document.createElement('tbody');
    tbody.id = 'command-output';

    table.append(thead);
    table.append(tbody);
    box.append(table);
    left.append(box);

    var right = document.createElement('div');
    right.className = 'col-md-8';


    var console = document.createElement('div');
    console.id = 'command-console';
    console.className = 'console';

    var list = document.createElement('ul');
    list.className = 'list-unstyled';

    var item = document.createElement('li');
    var icon = document.createElement('i');
    icon.className = 'fal fa-code-simple text-secondary';

    item.append(icon);
    list.append(item);
    console.append(list);
    right.append(console);

    row.replaceChildren(left, right);

    return tbody;
}

function createCommandRow(command) {
    var row = document.createElement('tr');
    row.id = 'action-command-' + command.id;
    row.className = command.status;
    row.dataset.route = 'ver/' + command.id;
    row.dataset.overlapShow = '#overlap';
    var cell = row.insertCell();
    cell.append(command.id + ' ');
    cell.append(command.label + ' ');
    var percent = document.createElement('strong');
    percent.className = 'progress-number';
    percent.textContent = command.progress + '%';
    cell.append(percent);
    cell = row.insertCell();
    cell.width = 75;
    var actions = document.createElement('div');
    actions.className = 'button-actions button-actions-end';
    createCommandButtons(actions, command);
    cell.append(actions);
    return row;
}

function createCommandButtons(container, command) {
    container.replaceChildren();
    if (command.status === 'Activo') {
        var button = document.createElement('button');
        button.type = 'button';
        button.id = 'cancel-command-' + command.id;
        button.className = 'btn btn-link';
        button.dataset.route = 'cancelar/' + command.id;
        button.dataset.wenk = 'Detener';
        button.dataset.wenkPosition = 'left';
        var icon = document.createElement('i');
        icon.className = 'fal fa-circle-xmark';
        button.append(icon);
        container.append(button);
        return;
    }
    if (command.status === 'Cancelado') {
        var button = document.createElement('button');
        button.type = 'button';
        button.id = 'retry-command-' + command.id;
        button.className = 'btn btn-link';
        button.dataset.route = 'reintentar/' + command.id;
        button.dataset.wenk = 'Reintentar';
        button.dataset.wenkPosition = 'left';
        var icon = document.createElement('i');
        icon.className = 'fal fa-arrow-rotate-right';
        button.append(icon);
        container.append(button);
    }
}