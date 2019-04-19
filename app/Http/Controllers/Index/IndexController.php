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
        $data = DB::table('goods')->where('goods_id',$goods_id)->get(['goods_id','goods_name','goods_img','goods_selfprice'])->toArray();
        $cartInfo= DB::table('cart')->where('user_id',$user_id)->get()->toArray();
        $buy_num=array_column($cartInfo,'buy_number');
        $buy_number=array_sum($buy_num);
        //var_dump($buy_num);exit;

        $res = DB::table('users')->where('id',$user_id)->first();
        //print_r($data);exit;
        $time = time();


        $objredis = new \Redis();
        $objredis->connect('127.0.0.1',6379);

        $id = $objredis->incr('id');

        $hash_key = "list_".$id;
        $objredis->hset($hash_key,'id',$id);
        $objredis->hset($hash_key,'user_id',$user_id);
        $objredis->hset($hash_key,'goods_id',$goods_id);
        //$objredis->hset($hash_key,'openid',$openid);
        $objredis->hset($hash_key,'createtime',$time);

        $list_key = "list_hahaha";
        $objredis->rpush($list_key,$hash_key);



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
}
