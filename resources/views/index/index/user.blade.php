<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/layui/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
            
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>信息流 - 滚动加载</legend>
</fieldset>
 
<ul class="flow-default" id="LAY_demo1"></ul>
 
           
          
<script src="/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use('flow', function(){
  var flow = layui.flow;
 
  flow.load({
    elem: '#LAY_demo1' 
    ,done: function(page, next){ //执行下一页的回调
      
      $.ajax({
        url:'indexInfo',
        type:'post',
        success:function(res){
          console.log(res);
        }
      })
        
        //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
        //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
        next(lis.join(''), page < 10); //假设总页数为 10
      }, 500);
    }
  });
  
});
</script>

</body>
</html>