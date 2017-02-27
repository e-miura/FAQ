<?php
        include("header.php");
        include("sidebar.php");
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">回答</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-11">
<?php
    require_once('./common/DBConnect.php');

    $dbh = connect();

    $category = 0;
    $catName = "";
    $question_id = 0;
    $msg = "";

    if(isset($_REQUEST['category'])){
        $category = $_REQUEST['category'];
    }

    if(isset($_REQUEST['catName'])){
        $catName = $_REQUEST['catName'];
    }

    if(isset($_REQUEST['question_id'])){
        $question_id = $_REQUEST['question_id'];
    }

    if(isset($_REQUEST['result_flg'])){
        switch ($_REQUEST['result_flg']) {
            case 0:
                $msg = "コメントを登録しました。";
                break;
            case 1:
                $msg = "コメント登録に失敗しました。";
                break;
            case 2:
                $msg = "コメントを削除しました。";
                break;
            case 3:
                $msg = "コメント削除に失敗しました。";
                break;
            case 4:
                $msg = "削除しました。";
                break;
            case 5:
                $msg = "削除に失敗しました。";
                break;
            default: 
                $msg = "";   
                break;
        } 
    }   

    $sql = "select ca.category_id, ca.category_name, qu.title, qu.question, qu.qdate, ";
    $sql .= "qu.drafter, qu.resolved_date, qu.status, qu.priority, u.name ";
    $sql .= "from question qu ";
    $sql .= "inner join category ca on qu.category_id = ca.category_id ";
    $sql .= "left join user u on qu.drafter = u.id ";
    $sql .= "where qu.question_id = :question_id and qu.isdelete = 0 ";

    $result = $dbh->prepare($sql);
    $result->bindParam(':question_id', $question_id, PDO::PARAM_INT);
    $result->execute();
    
    $html = '<p><font color="red"><span id="message">' . $msg . '</span></font></p>' . "\r\n";
    $html .= '<div class="panel panel-default">' . "\r\n";
    $html .= '<form role="form" id="f" method="post">' . "\r\n"; 
    if ($result->rowCount() < 1) {
        $html .= '<div>該当データがありません</div><br><br>' . "\r\n";
    } else {    
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $html .= '<div class="panel-heading">' . "\r\n";
        $html .= '<font color="blue"><label>質問</label></font>&nbsp;&nbsp;&nbsp;&nbsp;NO.'. $question_id . "\r\n";
        $html .= '</div><!-- ./panel-heading -->' . "\r\n";

        $html .= '<div class="panel-body">' . "\r\n";
        
        $html .= '<div class="form-group col-lg-12">' . "\r\n";
        $html .= '<label>カテゴリー</label>' . "\r\n";
        $html .= '<div>'. $catName . '</div>' . "\r\n";
        $html .= '<input type="hidden" id="category" name="category" value="' . $category . '" />' . "\r\n"; 
        $html .= '<input type="hidden" id="catName" name="catName" value="' . $catName . '" />' . "\r\n";
        $html .= '<input type="hidden" id="category_id" name="category_id" value="' . $row['category_id'] . '" />' . "\r\n";
        $html .= '<input type="hidden" id="category_name" name="category_name" value="' . $row['category_name'] . '" />' . "\r\n";
        $html .= '</div>' . "\r\n";    

        $html .= '<div class="form-group col-lg-12">' . "\r\n";
        $html .= '<label>タイトル</label>' . "\r\n";
        $html .= '<div>'. $row['title'] . '</div>' . "\r\n";
        $html .= '<input type="hidden" id="title" name="title" value="' . $row['title'] . '" />' . "\r\n";               
        $html .= '</div>' . "\r\n";

        $html .= '<div class="form-group col-lg-12">' . "\r\n";
        $html .= '<label>質問</label>' . "\r\n";
        $html .= '<div>' . nl2br($row['question']) . '</div>' . "\r\n";
        $html .= '<input type="hidden" id="question_id" name="question_id" value="' . $question_id . '" />' . "\r\n";
        $html .= '<input type="hidden" id="question" name="question" value="' . $row['question'] . '" />' . "\r\n";               
        $html .= '</div>' . "\r\n";
        
        $html .= '<div class="form-group col-lg-12" >' . "\r\n";
        $html .= '<label>起案者</label>' . "\r\n";
        $html .= '<div>' . $row['name']  . '</div>' . "\r\n";
        $html .= '<input type="hidden" id="drafter" name="drafter" value="' . $row['drafter'] . '" />' . "\r\n"; 
        $html .= '</div>' . "\r\n";

        $qdate = new DateTime($row["qdate"]);
        $value = $qdate->format('Y/m/d H:i:s'); 
        $html .= '<div class="form-group col-lg-12" >' . "\r\n";
        $html .= '<label>起案日</label>' . "\r\n";
        $html .= '<div>' . $value . '</div>' . "\r\n";
        $html .= '<input type="hidden" id="qdate" name="qdate" value="' . $value . '" />' . "\r\n"; 
        $html .= '</div>' . "\r\n";

        $html .= '<div class="form-group col-lg-12" >' . "\r\n";
        $html .= '<label>優先度</label>' . "\r\n";
        switch ($row["priority"]) {
            case 1:
                $html .= '<div>' . PRIORITY1 . '</div>' . "\r\n";
                break;
            case 2:
                $html .= '<div>' . PRIORITY2 . '</div>' . "\r\n";
                break;
            case 3:
                $html .= '<div>' . PRIORITY3 . '</div>' . "\r\n";
                break;
        } 
        $html .= '<input type="hidden" id="priority" name="priority" value="' . $row['priority'] . '" />' . "\r\n"; 
        $html .= '</div>' . "\r\n";

        $html .= '<div class="form-group col-lg-11" >' . "\r\n";
        $html .= '<label>ステータス</label>' . "\r\n";
        $html .= '<select class="form-control" style="width: 120px" id="status" name="status">' . "\r\n";
        switch ($row["status"]) {
            case 1:
                $html .= '<option selected value="1">' . STATUS1 . '</option>' . "\r\n";
                $html .= '<option value="2">' . STATUS2 . '</option>' . "\r\n";
                $html .= '<option value="3">' . STATUS3 . '</option>' . "\r\n";
                $html .= '<option value="4">' . STATUS4 . '</option>' . "\r\n";
                $html .= '<option value="5">' . STATUS5 . '</option>' . "\r\n";
                break;
            case 2:
                $html .= '<option value="1">' . STATUS1 . '</option>' . "\r\n";
                $html .= '<option selected value="2">' . STATUS2 . '</option>' . "\r\n";
                $html .= '<option value="3">' . STATUS3 . '</option>' . "\r\n";
                $html .= '<option value="4">' . STATUS4 . '</option>' . "\r\n";
                $html .= '<option value="5">' . STATUS5 . '</option>' . "\r\n";
                break;
            case 3:
                $html .= '<option value="1">' . STATUS1 . '</option>' . "\r\n";
                $html .= '<option value="2">' . STATUS2 . '</option>' . "\r\n";
                $html .= '<option selected value="3">' . STATUS3 . '</option>' . "\r\n";
                $html .= '<option value="4">' . STATUS4 . '</option>' . "\r\n";
                $html .= '<option value="5">' . STATUS5 . '</option>' . "\r\n";
                break;
            case 4:
                $html .= '<option value="1">' . STATUS1 . '</option>' . "\r\n";
                $html .= '<option value="2">' . STATUS2 . '</option>' . "\r\n";
                $html .= '<option value="3">' . STATUS3 . '</option>' . "\r\n";
                $html .= '<option selected value="4">' . STATUS4 . '</option>' . "\r\n";
                $html .= '<option value="5">' . STATUS5 . '</option>' . "\r\n";
                break;
            case 5:
                $html .= '<option value="1">' . STATUS1 . '</option>' . "\r\n";
                $html .= '<option value="2">' . STATUS2 . '</option>' . "\r\n";
                $html .= '<option value="3">' . STATUS3 . '</option>' . "\r\n";
                $html .= '<option value="4">' . STATUS4 . '</option>' . "\r\n";
                $html .= '<option selected value="5">' . STATUS5 . '</option>' . "\r\n";
                break;
        } 
        $html .= '</select>' . "\r\n";
        $html .= '<br>' . "\r\n";               
        $html .= '<div align="right"><input type="button" id="change" class="btn btn-default" value="変更">&nbsp;&nbsp;' . "\r\n";
        $html .= '<button type="submit" id="delete" class="btn btn-default">削除</button></div>' . "\r\n";
        $html .= '</div>' . "\r\n";
        $html .= '</div><!-- /.panel-body -->' . "\r\n";

        $sql2 = "select c.comment_id, c.comment, c.comment_date, ";
        $sql2 .= "c.respondent, u.name ";
        $sql2 .= "from comment c ";
        $sql2 .= "left join user u on c.respondent = u.id ";
        $sql2 .= "where c.question_id = :question_id ";
        $sql2 .= "and c.isdelete = 0 ";
        $sql2 .= "order by c.comment_id";

        $result2 = $dbh->prepare($sql2);
        $result2->bindParam(':question_id', $question_id, PDO::PARAM_INT);
        $result2->execute();

        if ($result2->rowCount() > 0) {
            $html .= '<div id="commentArea">' . "\r\n";
            while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                $html .= '<hr>' . "\r\n";
                $html .= '<div class="panel-heading">' . "\r\n";
                $html .= '<font color="blue"><label>コメント</label></font>&nbsp;&nbsp;&nbsp;&nbsp;NO.'. $row2['comment_id'] . "\r\n";
                $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>回答者</label>' . "\r\n";
                $html .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $row2['name'] . "\r\n";
                $cdate = new DateTime($row2["comment_date"]);
                $value2 = $cdate->format('Y/m/d H:i:s'); 

                $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>回答日</label>' . "\r\n";
                $html .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $value2 . "\r\n";
                $html .= '</div><!-- ./panel-heading -->' . "\r\n";

                $html .= '<div class="panel-body">' . "\r\n";
                $html .= '<div class="form-group col-lg-11">' . "\r\n";
                $html .= '<label>コメント</label>' . "\r\n";
                $html .= '<div>'. nl2br($row2['comment']) . '</div>' . "\r\n";
                $html .= '<input type="hidden" id="respondent" value="' . $row2['respondent'] . '" />' . "\r\n";
                $html .= '<input type="hidden" id="respondent_name" value="' . $row2['name'] . '" />' . "\r\n"; 
                $html .= '<input type="hidden" id="comment_date" value="' . $value2 . '" />' . "\r\n"; 
                $html .= '<input type="hidden" id="comment_id" value="' . $row2['comment_id'] . '" />' . "\r\n";
                $html .= '<input type="hidden" id="comment" value="' . $row2['comment'] . '" />' . "\r\n";

                $html .= '<br>' . "\r\n";
                $html .= '<div align="right">' . "\r\n";
                //$html .= '<button type="submit" id="cUpdate' . $row2['comment_id'] . "\r\n";
                //$html .= '" class="btn btn-default">更新</button>&nbsp;&nbsp;' . "\r\n";
                $html .= '<button type="submit" id="cDelete' . $row2['comment_id'];
                $html .= '" class="btn btn-default">削除</button></div>' . "\r\n";
                $html .= '</div>' . "\r\n";
                $html .= '</div><!-- /.panel-body -->' . "\r\n";
            }
            $html .= '</div><!-- ./commentArea -->' . "\r\n";
        }

        if ($row["status"] != '5') {
            $html .= '<hr>' . "\r\n";
            $html .= '<div class="panel-heading">' . "\r\n";
            $html .= '<font color="blue"><label>コメント追加</label></font>' . "\r\n";
            $html .= '</div><!-- ./panel-heading -->' . "\r\n";

            $html .= '<div class="panel-body">' . "\r\n";
            $html .= '<div class="form-group col-lg-11">' . "\r\n";
            $html .= '<label>回答者</label>' . "\r\n";
            $html .= '<select class="form-control" style="width: 300px" id="user">' . "\r\n";
            // 回答者取得
            $sql3 = "SELECT * FROM user ORDER BY id";
            $result3 = $dbh->prepare($sql3);
            $result3->execute();
            while($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
                $html .= '<option value="' . $row3['id'] . '">' . "\r\n"; 
                $html .= $row3['name'] . '</option>' . "\r\n";
            }   
            $html .= '</select>' . "\r\n";
            $html .= '</div>' . "\r\n";
            $html .= '<div class="form-group col-lg-11">' . "\r\n";
            $html .= '<label>コメント</label>' . "\r\n";
            $html .= '<textarea class="form-control" rows="8" id="answer"></textarea>' . "\r\n";
            $html .= '<br>' . "\r\n";
            $html .= '<div align="right"><button type="submit" id="cInsert" class="btn btn-default">登録</button></div>' . "\r\n";
            $html .= '</div>';
            $html .= '</div><!-- /.panel-body -->' . "\r\n";
        }

    }
    $html .= '</form>' . "\r\n";
    $html .= '</div><!-- /.panel -->' . "\r\n";
    $html .= '<div align="right" class="form-group">' . "\r\n";
    $html .= '<a href="index.php';
    if ($category != 0) {
        $html .= '?category=' . $category . '&catName=' .$catName ; 
    }
    $html .= '">' . "\r\n";
    $html .= '<button type="button" class="btn btn-default">戻る</button></a></div>' . "\r\n";
    print $html;
?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php
    include("footer.php");
?>