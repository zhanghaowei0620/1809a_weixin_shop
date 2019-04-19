<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cates;
use App\Models\Goods;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    /**生成订单 */
    public function cartList(Request $request){
        $goods_id=$request->input('goods_id');
        $zongjia=intval($request->input('zongjia'));
        // var_dump($zongjia);exit;
        $user_id=Auth::id();
        if(empty($user_id)){
            $arr= ['num'=>1,'msg'=>'未登录，请先登录'];
            return $arr;
        }
        if(empty($goods_id)){
            $arr= ['num'=>0,'msg'=>'请选择你要购买的商品'];
            return $arr;
        }
        //订单号
        $order_no = date("YmdHis",time()).rand(1000,9999);

        //添加订单表
        $dataorder = [
            'user_id'=>$user_id,
            'order_amount'=>$zongjia,
            'order_no'=>$order_no,
            'order_pay_type'=>1,
            'pay_status'=>1,
            'pay_way'=>1,
            'status'=>1,
            'create_time'=>time()
        ];
        $infodata =DB::table('order')->insert($dataorder);
        $dataData = DB::table('order')->where('order_no',$order_no)->first();
        $order_id = $dataData->order_id;
        session(['order_id'=>$order_id]);
        // $tiaojian = [
        //     'user_id'=>$user_id,
        //     'goods_id'=>$goods_id
        // ];

        // $asdasd = DB::table('cart')->where($tiaojian)->get();



        // print_r($order_id);exit;
        $cartUpdate=[
            'is_del'=>2,
            // 'buy_number'=>0,
            'update_time'=>time()
        ];
        $res = Cart::where('user_id',$user_id)->whereIn('goods_id',$goods_id)->update($cartUpdate);
        //添加订单详情表
        $num = Cart::join('goods','goods.goods_id','=','cart.goods_id')->whereIn('goods.goods_id',$goods_id)->get();
        foreach($num as $k=>$v){
            $info=[
                'user_id'=>$user_id,
                'order_id'=>$order_id,
                'order_no'=>$order_no,
                'goods_id'=>$v['goods_id'],
                'goods_name'=>$v['goods_name'],
                'goods_selfprice'=>$v['goods_selfprice'],
                'goods_img'=>$v['goods_img'],
                'buy_number'=>$v['buy_number'],
                'goods_status'=>1,
                'create_time'=>time()
            ];
            $datailData = DB::table('order_detail')->insert($info);
        }

        $UpdateNum=[
            // 'is_del'=>2,
            'buy_number'=>0,
            'update_time'=>time()
        ];
        $res = Cart::where('user_id',$user_id)->whereIn('goods_id',$goods_id)->update($UpdateNum);



        return $arr=['num'=>3,'order_id'=>$order_id];

    }
    /**订单展示 */
    public function cartshow(Request $request){
        $user_id=Auth::id();
        $order_id=$request->input('order_id');
        $orderDetailWhere=[
            'order.order_id'=>$order_id,
            'order.user_id'=>$user_id
        ];
        $goodsInfo=Order::where($orderDetailWhere)
            ->join('order_detail','order.order_id','=','order_detail.order_id')
            ->get();
        $defaultWhere=[
            'user_id'=>$user_id,
            'is_default'=>1
        ];
        $addressDefault=Address::where($defaultWhere)->first();
        if($addressDefault){
            $addressDefault=$addressDefault->toArray();
        }else{
            $addressDefault=[];
        }
        $addressnum=count($addressDefault);
        $amount = DB::table('order')->where($orderDetailWhere)->first();
        return view('index.carts.cartshow',['goodsInfo'=>$goodsInfo,'order_id'=>$order_id,'addressnum'=>$addressnum,'addressDefault'=>$addressDefault],['amount'=>$amount]);
    }
    protected function ToXml()
    {
        if(!is_array($this->values)
            || count($this->values) <= 0)
        {
            die("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($this->values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    public $weixin_unifiedorder_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    public $notify_url = 'http://1809zhanghaowei.comcto.com/wstatus';
    public function wpay(Request $request)
    {
        $order_id = $request->session()->get('order_id');
        //print_r($order_id);exit;
        $arrInfo = DB::table('order')->where('order_id', $order_id)->first();
        //print_r($arrInfo);exit;
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $str = md5(time());
        $key = "7c4a8d09ca3762af61e59520943AB26Q";
        $orderId = $arrInfo->order_no;
        $ip = $_SERVER['REMOTE_ADDR'];

        $arr = array(
            'appid' => "wxd5af665b240b75d4",
            'mch_id' => "1500086022",
            'nonce_str' => $str,
            'sign_type' => "MD5",
            'body' => "aaaad",
            'out_trade_no' => $orderId,
            'total_fee' => 1,
            'spbill_create_ip' => $ip,
            'notify_url' => $this->notify_url,
            'trade_type' => "NATIVE",
        );
        //签名算法
        ksort($arr);
        $strParams = urldecode(http_build_query($arr));
        $strParams .= "&key=$key";
        $endStr = md5($strParams);
        $arr['sign'] = $endStr;

        $objurl = new Client();

        $this->values = [];
        $this->values = $arr;
        $xml = $this->ToXml();
        //var_dump($xmldata);
        $rs = $this->postXmlCurl($xml, $this->weixin_unifiedorder_url, $useCert = false, $second = 30);
        //var_dump($rs);exit;
        $data = simplexml_load_string($rs);

        //将 code_url 返回给前端，前端生成 支付二维码
        $data = [
            'code_url'  => $data->code_url
        ];
        //var_dump($data);die;
        return view('wpaylist',$data);
    }
    private  function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		if($useCert == true){
//			//设置证书
//			//使用证书：cert 与 key 分别属于两个.pem文件
//			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
//			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
//		}
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            die("curl出错，错误码:$error");
        }
    }
    /**
     * 格式化参数格式化成url参数
     */
    protected function ToUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
}
