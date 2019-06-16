<?php
class Adb
{
    protected $follow = [];
    protected $slide = [];
    protected $fabulous = [];

    public function __construct(array $config)
    {
        $this->follow = $config["follow"];
        $this->slide = $config["slide"];
        $this->fabulous = $config["fabulous"];
    }

    /**
     * Describe:关注
     * @Author: Bygones
     * Date: 2019-06-15
     * Time: 23:16
     * @return mixed
     */
    public function Follow()
    {
        $x = $this->follow["x"];
        $y = $this->follow["y"];
        exec("adb shell input tap ".$x." ".$y." ");
        return true;
    }

    /**
     * Describe:滑动
     * @Author: Bygones
     * Date: 2019-06-15
     * Time: 23:22
     * @return mixed
     */
    public function Slide()
    {
        $x = $this->slide["x"];
        $y = $this->slide["y"];
        $x1 = $this->slide["x1"];
        $y1 = $this->slide["y1"];
        exec("adb shell input swipe ".$x." ".$y." ".$x1." ".$y1." ");
        return true;
    }

    /**
     * Describe:点赞
     * @Author: Bygones
     * Date: 2019-06-16
     * Time: 11:05
     */
    public function Fabulous()
    {
        $x = $this->fabulous["x"];
        $y = $this->fabulous["y"];
        exec("adb shell input tap ".$x." ".$y." ");
        return true;
    }
    /**
     * Describe:截图
     * @Author: Bygones
     * Date: 2019-06-15
     * Time: 23:33
     */
    public function Screenshot()
    {
        $dir = __DIR__ . "/img/dy".date("YmdHis").".png";
        exec("adb exec-out screencap -p > ".$dir);
        return $dir;
    }
}
?>