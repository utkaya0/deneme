<?php  
session_start();

if(!isset($_SESSION["tasks"])){
    $_SESSION["tasks"] = [];
}

if(isset($_POST['text'])){
    $task = trim($_POST['text']);

    if($task !== ""){
        $_SESSION["tasks"][] = [
            "text" => htmlspecialchars($task),
            "done" => false
        ];
    }
}

if (isset($_GET["delete"])) {
    $index = (int) $_GET["delete"];
    if (isset($_SESSION["tasks"][$index])) {
        unset($_SESSION["tasks"][$index]);
        $_SESSION["tasks"] = array_values($_SESSION["tasks"]);
    }
}

if(isset($_GET["do"])){

    $index = (int) $_GET["do"];

    if(isset($_SESSION["tasks"][$index])){
        $_SESSION["tasks"][$index]["done"] = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
</head>
<body>
    <form action="index.php" method="POST">
        <label>Add Task</label>
        <input type="text" name="text">
        <input type="submit" value="Submit">
    </form>

    <?php if (empty($_SESSION["tasks"])): ?>
    <p>Henüz hiç görev eklenmedi.</p>
<?php else: ?>
    <ul>
        <?php foreach ($_SESSION["tasks"] as $index => $task): ?>
            <li>
                <span style="<?= $task["done"] ? 'text-decoration: line-through; color: gray;' : '' ?>">
                    <?= $task["text"] ?>
                </span>

                <?php if (!$task["done"]): ?>
                    <a href="?do=<?= $index ?>">✅ Do</a>
                <?php endif; ?>

                <a href="?delete=<?= $index ?>" onclick="return confirm('Do you want to delete this task?')">❌ Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
   
</body>
</html>