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

    $dbh = connect();
     
    $html = '<p><font color="red"><span id="result"></span></font></p>' . "\r\n";
    $html .= '<div class="panel panel-default">' . "\r\n";
    $html .= '<div class="panel-heading">' . "\r\n";
    $html .= '<font color="blue"><label>質問</label></font>' . "\r\n";
    $html .= '</div>' . "\r\n";
    $html .= '<div class="panel-body">' . "\r\n";
    $html .= '<div class="row">' . "\r\n";
    $html .= '<form role="form" id="f" method="post">' . "\r\n";
    $html .= '<div class="form-group col-lg-3">' . "\r\n";
    $html .= '<label>カテゴリー<font color="red">*</font></label>' . "\r\n";
    $html .= '<select class="form-control" id="category">' . "\r\n";
    // カテゴリ取得
    $sql = "SELECT * FROM category ORDER BY category_id";
    $result = $dbh->prepare($sql);
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<option value="' . $row['category_id'] . '">' . "\r\n"; 
        $html .= $row['category_name'] . '</option>' . "\r\n";
    }
    $html .= '</select>' . "\r\n";
    $html .= '</div>' . "\r\n";
    $html .= '<br><br><br><br>' . "\r\n";
    $html .= '<div class="form-group col-lg-8">' . "\r\n";
    $html .= '<label>タイトル<font color="red">*</font></label>' . "\r\n";
    if (empty($title)) {
        $html .= '<input class="form-control" id="title">' . "\r\n";
    } else {
        $html .= '<input class="form-control" id="title" value="' . $title . '">' . "\r\n";
    }
    $html .= '</div>' . "\r\n";                              
    $html .= '<div class="form-group col-lg-11">' . "\r\n";
    $html .= '<label>質問<font color="red">*</font></label>' . "\r\n";
    $html .= '<textarea class="form-control" rows="8" id="question"></textarea>' . "\r\n";
    $html .= '</div>' . "\r\n";
    $html .= '<div class="form-group col-lg-11">' . "\r\n";
    $html .= '<label>起案者</label>' . "\r\n";
    $html .= '<select class="form-control" style="width: 300px" id="drafter">' . "\r\n";
    // 起案者取得
    $sql2 = "SELECT * FROM user ORDER BY id";
    $result2 = $dbh->prepare($sql2);
    $result2->execute();
    while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<option value="' . $row2['id'] . '">' . "\r\n"; 
        $html .= $row2['name'] . '</option>' . "\r\n";
    }   
    $html .= '</select>' . "\r\n";
    $html .= '<br>' . "\r\n";
    $html .= '<label>優先度</label>' . "\r\n";
    $html .= '<select class="form-control" style="width: 80px" id="priority">' . "\r\n";
    $html .= '<option value="1">' . PRIORITY1 . '</option>' . "\r\n";
    $html .= '<option value="2">' . PRIORITY2 . '</option>' . "\r\n";
    $html .= '<option value="3">' . PRIORITY3 . '</option>' . "\r\n";
    $html .= '</select>' . "\r\n";
    $html .= '<br>' . "\r\n";
    $html .= '<div align="right"><button type="submit" id="insert" class="btn btn-default">登録</button>&nbsp;&nbsp;' . "\r\n";
    $html .= '<a href="index.php"><button type="button" class="btn btn-default">一覧へ</button></a></div>' . "\r\n";
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