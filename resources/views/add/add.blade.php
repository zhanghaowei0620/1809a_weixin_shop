<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/js/j.js"></script>
</head>
<body>
    <form action="insert" method="POST">
        <table>
            <tr>
                <td>名称：</td>
                <td>
                    <input type="text" name="username" id="username">
                </td>
            </tr>
            <tr>
                <td>分类：</td>
                <td>
                    <select name="cate_id" id="cate_id">
                        @foreach($data as $k=>$v)
                        <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>描述：</td>
                <td>
                    <input type="text" name="desc" id="desc">
                </td>
            </tr>
            <tr>
                <td>是否热卖：</td>
                <td>
                    <input type="radio" value="1" name="is_hot" checked>是
                    <input type="radio" value="2" name="is_hot" >否
                </td>
            </tr>
            <tr>
                <td>是否上架：</td>
                <td>
                    <input type="radio" value="1" name="is_up" >是
                    <input type="radio" value="2" name="is_up" checked>否
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" value="提交" id="formDemo"></td>
            </tr>
        </table>
    </form>
</body>
</html>
<script>
    $(function(){
        $('#formDemo').click(function(){
            var username=$('#username').val();
            var cate_id=$('#cate_id').val();
            var desc=$('#desc').val();
            var is_hot=$("input[name='is_hot']:checked").val();
            var is_up=$("input[name='is_up']:checked").val();
            // console.log(is_hot);
            $.ajax({
                url:'insert',
                data:{username:username,cate_id:cate_id,desc:desc,is_hot:is_hot,is_up:is_up},
                method:'post',
            }).done(function (res) {
                if(res==1){
                    alert('添加成功');
                    location.href='list';
                }else{
                    alert('添加失败');
                    location.href='add';
                }
            })
        });
    })
</script>

