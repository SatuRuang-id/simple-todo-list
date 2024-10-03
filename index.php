<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List App Chesta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 60vw;=
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }

        .completed {
            text-decoration: line-through;
            color: #aaaaaa;
        }

        .card {
            width: 100%;
            padding: 20px;
            margin-top: 10px;
            background-color: #ffff;
            border-radius: 8px;
            box-shadow: 0px 1px 3px #787777;
            display: grid;
            grid-template-columns: auto 20%;
        }

        input {
            width: 80%;
            border-top: none;
            border-right: none;
            border-left: none;
            padding: 10px;
            outline-color: transparent;

        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Todo List</h1>
        <div>
            <input type="text" id="task" placeholder="Add a new task" autocomplete="off">
            <button onclick="addTask()">Add Task</button>
        </div>
        <ul id="todo-list"></ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            displayTasks();
        });

        function displayTasks() {
            const todoList = document.getElementById('todo-list');
            todoList.innerHTML = '';

            fetch('api.php') // Ganti dengan URL API sesuai dengan backend Anda
                .then(response => response.json())
                .then(data => {
                    data.forEach(task => {
                        const li = document.createElement('li');
                        const card = document.createElement('div');
                        card.classList.add("card");
                        const listTask = document.createElement('span');
                        listTask.textContent = task.task;
                        if (task.completed === '1') {
                            listTask.classList.add('completed');
                        }
                        const btnArea = document.createElement('div');
                        btnArea.innerHTML = `<button onclick="toggleTask(${task.id})">Check</button>
                        <button onclick="deleteTask(${task.id})">Hapus</button>`;

                        todoList.appendChild(li);
                        li.appendChild(card);
                        card.appendChild(listTask);



                        card.appendChild(btnArea)
                    });
                });
        }

        function addTask() {
            const taskInput = document.getElementById('task');
            const task = taskInput.value.trim();

            if (task !== '') {
                fetch('api.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            task
                        }),
                    })
                    .then(() => {
                        taskInput.value = '';
                        displayTasks();
                    });
            }
        }

        function toggleTask(id) {
            fetch(`api.php?id=${id}`, {
                    method: 'PUT',
                })
                .then(() => displayTasks());
        }

        function deleteTask(id) {
            fetch(`api.php?id=${id}`, {
                    method: 'DELETE',
                })
                .then(() => displayTasks());
        }
    </script>
</body>

</html>