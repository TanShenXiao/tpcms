<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/14
 * Time: 10:12
 */

namespace think\TsxBuild;

use think\Db;

class BaseObject
{
    public $Table;

    protected $PreKey;

    protected $keyPrefix = 'tsx';

    public static function className()
    {
        return get_called_class();
    }

    public function __construct($config = [])
    {
        foreach ($config as $name => $value) {
            $this->$name = $value;
        }

        $this->init();
    }


    public function init()
    {
    }

   public function ColumnKey($array,$key)
   {
       $data=[];
       foreach ($array as $arr){
           $data[$arr[$key]] = $arr;
           unset($data[$arr[$key]][$key]);
       }
       return $data;
   }

   public function renderFile($file,$data=[])
   {
       extract($data);

       ob_start();
       ob_implicit_flush(0);

       include($file);

       return ob_get_clean();
   }

   public function getKey()
   {
        $data=Db::query('desc '.$this->Table);
        foreach ($data as $key => $item){
            if($item['Key'] == 'PRI'){
                $this->PreKey = $this->keyPrefix.$item['Field'];
            }
        }
   }



}