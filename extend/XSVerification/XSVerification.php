<?php

/**
 * @auther Liu xian song
 * @email  326427540@qq.com
 * @desc   GD2 图片滑动验证码
 */

namespace XSVerification;

class XSVerification{

    private $tailoring_big_save_path;    //拼图保存路径
    private $tailoring_small_save_path;  //小截图保存路径
    private $session_name = 'XSVer';    //Session Name
    private $tailoring_w;       //截图宽
    private $tailoring_h;      //截图高
    private $PicSavePath;      //全部存储在目录下面
    private $ResourcesPath;    //资源图片路径
    private $smallPicName;  //小图片名称
    private $bigPicName;    //大图图片名称
    private $srcPic;     //参照图片
    private $picSuffix = '.png'; //图片后缀
    private $location_x; //随机X位置
    private $location_y; //随机Y位置
    private $pic_info;
    /**
     * @name 初始化相关数据
     */
    public function init()
    {
        $this->tailoring_w = mt_rand(30,40);
        $this->tailoring_h = mt_rand(30,40);
        $this->ResourcesPath =  APP_PATH.'../extend/XSVerification/Resources/Admin/Code/'; //背景图片存放目录 （Resources）
        $dir = './pic_temp/code/'.date('YmdH');  //被处理图片 存放目录（裁剪小图，错位背景图）
        $this->tailoring_big_save_path = $dir.'/big/';
        $this->tailoring_small_save_path = $dir.'/small/';
        $this->getRandomPng();
        $this->smallPicName  =  $this->tailoring_small_save_path.md5(uniqid()).$this->picSuffix;
        $this->bigPicName    =  $this->tailoring_big_save_path.md5(uniqid().time()).$this->picSuffix;

        //检查目录是否存在
        if( !file_exists( $this->tailoring_big_save_path) ){
            mkdir($this->tailoring_big_save_path,0777,true);
        }
        if(!file_exists( $this->tailoring_small_save_path) ) {
            mkdir($this->tailoring_small_save_path,0777,true);
        }
        //删除过时资源图片
        $this->PicSavePath = dirname($dir);
        $this->delete_1hour_XSVerification($this->PicSavePath);
    }



    public function __construct()
    {
       $this->init();
       $this->pic_info = $this->get_pic_wide_height($this->srcPic); //  获取原图的 宽高
       $this->setRandomLocation( $this->pic_info);
       $this->tailoring($this->srcPic,$this->smallPicName,$this->location_x, $this->location_y,$this->tailoring_w,$this->tailoring_h);
       $this->mergePic($this->srcPic,$this->smallPicName,$this->bigPicName,$this->location_x, $this->location_y);
    }




    public function getOkPng()
    {
        return $this->RestructuringCutting($this->bigPicName,$this->bigPicName, $this->pic_info['w'],  $this->pic_info['h']);
    }

    /**
     * @name 设置随机 X,Y位置
     * @param $pic_info
     */
    public function setRandomLocation($pic_info)
    {
        $this->location_x =  mt_rand(30,$pic_info['w']-$this->tailoring_w);
        $this->location_y =  mt_rand(5,$pic_info['h']-$this->tailoring_h);
    }

    /**
     * @name 随机小数点
     * @param int $min
     * @param int $max
     * @return int
     */
    function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    /**
     * @name 随机获取参照图片
     * @return string
     * @throws \Exception
     */
    private function getRandomPng(){
        $this->srcPic  = $this->ResourcesPath.$this->bigPicName.mt_rand(1,4).'.png';
        if(!file_exists($this->srcPic )) {
            throw new \Exception('图片资源不存在！！！');
        } else {
            return  $this->srcPic;
        }
    }

    /**
     * @name 检查路径存在
     * @param $filePath
     */
    public function check_path_exists($filePath)
    {
        if( !file_exists(dirname($filePath)) ) {
            @mkdir(dirname($filePath),0777,true);
        }
    }

    /**
     * @name 获取图片宽、高
     * @param $pic_path
     * @return array
     */
    public function get_pic_wide_height( $pic_path )
    {

        $lim_size = getimagesize($pic_path);
        return array('w'=> $lim_size[0], 'h'=> $lim_size[1]);
    }




    /**
     * @name 删除一小时之前的 验证码图片
     */
    public function delete_1hour_XSVerification($dir)
    {
        $op   = dir($dir);
        $time = date("YmdH",strtotime("-1 hours"));
        $i=0;
        while(false != ($item = $op->read()) && $i<=10) {
            $i++;
            if($item == '.' || $item == '..') {
                continue;
            }
            if( (is_numeric($item) && $item<=$time) || !is_numeric($item) ) {
               if (is_dir($op->path.'/'.$item) && @rmdir($op->path . '/'.$item)==false ) {
                 $this->delete_1hour_XSVerification($op->path.'/'.$item);
              } else {
                  @unlink($op->path . '/' . $item);
              }
            }
        }
    }



    /**
     * @NAME 调整图像的宽高 ，看情况才有。减少系统开销
     * @param $picFile
     * @param $saveFile
     * @param $thumbnailWide
     * @param $thumbnailHeight
     */
    public function Adjust_pic_wide_height($picFile,$saveFile,$thumbnailWide,$thumbnailHeight)
    {
        $imgStream = file_get_contents($picFile);
        $im = imagecreatefromstring($imgStream);
        $x  = imagesx($im);//获取图片的宽
        $y  = imagesy($im);//获取图片的高
        $xx = $thumbnailHeight;
        $yy = $thumbnailWide;
        if( $x > $y ){
            $sy = 0;
            $sx = 0;
            $thumbw = $thumbnailWide;
            $thumbh = $thumbnailHeight;
        } else {
            $sx = abs(($y-$x)/2);
            $sy = 0;
            $thumbw = $y;
            $thumbh = $y;
        }
        if(function_exists("imagecreatetruecolor")) {
            $dim = imagecreatetruecolor($yy, $xx); //创建目标图gd2 高清
        } else {
            $dim = imagecreate($yy, $xx); //创建目标图gd1，失色
        }
        imageCopyreSampled($dim,$im,0,0,$sx,$sy,$yy,$xx,$thumbw,$thumbh);
        imagejpeg ($dim, $saveFile, 100);
        imagedestroy($dim);
    }


    /**
     * @name 裁剪小图
     * @param $srcFile
     * @param $picName
     * @param $tailoring_x
     * @param $tailoring_y
     * @param $PicW
     * @param $PicH
     */
    private function tailoring($srcFile,$picName,$tailoring_x,$tailoring_y,$PicW,$PicH)
    {
        if( $this->picSuffix == '.webp' ) {
            $imgStream = file_get_contents($srcFile);
            $srcIm = imagecreatefromstring($imgStream);
        } else {
            $srcIm = @imagecreatefrompng($srcFile);
        }
        $dstIm   = @imagecreatetruecolor($PicW,$PicH) or die("Cannot Initialize new GD image stream");

        $dstImBg = @imagecolorallocate($dstIm,255,255,255);
        imagefill($dstIm,0,0,$dstImBg); //创建背景为白色的图片
        imagecopy($dstIm,$srcIm,0,0,$tailoring_x,$tailoring_y,$PicW,$PicH);
        //imagewebp($dstIm,$picName,100);
        imagepng($dstIm,$picName);
        imagedestroy($dstIm);
        imagedestroy($srcIm);

    }


    /**
     * @name 去色合并块状,指定位置
     * @param $srcFile
     * @param $smallPicName
     * @param $picName
     * @param $tailoring_x
     * @param $tailoring_y
     */
    private function mergePic($srcFile,$smallPicName,$picName,$tailoring_x,$tailoring_y)
    {

        $src_lim  = imagecreatefrompng($srcFile);
        $lim_size = getimagesize($smallPicName); //取得水印图像尺寸，信息
        $border   = imagecolorat ($src_lim,5, 5);
        $red      = imagecolorallocate($src_lim, 0, 0, 0);
        imagefilltoborder($src_lim, 0, 0, $border, $red);


        $im_size = getimagesize($srcFile);
        $src_w   = $im_size[0];
        $src_h   = $im_size[1];
        $src_im  = imagecreatefrompng($srcFile);

        $dst_im = imagecreatetruecolor($src_w,$src_h);
        //根据原图尺寸创建一个相同大小的真彩色位图
        $white = imagecolorallocate($dst_im,255,255,255);//白
        //给新图填充背景色
        $black = imagecolorallocate($dst_im,0,0,0);//黑
        $red = imagecolorallocate($dst_im,255,0,0);//红
        $orange = imagecolorallocate($dst_im,255,85,0);//橙
        imagefill($dst_im,0,0,$black);
        imagecopymerge($dst_im,$src_im,0,0,0,0,$src_w,$src_h,100);//原图图像写入新建真彩位图中


        $src_lw = $tailoring_x; //水印位于背景图正中央width定位
        $src_lh = $tailoring_y; //height定位
        imagecopymerge($dst_im,$src_lim,$src_lw,$src_lh,0,0,$lim_size[0],$lim_size[1],66);// 合并两个图像，设置水印透明度$waterclearly
        imagecopymerge($dst_im,$src_lim,$src_lw+2,$src_lh+2,0,0,$lim_size[0]-4,$lim_size[1]-4,33);

        imagepng($dst_im,$picName); //生成图片 定义命名规则
        imagedestroy($src_lim);
        imagedestroy($src_im);
        imagedestroy($dst_im);
    }

    //图片切割，打乱,重组
    public function RestructuringCutting($srcFile,$bigPicName,$thumbnailWide,$thumbnailHeight)
    {
        $num_w = 20;
        $num_h = 2;
        //每张小图宽度，高度
        $number_wide   = $thumbnailWide/$num_w;
        $number_height = $thumbnailHeight/$num_h;

        $p_x =0;
        $p_y =0;

        for($y=0;$y<$num_h;$y++) {
            for($x=0;$x<$num_w;$x++) {
                if( $p_x >= $thumbnailWide ) {
                    $p_x = 0;
                }
                $data_source[] = array('x'=>$p_x,'y'=>$p_y);
                $p_x +=$number_wide;
            }
            $p_y +=$number_height;
        }

        if( empty($data_source) ) {
            return false;
        }
        shuffle($data_source);

        $target_imgA = imagecreatetruecolor($thumbnailWide, $thumbnailHeight);
        $dstImBg = @imagecolorallocate($target_imgA,255,255,255);
        imagefill($target_imgA,0,0,$dstImBg); //创建背景为白色的图片
        $srcIm   = @imagecreatefrompng($srcFile); //截取指定区域

        $p_x =0;
        $p_y =0;
        $dataV = array();
        foreach($data_source as $key=>$val)  {
            imagecopy($target_imgA,$srcIm,$p_x,$p_y,$val['x'],$val['y'],$number_wide,$number_height);
             $dataV[$val['x'].'_'.$val['y']] = array('X'=>$p_x.'_'.$p_y , 'Y'=>$val['x'].'_'.$val['y']);
            $p_x +=$number_wide;
            if( $p_x >= $thumbnailWide ) {
                $p_x = 0;
                $p_y = $number_height;
            }
        }
        imagepng($target_imgA,$bigPicName);
        imagedestroy($target_imgA);
        imagedestroy($srcIm);
        $_temp_xy_data = array();

        foreach( $dataV as $key=>$val) {
            if( $val['X'] != $val['Y'] ) {
                $vv=explode('_', $dataV[$val['X']]['X'] );
                $_temp_xy_data[] = $vv;
            } else {
                $vv=explode('_',  $val['X'] );
                $_temp_xy_data[] = $vv;
            }
        }
        session($this->session_name,$this->location_x);
        return array(
            'session_name' => $this->session_name,
            'data'    => $_temp_xy_data,
            'bg_pic'  => ltrim($bigPicName,'.'),
            'ico_pic' => array('url'=> ltrim($this->smallPicName,'.'),'w'=> $this->tailoring_w ,'h'=>$this->tailoring_h),
            'x_point' => $this->location_x,
            'y_point' => $this->location_y
        );
    }


    /**
     * @nmae 校验数据合法性
     * @param $val
     * @param $rules
     * @return array
     */
    public static function checkData($val,$rules)
    {
        if( empty($val) || !is_numeric($val)  ||  empty($rules) || !is_numeric($rules) ) {
            exit(json_encode(array('state'=>402,'info'=>'抱歉错误')));
        }
        $max = $rules+6;
        $min = $rules-6;
        if( $val <= $max &&  $val >= $min  ) {
            return array('state'=>0,'info'=>'正确','data'=>$rules);
        } else {
            return array('state'=>401,'info'=>'抱歉错误');
        }
    }
}
