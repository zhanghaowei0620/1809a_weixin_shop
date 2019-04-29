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
    <script src="/js/jquery.min.js"></script>
    <script src="/js/qrcode.min.js"></script>
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

        <!-- 焦点图 -->
        <div class="hotimg-wrapper">
            <div class="hotimg-top"></div>
            <section id="gallery" class="hotimg">
                <ul class="slides" style="width: 600%; transition-duration: 0.4s; transform: translate3d(-828px, 0px, 0px);">
                    <li style="width: 414px; float: left; display: block;" class="clone">

                        <a href="https://img.1yyg.net/Poster/20170227170302909.png">
                            <img src="{{URL::asset('goodsimg/'.$data[0]->goods_img)}}">
                        </a>
                    </li>

                </ul>
            </section>
        </div>
        <!-- 产品信息 -->
        <div class="pro_info">
            <h2 class="gray6">
                <span class="ubva">{{$data[0]->goods_name}}</span>
                (第<em id='Period'>10363</em>潮)
                </span>
            </h2>
            <div class="purchase-txt gray9 clearfix">
                价值：￥{{$data[0]->goods_selfprice}}
            </div>
            <div class="clearfix">

                <div class="gRate">
                    <div class="Progress-bar">
                        <p class="u-progress" title="已完成90%">
                                    <span class="pgbar" style="width:90%;">
                                        <span class="pging"></span>
                                    </span>
                        </p>
                        <ul class="Pro-bar-li">
                            <li class="P-bar01"><em>27</em>已参与</li>
                            <li class="P-bar02"><em>30</em>总需人次</li>
                            <li class="P-bar03"><em>3</em>剩余</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--本商品已结束-->

        </div>

        <button class="layui-btn layui-btn-danger" id="asdasdasd" goods_id="{{$data[0]->goods_id}}">加入购物车</button>
        <!--揭晓倒计时-->
        <div id="divLotteryTime" class="Countdown-con">
            <p class="declare">声明：所有商品及活动均与苹果公司（Apple Inc）无关。</p>
            <div class="state">
                <em></em>
                <span>我已阅读《潮购声明》</span>
            </div>
            <div class="guide">您还没有参与哦，试试吧！</div>
        </div>
        <div class="imgdetail">
            <div class="ann_btn">
                <a href="">图文详情<s class="fr"></s></a>
            </div>
        </div>
        <div id="qrcode"></div>

        <div class="pro_foot">
            <a href="" class="">第10364潮正在进行中<span class="dotting"></span></a>
            <a href="" class="shopping">立即参与</a>
            </a><span class="fr" id='zxczxczxc'><i><b num="1" id="bnm"></b></i></span>
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
    var qrcode = new QRCode('qrcode',{
        text:'{{$current_url}}',
        width:256,
        height:256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });

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
                // console.log(goods_id);
                $.post(
                    'goodsCart',
                    {goods_id:goods_id},
                    function(res){
                        if(res.code==0){
                            layer.msg(res.font);
                            $('#bnm').html(res.num);
                        }else if(res.code==1){
                            layer.msg(res.font,{time:3000})
                            location.href='login';
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
