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
        'author' => 'John Green',
        'bookPrice' => '150MAD'
    ],
     ['name' => 'Atomic Habits',
        'author' => 'Snziku Matimosho',
        'bookPrice' => '99MAD'
        ]
];

    // let's create filterAuthor function
    function filterAuthor($bookImproved, $author){
        
        $filteredByAuthor = [];
        foreach ($bookImproved as $book) {
            if ($book['author'] === $author) {
                $filteredByAuthor[] = $book;
            }
        }

        return $filteredByAuthor;

    }

    ?>



    <h3> Filter By Author: Use functions</h3>
    <div>
        <!-- // here put the logic to using my function -->
        <?php
        $filteredBooks = filterAuthor($booksImproved, 'John Green'); // Get the filtered books
        foreach ($filteredBooks as $book) :
        ?>
        <p>
            <?= htmlspecialchars($book['name']) ?> by <?= htmlspecialchars($book['author']) ?> - Price: <?= htmlspecialchars($book['bookPrice']) ?>
        </p>
        <?php endforeach; ?>
    </div>
</body>
</html>