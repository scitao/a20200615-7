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
class  SellerO2oOrderBill extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/seller_o2o_order_bill.lang.php');
    }

    /**
     * 结算列表
     *
     */
    public function index() {
        $o2o_order_bill_model = model('o2o_order_bill');
        $condition = array();

        $o2o_order_bill_validate = validate('o2o_order_bill');
        $condition['store_id'] = session('store_id');


        $bill_state = input('bill_state');
        if ($bill_state !== '' && $bill_state !== null) {
            $condition['o2o_order_bill_state'] = $bill_state;
        }
        $query_start_date = input('param.query_start_date');
        $query_end_date = input('param.query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $start_unixtime = $if_start_date ? strtotime($query_start_date) : null;
        $end_unixtime = $if_end_date ? strtotime($query_end_date) : null;
        if ($start_unixtime) {
            $condition['o2o_order_bill_start_time'] = array('>=', $start_unixtime);
        }
        if ($end_unixtime) {
            $condition['o2o_order_bill_end_time'] = array('<=', $end_unixtime);
        }
        if (!$o2o_order_bill_validate->scene('o2o_order_bill_search')->check($condition)) {
            $this->error($o2o_order_bill_validate->getError());
        }

        $bill_list = $o2o_order_bill_model->getO2oOrderBillList($condition, '*', 12);
        $this->assign('bill_list', $bill_list);
        $this->assign('show_page', $o2o_order_bill_model->page_info->render());

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_o2o_order_bill');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('list');
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 查看结算单详细
     *
     */
    public function show_bill() {
        $bill_id = intval(input('param.bill_id'));
        if (!$bill_id) {
            $this->error('参数错误');
        }

        $o2o_order_bill_model = model('o2o_order_bill');
        $bill_info = $o2o_order_bill_model->getO2oOrderBillInfo(array('o2o_order_bill_id' => $bill_id, 'store_id' => session('store_id')));
        if (!$bill_info) {
            $this->error(lang('seller_o2o_order_bill_not_exists'));
        }

        $order_condition = array();
        $order_condition['o2o_order_bill_id'] = $bill_id;
        $query_order_no = trim(input('get.query_order_no'));
        if (preg_match('/^\d{8,20}$/', $query_order_no)) {
            $order_condition['order_sn'] = $query_order_no;
        }
        $query_start_date = input('get.query_start_date');
        $query_end_date = input('get.query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $start_unixtime = $if_start_date ? strtotime($query_start_date) : null;
        $end_unixtime = $if_end_date ? (strtotime($query_end_date)+86399) : null;
        if ($if_start_date && $if_end_date) {
            $order_condition['finnshed_time'] = array('between', array($start_unixtime, $end_unixtime));
        }else if($if_start_date){
            $order_condition['finnshed_time'] = array('>=',$start_unixtime);
        }else if($if_end_date){
            $order_condition['finnshed_time'] = array('<=',$query_end_date);
        }

        $order_model = model('order');
        $o2o_complaint_model = model('o2o_complaint');
        $order_list = $order_model->getOrderList($order_condition, 20, 'order_sn,order_id,shipping_fee,order_state,buyer_name,order_amount,add_time,finnshed_time');
        foreach ($order_list as $key => $val) {
            $order_list[$key]['order_is_complaint'] = $o2o_complaint_model->getO2oComplaintInfo(array('order_id' => $val['order_id']), 'order_id');
        }
        $this->assign('show_page', $order_model->page_info);
        $this->assign('order_list', $order_list);
        $sub_tpl_name = 'show_order_list';
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_o2o_order_bill');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('');
        $this->assign('bill_info', $bill_info);

        return $this->fetch($this->template_dir . $sub_tpl_name);
    }


    /**
     * 店铺确认出账单
     *
     */
    public function confirm_bill() {
        $bill_id = input('param.bill_id');
        if (!$bill_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $o2o_order_bill_model = model('o2o_order_bill');
        $condition = array();
        $condition['o2o_order_bill_id'] = $bill_id;
        $condition['store_id'] = session('store_id');
        $condition['o2o_order_bill_state'] = O2O_ORDER_BILL_STATE_CHECK;
        $bill_info = $o2o_order_bill_model->getO2oOrderBillInfo($condition);
        if (!$bill_info) {
            ds_json_encode(10001, lang('seller_o2o_order_bill_not_exists'));
        }
        if (request()->isPost()) {
            $update = $o2o_order_bill_model->editO2oOrderBill(array('o2o_order_bill_state' => O2O_ORDER_BILL_STATE_PAY, 'o2o_order_bill_remark' => input('post.ob_seller_content')), $condition);
            if ($update) {
                ds_json_encode(10000, lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
        } else {

            return $this->fetch($this->template_dir . 'bill_confirm');
        }
    }
    
    /**
     * 店铺付款账单
     *
     */
    public function pay_bill() {
        $bill_id = input('param.bill_id');
        if (!$bill_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $o2o_order_bill_model = model('o2o_order_bill');
        $condition = array();
        $condition['o2o_order_bill_id'] = $bill_id;
        $condition['store_id'] = session('store_id');
        $condition['o2o_order_bill_state'] = O2O_ORDER_BILL_STATE_PAY;
        $bill_info = $o2o_order_bill_model->getO2oOrderBillInfo($condition);
        if (!$bill_info) {
            ds_json_encode(10001, lang('seller_o2o_order_bill_not_exists'));
        }
        if (request()->isPost()) {
            $o2o_order_bill_payment_voucher='';
            if (!empty($_FILES['file']['name'])) {
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $bill_info['store_id'] . DS . 'o2o_order_bill';
            $file = request()->file('file');
            $result = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
            if ($result) {
                $o2o_order_bill_payment_voucher = $result->getFilename();
            }else{
                $this->error($file->getError());
            }
            }
            $update = $o2o_order_bill_model->editO2oOrderBill(array('o2o_order_bill_payment_voucher'=>$o2o_order_bill_payment_voucher,'o2o_order_bill_state' => O2O_ORDER_BILL_STATE_SUCCESS), $condition);
            if ($update) {
                $this->success(lang('ds_common_op_succ'),url('SellerO2oOrderBill/index'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        } else {

            return $this->fetch($this->template_dir . 'bill_pay');
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $menu_array = array(
            array(
                'name' => 'list',
                'text' => lang('physical_settlement'),
                'url' => url('SellerO2oOrderBill/index')
            ),
        );
        return $menu_array;
    }

}

?>
