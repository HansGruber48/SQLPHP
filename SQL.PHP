<?php

$user="root";
$pass="";
$dbname="polar_wp";
$host="localhost";
$row = array();




try {

    $dsn= 'mysql:host='.$host.';dbname='.$dbname;

    //echo $dsn;

    $options=array(
PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",
PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION

    );


    $dbh = new PDO($dsn, $user, $pass,$options);
   var_dump( $dbh);
   echo "connexion etablie";

} catch (PDOException $e) {
    print "Erreur connexion !: " . $e->getMessage() . "<br/>";
    die();
}

try {

   $query= 'SELECT wp_posts.ID, post_title,LEFT(post_content,100) AS post_content_tr,post_date ,display_name
   from wp_posts,wp_users
   where post_type="post"
        and post_status="publish"
        and post_author=wp_users.ID
        order by post_date DESC';
   // and ping_status="open"
   $req = $dbh->query($query);
//$req->setFetchMode(PDO::FETCH_BOTH);
$req->setFetchMode(PDO::FETCH_ASSOC);
$tab = $req->fetchAll();
$req->closeCursor();
var_dump($tab );

   /*  foreach($tab as $row) {
        var_dump($row);
    } */
    $dbh = null; 
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>
<!DOCTYPE html>
   <html lang="en">
   <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta http-equiv="X-LA-Compatible" content ="IE-Edge">
   <title> Ceci est mon titre </title>
   </head>
   <body>

   <?php foreach ($tab as $row) {?>
    <h2> <a href ="article.php?id=<?= $row["ID"] ?>"><?= $row["post_title"] ?></a></h2>>
    <p>Contenu de l'article</p>
    <p><?= $row["post_content_tr"]?></p>
    <p>Rédigé par : <?= $row["display_name"]?> - Date : <?= $row["post_date"]?></p>
    <?php } ?>

   </body>
   
   </html>