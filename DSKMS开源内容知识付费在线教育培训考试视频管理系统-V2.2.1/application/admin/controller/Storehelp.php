<?php

namespace app\admin\controller;

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
class  Storehelp extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 帮助列表
     */
    public function index()
    {
        $help_model = model('help');
        $condition = array();
        $condition['help_id'] = array('gt', '99');//内容列表不显示系统自动添加的数据
        $key = trim(input('param.key'));
        if ($key != '') {
            $condition['help_title'] = array('like', '%' . $key . '%');
        }
        $helptype_id = intval(input('param.helptype_id'));
        if ($helptype_id > 0) {
            $condition['helptype_id'] = $helptype_id;
        }
        $help_list = $help_model->getStoreHelpList($condition, 10);
        $this->assign('help_list', $help_list);
        $this->assign('show_page', $help_model->page_info->render());

        $helptype_list = $help_model->getStoreHelptypeList();
        $this->assign('helptype_list', $helptype_list);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 帮助类型
     */
    public function help_type()
    {
        $help_model = model('help');
        $condition = array();

        $helptype_list = $help_model->getStoreHelptypeList($condition, 10);
        $this->assign('helptype_list', $helptype_list);
        $this->assign('show_page', $help_model->page_info->render());
        $this->setAdminCurItem('help_type');
        return $this->fetch();
    }

    /**
     * 新增帮助
     *
     */
    public function add_help()
    {
        $help_model = model('help');
        $help=array(
            'help_title'=>'',
            'helptype_id'=>'',
            'help_sort'=>'',
            'help_url'=>'',
            'help_info'=>'',
            'help_id'=>'',
        );
        $this->assign('help', $help);
        if (request()->isPost()) {
            $help_array = array();
            $help_array['help_title'] = input('post.help_title');
            $help_array['help_url'] = input('post.help_url');
            $help_array['help_info'] = input('post.help_info');
            $help_array['help_sort'] = intval(input('post.help_sort'));
            $help_array['helptype_id'] = intval(input('post.helptype_id'));
            $help_array['help_updatetime'] = TIMESTAMP;
            $help_array['page_show'] = '1';//页面类型:1为机构,2为会员
            $state = $help_model->addHelp($help_array);
            if ($state) {
                $file_id_array = input('post.file_id/a');
                if (!empty($file_id_array) && is_array($file_id_array)) {
                    $help_model->editHelpPic($state, $file_id_array);
                }
                $this->log('新增机构帮助，编号' . $state);
                $this->success(lang('ds_common_op_succ'), 'storehelp/index');
            }
            else {
                $this->errot(lang('ds_common_op_fail'));
            }
        } else {
            $helptype_list = $help_model->getStoreHelptypeList();
            $this->assign('helptype_list', $helptype_list);
            $condition = array();
            $condition['item_id'] = '0';
            $pic_list = $help_model->getHelpPicList($condition);
            $this->assign('pic_list', $pic_list);
            $this->setAdminCurItem('add_help');
            return $this->fetch('edit_help');
        }
    }

    /**
     * 编辑帮助
     *
     */
    public function edit_help()
    {
        $help_model = model('help');
        $condition = array();
        $help_id = intval(input('param.help_id'));
        $condition['help_id'] = $help_id;
        $help_list = $help_model->getStoreHelpList($condition);
        //halt($help_list);
        $help = $help_list[0];
        $this->assign('help', $help);
        if (request()->isPost()) {
            $help_array = array();
            $help_array['help_title'] = input('post.help_title');
            $help_array['help_url'] = input('post.help_url');
            $help_array['help_info'] = input('post.help_info');
            $help_array['help_sort'] = intval(input('post.help_sort'));
            $help_array['helptype_id'] = intval(input('post.helptype_id'));
            $help_array['help_updatetime'] = TIMESTAMP;
            $state = $help_model->editHelp($condition, $help_array);
            if ($state) {
                $this->log('编辑机构帮助，编号' . $help_id);
                $this->success(lang('ds_common_op_succ'), 'storehelp/index');
            }
            else {
                $this->error(lang('ds_common_op_fail'));
            }
        } else {
            $helptype_list = $help_model->getStoreHelptypeList();
            $this->assign('helptype_list', $helptype_list);
            $condition = array();
            $condition['item_id'] = $help_id;
            $pic_list = $help_model->getHelpPicList($condition);
            $this->assign('pic_list', $pic_list);
            $this->setAdminCurItem('edit');

            return $this->fetch();
        }
    }

    /**
     * 删除帮助
     *
     */
    public function del_help()
    {
        $help_model = model('help');
        $condition = array();
        $condition['help_id'] = intval(input('param.help_id'));
        $state = $help_model->delHelp($condition, array($condition['help_id']));
        if ($state) {
            $this->log('删除机构帮助，编号' . $condition['help_id']);
            ds_json_encode(10000, lang('ds_common_del_succ'));
        }
        else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 新增帮助类型
     *
     */
    public function add_type()
    {
        $help_model = model('help');
        if (request()->isPost()) {
            $type_array = array();
            $type_array['helptype_name'] = input('post.helptype_name');
            $type_array['helptype_sort'] = intval(input('post.helptype_sort'));
            $type_array['helptype_show'] = intval(input('post.helptype_show'));//是否显示,0为否,1为是
            $type_array['page_show'] = '1';//页面类型:1为机构,2为会员

            $state = $help_model->addHelptype($type_array);
            if ($state) {
                $this->log('新增机构帮助类型，编号' . $state);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            }
            else {
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $type = array(
                'helptype_name' => '',
                'helptype_sort' => '255',
                'helptype_show' => '1',
            );
            $this->assign('type', $type);
            return $this->fetch('edit_type');
        }
    }

    /**
     * 编辑帮助类型
     *
     */
    public function edit_type()
    {
        $help_model = model('help');
        $condition = array();
        $condition['helptype_id'] = intval(input('param.helptype_id'));
        $helptype_list = $help_model->getHelptypeList($condition);
        $type = $helptype_list[0];
        if (request()->isPost()) {
            $type_array = array();
            $type_array['helptype_name'] = input('post.helptype_name');
            $type_array['helptype_sort'] = intval(input('post.helptype_sort'));
            $type_array['helptype_show'] = intval(input('post.helptype_show'));//是否显示,0为否,1为是
            $state = $help_model->editHelptype($condition, $type_array);
            if ($state>=0) {
                $this->log('编辑机构帮助类型，编号' . $condition['helptype_id']);
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            }
            else {
                $this->error(lang('ds_common_op_fail'));
            }
        } else {
            $this->assign('type', $type);
            return $this->fetch();
        }
    }

    /**
     * 删除帮助类型
     *
     */
    public function del_type()
    {
        $help_model = model('help');
        $condition = array();
        $condition['helptype_id'] = intval(input('param.helptype_id'));
        $state = $help_model->delHelptype($condition);
        if ($state) {
            $this->log('删除机构帮助类型，编号' . $condition['helptype_id']);
            ds_json_encode(10000, lang('ds_common_del_succ'));
        }
        else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 上传图片
     */
    public function upload_pic()
    {
        $data = array();
        if (!empty($_FILES['fileupload']['name'])) {//上传图片
            $fprefix = 'admin/storehelp';
            $upload_file= BASE_UPLOAD_PATH . DS. $fprefix;
            $filename=$file_name= date('YmdHis') . rand(10000, 99999);
            $file = request()->file('fileupload');
            $info = $file->validate(['ext'=>ALLOW_IMG_EXT])->move($upload_file,$filename);
          if($info){
              $file_name=$info->getFilename();
          }
            $upload_model = model('upload');
            $insert_array = array();
            $insert_array['file_name'] = $file_name;
            $insert_array['file_size'] = $_FILES['fileupload']['size'];
            $insert_array['upload_time'] = TIMESTAMP;
            $insert_array['item_id'] = intval(input('param.item_id'));
            $insert_array['upload_type'] = '2';
            $result = $upload_model->addUpload($insert_array);
            if ($result) {
                $data['file_id'] = $result;
                $data['file_name'] = $file_name;
                $data['file_path'] = UPLOAD_SITE_URL.'/'.$fprefix.'/'.$file_name;
            }
        }
        echo json_encode($data);
        exit;
    }

    /**
     * 删除图片
     */
    public function del_pic()
    {
        $condition = array();
        $condition['upload_id'] = intval(input('param.file_id'));
        $help_model = model('help');
        $state = $help_model->delHelpPic($condition);
        if ($state) {
            echo 'true';
            exit;
        }
        else {
            echo 'false';
            exit;
        }
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '帮助内容',
                'url' => url('Storehelp/index')
            ), array(
                'name' => 'help_type',
                'text' => '帮助类型',
                'url' => url('Storehelp/help_type')
            )
        );
        if (request()->action() == 'edit_help') {
            $menu_array[] = array(
                'name' => 'edit',
                'text' => '编辑内容',
                'url' => url('Storehelp/edit_help')
                );
        }
        if (request()->action() == 'index'||request()->action() =='add_help') {
            $menu_array[] = array(
                'name' => 'add_help',
                'text' => '新增内容',
                'url' => url('Storehelp/add_help')
            );
        }
        if (request()->action() == 'help_type'||request()->action() =='add_type') {
            $menu_array[] = array(
                'name' => 'add_type',
                'text' => '新增类型',
                'url' =>"javascript:dsLayerOpen('".url('Storehelp/add_type')."','新增类型')");
        }
        return $menu_array;
    }

}