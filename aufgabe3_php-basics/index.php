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
        'image' => 'img/LeandroDiCabrio.jpg'
    ],
    [
        'name' => 'Scarlett Johansson',
        'movies' => ['Lost in Translation', 'Lucy', 'Black Widow'],
        'image' => 'img/ScarlettJohansson.jpg'

    ],
    [
        'name' => 'Tom Hanks',
        'movies' => ['Forrest Gump', 'Cast Away', 'Saving Private Ryan'],
        'image' => 'img/TomHanks.jpg'
    ],
    [
        'name' => 'Morgan Freeman',
        'movies' => ['The Shawshank Redemption', 'Se7en', 'Bruce Almighty'],
        'image' => 'img/MorganFreeman.webp'
    ],
    [
        'name' => 'Natalie Portman',
        'movies' => ['Black Swan', 'V for Vendetta', 'Closer'],
        'image' => 'img/NataliePortman.jpg'
    ],
    [
        'name' => 'Robert Downey Jr.',
        'movies' => ['Iron Man', 'Sherlock Holmes', 'Chaplin'],
        'image' => 'img/RobertDowneyJr.jpg'
    ],
    [
        'name' => 'Angelina Jolie',
        'movies' => ['Lara Croft: Tomb Raider', 'Maleficent', 'Mr. & Mrs. Smith'],
        'image' => 'img/AngelinaJolie.jpg'
    ]
];?>

<?php
foreach ($movieStars as $Actor) {
    ?> <section>
    <h2> <?php echo $Actor['name'] . "<br>"; ?> </h2>  
    <ul>
        <?php
        foreach ($Actor['movies'] as $movie) {
            echo "<li>" . ($movie) . "</li>";
        }
        ?>
    </ul>
    <img src="<?php echo $Actor['image'] ?>" alt="<?php echo $Actor['name'] ?>" width="500" height="600">
    </section>
<?php
}
?>  
</body>
</html>