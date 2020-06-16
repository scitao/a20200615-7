<?php

namespace app\admin\controller;

use think\Lang;

/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class Flea extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/flea.lang.php');
        if (config('flea_isuse') != 1 ){
            $this->error(lang('flea_index_unable'),'dashboard/welcome');
        }
    }
    /**
     * 商品管理
     */
    public function flea(){
        $flea_model = model('flea');
        /**
         * 排序
         */
        $condition = array();
        $keyword = trim(input('param.search_goods_name'));
        if($keyword){
            $condition['keyword'] = $keyword;
        }
        $like_member_name = trim(input('param.search_store_name'));
        if($like_member_name){
            $condition['like_member_name'] = $like_member_name; //店铺名称
        }
        $search_brand_id = intval(input('param.search_brand_id'));
        if($search_brand_id){
            $condition['brand_id'] = $search_brand_id;
        }
        $cate_id = intval(input('param.cate_id'));
        if($cate_id){
            $condition['fleaclass_id'] = $cate_id;
        }

        /**
         * 分页
         */
        $goods_list = $flea_model->getFleaList($condition,10);
        if (is_array($goods_list) and !empty($goods_list)) {
            foreach ($goods_list as $key => $val) {
                $goods_list[$key]['goods_image'] = $goods_list[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MFLEA . '/' . $val['member_id'] . '/' . str_replace('_1024', '_240', $val['goods_image']);
            }
        }
        /**
         * 商品类别
         */
        /**
         * 商品分类
         */
        $fleaclass_model = model('fleaclass');
        $goods_class = $fleaclass_model->getTreeClassList(1);

        $this->assign('goods_class',$goods_class);
        $this->assign('goods_list',$goods_list);
        $this->assign('show_page',$flea_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('index');
        return $this->fetch('index');
    }
    
    /**
     * 闲置商品删除
     */
    public function del()
    {
        $del_id = input('param.del_id');
        $del_id_array = ds_delete_param($del_id);
        if ($del_id_array == FALSE) {
            ds_json_encode('10001', lang('goods_index_argument_invalid'));
        }
        $flea_model = model('flea');
        $result  = $flea_model->delFlea($del_id_array);
        
        if($result){
            ds_json_encode('10000', lang('goods_index_del_succ'));
        }else{
            ds_json_encode('10001', lang('goods_index_choose_del'));
        }
    }




    /**
     * ajax操作
     */
    public function ajax() {
        $branch = input('get.branch');
        $column = input('get.column');
        $value = trim(input('get.value'));
        $id = intval(input('get.id'));
        switch ($branch) {
            /**
             * 商品名称
             */
            case 'goods_name':
                $flea_model = model('flea');
                $update_array = array();
                $update_array[$column] = $value;
                $flea_model->editFlea($update_array, $id);
                echo 'true';
                exit;
                break;
        }
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('flea_all_ldle'), 'url' => url('Flea/flea')
            ),
        );
        return $menu_array;
    }
}