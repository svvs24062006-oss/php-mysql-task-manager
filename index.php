<?php
require 'db.php';

// CREATE: Add new task
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST['title']))) {
    $title = trim($_POST['title']);
    $category = $_POST['category'];
    $stmt = $conn->prepare("INSERT INTO tasks (title, category) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $category);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

// UPDATE: Mark task as Completed
if (isset($_GET['complete'])) {
    $id = intval($_GET['complete']);
    $stmt = $conn->prepare("UPDATE tasks SET status = 'Completed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

// DELETE: Remove task
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

// READ: Fetch all tasks
$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
    <h2>Task & Study Planner</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Enter task (e.g., Practice SQL Joins)" required>
        <select name="category">
            <option value="Coding">Coding</option>
            <option value="Internship">Internship</option>
            <option value="Exam Prep">Exam Prep</option>
        </select>
        <button type="submit">Add</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td>
                    <span class="badge <?php echo $row['status'] == 'Completed' ? 'done' : 'pending'; ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td>
                    <?php if ($row['status'] == 'Pending'): ?>
                        <a href="?complete=<?php echo $row['id']; ?>" class="action-link complete-btn">Done</a>
                    <?php endif; ?>
                    <a href="?delete=<?php echo $row['id']; ?>" class="action-link delete-btn">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
