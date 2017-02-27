$(function() {

    $('#insert').click(function() {
        var hostUrl= './insert.php';
        var category = $("#category").val();
        var title = $("#title").val();
        var question = $("#question").val();
        var drafter = $("#drafter").val();
        var priority = $("#priority").val();
        // 必須チェック
        if (category == "") {
            alert("カテゴリーの指定がありません。");
            return false;
        }

        if (title == "") {
            alert("タイトルの入力がありません。");
            return false;
        }

        if (question == "") {
            alert("質問の入力がありません。");
            return false;
        }

        $.ajax({
            type: "post",
            url: hostUrl,
            dataType : 'text',
            data: {
                "category": category, "title": title, "question": question, 
                "drafter": drafter, "priority": priority
            }
        }).done(function (data) {
            if (data == 0) {
                $("#result").text("登録しました。");
                //$("#insert").prop("disabled", true);
            } else {
                $("#result").text("登録できませんでした。");
            }
        }).fail(function (data) {
            $("#result").text("通信エラーが発生しました。");
        });

        return false; 
    });

    $('#cInsert').click(function() {
        var hostUrl = './c_insert.php';
        var category = $("#category").val();
        var catName = $("#catName").val();
        var question_id = $("#question_id").val();
        var comment = $("#answer").val();
        var respondent = $("#user").val();
        var status = $("#status").val();

        $.ajax({
            type: "post",
            url: hostUrl,
            dataType : 'text',
            data: {
                "question_id": question_id, "comment": comment, 
                "respondent": respondent, "status": status
            }
        }).done(function (result) {        
            var link = "./comment.php?question_id=" + question_id + "&result_flg=" + result;
            if (category != 0){
                link = link + "&category=" + category + "&catName=" + catName;
            }

            location.href = link;

        }).fail(function (result) {
            $("#result").text("通信エラーが発生しました。");            
        });

        return false;

    });

    $('#commentArea').find('button').click(function() {
        //if ($(this).attr('id').indexOf('cUpdate') != -1) {
        //}

        if ($(this).attr('id').indexOf('cDelete') != -1) {
            var hostUrl = './c_delete.php'; 
            var category = $("#category").val();
            var catName = $("#catName").val();
            var question_id = $("#question_id").val();
            var comment_id = $("#comment_id").val();

            $.ajax({
                type: "post",
                url: hostUrl,
                dataType : 'text',
                data: { "comment_id": comment_id }
            }).done(function (result) {

                var link = "./comment.php?question_id=" + question_id + "&result_flg=" + result;
                if (category != 0){
                    link = link + "&category=" + category + "&catName=" + catName;
                }

                location.href = link;

            }).fail(function (relult) {
                $("#result").text("通信エラーが発生しました。");
            });

            return false; 
        }
    });

    $('#change').click(function() {
        var params = $('#f').serialize();

        $('#f').append($('<input>',{type:'hidden',id:'params', name:'params',value:params}));
        $('#f').attr('action', './edit.php');
　       $('#f').submit();
    });

    $('#qUpdate').click(function() {
        var hostUrl= './q_update.php';
        var title = $("#title").val();
        var question_id = $("#question_id").val();
        var question = $("#question").val();
        var drafter = $("#drafter").val();
        var qdate = $("#qdate").val();
        var priority = $("#priority").val();
        var status = $("#status").val();

        // 必須チェック
        if (title == "") {
            alert("タイトルの入力がありません。");
            return false;
        }

        if (question == "") {
            alert("質問の入力がありません。");
            return false;
        }

        // フォーマットチェック
        var strDate = qdate.replace( /\//g , "-" ) ;
        if(!strDate.match(/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) (0[1-9]|1[0-9]|2[0-3]):([0-5][1-9]):([0-5][1-9])$/)){
            alert("日付のフォーマットが正しくありません。");
            return false;
        }

        $.ajax({
            type: "post",
            url: hostUrl,
            dataType : 'text',
            data: {
                "title": title, "question_id": question_id,  "question": question, 
                "qdate": qdate, "drafter": drafter, "status": status, "priority": priority
            }
        }).done(function (data) {
            if (data == 0) {
                $("#result").text("更新しました。");
            } else {
                $("#result").text("更新に失敗しました。");
            }
        }).fail(function (data) {
            $("#result").text("通信エラーが発生しました。");
        });

        return false; 
    });

    $('#delete').click(function() {
            var hostUrl = './q_delete.php'; 
            var category = $("#category").val();
            var catName = $("#catName").val();
            var question_id = $("#question_id").val();

            $.ajax({
                type: "post",
                url: hostUrl,
                dataType : 'text',
                data: { "question_id": question_id }
            }).done(function (result) {

                var link = "./comment.php?question_id=" + question_id + "&result_flg=" + result;
                if (category != 0){
                    link = link + "&category=" + category + "&catName=" + catName;
                }

                location.href = link;

            }).fail(function (relult) {
                $("#result").text("通信エラーが発生しました。");
            });

            return false; 
    });

});
