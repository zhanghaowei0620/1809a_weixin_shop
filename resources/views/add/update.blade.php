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
        <input type="hidden" name="id" value="{{$data->id}}" id="id">
            <tr>
                <td>名称：</td>
                <td>
                    <input type="text" name="username" id="username" value="{{$data->username}}">
                </td>
            </tr>
            <tr>
                <td>分类：</td>
                <td>
                <select name="cate_id" id="cate_id">
                    @foreach($datas as $k=>$v)
                    @if($v->cate_id == $data->cate_id)
                    <option value="{{$v->cate_id}}" selected>{{$v->cate_name}}</option>
                    @else
                    <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                    @endif
                    @endforeach
                </select>
                </td>
            </tr>
            <tr>
                <td>描述：</td>
                <td>
                    <input type="text" name="desc" id="desc" value="{{$data->desc}}">
                </td>
            </tr>
            <tr>
                <td>是否热卖：</td>
                <td>
                    <input type="radio" value="1" name="is_hot" @if($data->is_hot ==1)checked @endif>是
                    <input type="radio" value="2" name="is_hot" @if($data->is_hot ==2)checked @endif>否
                </td>
            </tr>
            <tr>
                <td>是否上架：</td>
                <td>
                    <input type="radio" value="1" name="is_up" @if($data->is_up ==1)checked @endif>是
                    <input type="radio" value="2" name="is_up" @if($data->is_up ==2)checked @endif>否
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" value="修改" id="formDemo"></td>
            </tr>
        </table>
    </form>
</body>
</html>
<script>
    $(function(){
        $('#formDemo').click(function(){
            var username=$('#username').val();
            var id=$('#id').val();
            var cate_id=$('#cate_id').val();
            var desc=$('#desc').val();
            var is_hot=$("input[name='is_hot']:checked").val();
            var is_up=$("input[name='is_up']:checked").val();
            // console.log(is_hot);
            $.ajax({
                url:'updatedo',
                data:{id:id,username:username,cate_id:cate_id,desc:desc,is_hot:is_hot,is_up:is_up},
                method:'post',
            }).done(function (res) {
                console.log(res);
                if(res==1){
                    alert('修改成功');
                    location.href='list';
                }else{
                    alert('未修改');
                    location.href='update?id='+id;
                }
            })
        });
    })
</script>

