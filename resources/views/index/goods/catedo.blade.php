<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>商品列表</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content="app-id=518966501" name="apple-itunes-app" />
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport" />
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        <meta content="telephone=no" name="format-detection" />
        <link rel="stylesheet" href="css/mui.min_1.css">
        <link href="css/comm.css" rel="stylesheet" type="text/css" />
        <link href="css/goods.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="layui/css/layui.css">
    </head>

    <body class="g-acc-bg" fnav="0" style="position: static">
    <div class="page-group">
        <div id="page-infinite-scroll-bottom" class="page">

            <!--触屏版内页头部-->
            <div class="m-block-header" id="div-header" style="display: none">
                <strong id="m-title"></strong>
                <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
                <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
            </div>

            <div class="pro-s-box thin-bor-bottom" id="divSearch">
                <div class="box">
                    <div class="border">
                        <div class="border-inner"></div>
                    </div>
                    <div class="input-box">
                        <i class="s-icon"></i>
                        <input type="text" placeholder="输入“汽车”试试" id="txtSearch" />
                        <i class="c-icon" id="btnClearInput" style="display: none"></i>
                    </div>
                </div>
                <a href="javascript:;" class="s-btn" id="btnSearch">搜索</a>
            </div>

            <!--搜索时显示的模块-->
            <div class="search-info" style="display: none;">
                <div class="hot">
                    <p class="title">热门搜索</p>
                    <ul id="ulSearchHot" class="hot-list clearfix">
                        <li wd='iPhone'><a class="items">iPhone</a></li>
                        <li wd='三星'><a class="items">三星</a></li>
                        <li wd='小米'><a class="items">小米</a></li>
                        <li wd='黄金'><a class="items">黄金</a></li>
                        <li wd='汽车'><a class="items">汽车</a></li>
                        <li wd='电脑'><a class="items">电脑</a></li>

                    </ul>
                </div>
                <div class="history" style="display: none">
                    <p class="title">历史记录</p>
                    <div class="his-inner" id="divSearchHotHistory">
                        <ul class="his-list thin-bor-top">
                            <li wd="小米移动电源" class="thin-bor-bottom"><a class="items">小米移动电源</a></li>
                            <li wd="苹果6" class="thin-bor-bottom"><a class="items">苹果6</a></li>
                            <li wd="苹果电脑" class="thin-bor-bottom"><a class="items">苹果电脑</a></li>
                        </ul>
                        <div class="cle-cord thin-bor-bottom" id="btnClear">清空历史记录</div>
                    </div>
                </div>
            </div>

            <div class="all-list-wrapper">

                <div class="menu-list-wrapper" id="divSortList">
                    <ul id="sortListUl" class="list">
                        <li sortid='0' class='current'><span class='items'cate_id=''>全部商品</span></li>
                    </ul>
                </div>

                <div class="good-list-wrapper">
                    <div class="good-menu thin-bor-bottom">
                        <ul class="good-menu-list" id="ulOrderBy">
                            <li orderflag="10" class="current"><a href="javascript:;">即将揭晓</a></li>
                            <li orderflag="20"><a href="javascript:;">人气</a></li>
                            <li orderflag="50"><a href="javascript:;">最新</a></li>
                            <li orderflag="30"><a href="javascript:;">价值</a><span class="i-wrap"><i class="up"></i><i class="down"></i></span></li>
                            <!--价值(由高到低30,由低到高31)-->
                        </ul>
                    </div>

                    <div class="good-list-inner">
                        <div id="pullrefresh" class="good-list-box  mui-content mui-scroll-wrapper">
                            <div class="goodList mui-scroll">

                                <ul id="ulGoodsList" class="mui-table-view mui-table-view-chevron" >
                                    @foreach($info as $v)

                                        <li id="23468">
                                            <span class="gList_l fl">
                                            <a href="goodsList?goods_id={{$v->goods_id}}">
                                                <img class="lazy" src="{{URL::asset('goodsimg/'.$v->goods_img)}}">
                                            </a>
                                            </span>
                                            <div class="gList_r">
                                                <a href="goodsList?goods_id={{$v->goods_id}}">
                                                    <h3 class="gray6">{{$v->goods_name}}</h3>
                                                </a>
                                                <em class="gray9">价值：￥{{$v->goods_selfprice}}</em>
                                                <div class="gRate">
                                                    <div class="Progress-bar">
                                                        <p class="u-progress">
                                                            <span style="width: 91.91286930395593%;" class="pgbar">
                                                                <span class="pging"></span>
                                                            </span>
                                                        </p>
                                                        <ul class="Pro-bar-li">
                                                            <li class="P-bar01"><em></em>已参与</li>
                                                            <li class="P-bar02"><em></em>总需人次</li>
                                                            <li class="P-bar03"><em></em>剩余</li>
                                                        </ul>
                                                    </div>
                                                    <a codeid="12785750" class="uper" canbuy="646" goods_id="{{$v->goods_id}}"><s></s></a>

                                                </div>
                                            </div>
                                        </li>

                                    @endforeach
                                </ul>
                                <div id="zxc">
                                    <ul class="flow-default" id="LAY_demo1"></ul>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="footer clearfix">
                <ul>
                    <li class="f_home"><a href="index"><i></i>潮购</a></li>
                    <li class="f_announced"><a href="goodsCate"  class="hover"><i></i>所有商品</a></li>
                    <li class="f_single"><a href="/v41/post/index.do" ><i></i>最新揭晓</a></li>
                    <li class="f_car"><a id="btnCart" href="listCart" ><i></i>购物车</a></li>
                    <li class="f_personal"><a href="userpage" ><i></i>我的潮购</a></li>
                </ul>
            </div>
        </div>
    </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/lazyload.min.js"></script>
    <script src="js/mui.min.js"></script>
    <script>
        layui.use('layer', function(){
            var layer=layui.layer;
            $('.uper').click(function(){
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
        })
    </script>
    <script>

        jQuery(document).ready(function() {
            $("img.lazy").lazyload({
                placeholder : "images/loading2.gif",
                effect: "fadeIn",
            });


        });

    </script>
    <script>
        // 点击切换类别
        $('#sortListUl li').click(function(){
            $(this).addClass('current').siblings('li').removeClass('current');
        })
    </script>
    </body>
    </html>
    <script src="/layui/layui.js" charset="utf-8"></script>

    <script>
        $('.items').click(function(){
            var _this=$(this);
            cate_id=_this.attr('cate_id');
            var data = {page:1,cate_id:cate_id};
            console.log(data);
            var url = "cateInfo";
            $.ajax({
                url:url,
                data:data,
                type:'post',
                dataType:"json",
                success:function(msg){
                    var info = msg.info;
                    // console.log(msg)
                    var pageTotal = msg.pageTotal;
                    var page = msg.page;
                    $("#ulGoodsList").empty().append(info);
                }
            });
        })


        layui.use('flow', function(){
            var flow = layui.flow;

            var cate_id=$('.items').attr('cate_id');
            flow.load({
                elem: '#zxc',
                done: function(page, next){
                    var data = {page:page,cate_id:cate_id};
                    var url = "cateInfo";
                    $.ajax({
                        url:url,
                        data:data,
                        type:'post',
                        dataType:"json",
                        success:function(msg){
                            var info = msg.info;
                            var pageTotal = msg.pageTotal;
                            var page = msg.page;
                            $("#ulGoodsList").append(info);
                            next('',page<pageTotal);
                        }
                    })
                }
            });
        })

    </script>
    <script>

    </script>

