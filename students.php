<?php
session_start();

// Initialize students array
if(!isset($_SESSION['students'])){
    $_SESSION['students'] = [];
}

// Add new student
if(isset($_POST['submit'])){
    $regno = $_POST['regno'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $_SESSION['students'][] = ['regno'=>$regno, 'name'=>$name, 'email'=>$email];
    echo "<script>alert('✅ Student Added Successfully');</script>";
}

// Delete student
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    if(isset($_SESSION['students'][$id])){
        unset($_SESSION['students'][$id]);
        $_SESSION['students'] = array_values($_SESSION['students']);
        echo "<script>alert('❌ Student Deleted Successfully');</script>";
    }
}

// Edit student
if(isset($_POST['edit_submit'])){
    $id = $_POST['id'];
    $_SESSION['students'][$id]['regno'] = $_POST['regno'] ?? '';
    $_SESSION['students'][$id]['name'] = $_POST['name'] ?? '';
    $_SESSION['students'][$id]['email'] = $_POST['email'] ?? '';
    echo "<script>alert('✏️ Student Edited Successfully');</script>";
}

// Prepare edit form
$edit_student = null;
$edit_id = null;
if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
    if(isset($_SESSION['students'][$edit_id])){
        $edit_student = $_SESSION['students'][$edit_id];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students List</title>
    <style>
        body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
    padding: 40px 10px;
}

.container {
    max-width: 1000px;
    margin: auto;
    background-color: #ffffff;
    padding: 35px 45px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    border-top: 5px solid #2c3e50;
}

h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-weight: 600;
}

a.add-student {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 18px;
    background-color: #2c3e50;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    transition: 0.3s;
}

a.add-student:hover {
    background-color: #1a252f;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 14px;
    border-bottom: 1px solid #e1e5ea;
    text-align: center;
}

table th {
    background-color: #ecf0f1;
    color: #2c3e50;
    font-weight: 600;
}

table tr:hover {
    background-color: #f2f4f7;
}

.action-btn {
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    font-size: 13px;
    text-decoration: none;
    transition: 0.3s;
}

.edit-btn {
    background-color: #34495e;
}

.edit-btn:hover {
    background-color: #2c3e50;
}

.delete-btn {
    background-color: #c0392b;
}

.delete-btn:hover {
    background-color: #922b21;
}

.edit-form input[type="text"],
.edit-form input[type="email"] {
    width: 140px;
    padding: 6px;
    border-radius: 4px;
    border: 1px solid #dcdde1;
}

.edit-form input[type="text"]:focus,
.edit-form input[type="email"]:focus {
    border-color: #2c3e50;
    outline: none;
}
    </style>
</head>
<body>

<div class="container">
    <h2>Students List</h2>
    <a class="add-student" href="form.php">➕ Add New Student</a>

    <table>
        <tr>
            <th>Registration No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php foreach($_SESSION['students'] as $id => $student): ?>
        <tr>
            <?php if($edit_student && $edit_id == $id): ?>
            <!-- Edit Row -->
            <form method="POST" class="edit-form">
                <td><input type="text" name="regno" value="<?php echo htmlspecialchars($student['regno'] ?? ''); ?>"></td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>"></td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>"></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="edit_submit" value="💾 Save" class="action-btn edit-btn">
                    <a href="students.php" class="action-btn delete-btn">❌ Cancel</a>
                </td>
            </form>
            <?php else: ?>
            <td><?php echo htmlspecialchars($student['regno'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($student['name']); ?></td>
            <td><?php echo htmlspecialchars($student['email']); ?></td>
            <td>
                <a href="students.php?edit=<?php echo $id; ?>" class="action-btn edit-btn">✏️ Edit</a>
                <a href="students.php?delete=<?php echo $id; ?>" onclick="return confirm('Are you sure to delete?')" class="action-btn delete-btn">🗑️ Delete</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>