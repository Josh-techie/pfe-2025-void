<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Recommendation </title>
</head>
<body>
    <h1> Book Recommendation</h1>

    <?php

    $books = ['The Faullt in our Stars', 'Atomic Habits', 'Samurai Champlou'];


    ?>

    <ul>
        <!-- First way to do a foreach -->
        <?php foreach ($books as $book){
            echo "<li> $book </li>";
        }
        ?>

        <!-- second method to do an foreach -->
         <?php foreach($books as $book): ?>
            <li> <?= $book; ?> </li>
        <?php endforeach; ?>
    </ul>
    
    
</body>
</html>