<html>
<head>
    <title>Ein PHP-Beispiel</title>
</head>
<body>
    <?php 
         $numbers = [1122, 2489, 9367, 270, 827, 9046, 555, 123, 2020, 9080];

         foreach ($numbers as $number) {
             if ($number % 2 == 0) {
                 echo "$number ist gerade.<br>";
             } else {
                 echo "$number ist ungerade.<br>";
             }
         }
    ?>
</body>
</html>