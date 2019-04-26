<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>商品详情</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link href="css/goods.css" rel="stylesheet" type="text/css" />
    <link href="css/fsgallery.css" rel="stylesheet" charset="utf-8">
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="layui/css/layui.css">
    <style>
        .Countdown-con {padding: 4px 15px 0px;}
    </style>
</head>
<body fnav="2" class="g-acc-bg">
    <div class="page-group">
        <div id="page-photo-browser" class="page">
            <!--触屏版内页头部-->
        <div class="m-block-header" id="div-header">
            <strong id="m-title">商品详情</strong>
            <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
            <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
        </div>
                <div class="ann_btn partcon" id="tabs-container">
                    <div class="swiper-wrapper">
                        <div class="record-wrapp swiper-slide">
                             <!--所有参与记录-->
                            <div class="part-record">
                                <div class="ann_list">
                                    <div class="fl">
                                        <img src="images/goods2.jpg" alt="">阿珍
                                    </div>
                                </div>
                            </div>
                            <!-- 无内容时显示 -->
                            <div class="nocontent" style="display: none">
                                <div class="m_buylist m_get">
                                    <ul id="ul_list">
                                        <div class="noRecords colorbbb clearfix">
                                            <s class="default"></s>您还没有参与记录哦~
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!--历史获得者 -->
                        <div class="history-winwrapp mb48 swiper-slide">
                            @foreach($historyarrInfo as $v)
                                <div class="history-win">
                                    <div class="win-list clearfix">
                                        <div class="win-left fl">
                                            <p class="chao">浏览记录</p>
                                            <img src="images/goods2.jpg" alt="">
                                        </div>
                                        @foreach($historyarrInfo as $v)
                                            <div class="win-right fl">
                                                <p class="show-time">时间<?php echo date('Y-m-d H:i:s',$v['create_time'])?></p>
                                                <p class="show-code">商品id:{{$v['goods_id']}}</p>
                                                <p class="winner">商品名称{{$v['goods_name']}}</p>
                                                商品图片:<img src="{{URL::asset('goodsimg/'.$v['goods_img'])}}" alt="">
                                                <p class="show-count">价格:{{$v['goods_selfprice']}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            <!-- 无内容时显示 -->
                            <div class="nocontent" style="display: none">
                                <div class="m_buylist m_get">
                                    <ul id="ul_list">
                                        <div class="noRecords colorbbb clearfix">
                                            <s class="default"></s>您还没有参与记录哦~
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="pro_foot">
                        <a href="" class="">第10364潮正在进行中<span class="dotting"></span></a>
                        <a href="" class="shopping">立即参与</a>
                        </a><span class="fr" id='zxczxczxc'><i><b num="1" id="bnm">{{$buy_number}}</b></i></span>
                </div>
            </div>
        </div>
    </div>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="http://cdn.bootcss.com/flexslider/2.6.2/jquery.flexslider.min.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/photo.js" charset="utf-8"></script>
<script src="layui/layui.js"></script>
<script>
    $(function () {
        $('.hotimg').flexslider({
            directionNav: false,   //是否显示左右控制按钮
            controlNav: true,   //是否显示底部切换按钮
            pauseOnAction: false,  //手动切换后是否继续自动轮播,继续(false),停止(true),默认true
            animation: 'slide',   //淡入淡出(fade)或滑动(slide),默认fade
            slideshowSpeed: 3000,  //自动轮播间隔时间(毫秒),默认5000ms
            animationSpeed: 150,   //轮播效果切换时间,默认600ms
            direction: 'horizontal',  //设置滑动方向:左右horizontal或者上下vertical,需设置animation: "slide",默认horizontal
            randomize: false,   //是否随机幻切换
            animationLoop: true   //是否循环滚动
        });
        setTimeout($('.flexslider img').fadeIn());

        // 参与记录、历史获得者左右切换
        // $('.listtab a').click(function(){
        //     $(this).addClass('current').siblings('a').removeClass('current');
        //     if($('.partcon').css('display')=='block'){
        //         $('.partcon').css('display','none');
        //         $('.history-winwrapp').css('display','block');
        //     }else{
        //         $('.partcon').css('display','block');
        //         $('.history-winwrapp').css('display','none');
        //     }
        // })



        // 无内容判断
        if($('.partcon .part-record div.ann_list').length==0){
            $('.partcon .part-record').css('display','none');
            $('.partcon .nocontent').css('display','block');
        }else{
            $('.partcon .part-record').css('display','block');
            $('.partcon .nocontent').css('display','none');
        }


        if($('.history-winwrapp .history-win .win-list').length==0){
            $('.history-winwrapp .history-win').css('display','none');
            $('.history-winwrapp .nocontent').css('display','block');
        }else{
            $('.history-winwrapp .history-win').css('display','block');
            $('.history-winwrapp .nocontent').css('display','none');
        }

        // 滑动
        var tabsSwiper = new Swiper('#tabs-container',{
            speed:500,
            onSlideChangeStart: function(){
              $(".tabs .active").removeClass('active')
              $(".tabs a").eq(tabsSwiper.activeIndex).addClass('active')
            }
        })
        $(".tabs a").on('touchstart mousedown',function(e){
            e.preventDefault()
            $(".tabs .active").removeClass('active')
            $(this).addClass('active')
            tabsSwiper.slideTo( $(this).index() )
        })
        $(".tabs a").click(function(e){
            e.preventDefault()
        })
    })
</script>
</body>
</html>
<script>
    $(function(){
        layui.use('layer', function(){
            var layer=layui.layer;
            $('#asdasdasd').click(function(){
                var _this=$(this);
                var goods_id=_this.attr('goods_id');
                //console.log(goods_id);
                $.post(
                    'goodsCart',
                    {goods_id:goods_id},
                    function(res){
                        if(res.code==0){
                            layer.msg(res.font);
                            $('#bnm').html(res.num);
                        }else{
                            layer.msg(res.font)
                        }

                    },'json'
                )
            })

            $('#bnm').click(function(){
                location.href='listCart';
            })
        })
    })
</script>



