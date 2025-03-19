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

    $booksImproved = [
        ['name' => 'The fault in our stars',
        'author' => 'Johhhn Green',
        'bookPrice' => '150MAD'
    ],
     ['name' => 'Atomic Habits',
        'author' => 'Snziku Matimosho',
        'bookPrice' => '99MAD'
        ]
    ]

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

    <!-- associative arrays -->

    <!-- access a speific inndex -->
    <p> <?= $books[2]; ?> </p>

    <h2>
        <?php foreach ($booksImproved as $bookImproved) : ?>
        <div>
            <!-- looping throuugh the names of each book -->
            <span><?= $bookImproved['name'] ?> </span>
            <!-- looping through the price -->
            <span> <?= $bookImproved['bookPrice']; ?> </span>
         </div>
        <?php endforeach; ?>
    </h2>

</body>
</html>