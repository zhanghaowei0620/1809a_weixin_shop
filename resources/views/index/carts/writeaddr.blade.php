<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>填写收货地址</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/writeaddr.css">
    <link rel="stylesheet" href="layui/css/layui.css">
    <link rel="stylesheet" href="dist/css/LArea.css">
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">填写收货地址</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a class="m-index-icon">保存</a>
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">  
  
</form> -->
<form class="layui-form">
  <div class="addrcon">
    <ul>
      <li><em>收货人</em><input type="text" name="add_name" placeholder="请填写真实姓名"></li>
      <li><em>手机号码</em><input type="number" name="add_tel" placeholder="请输入手机号"></li>
      <li><em>所在区域</em><input  type="text" name="add_province"  placeholder="请选择所在区域"></li>
      <li class="addr-detail"><em>详细地址</em><input type="text" name="add_details" placeholder="20个字以内" class="addr"></li>
    </ul>
    <div class="setnormal"><span>设为默认地址</span><input type="checkbox" name="is_default" value="2" lay-skin="switch"></div>
  </div>
  <!-- <button class="layui-btn m-index-icon" lay-submit lay-filter="*">立即提交</button> -->
</form>

<!-- SUI mobile -->
<script src="dist/js/LArea.js"></script>
<script src="dist/js/LAreaData1.js"></script>
<script src="dist/js/LAreaData2.js"></script>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="layui/layui.js"></script>
<script>
  $('.m-index-icon').click(function(){
    var add_name=$("[name='add_name']").val();
    var add_tel=$("[name='add_tel']").val();
    var add_province=$("[name='add_province']").val();
    var add_details=$("[name='add_details']").val();
    var is_default=$("[name='is_default']").prop('checked');
    // console.log(is_default)
    if(is_default == true){
            is_default = 1;
        }else{
            is_default = 2;
        }
        console.log(is_default)
    $.post(
      'witeaddradd',
      {add_name:add_name,add_tel:add_tel,add_province:add_province,add_details:add_details,is_default:is_default},
      function(res){
        // console.log(res)
        if(res == 'ok'){
          location.href = 'address';
        }
      }
    )
  })
</script>

<!-- <script>
  layui.use(['form','layer'],function(){
 	var form=layui.form;
 	var layer=layui.layer;
   $('.m-index-icon').click(function(){
         //监听提交
 		form.on('submit(*)',function(data){
 			  $.post(
 			  		"witeaddradd",
 			  		data.field,
 			  		function(res){
 			  				console.log(res)
 			  			}
 			  			, 'json'
 			  	);
			  return false;
 		})


   })
  })
</script> -->






 <script>
  //Demo
layui.use('form', function(){
  var form = layui.form();
  
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});

var area = new LArea();
// area.init({
//     'trigger': '#demo1',//触发选择控件的文本框，同时选择完毕后name属性输出到该位置
//     'valueTo':'#value1',//选择完毕后id属性输出到该位置
//     'keys':{id:'id',name:'name'},//绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
//     'type':1,//数据源类型
//     'data':LAreaData//数据源
// });


</script>


</body>
</html>
