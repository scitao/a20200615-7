<?php

namespace app\home\controller;

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
class  Sellerlive extends BaseSeller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerlive.lang.php');
    }

    /*
    * 线下商铺
    */
    public function index()
    {
        if (request()->isPost()) {//编辑商户信息

            $params = array();//参数
            $params['live_store_name'] = input('post.live_store_name');
            $params['live_store_address'] = input('post.live_store_address');
            $params['live_store_tel'] = input('post.live_store_tel');
            $params['live_store_bus'] = input('post.live_store_bus');

            $store_model = model('store');
            $res = $store_model->editStore($params, array('store_id' => session('store_id')));

            if ($res) {
                ds_json_encode(10000,'编辑成功');
            }
            else {
                ds_json_encode(10001,'编辑失败');
            }
        }else  {
            $store_model = model('store');
            $store = $store_model->getStoreInfo(array('store_id' => session('store_id')));
            if (empty($store)) {
                ds_json_encode(10001,'该商家不存在');
            }

            $this->assign('store', $store);
            $this->setSellerCurItem('index');
            $this->setSellerCurMenu('sellerlive');
            $this->assign('baidu_ak', config('baidu_ak'));
            return $this->fetch($this->template_dir . 'index');
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array(
             array(
                'name' => 'index', 'text' => '线下商铺',
                'url' => url('Sellerlive/index')
            ),
        );
        return $menu_array;
    }
}