<?php
class AI
{
    protected $appkey="R2tqFEW4gJWY4SSp";
    protected $appid = "2117414489";

    /**
     * Describe:获取图片信息
     * @Author: Bygones
     * Date: 2019-06-15
     * Time: 23:05
     * @param string $img
     * @return array
     */
    public function get(string $img):array
    {
        $data   = file_get_contents($img);
        $img = base64_encode($data);
        $params = [
            'app_id'     => $this->appid,
            'image'      => $img,
            'mode'       => '1',
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        ];
        $params['sign'] = $this->getReqSign((array) $params, (string) $this->appkey);
        $url = 'https://api.ai.qq.com/fcgi-bin/face/face_detectface';
        $response = $this->doHttpPost((string) $url, (array) $params);
        $response = json_decode($response,true);
        if($response["ret"] === 0){
        $response["data"] = [
            "gender"=>$response["data"]["face_list"][0]["gender"],
            "age"=>$response["data"]["face_list"][0]["age"],
            "beauty"=>$response["data"]["face_list"][0]["beauty"],
        ];
            return ["code"=>1,"data"=>$response["data"],"message"=>"获取成功"];
        }
        return ["code"=>0,"data"=>$response["data"],"message"=>"未识别"];
    }

    /**
     * Describe:鉴权签名
     * @Author: Bygones
     * Date: 2019-06-15
     * Time: 22:33
     * @param array $params
     * @param string $appkey
     * @return string
     */
    public function getReqSign(array $params,string $appkey):string
    {
        ksort($params);
        $str = '';
        foreach ($params as $key => $value){
            if ($value !== '')
            {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }
        $str .= 'app_key=' . $appkey;
        $sign = strtoupper(md5($str));
        return $sign;
    }

    /**
     * Describe:Post请求API
     * @Author: Bygones
     * Date: 2019-06-15
     * Time: 22:34
     * @param string $url
     * @param array $params
     * @return bool|string
     */
    public function doHttpPost(string $url,array $params):string
    {
        $curl = curl_init();

        $response = false;
        do
        {
            curl_setopt($curl, CURLOPT_URL, $url);
            $head = [
                'Content-Type: application/x-www-form-urlencoded'
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $head);
            $body = http_build_query($params);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_NOBODY, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            if ($response === false)
            {
                $response = false;
                break;
            }
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($code != 200)
            {
                $response = false;
                break;
            }
        } while (0);
        curl_close($curl);
        return $response;
    }
}
