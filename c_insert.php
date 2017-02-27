<?php
    require_once('./common/DBConnect.php');

	$question_id = 0;
    $comment = "";
    $respondent = "";
    $status = "";
    $result = "";

    if(isset($_REQUEST['question_id'])){
        $question_id = $_REQUEST['question_id'];
    }
    if(isset($_REQUEST['comment'])){
        $comment = $_REQUEST['comment'];
    }
    if (isset($_REQUEST['respondent'])) {
        $respondent = $_REQUEST['respondent'];
    }
    if (isset($_REQUEST['status'])) {
        $status = $_REQUEST['status'];
    }

    // mysql接続
    $dbh = connect();

    $cdate = date('Y-m-d H:i:s');
    if (!empty($comment)) {
        // コメントテーブル追加
        $sql = "INSERT INTO comment ";
        $sql .= "(question_id, comment, comment_date, respondent) ";
        $sql .= "VALUES (:question_id, :comment, :cdate, :respondent)"; 

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':question_id' , $question_id, PDO::PARAM_INT);
        $stmt->bindParam(':comment' , $comment, PDO::PARAM_STR);
        $stmt->bindParam(':cdate' , $cdate, PDO::PARAM_STR);
        $stmt->bindParam(':respondent' , $respondent, PDO::PARAM_STR);
        $flg = $stmt->execute();

        if ($flg) {
        } else {
            $result = "1";
            exit;
        }
    }
 
    // ステータス更新
    $sql = "UPDATE question ";
    $sql .= "SET status = :status ";
    $sql .= "WHERE question_id = :question_id"; 

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':status' , $status, PDO::PARAM_STR);
    $stmt->bindParam(':question_id' , $question_id, PDO::PARAM_INT);
    $flg = $stmt->execute();

    if ($flg) { 
        $result = "0";
    } else {
        $result = "1";
    }
 

    close($dbh);

    return $result;

?>