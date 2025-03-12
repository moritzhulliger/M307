<!DOCTYPE html>
<html>
<head>
    <title>Ein PHP-Beispiel</title>
</head>
<body>

<?php
$movieStars = [
    [
        'name' => 'Leonardo DiCaprio',
        'movies' => ['Inception', 'Titanic', 'The Wolf of Wall Street'],
        'image' => 'images/Download.webp'
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
];?>

<img src="<?php echo $movieStars[0]['image']?>" alt="Girl in a jacket" width="500" height="600">

</body>
</html>