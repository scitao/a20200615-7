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
class Delivery extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/delivery.lang.php');
    }

    /**
     * 自提服务站列表
     */
    public function index()
    {
        $deliverypoint_model = model('deliverypoint');
        $where = array();
        if (input('param.search_name') != '') {
            $where['dlyp_truename'] = array('like', '%' . input('param.search_name') . '%');
            $this->assign('search_name', input('param.search_name'));
        }
        if (input('param.sign') == 'verify') {
            $this->assign('sign', 'verify');
            $dp_list = $deliverypoint_model->getDeliverypointWaitVerifyList($where, 10);
            $this->setAdminCurItem('verify');
        }
        else {
            $dp_list = $deliverypoint_model->getDeliverypointList($where, 10);
            $this->setAdminCurItem('index');
        }
        $this->assign('show_page', $deliverypoint_model->page_info->render());
        $this->assign('dp_list', $dp_list);

        $this->assign('delivery_state', $deliverypoint_model->getDeliveryState());
        return $this->fetch();
    }

    /**
     * 自提服务站设置
     */
    public function setting()
    {
        if (!request()->isPost()) {
            $list_setting = rkcache('config', true);
            $this->assign('list_setting', $list_setting);
            return $this->fetch();
        } else {
            $update_array = array();
            $update_array['delivery_isuse'] = intval(input('post.delivery_isuse'));
            $result = model('config')->editConfig($update_array);
            $log = '开启';
            if ($result === true) {
                if ($update_array['delivery_isuse'] == 0) {
                    $log = '关闭';
                    // 删除相关联的收货地址
                    model('address')->delAddress(array('dlyp_id' => array('neq', 0)));
                }
                $this->log($log . '自提服务站功能', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->log($log . '自提服务站功能', 0);
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 编辑自提服务站信息
     */
    public function edit_delivery()
    {
        $dlyp_id = intval(input('param.d_id'));
        if ($dlyp_id <= 0) {
            $this->error(lang('param_error'));
        }
        $dlyp_info = model('deliverypoint')->getDeliverypointInfo(array('dlyp_id' => $dlyp_id));
        if (empty($dlyp_info)) {
            $this->error(lang('param_error'));
        }
        $this->assign('dlyp_info', $dlyp_info);
        $this->setAdminCurItem('edit_delivery');
        return $this->fetch();
    }

    /**
     * 编辑保存
     */
    public function save_edit()
    {
        $dlyp_id = intval(input('param.did'));
        if (!request()->isPost() || $dlyp_id <= 0) {
            $this->error(lang('param_error'));
        }
        $where = array('dlyp_id' => $dlyp_id);
        $update = array();
        $update['dlyp_mobile'] = input('post.dmobile');
        $update['dlyp_telephony'] = input('post.dtelephony');
        $update['dlyp_addressname'] = input('post.daddressname');
        $update['dlyp_address'] = input('post.daddress');
        
        $dlyp_passwd = input('post.dpasswd');
        if (!empty($dlyp_passwd)) {
            $update['dlyp_passwd'] = md5($dlyp_passwd);
        }
        $update['dlyp_state'] = intval(input('post.dstate'));
        $update['dlyp_failreason'] = input('post.fail_reason');
        $result = model('deliverypoint')->editDeliverypoint($update, $where);
        if ($result) {
            // 删除相关联的收货地址
            model('address')->delAddress(array('dlyp_id' => $dlyp_id));
            $this->log('编辑自提服务站功能，ID：' . $dlyp_id, 1);
            $this->success(lang('ds_common_op_succ'), url('Delivery/index'));
        }
        else {
            $this->log('编辑自提服务站功能，ID：' . $dlyp_id, 0);
            $this->error(lang('ds_common_op_fail'));
        }
    }

    /**
     * 订单列表
     */
    public function order_list()
    {
        $dlyp_id = intval(input('param.d_id'));
        if ($dlyp_id <= 0) {
            $this->error(lang('param_error'));
        }
        $dorder_model = model('deliveryorder');
        $where = array();
        $where['dlyp_id'] = $dlyp_id;
        $order_sn = input('param.order_sn');
        if ($order_sn != '') {
            $where['order_sn'] = array('like', '%' . $order_sn . '%');
        }
        $shipping_code = input('param.shipping_code');
        if ($shipping_code != '') {
            $where['shipping_code'] = array('like', '%' . $shipping_code . '%');
        }
        
        $dorder_list = $dorder_model->getDeliveryorderList($where,'*', 10);
        $this->assign('dorder_list', $dorder_list);
        $this->assign('show_page', $dorder_model->page_info->render());
        
        $dorder_state = $dorder_model->getDeliveryorderState();
        $this->assign('dorder_state', $dorder_state);
        $this->setAdminCurItem('order_list');
        return $this->fetch();
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_manage'),
                'url' => url('Delivery/index')
            ), array(
                'name' => 'verify',
                'text' => lang('delivery_verify'),
                'url' => url('Delivery/index', 'sign=verify')
            ), array(
                'name' => 'setting', 
                'text' => lang('ds_set'),
                'url' => "javascript:dsLayerOpen('".url('Delivery/setting')."','".lang('ds_set')."')"
            ),
        );
        if (request()->action() == 'edit_delivery') {
            $menu_array[] = array('name' => 'edit_delivery', 'text' => lang('ds_edit'), 'url' => url('Delivery/edit_delivery'));
        }
        if (request()->action() == 'order_list') {
            $menu_array[] = array('name' => 'order_list', 'text' => lang('ds_edit'), 'url' => url('Delivery/order_list'));
        }
        return $menu_array;
    }
}