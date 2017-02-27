<?php
    require_once('./common/DBConnect.php');

	$comment_id = 0;
	$result = "";

    if(isset($_REQUEST['comment_id'])){
        $comment_id = $_REQUEST['comment_id'];
    }

    // mysql接続
    $dbh = connect();

    // コメント削除
    $sql = "UPDATE comment ";
    $sql .= "SET isdelete = 1 ";
    $sql .= "WHERE comment_id = :comment_id"; 

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':comment_id' , $comment_id, PDO::PARAM_INT);
    $flg = $stmt->execute();

    if ($flg) {
        $result = "2";
    } else {
        $result = "3";
    }

    close($dbh);

    print $result;
    
?>