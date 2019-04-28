<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class DitchController extends Controller
{
    public function accessToken()
    {
        //Cache::pull('access');exit;
        $access = Cache('access');
        if (empty($access)) {
//            $appid = "wx51db63563c238547";
//            $appkey = "35bdd2d4a7a832b6d20e4ed43017b66e";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WX_APP_ID')."&secret=".env('WX_KEY')."";
            $info = file_get_contents($url);
            $arrInfo = json_decode($info, true);
            $key = "access";
            $access = $arrInfo['access_token'];
            $time = $arrInfo['expires_in'];

            cache([$key => $access], $time);
        }

        return $access;
    }
    /**生成带参数的二维码*/
    public function codeAdd(){
        $objurl = new Client();
        $access = $this->accessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access";
        $data = [
            'expire_seconds'=>604800,
            'action_name'=>'QR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>'10'
                ]
            ],
        ];
        $strJson = json_encode($data,JSON_UNESCAPED_UNICODE);
        $response = $objurl->request('POST',$url,[
            'body' => $strJson
        ]);
        $res_str = $response->getBody();
        $res_data = json_decode($res_str);
        //var_dump($res_data);exit;
        //return $res_str;
        $ticket = $res_data->ticket;

        $codeurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
        $info = file_get_contents($codeurl);
        //$time = time();
        file_put_contents("./picture/10.jpg",$info);
        //var_dump($info);exit;
        return view('weixin.code',['code_url'=>$codeurl]);
    }
}
