<div class="tasks-container">
    <h1>Задачи</h1>

<?php
//change status
include_once('data.php');
if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
?>
<?php

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
}catch(PDOException $e){
    die("умри дб конекшн");
}


if (isset($_REQUEST['changeStatus']))
    {
        $id_task=$_REQUEST['changeStatus'];
        $complite=$_REQUEST['complite'];
        $current_complite = $complite == 1? 0: 1;
        try{
                $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $stmt = $pdo ->prepare("UPDATE tasks SET complite=? WHERE id_task=?");
                $stmt -> execute([$current_complite, $id_task]);
            }
            catch(PDOException $e)
            {
                die("умри дб конекшн");
            }
    }
    
//delete
if (isset($_REQUEST['delete']))
    {
        $id_task=$_REQUEST['delete'];
        try{
                $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $stmt = $pdo ->prepare("DELETE FROM tasks WHERE id_task=?");
                $stmt -> execute([$id_task]);
                $tasks = $stmt ->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                die("умри дб конекшн");
            }
    }

if (isset($_REQUEST['addOrUpdate']))
    {
        if($_REQUEST['addOrUpdate'] == 'Add')
        {
            $text = $_REQUEST['text'];
            $id_user = $_SESSION['id_user'];
            try{
                $stmt = $pdo ->prepare("INSERT INTO tasks (text, complite, id_user) VALUES (?, ?, ?)");
                $stmt -> execute([$text, 0, $id_user]);
                header('Location: index.php?page=tasks');
                exit;
            }
            catch(PDOException $e)
            {
                die("Ошибка: " . $e->getMessage());
            }
        }
        if($_REQUEST['addOrUpdate'] == 'Edit')
        {
            $text = $_REQUEST['text'];
            $id_task = $_REQUEST['id_task'];
            $stmt = $pdo ->prepare("UPDATE tasks SET text=? WHERE id_task=?");
            $stmt -> execute([$text, $id_task]);
            header('Location: index.php?page=tasks');
            exit; 
        }
        
    }

$isEditing=isset($_REQUEST['Edit']);
if(isset($_REQUEST['Edit']))
    {
        $id_task_edit=$_REQUEST['Edit'];
        $stmt = $pdo ->prepare("SELECT * FROM tasks WHERE id_task=?");
        $stmt -> execute([$id_task_edit]);
        $task_edit = $stmt->fetch();
    }

//select all tasks 
include_once('data.php');
            try{
                $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $stmt = $pdo ->prepare("SELECT * FROM tasks WHERE id_user=?");
                $stmt -> execute([$_SESSION['id_user']]);
                $tasks = $stmt ->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                die("умри дб конекшн");
            }
?>


<form method="get" action="tasks.php">
    <input type="text" name="text" value="<?=  $isEditing? $task_edit['text']:'';?>">
    <input type="hidden" name="id_task" value="<?= $isEditing ? $task_edit['id_task']: '';?>">
    <input type="submit" name="addOrUpdate" value="<?=  $isEditing? 'Edit':'Add';?>">
</form>

<?php
if(empty($tasks)){?>
<div class="task">
    <span class="no-tasks">Задач пока нет</span>
</div>
<?php } else {
    foreach($tasks as $task):
        $text = $task['text'];
        $complite = $task['complite'];?>
        <div class="task">
            <span><?php echo $text?></span>
            <span class="status"><?=$complite ? "Done" : "In Progress" ?></span>
            <div>
                <a href="index.php?page=tasks&changeStatus=<?=$task['id_task']?>&complite=<?=$task['complite']?>">Change status</a>
                <a href="index.php?page=tasks&delete=<?=$task['id_task']?>">delete</a>    
                <a href="index.php?page=tasks&Edit=<?=$task['id_task']?>">Edit</a>
            </div>
        </div>
<?php
    endforeach;
}

?>
</div>
