<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Cates;
use App\Models\Goods;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    /**查询商品 */
    public function cateInfo(Request $request){
        //var_dump($cate_id);exit;
        $page = $request->input('page',1);
        $pageNum = 20;
        $offset = ($page-1)*$pageNum;
        $goodsHotInfo=DB::table('goods')
            ->orderBy('goods_selfprice')
            ->offset($offset)
            ->limit($pageNum)
            ->get(['goods_id','goods_name','goods_img','goods_selfprice','goods_salenum']);
        $totalData = DB::table('goods')->count();
        //print_r($goodsHotInfo);exit;
        $pageTotal = ceil($totalData/$pageNum); //总页数
        return view('index.goods.catedo',['info'=>$goodsHotInfo]);
        //$content = response($objview)->getContent();
        $arr['info']=$content;
        $arr['pageTotal']=$pageTotal;
        $arr['page']=$page;
        return $arr;
    }
    /**详情页 */
    public function goodsList(Request $request){
        $goods_id=$request->input('goods_id');
        $user_id=Auth::id();
        // print_r($goods_id);exit;
        $data = DB::table('goods')->where('goods_id',$goods_id)->get(['goods_id','goods_name','goods_img','goods_selfprice','click_id'])->toArray();
        $cartInfo= DB::table('cart')->where('user_id',$user_id)->get()->toArray();
        $buy_num=array_column($cartInfo,'buy_number');
        $buy_number=array_sum($buy_num);
        //var_dump($buy_num);exit;

        $res = DB::table('users')->where('id',$user_id)->first();
        //print_r($data);exit;
        $time = time();


        $redis_view_key = 'count:view:goods_id:'.$goods_id;   //浏览量
        $redis_ss_view = 'ss:goods:view';      //浏览排名
        $id = Redis::incr($redis_view_key);
        //var_dump($id);exit;
        Redis::zAdd($redis_ss_view,$id,$goods_id);

        $arr = [
            'click_id'=>$id
        ];
        DB::table('goods')->where('goods_id',$goods_id)->update($arr);
        //print_r($data);exit;

        //浏览历史
        $where = [
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $historyInfo = DB::table('goods_history')->where($where)->first();
        $goods_name = $data[0]->goods_name;
        $goods_img = $data[0]->goods_img;
        $goods_selfprice = $data[0]->goods_selfprice;
        $time = time();
        //var_dump($historyInfo);exit;
        if($historyInfo == NULL){
            $historyarr = [
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
                'goods_name'=>$goods_name,
                'goods_img'=>$goods_img,
                'goods_selfprice'=>$goods_selfprice,
                'create_time'=>$time
            ];
            DB::table('goods_history')->insert($historyarr);
        }else{
            $historyarr = [
                'create_time'=>$time,
                'update_time'=>$time
            ];
            DB::table('goods_history')->where('goods_id',$goods_id)->update($historyarr);
        }
        return view('index.goods.goodslist',['data'=>$data],['buy_number'=>$buy_number]);
    }
    /**加入购物车*/
    public function goodsCart(Request $request){
        $goods_id=$request->input('goods_id');
        // $user_tel=$request->session()->get('user_tel');
        // var_dump($user_id);exit;
        $user_id=Auth::id();
        //var_dump($user_id);exit;
        if(!$user_id){
            echo json_encode(['font'=>'请先登录','code'=>1]);exit;
        }
        $where=[
            'goods_id'=>$goods_id,
            'goods_up'=>1
        ];
        $data = DB::table('goods')->where($where)->first();
        //var_dump($data);exit;
        //商品总数量
        $goods_num=$data->goods_num;
        $cartwhere=[
            'goods_id'=>$goods_id,
        ];
        $cartdata = DB::table('cart')->where($cartwhere)->first();
        if(!$cartdata){
            if($goods_num<1){
                echo json_encode(['font'=>'库存不足','code'=>2]);exit;
            }else{
                $cartwheres=[
                    'goods_id'=>$goods_id,
                    'user_id'=>$user_id,
                    'is_del'=>1,
                    'buy_number'=>1,
                    'create_time'=>time(),
                    'add_price'=>$data->goods_selfprice
                ];
                $cartdata = DB::table('cart')->insert($cartwheres);
                $cartInfo= DB::table('cart')->where('user_id',$user_id)->get()->toArray();
                $buy_num=array_column($cartInfo,'buy_number');
                $buy_number=array_sum($buy_num);
                echo json_encode(['font'=>'加入购物车成功','code'=>0,'num'=>$buy_number]);exit;
            }

        }
        $buy_number=$cartdata->buy_number+1;
        // print_r($buy_number);exit;
        if($goods_num<$buy_number){
            echo json_encode(['font'=>'库存不足','code'=>2]);exit;
        }
        $whereupdate=[
            'buy_number'=>$buy_number,
            'is_del'=>1,
            'update_time'=>time()
        ];
        $cartdata = DB::table('cart')->where('goods_id',$goods_id)->update($whereupdate);
        $cartInfo= DB::table('cart')->where('user_id',$user_id)->get()->toArray();
        $buy_num=array_column($cartInfo,'buy_number');
        $buy_number=array_sum($buy_num);
        echo json_encode(['font'=>'加入购物车成功','code'=>0,'num'=>$buy_number]);exit;
    }
    /**购物车页面 */
    public function listCart(Request $request){
        $user_id=Auth::id();
        $where=[
            'user_id'=>$user_id,
            'is_del'=>1
        ];
        $cartInfo=DB::table('cart')->join('goods','cart.goods_id','=','goods.goods_id')->where($where)->get();
        //var_dump($cartInfo);exit;
        $infodata = DB::table('goods')->where('goods_hot',1)->limit(4) ->get(['goods_id','goods_name','goods_img','goods_selfprice','goods_salenum']);

        if($cartInfo){
            $cartInfo=$cartInfo->toArray();
        }else{
            $cartInfo=[];
        }
        $cartnum=count($cartInfo);
        // print_r($cartnum);exit;
        return view('index.goods.goodscart',['info'=>$cartInfo,'cartnum'=>$cartnum],['infodata'=>$infodata]);
    }
    /**获取浏览量排名*/
    public function goodssort(){
        $user_id=Auth::id();
        $key = "ss:goods:view";
        $list = Redis::zRevRange($key,0,10000,true);
        $dataInfo = [];
        foreach ($list as $k=>$v) {
            $dataInfo[] = $k;
        }
        //print_r($dataInfo);exit;
        $goodsHotInfo=DB::table('goods')->whereIn('goods_id',$dataInfo)->orderBy('click_id','desc')->get(['goods_id','goods_name','goods_img','goods_selfprice','goods_salenum']);

        $goodshistory = DB::table('goods_history')->whereIn('goods_id',$dataInfo)->orderBy('create_time','desc')->get(['goods_id','goods_name','goods_img','goods_selfprice','create_time']);
        //print_r($goodshistory);exit;
        return view('index.goods.goodssort',['info'=>$goodsHotInfo,'goodshistory'=>$goodshistory]);

    }


    /**

    @foreach($historyarrInfo as $v)
    <div class="win-right fl">
    <p class="show-time">时间<?php echo date('Y-m-d H:i:s',$v['create_time'])?></p>
    <p class="show-code">商品id:{{$v['goods_id']}}</p>
    <p class="winner">商品名称{{$v['goods_name']}}</p>
    商品图片:<img src="{{URL::asset('goodsimg/'.$v['goods_img'])}}" alt="">
    <p class="show-count">价格:{{$v['goods_selfprice']}}</p>
    </div>
    @endforeach*/
}
