<?php include '../workDB.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<style>
    table{
        border: 1px solid black;
    }
    tr, td {
        border: 1px solid red;
    }
</style>

<?php $post_info = get_content('email','ASC');
$post_content = $post_info['row'];?>
<?php
echo "к-ство записей на странице {$post_info['per_page']}";
echo "<br>";
echo "количество записей в таблице всего {$post_info['total_rows']}" ;
echo "<br>";
echo "сколько всего получается страниц {$post_info['num_pages']}" ;
echo "<hr>";
?>

<?php  foreach($post_content as $item => $value): ?>
    <?php {
        echo "<table>";
        echo "<tr>";
        echo "<td> Имя - ". $value['userName'] . "</td>";
        echo "<td> Email - ". $value['email']. "</td>";
        echo "<td> created_data - ". $value['created_data']. "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='3'> text - ". $value['text'] . "</td>";
        echo "</tr>";
        echo "</table>";
    } ?>
<?php endforeach; ?>

<?php echo "<hr>"; ?>

<?php
$num_pages = $post_info['num_pages'];
$page = $post_info['page'];

for($i=1;$i<=$num_pages;$i++){
    if($i-1 == $page){
        echo $i. " ";
    }else{
        echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i."</a> ";
    }
}
?>
<br>
<hr>
<a href="index.html"><button type="button" class="btn" />Main page</button></a>

</body>
</html>