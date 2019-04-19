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
    <table border=1>
    是否上架<select name="" id="is_up">
                <option value="">选择</option>
                <option value="1">是</option>
                <option value="2">否</option>
            </select>
     是否热卖<select name="" id="is_hot">
                <option value="">选择</option>
                <option value="1">是</option>
                <option value="2">否</option>
            </select>
            <input type="button" value="搜索" id="btn">
        <tr>
            <td>ID</td>
            <td>名称</td>
            <td>分类</td>
            <td>描述</td>
            <td>是否上架</td>
            <td>是否热卖</td>
            <td>操作</td>
        </tr>
        <tbody id="tr">
        @foreach($data as $k=>$v)
        
        <tr id="{{$v->id}}">
            <td>{{$v->id}}</td>
            <td><span class="bbb">{{$v->username}}</span>
                <input type="text" value="{{$v->username}}" style="display:none" class="aaa">
            </td>
            <td>{{$v->cate_name}}</td>
            <td>{{$v->desc}}</td>
            <td>
                @if($v->is_up == 1)
                是
                @else
                否
                @endif
            </td>
            <td>
                @if($v->is_hot == 1)
                是
                @else
                否
                @endif
            </td>
            <td>
                <a href="javascript:;" class="update">修改</a>
                <a href="javascript:;" class="del">删除</a>
            </td>
        </tr>
        @endforeach
        <tbody>
    </table>
    {{$data->appends(['is_hot'=>$is_hot,'is_up'=>$is_up])->render()}}
</body>
</html>
<script>
    $(function(){
        //删除
        $('.del').click(function(){
            var isdel=window.confirm('是否删除');
            if(isdel==true){
                var _this=$(this);
                var id=_this.parents('tr').attr('id');
                // console.log(id);
                $.ajax({
                    url:"del",
                    method:"post",
                    data:{id:id},
                    success:function(res){
                        if(res=='ok'){
                            alert('删除成功');
                            location.href='list';
                        }
                    }
                })
            }
        })
        //修改
        $('.update').click(function(){
            var isupdate=window.confirm('是否修改');
            if(isupdate==true){
                var _this=$(this);
                var id=_this.parents('tr').attr('id');
                location.href='update?id='+id;
                
            }
        })
        //搜索
        $('#btn').click(function(){
            var is_hot=$('#is_hot').val();
            var is_up=$('#is_up').val();
            // $.ajax({
            //         url:"list",
            //         method:"post",
            //         data:{is_hot:is_hot,is_up:is_up},
            //         success:function(res){
            //             console.log(res);
            //            // location.href='list?is_hot='+is_hot+',is_up='+is_up;
            //         },
            //         'json'
            //     })
            $.post(
                    "list",
                    {is_hot:is_hot,is_up:is_up},
                    function(result){
                       //console.log(result.data.data)
                       $(result.data.data).each(function(i,v){
                        _tr=    "<tr id="+{{$v->id}}+">"
                                +"<td>"+{{$v->id}}+"</td>"
                                +"<td><span class='bbb'>{{$v->username}}</span>"+"<input type='text' value='{{$v->username}}' style='display:none' class='aaa'></td>"
                                +"<td>{{$v->cate_name}}</td>"
                                +"<td>{{$v->desc}}</td>"
                                +"<td>{{$v->is_up}}</td>"
                                +"<td>{{$v->is_hot}}</td>"
                                +"<td></td>"
                            "</tr>"
                            $('#tr').html(_tr);
                       })
                    },'json'
                )
                
        })
        //即点即改
        $('.bbb').click(function(){
            var _this=$(this);
            _this.empty();
            var style=_this.next().show();
        })
        $(".aaa").blur(function(){
            var _this=$(this);
            var style=_this.hide();

            var username=_this.val();
            var id=_this.parents('tr').attr('id');
            $.ajax({
                    url:"gai",
                    method:"post",
                    data:{id:id,username:username},
                    success:function(res){
                        location.href='list';
                    }
                })

        })
    })
</script>
