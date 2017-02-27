            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="register.php"><i class="fa fa-edit fa-fw"></i> 登録</a>
                        </li>
                    	<li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> カテゴリー<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
<?php
    require_once('./common/DBConnect.php');

    $dbh = connect();

    // カテゴリ取得
    $sql = "SELECT * FROM category ORDER BY category_id";
    $result = $dbh->prepare($sql);
    $result->execute();

    $html = '';
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<li><a href="index.php?category='. $row["category_id"]; 
        $html .= ' &catName=' . $row["category_name"] . '">';
        $html .= $row["category_name"] . '</a>';
        $html .= '</li>'; 
    }

    print $html;

    close($dbh);
?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>