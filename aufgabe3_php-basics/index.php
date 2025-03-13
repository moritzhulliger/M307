<!DOCTYPE html>
<html>
<head>
    <title>Ein PHP-Beispiel</title>
</head>
<body>
<h1> Filmstars </h1>
<?php
$movieStars = [
    [
        'name' => 'Leonardo DiCaprio',
        'movies' => ['Inception', 'Titanic', 'The Wolf of Wall Street']
    ],
    [
        'name' => 'Scarlett Johansson',
        'movies' => ['Lost in Translation', 'Lucy', 'Black Widow']
    ],
    [
        'name' => 'Tom Hanks',
        'movies' => ['Forrest Gump', 'Cast Away', 'Saving Private Ryan']
    ],
    [
        'name' => 'Morgan Freeman',
        'movies' => ['The Shawshank Redemption', 'Se7en', 'Bruce Almighty']
    ],
    [
        'name' => 'Natalie Portman',
        'movies' => ['Black Swan', 'V for Vendetta', 'Closer']
    ],
    [
        'name' => 'Robert Downey Jr.',
        'movies' => ['Iron Man', 'Sherlock Holmes', 'Chaplin']
    ],
    [
        'name' => 'Angelina Jolie',
        'movies' => ['Lara Croft: Tomb Raider', 'Maleficent', 'Mr. & Mrs. Smith']
    ]
];

foreach ($movieStars as $actor) {
     ?> 
     <section> <h2> <?php echo $actor['name'] . "<br>"; ?> </h2>
     <ul>
       <?php
       foreach ($actor['movies']  as $movie) {
        echo "<li>" . ($movie) . "</li>";

        }
        ?>
    </ul>
     </section>
    <?php
  }

?>

</body>
</html>