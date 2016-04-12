<?php
include_once '../DB.php';

    $sql = "INSERT INTO post( 'id', 'userName',     'email',    'text',   'homepage',     'user_ip',  'user_browser',     'created_data')
                         VALUES (null, '{$userName}', '{$email}', '{$text}', '{$homepage}', '{$user_ip}', '{$user_browser}', '{$created_data}')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

