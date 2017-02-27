<?php
    require_once('./common/DBConnect.php');

	$question_id = 0;
	$result = "";

    if(isset($_REQUEST['question_id'])){
        $question_id = $_REQUEST['question_id'];
    }

    // mysql接続
    $dbh = connect();

    // 質問削除
    $sql = "UPDATE question ";
    $sql .= "SET isdelete = 1 ";
    $sql .= "WHERE question_id = :question_id"; 

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':question_id' , $question_id, PDO::PARAM_INT);
    $flg = $stmt->execute();

    if (!$flg) {
        $result = "5";
        exit();
    }

    // コメント削除
    $sql = "UPDATE comment ";
    $sql .= "SET isdelete = 1 ";
    $sql .= "WHERE question_id = :question_id"; 

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':question_id' , $question_id, PDO::PARAM_INT);
    $flg = $stmt->execute();

    if ($flg) {
        $result = "4";
    } else {
        $result = "5";
    }

    close($dbh);

    print $result;

?>