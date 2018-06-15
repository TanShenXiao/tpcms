<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/14
 * Time: 10:19
 */

namespace think\TsxBuild\crud;


use think\Config;

use think\TsxBuild\BaseObject;

use think\TsxBuild\crud\CrudValidate;

use think\Db;


class Generator extends BaseObject
{

    public $templateType = 'default';                           //默认模板
    public $tempForm = CORE_PATH.'TsxBuild'.DS.'format';        //文本域模板
    public $tempFile = CORE_PATH.'TsxBuild'.DS.'Template';      //模板
    public $Table;              //表名
    public $Controller;         //Controller位置
    public $ViewModel;          //视图模型位置
    public $ModelLogic;         //逻辑模型位置
    public $Model;              //模型位置
    public $view;                //视图位置
    public $data;                //提交的数据
    public $tableDetails;       //表结构

    public function __construct(array $data = [])
    {
        $this->data=$data;
        parent::__construct($data);
    }

    public function Initialization()
    {
        $conf = [];
        if (isset(Config::get('formConf')[$this->Table])) {
            $conf = Config::get('formConf')[$this->Table];
        }

        /**
         * 移除不需要的字段
         */
        if (isset($conf['Disable']) and is_array($conf['Disable'])) {
            foreach ($conf['Disable'] as $key => $val) {
                if (is_string($val) and isset($this->tableDetails[$val])) {
                    unset($this->tableDetails[$val]);
                }
            }
        }
        /**
         * 获取表单规则
         */

            foreach($this->tableDetails as $key=>$val){
                $data=[];
                if(isset($conf['rule'][$key])){
                    $this->tableDetails[$key]['rule'] = $conf['rule'][$key];
                }else{
                    $this->tableDetails[$key]['rule'] ='';
                }
                $data['rule'] = $this->tableDetails[$key]['rule'];
                if(isset($conf['title'][$key])){
                    $this->tableDetails[$key]['title'] = $conf['title'][$key];
                }else{
                    $this->tableDetails[$key]['title'] = $this->tableDetails[$key]['column_comment'];
                }

                $data['title'] = $this->tableDetails[$key]['title'];
                $data['name'] = $key;

                if(isset($conf['form'][$key])){
                    $this->tableDetails[$key]['form'] = $this->renderFile($this->tempForm.DS.$this->templateType.DS.$conf['form'][$key].'.html',$data);
                }else{
                    $this->tableDetails[$key]['form'] = $this->renderFile($this->tempForm.DS.$this->templateType.DS.'text.html',$data);
                }
            }
    }
    public function build()
    {
        $validate=new CrudValidate();
        $validate->batch()->check($this->data);
        if($validate->batch()->check($this->data) !== true){

            return $validate->getError();
        }
        $this->tableDetails=$this->ColumnKey(Db::query('select column_name,column_comment from Information_schema.columns WHERE TABLE_NAME="'.$this->Table.'"'),'column_name');
        $this->getKey();

        //创建添加表单
        if(($result=$this->buildForm()) !== true){
            return $result;
        }
    }

    public function buildForm()
    {
        /**
         * 表单初始化
         */
        $this->Initialization();

        $file=$this->tempFile.DS.$this->templateType.DS.'form.html';
        $data['data'] = $this->tableDetails;
        $model = Config::get('build');
        $content=substr($this->Controller,strripos($this->Controller,'\\')+1);
        
        $data['add_form'] =$this->renderFile($this->tempForm.DS.$this->templateType.DS.'heand.html',['url'=> $model.'/'.$content.'/'.'add']);
        $data['edit_form'] = $this->renderFile($this->tempForm.DS.$this->templateType.DS.'heand.html',['url'=> $model.'/'.$content.'/'.'edit']);

        $data['add_button'] = $this->renderFile($this->tempForm.DS.$this->templateType.DS.'d_button.html');
        $data['edit_button'] = $this->renderFile($this->tempForm.DS.$this->templateType.DS.'e_button.html');

        $data['cancel'] = $this->renderFile($this->tempForm.DS.$this->templateType.DS.'c_button.html');
        $data['PriKey'] = $this->PreKey;

        $viewFile=APP_PATH.str_replace('\\',DS,$this->view);

        if(!is_dir($viewFile)){
            mkdir($viewFile,777);
        }
        if(is_file($viewFile.DS.'index.html')){
            return '文件存在请先删除';
        }
        return file_put_contents( $viewFile.DS.'index.html',$content=$this->renderFile($file,$data))?true:false;
    }

}

