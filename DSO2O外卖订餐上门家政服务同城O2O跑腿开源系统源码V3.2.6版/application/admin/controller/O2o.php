<?php

/**
 * 微信配置
 */
namespace app\admin\controller;
use think\Lang;
use think\Validate;
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
class  O2o extends AdminControl {

    public function _initialize() {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/o2o.lang.php');
    }

    public function setting() {
        $config_model = model('config');
        if (!request()->isPost()) {
            $list_config = rkcache('config', true);
            $this->assign('list_config', $list_config);
            return $this->fetch();
        } else {
            $update_array['o2o_socket_url'] = trim(input('post.o2o_socket_url'));
            $update_array['o2o_distance'] = abs(intval(input('post.o2o_distance')));
            $update_array['o2o_auto_distribute'] = abs(input('post.o2o_auto_distribute'));
            $update_array['o2o_fee'] = abs(floatval(input('post.o2o_fee')));
						$update_array['o2o_complaint_fine'] = abs(floatval(input('post.o2o_complaint_fine')));
            $result = $config_model->editConfig($update_array);
            if ($result) {
                dkcache('config');
                $this->log(lang('ds_edit').lang('o2o_setting'),1);
                $this->success(lang('ds_common_save_succ'), 'O2o/setting');
            }else{
                $this->log(lang('ds_edit').lang('o2o_setting'),0);
            }
        }
    }

    

}
