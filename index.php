<?php
        include("header.php");
        include("sidebar.php");
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">一覧</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
<?php
    require_once('./common/DBConnect.php');
    require_once('./common/Config.php');

    $category = 0;
    $catName = "";
    $html = "";

    if(isset($_REQUEST['category'])){
        $category = $_REQUEST['category'];
    }

    if(isset($_REQUEST['catName'])){
        $catName = $_REQUEST['catName'];
    }

    $dbh = connect();
    
    // 質問取得
    $sql = "";
    if ($category == 0) {
        $sql .= "SELECT ca.category_id AS category_id, ca.category_name AS catname, "; 
        $sql .= "qu.question_id AS question_id, qu.title AS title, qu.question AS question, ";
        $sql .= "qu.qdate AS qdate, qu.drafter AS drafter, qu.resolved_date AS rdate, ";
        $sql .= "qu.status AS status, u.name AS username, qu.priority AS priority ";
        $sql .= "FROM (question qu "; 
        $sql .= "inner join category ca ";
        $sql .= "on qu.category_id = ca.category_id) ";
        $sql .= "left join user as u ";
        $sql .= "on qu.drafter = u.id ";
        $sql .= "where qu.isdelete = 0 ";
        $sql .= "order by ca.category_id, qu.qdate desc, question_id";
    } else {
        $sql .= "SELECT u.name AS username, ";
        $sql .= "qu.question_id AS question_id, qu.title AS title, qu.question AS question, ";
        $sql .= "qu.qdate AS qdate, qu.drafter AS drafter, qu.resolved_date AS rdate, ";
        $sql .= "qu.status AS status, u.name AS username, qu.priority AS priority ";         
        $sql .= "FROM question qu ";
        $sql .= "left join user as u ";
        $sql .= "on qu.drafter = u.id ";
        $sql .= "where qu.isdelete = 0 ";
        $sql .= "and qu.category_id = " . $category;
        $sql .= " order by qu.qdate desc, qu.question_id";
    }
    $result = $dbh->prepare($sql);
    $result->execute();

    // カテゴリーを選択した場合、表示
    if ($category != 0) {
        $html .= '<div class="panel-heading">';
        $html .=  $catName;                
        $html .= '</div>';
        // <!-- /.panel-heading -->
    }

    $html .= '<div class="panel-body">';
    $html .= '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">';
    $html .= '<thead>';
    $html .= '<tr>';
    if ($category == 0) {
        $html .= '<th width="200px">カテゴリー</th>';
    }
    $html .= '<th width="60px">No</th>';
    $html .= '<th width="500px">タイトル</th>';
    $html .= '<th width="110px">ステータス</th>';
    $html .= '<th width="100px">起案日</th>';
    $html .= '<th width="100px">起案者</th>';
    $html .= '<th width="80px">優先度</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<tr>';
        // カテゴリ
        if ($category == 0){
            $html .= '<td>' . $row["catname"] . '</td>';
        }
        // 質問No
        $html .= '<td>' . $row["question_id"] .  '</td>';
        // タイトル
        $html .= '<td><a href="comment.php?';
        if ($category != 0) {
            $html .= 'category=' . $category . '&catName=' .$catName . "&"; 
        }
        $html .= 'question_id=' . $row["question_id"] . '">' . $row["title"] . '</a></td>';
        // ステータス
        switch ($row["status"]) {
            case 1:
                $html .= '<td>' . STATUS1 . '</td>';
                break;
            case 2:
                $html .= '<td>' . STATUS2 . '</td>';
                break;
            case 3:
                $html .= '<td>' . STATUS3 . '</td>';
                break;
            case 4:
                $html .= '<td>' . STATUS4 . '</td>';
                break;
            case 5:
                $html .= '<td>' . STATUS5 . '</td>';
                break;
        } 
        // 起案日
        $date = new DateTime($row["qdate"]);
        $value = $date->format('Y/m/d'); 
        $html .= '<td>' . $value . '</td>';
        // 起案者  
        $html .= '<td>' . $row["username"] . '</td>';
        // 優先度 
        switch ($row["priority"]) {
            case 1:
                $html .= '<td align="center">' . PRIORITY1 . '</td>';
                break;
            case 2:
                $html .= '<td align="center">' . PRIORITY2 . '</td>';
                break;
            case 3:
                $html .= '<td align="center">' . PRIORITY3 . '</td>';
                break;
        }  
        $html .= '</tr>'; 
     }
                                                      
    print $html;

    close($dbh);
?>                                   
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
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