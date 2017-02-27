<?php
        include("header.php");
        include("sidebar.php");
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">質問</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-11">
                 
<?php
    require_once('./common/DBConnect.php');
    require_once('./common/Config.php');

    $category = 0;
    $catName = "";
    $category_id = 0;
    $category_name = "";
    $title = "";
    $question_id = 0;
    $question = "";
    $drafter = "";
    $qdate = "";
    $priority = "";
    $status = "";

    $params = array();

    if(isset($_REQUEST['params'])) {
        $params = explode('&', $_REQUEST['params']);
        $param = array();

        foreach($params as $str){
            $param = explode('=', $str);
            if($param[0] == 'category') {
                $category = $param[1];
            }
            if($param[0] == 'catName') {
                $catName = $param[1];
            }
            if($param[0] == 'category_id') {
                $category_id = $param[1];
            }
            if($param[0] == 'category_name') {
                $category_name = $param[1];
            }
            if($param[0] == 'title') {
                $title = $param[1];
            }
            if($param[0] == 'question_id') {
                $question_id = $param[1];
            }
            if($param[0] == 'question') {
                $question = $param[1];
            }
            if($param[0] == 'drafter') {
                $drafter = $param[1];
            }
            if($param[0] == 'qdate') {
                $qdate = $param[1];
            }
            if($param[0] == 'priority') {
                $priority = $param[1];
            }
            if($param[0] == 'status') {
                $status = $param[1];
            }           
        }
    }
    $dbh = connect();
   
    $html = '<p><font color="red"><span id="result"></span></font></p>' . "\r\n";
    $html .= '<div class="panel panel-default">' . "\r\n";
    $html .= '<div class="panel-heading">' . "\r\n";
    $html .= '<font color="blue"><label>質問</label></font>&nbsp;&nbsp;&nbsp;&nbsp;NO.'. $question_id  . "\r\n";
    $html .= '</div>' . "\r\n";
    $html .= '<div class="panel-body">' . "\r\n";
    $html .= '<div class="row">' . "\r\n";
    $html .= '<form role="form" id="f" method="post">' . "\r\n";
    $html .= '<div class="form-group col-lg-3">' . "\r\n";
    $html .= '<label>カテゴリー</label>' . "\r\n";
    $html .= '<div>'. mb_convert_encoding(urldecode($category_name), 'UTF-8', 'AUTO') . '</div>' . "\r\n";
    $html .= '</div>' . "\r\n";
    $html .= '<br><br><br><br>' . "\r\n";
    $html .= '<div class="form-group col-lg-8">' . "\r\n";
    $html .= '<label>タイトル<font color="red">*</font></label>' . "\r\n";
    if (empty($title)) {
        $html .= '<input class="form-control" id="title">' . "\r\n";
    } else {
        $html .= '<input class="form-control" id="title" value="' . mb_convert_encoding(urldecode($title), 'UTF-8', 'AUTO') . '">' . "\r\n";
    }
    $html .= '</div>' . "\r\n";                              
    $html .= '<div class="form-group col-lg-11">' . "\r\n";
    $html .= '<label>質問<font color="red">*</font></label>' . "\r\n";
    if (empty($question)) {
        $html .= '<textarea class="form-control" rows="8" id="question"></textarea>' . "\r\n";
    } else {
        $html .= '<textarea class="form-control" rows="8" id="question">' . mb_convert_encoding(urldecode($question), 'UTF-8', 'AUTO') . '</textarea>' . "\r\n";
    }
    $html .= '<input type="hidden" id="question_id" name="question_id" value="' . $question_id . '" />' . "\r\n";    
    $html .= '</div>' . "\r\n";
    $html .= '<div class="form-group col-lg-11">' . "\r\n";
    $html .= '<label>起案者</label>' . "\r\n";
    $html .= '<select class="form-control" style="width: 300px" id="drafter">' . "\r\n";
    // 起案者取得
    $sql = "SELECT * FROM user ORDER BY id";
    $result = $dbh->prepare($sql);
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row['id'] == $drafter) {
            $html .= '<option selected value="' . $row['id'] . '">' . "\r\n"; 
            $html .= $row['name'] . '</option>' . "\r\n";
        } else {
            $html .= '<option value="' . $row['id'] . '">' . "\r\n"; 
            $html .= $row['name'] . '</option>' . "\r\n";           
        }
    }   
    $html .= '</select>' . "\r\n";
    $html .= '</div>' . "\r\n"; 

    $html .= '<div class="form-group col-lg-8" >' . "\r\n";
    $html .= '<label>起案日</label>' . "\r\n";
    if (empty($qdate)) {
        $html .= '<input class="form-control" id="qdate">' . "\r\n";
    } else {
        $html .= '<input class="form-control" id="qdate" value="' . mb_convert_encoding(urldecode($qdate), 'UTF-8', 'SJIS') . '">' . "\r\n";
    }
    $html .= '</div>' . "\r\n";
    $html .= '<div class="form-group col-lg-12" >' . "\r\n";
    $html .= '<label>優先度</label>' . "\r\n";
    $html .= '<select class="form-control" style="width: 80px" id="priority">' . "\r\n";
    switch ($priority) {
        case 1:
            $html .= '<option selected value="1">' . PRIORITY1 . '</option>' . "\r\n";
            $html .= '<option value="2">' . PRIORITY2 . '</option>' . "\r\n";
            $html .= '<option value="3">' . PRIORITY3 . '</option>' . "\r\n";
            break;
        case 2:
            $html .= '<option value="1">' . PRIORITY1 . '</option>' . "\r\n";
            $html .= '<option selected value="2">' . PRIORITY2 . '</option>' . "\r\n";
            $html .= '<option value="3">' . PRIORITY3 . '</option>' . "\r\n";
            break;           
        case 3:
            $html .= '<option value="1">' . PRIORITY1 . '</option>' . "\r\n";
            $html .= '<option value="2">' . PRIORITY2 . '</option>' . "\r\n";
            $html .= '<option selected value="3">' . PRIORITY3 . '</option>' . "\r\n";
            break;
    }
    $html .= '</select>' . "\r\n";
    $html .= '</div>' . "\r\n";
    $html .= '<div class="form-group col-lg-11" >' . "\r\n";
    $html .= '<label>ステータス</label>' . "\r\n";
    $html .= '<select class="form-control" style="width: 120px" id="status">' . "\r\n";
    switch ($status) {
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
    $html .= '<div align="right"><button type="submit" id="qUpdate" class="btn btn-default">更新</button>&nbsp;&nbsp;' . "\r\n";
    $html .= '<a href="index.php' . "\r\n";
    if ($category != 0) {
        $html .= '?category=' . $category . '&catName=' . $catName . "\r\n"; 
    }
    $html .= '"><button type="button" class="btn btn-default">戻る</button></a></div>' . "\r\n";
    $html .= '</div>' . "\r\n"; 
    $html .= '</div><!-- /.row (nested) -->' . "\r\n"; 
    $html .= '</form>' . "\r\n";

    print $html;
?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
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