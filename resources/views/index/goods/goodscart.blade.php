<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link href="css/cartlist.css" rel="stylesheet" type="text/css" />
</head>
<body id="loadingPicBlock" class="g-acc-bg">
    <input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
    <div>
        <!--首页头部-->
        <div class="m-block-header">
            <a href="/" class="m-public-icon m-1yyg-icon"></a>
            <a href="/" class="m-index-icon">编辑</a>
        </div>
        <!--首页头部 end-->
        @if($cartnum != 0)
        <div class="g-Cart-list">
            <ul id="cartBody">
            @foreach($info as $v)
                <li class="qweqweqe" goods_id="{{$v->goods_id}}" goods_selfprice="{{$v->goods_selfprice}}" buy_number="{{$v->buy_number}}">
                    <s class="xuan"  goods_id="{{$v->goods_id}}"></s>
                    <a class="fl u-Cart-img" href="goodsList?goods_id={{$v->goods_id}}">
                        <img src="{{URL::asset('goodsimg/'.$v->goods_img)}}" border="0" alt="">
                    </a>
                    <div class="u-Cart-r">
                        <a href="goodsList?goods_id={{$v->goods_id}}" class="gray6">{{$v->goods_name}}</a>
                        <span class="gray9">
                            <em>￥{{$v->goods_selfprice}}</em>
                        </span>
                        <!-- asfghrwtjeyrkuyjthrgwasdasfcdavfdsvdavdaverhtjykrhegwhrtjykjthehwtejyk -->
                        <div class="num-opt">
                            <em class="num-mius dis min"><i></i></em>
                            <input class="text_box" name="num" maxlength="6" onkeyup="value=(parseInt((value=value.replace(/\D/g,''))==''||parseInt((value=value.replace(/\D/g,''))==0)?'1':value,10))" onafterpaste="value=(parseInt((value=value.replace(/\D/g,''))==''||parseInt((value=value.replace(/\D/g,''))==0)?'1':value,10))" type="number" goods_id="{{$v->goods_id}}" value="{{$v->buy_number}}" codeid="12501977">
                            <em class="num-add add"><i></i></em>
                        </div>



                        <a href="javascript:;" name="delLink" cid="12501977" isover="0" class="z-del" goods_id="{{$v->goods_id}}"><s></s></a>
                    </div>    
                </li>
             @endforeach
             </ul>
        </div>
        @else
        <div id="divNone" class="empty "><s></s><p>您的购物车还是空的哦~</p><a href="goodsCate" class="orangeBtn">立即潮购</a></div>
        @endif
        
        <div id="mycartpay" class="g-Total-bt g-car-new" style="">
            <dl>
                <dt class="gray6">
                    <s class="quanxuan"></s>全选
                    <p class="money-total">合计<em class="orange total"><span>￥</span><span class="ssspan">00.00<span></em></p>
                    
                </dt>
                <dd>
                    <a href="javascript:;" id="del_payment" class="orangeBtn w_account remove">删除</a>
                    <a href="javascript:;" id="a_payment" class="orangeBtn w_account">去结算</a>
                </dd>
            </dl>
        </div>
        <div class="hot-recom">
            <div class="title thin-bor-top gray6">
                <span><b class="z-set"></b>人气推荐</span>
                <em></em>
            </div>
            <div class="goods-wrap thin-bor-top">
                <ul class="goods-list clearfix">
                @foreach($infodata as $v)
                    <li>
                        <a href="goodsList?goods_id={{$v->goods_id}}" class="g-pic">
                            <img  src="{{URL::asset('goodsimg/'.$v->goods_img)}}" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="goodsList?goods_id={{$v->goods_id}}">{{$v->goods_name}}</a>
                        </p>
                        <ins class="gray9">价值:￥{{$v->goods_selfprice}}</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

       
        

<div class="footer clearfix">
<ul>
        <li class="f_home"><a href="index"><i></i>潮购</a></li>
        <li class="f_announced"><a href="goodsCate" ><i></i>所有商品</a></li>
        <li class="f_single"><a href="/v41/post/index.do" ><i></i>最新揭晓</a></li>
        <li class="f_car"><a id="btnCart" href="listCart"  class="hover"><i></i>购物车</a></li>
        <li class="f_personal"><a href="userpage" ><i></i>我的潮购</a></li>
    </ul>
</div>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="layui/layui.js"></script> 
<!---商品加减算总数---->

<script>
  layui.use('layer', function(){
    var layer=layui.layer;
    $('.z-del').click(function(){

        _this=$(this);
        var goods_id=_this.attr('goods_id');
        $.post(
            'goodsDel',
            {goods_id:goods_id},
            function(res){
                layer.msg('删除成功');
                _this.parents('li').remove();
            }
        )
    })

    //修改文本框值
    $('.text_box').blur(function(){
        var _this=$(this)
        var goods_id = _this.attr('goods_id')
        var goods_value = _this.val();
        $.post(
            'goodsValue',
            {goods_id:goods_id,goods_value:goods_value},
            function(res){
                if(res.num==1){
                        layer.msg(res.msg);
                        _this.val(res.buy_number);
                    }
            }
        )
    })

    //结算
    $('#a_payment').click(function(){
            var goods_id = [];
            var zongjia = $('.ssspan').html();
            // console.log(zongjia);
            $(".g-Cart-list .xuan").each(function () {
                   if($(this).hasClass("current")){
                       goods_id.push($(this).attr('goods_id'));
                   }
            });
            // location.href='cartList';
            $.post(
                'cartList',
                {goods_id:goods_id,zongjia:zongjia},
                function(res){
                    var order_id=res.order_id;
                    // console.log(order_id)
                    if(res.num==0){
                        layer.msg(res.msg);
                    }else if(res.num==1){
                        layer.msg(res.msg);
                        location.href='login'
                    }else if(res.num==3){
                        location.href='cartshow?order_id='+order_id;
                    }
                }
            )
    })
  })
</script>















    <script type="text/javascript">
    $(function () {
        layui.use('layer', function(){
            var layer = layui.layer;
            //加
        $(".add").click(function () {
            var t = $(this).prev();
            var ccc=$('.text_box').val();
            var xxxx=t.val(parseInt(t.val()) + 1);
            var goods_id=$(this).parents('li').attr('goods_id');
            $.post(
                'scartAdd',
                {goods_id:goods_id},
                function(res){
                    if(res.num==0){
                        layer.msg(res.msg);
                        var xxxx=t.val(parseInt(t.val())-1);
                    }
                }
            )
            GetCount();
        })
        //减
        $(".min").click(function () {
            var t = $(this).next();
            var ccc=$('.text_box').val();
            var goods_id=$(this).parents('li').attr('goods_id');
            if(t.val()>1){
                t.val(parseInt(t.val()) - 1);
                $.post(
                'scartMin',
                {goods_id:goods_id},
                function(res){

                }
            )
            }
            GetCount();
        })
        //批量删除
        $(document).on('click','.remove',function(){
            var goods_id = [];
            $(".g-Cart-list .xuan").each(function () {
                   if($(this).hasClass("current")){
                       goods_id.push($(this).attr('goods_id'));
                   }
                //    console.log(goods_id);
            });
            $.post(
                'cartAllDel',
                {goods_id:goods_id},
                function(res){
                    // console.log(res);
                    if(res.num == 1){
                        // console.log(res);
                        layer.msg(res.msg)
                        window.location.reload();
                    }else{
                        layer.msg(res.msg)
                    }
                }
            )
        })
    })
    })
    </script>



    
    <script>

    // 全选        
    $(".quanxuan").click(function () {
        if($(this).hasClass('current')){
            $(this).removeClass('current');
             $(".g-Cart-list .xuan").each(function () {
                    $(this).removeClass("current");
                    GetCount();
            });
        }else{
            $(this).addClass('current');
            $(".g-Cart-list .xuan").each(function () {
                   $(this).addClass("current");
                  
                   GetCount();
            //         $.post(
            //             'zongjia',
            //             function(res){
            //                 console.log(res)
            //             }
            //         )
            //        $('#ssspan').html();
             });
            
        }
        
    });
    // 单选
    $(".g-Cart-list .xuan").click(function () {
        if($(this).hasClass('current')){
            

            $(this).removeClass('current');
            GetCount()
            // var goods_selfprice=$(this).parents('li').attr('goods_selfprice');
            // var buy_number=$(this).parents('li').attr('buy_number');
            // var zon=goods_selfprice * buy_number;
            // var qian=$('#ssspan').text();
            // var money=parseInt(qian)-parseInt(zon);
            // $('#ssspan').html(money);
        }else{
            $(this).addClass('current');
            GetCount()
            // var goods_id=$(this).parents('li').attr('goods_id');
            // var goods_selfprice=$(this).parents('li').attr('goods_selfprice');
            // var buy_number=$(this).parents('li').attr('buy_number');

            // var zon=goods_selfprice * buy_number;
            // var qian=$('#ssspan').text();
            // var money=parseInt(zon)+parseInt(qian);
            // // var money =zon+qian;
            // // console.log(money);
            // $('#ssspan').html(money);
        }
        if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                $('.quanxuan').addClass('current');

            }else{
                $('.quanxuan').removeClass('current');
            }
        // $("#total2").html() = GetCount($(this));

        //alert(conts);
    });
    function GetCount() {
         var conts = 0;
        // var selfprice = 0;
        var allprice=0;
        $(".g-Cart-list .xuan").each(function () {
            if ($(this).hasClass("current")) {
                for (var i = 0; i < $(this).length; i++) {
                     conts += parseInt($(this).parents('li').find('input.text_box').val()) * parseInt($(this).parents('li').attr('goods_selfprice'));
                    // selfprice+=parseInt($(this).parents('li').find('font.selfprice').text());
                    //allprice+=parseInt($(this).parents('li').attr('allprice'));
                }


            }
        });
        
         $(".ssspan").html((conts));
    }//.toFixed(2)
</script>
</body>
</html>
