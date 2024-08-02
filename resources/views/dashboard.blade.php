<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .board {
            display: flex;
            gap: 20px;
        }
        .column {
            flex: 1;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
        }
        .column h2 {
            margin-top: 0;
        }
        .todo-item {
            background: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .todo-item button {
            border: none;
            background: transparent;
            cursor: pointer;
            color: #ff0000;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadTodos();

            document.getElementById('createTodoForm').addEventListener('submit', function(event) {
                event.preventDefault();
                createTodo();
            });
        });

        function loadTodos() {
            const token = localStorage.getItem('token');
            axios.get('/api/todos', {
                headers: { 'Authorization': `Bearer ${token}` }
            })
            .then(response => {
                displayTodos(response.data);
            })
            .catch(error => {
                console.error(error);
            });
        }

        function displayTodos(todos) {
            const toDoColumn = document.getElementById('to-do');
            const inProgressColumn = document.getElementById('in-progress');
            const inReviewColumn = document.getElementById('in-review');
            const doneColumn = document.getElementById('done');

            toDoColumn.innerHTML = '';
            inProgressColumn.innerHTML = '';
            inReviewColumn.innerHTML = '';
            doneColumn.innerHTML = '';

            todos.forEach(todo => {
                const todoItem = document.createElement('div');
                todoItem.classList.add('todo-item');
                todoItem.innerHTML = `
                    <span>${todo.title}</span>
                    <button onclick="deleteTodo(${todo.id})"><i class="fas fa-trash-alt"></i></button>
                `;
                switch (todo.status) {
                    case 'pending':
                        toDoColumn.appendChild(todoItem);
                        break;
                    case 'in_progress':
                        inProgressColumn.appendChild(todoItem);
                        break;
                    case 'in_review':
                        inReviewColumn.appendChild(todoItem);
                        break;
                    case 'completed':
                        doneColumn.appendChild(todoItem);
                        break;
                }
            });
        }

        function createTodo() {
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const date = document.getElementById('date').value;
            const status = document.getElementById('status').value;

            const token = localStorage.getItem('token');
            axios.post('/api/todos', {
                title: title,
                description: description,
                date: date,
                status: status
            }, {
                headers: { 'Authorization': `Bearer ${token}` }
            })
            .then(response => {
                loadTodos();
                document.getElementById('createTodoForm').reset();
            })
            .catch(error => {
                console.error(error);
            });
        }

        function deleteTodo(id) {
            const token = localStorage.getItem('token');
            axios.delete(`/api/todos/${id}`, {
                headers: { 'Authorization': `Bearer ${token}` }
            })
            .then(response => {
                loadTodos();
            })
            .catch(error => {
                console.error(error);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Todo Dashboard</h1>

        <form id="createTodoForm">
            <input type="text" id="title" name="title" placeholder="Title" required>
            <input type="text" id="description" name="description" placeholder="Description">
            <input type="date" id="date" name="date" required>
            <select id="status" name="status" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="in_review">In Review</option>
                <option value="completed">Completed</option>
            </select>
            <button type="submit">Create Todo</button>
        </form>

        <div class="board">
            <div class="column" id="to-do">
                <h2>To Do</h2>
            </div>
            <div class="column" id="in-progress">
                <h2>In Progress</h2>
            </div>
            <div class="column" id="in-review">
                <h2>In Review</h2>
            </div>
            <div class="column" id="done">
                <h2>Done</h2>
            </div>
        </div>
    </div>
</body>
</html>
