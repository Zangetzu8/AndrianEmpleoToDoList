<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleo Todo List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }


        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            color: #333;
        }


        .todo-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }


        .todo-container h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }


        .input-section {
            display: flex;
            margin-bottom: 25px;
        }

        .input-section input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s ease;
        }

        .input-section input[type="text"]:focus {
            border-color: #ff9a9e;
        }

        .input-section button {
            background-color: #ff9a9e;
            border: none;
            color: #fff;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .input-section button:hover {
            background-color: #d17878;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #ff9a9e;
            color: #fff;
            border-radius: 5px 5px 0 0;
        }

        td {
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }

        tr:hover td {
            background-color: #ffe5e5;
        }


        .action-links {
            text-align: center;
        }

        .action-links a {
            text-decoration: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            margin: 0 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #ff4d4d;
        }

        .delete-btn:hover {
            background-color: #d12e2e;
        }


        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 350px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-bottom: 15px;
            font-size: 24px;
            color: #ff4d4d;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .modal-buttons button {
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .confirm-btn {
            background-color: #ff4d4d;
            color: white;
        }

        .cancel-btn {
            background-color: #ccc;
            color: #333;
        }


        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="todo-container">
        <h1>Empleos To-Do List</h1>


        <form class="input-section" action="add_task.php" method="POST">
            <input type="text" name="task" placeholder="Enter new task" required>
            <button type="submit">Add</button>
        </form>

        <?php include 'db.php'; ?>


        <table>
            <tr>
                <th>Task</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['task']) . "</td>";
                echo "<td class='action-links'>
                        <a href='edit_task.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>
                        <a href='#' class='delete-btn' onclick='openModal(" . $row['id'] . ")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>


    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this task?</p>
            <div class="modal-buttons">
                <button class="confirm-btn" onclick="confirmDelete()">Delete</button>
                <button class="cancel-btn" onclick="closeModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        let deleteTaskId = null;

        function openModal(taskId) {
            deleteTaskId = taskId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            deleteTaskId = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        function confirmDelete() {
            if (deleteTaskId) {
                window.location.href = `delete_task.php?id=${deleteTaskId}`;
            }
        }
    </script>
</body>
</html>
