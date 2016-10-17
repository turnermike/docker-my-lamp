<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

/* ==========================================================================
   PDO
   ========================================================================== */

// get db creds from environment variables
$host =     getenv('MYSQL_HOST');
$db =       getenv('MYSQL_DATABASE');
$user =     getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

echo '<br>host: ' . $host;
echo '<br>db: ' . $db;
echo '<br>user: ' . $user;
echo '<br>password: ' . $password;
echo '<br><br>';


// $dsn = 'mysql:dbname=test_php_app;host=db';
// $user = 'test_app_user';
// $password = 'test_app_password';
$dsn = 'mysql:dbname=steelhouse_website;host=steelhousedbcluster.cluster-cseokarizhz1.us-east-1.rds.amazonaws.com';
$user = 'realinteractive';
$password = 'O#43Sf%!aE987';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo '<br>Connection failed: ' . $e->getMessage();
}

foreach($dbh->query("Show variables like '%char%'") as $row) {
    printf("%s: %s<br />", htmlspecialchars($row[0]), htmlspecialchars($row[1]));
}

echo '<br><br>testing abc123';



/* ==========================================================================
   mysql_connect
   ========================================================================== */



// //$link = mysql_connect('localhost', 'root', 'root');
// $link = mysql_connect('steelhousedbcluster.cluster-cseokarizhz1.us-east-1.rds.amazonaws.com', 'realinteractive', 'O#43Sf%!aE987');

// if (!$link) {
//     die('<br />Could not connect: ' . mysql_error());
// }
// echo '<br />Connected successfully';


// $db_selected = mysql_select_db('steelhouse_website', $link);

// if(!$db_selected){
//  die('<br />Could not use backbone_address_book: ' . mysql_error());
// }

// echo '<br />Selected DB Successfully';


// mysql_close($link);





