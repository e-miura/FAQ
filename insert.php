<?php
    require_once('./common/DBConnect.php');

	$category = 0;
    $title = "";
    $question = "";
    $drafter = "";
    $priority = "";

    if(isset($_REQUEST['category'])){
        $category = $_REQUEST['category'];
    }
    if(isset($_REQUEST['title'])){
        $title = $_REQUEST['title'];
    }
    if (isset($_REQUEST['question'])) {
        $question = $_REQUEST['question'];
    }
    if (isset($_REQUEST['drafter'])) {
        $drafter = $_REQUEST['drafter'];
    }
    if (isset($_REQUEST['priority'])) {
        $priority = $_REQUEST['priority'];
    }

    // mysql接続
    $dbh = connect();

    $qdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO question ";
    $sql .= "(category_id, title, question, qdate, drafter, priority) ";
    $sql .= "VALUES (:category_id, :title, :question, :qdate, :drafter, :priority)"; 

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':category_id' , $category, PDO::PARAM_INT);
    $stmt->bindParam(':title' , $title, PDO::PARAM_STR);
    $stmt->bindParam(':question' , $question, PDO::PARAM_STR);
    $stmt->bindParam(':qdate' , $qdate, PDO::PARAM_STR);
    $stmt->bindParam(':drafter' , $drafter, PDO::PARAM_STR);
    $stmt->bindParam(':priority' , $priority, PDO::PARAM_STR);
    $flg = $stmt->execute();

    if ($flg) {
        print 0;
    } else {
        print 1;
    }

    close($dbh);
?>