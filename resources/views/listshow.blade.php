<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table border="1">
    <input type="button" name="start" value="开始">
    <input type="button" name="end" value="停止">
    <input type="button" name="del" value="清空">

    <input type="hidden" id="aaaa" name="page" value="1">
    <tr class="ab">
        <td>id</td>
        <td>昵称</td>
        <td>价格</td>
    </tr>
    <tbody id="aab">

    </tbody>
</table>
</body>
</html>
<script src="./js/j.js"></script>

<script>
    num = "";
    page = 0;
    $("input[name='start']").click(function(){
        clearInterval(num);
        var res = setInterval(function(){
            page++
           $.post(
               'aoteman',
               {page:page},
               function(res){
                    $("#aab").append(res.info);
               }
           );
        },2000);
        num = res;
    });
    $("input[name='end']").click(function(){
        clearInterval(num);
    });
    $("input[name='del']").click(function(){
            $.post(
                'aotemandel',
                function(res){
                    location.href = "";
                }
            );
    });
</script>