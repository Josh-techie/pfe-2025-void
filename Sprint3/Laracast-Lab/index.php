<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Hello Wold</title>
</head>
<body>
    <?php
    $book = "The Fault in our star";
    $read = false;
    // check if the value is correct
    if($read){
    $message = "I've read $book Book.";
    }
    else{
        $message = "I haven't read the book $book";
    }
?>

    <h1>
        <?php echo $message; ?>
        <?= $message ?>
    </h1>
</body>
</html>