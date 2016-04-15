<?php include '../workDB.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php $post_info = get_content('email','ASC');?>
<?php
echo "к-ство записей на странице {$post_info['per_page']}";
echo "<br>";
echo "количество записей в таблице всего {$post_info['total_rows']}" ;
echo "<br>";
echo "сколько всего получается страниц {$post_info['num_pages']}" ;
?>

<?php var_dump($post_info['row']);?>

</body>
</html>