<?php
    require_once('./common/DBConnect.php');

    $title = "";
	$question_id = 0;
    $question = "";
    $drafter = 0;
    $qdate = "";
    $priority = "";
    $status = "";

    if(isset($_REQUEST['title'])){
        $title = $_REQUEST['title'];
    }
    if(isset($_REQUEST['question_id'])){
        $question_id = $_REQUEST['question_id'];
    }
    if(isset($_REQUEST['question'])){
        $question = $_REQUEST['question'];
    }
    if (isset($_REQUEST['qdate'])) {
        $qdate = $_REQUEST['qdate'];
    }
    if(isset($_REQUEST['drafter'])){
        $drafter = $_REQUEST['drafter'];
    }
    if (isset($_REQUEST['status'])) {
        $status = $_REQUEST['status'];
    }
    if (isset($_REQUEST['priority'])) {
        $priority = $_REQUEST['priority'];
    }

    // mysql接続
    $dbh = connect();

    // 質問テーブル更新
    $sql = "UPDATE question ";
    $sql .= "SET title = :title, question = :question, qdate = :qdate, ";
    $sql .= "drafter = :drafter, status = :status, priority=:priority ";
    $sql .= "WHERE question_id = :question_id"; 

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title' , $title, PDO::PARAM_STR);
    $stmt->bindParam(':question' , $question, PDO::PARAM_STR);
    $stmt->bindParam(':qdate' , $qdate, PDO::PARAM_STR);
    $stmt->bindParam(':drafter' , $drafter, PDO::PARAM_INT);
    $stmt->bindParam(':status' , $status, PDO::PARAM_STR);
    $stmt->bindParam(':priority' , $priority, PDO::PARAM_STR);
    $stmt->bindParam(':question_id' , $question_id, PDO::PARAM_INT);
    $flg = $stmt->execute();

    close($dbh);
    
    if ($flg) {
        print 0;
    } else {
        print 1;
    }

?>