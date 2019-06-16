<?php
include __DIR__ . "/AI.php";
include __DIR__ . "/Adb.php";
include __DIR__ . "/DyImg.php";
$config = include __DIR__ . "/config/redmi.php";

//咳咳,由于我的测试 = =,我劝大家把年龄调到0(通吃,是女的就点赞关注),因为我测试到很多女生检测到12岁,明明都20多岁了 ,好了不多说了,自行脑补啦
$gender = 50;//小于50为女
$age = 0;//最小年龄为18,
$beauty = 80;//颜值最低80
fwrite(STDOUT,'是否开始你的表演 [y/n] ');
if(trim(fgets(STDIN)) != "y") {
    echo "感谢您的使用,再见".PHP_EOL;exit();
}
echo "开始了...".PHP_EOL;
$AI = new AI();
$Adb = new Adb((array) $config);
$DyImg = new DyImg();
while (true){
    try{
        $dir = $Adb->Screenshot();
        $img = $DyImg->compressedImage($dir,$dir);
        $res = $AI->get($img);
        if($res["code"] == 1){
            if($res["data"]["gender"] <= $gender && $res["data"]["age"] >= 18 && $res["data"]["beauty"] >= 80){
                $Adb->Follow();
                $Adb->Fabulous();
                echo "遇到好看的小姐姐,点赞加关注✧(≖ ◡ ≖✿)嘿嘿".PHP_EOL;
                $Swipe = $Adb->Slide();
            }else{
                $Swipe = $Adb->Slide();
            }
        } else {
            $Swipe = $Adb->Slide();
        }
    }catch (\Exception $e){
        echo "感谢您的使用,再见".PHP_EOL;exit();
    }
}