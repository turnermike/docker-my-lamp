<?php
// $dsn = 'mysql:dbname=test_php_app;host=db';
// $user = 'test_app_user';
// $password = 'test_app_password';

$dsn = 'mysql:dbname=steelhouse_website;host=steelhousedbcluster.cluster-cseokarizhz1.us-east-1.rds.amazonaws.com';
$user = 'realinteractive';
$password = 'O#43Sf%!aE987';



try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

foreach($dbh->query("Show variables like '%char%'") as $row) {
    printf("%s: %s<br />", htmlspecialchars($row[0]), htmlspecialchars($row[1]));
}

echo '<br />testing 123 456';