<?php
/**
 * 商品统计分析
 */

namespace app\admin\controller;

use think\Lang;
use think\Loader;/**
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
class  Statgoods extends AdminControl
{
    private $search_arr;//处理后的参数
    private $gc_arr;//分类数组
    private $choose_gcid;//选择的分类ID

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH.'admin/lang/'.config('default_lang').'/stat.lang.php');
        Loader::import('mall.statistics');
        Loader::import('mall.datehelper');
        $stat_model = model('stat');
        //存储参数
        $this->search_arr = input('param.');
        //处理搜索时间
        if (in_array(request()->action(),array('pricerange','hotgoods','goods_sale'))){
            $this->search_arr = $stat_model->dealwithSearchTime($this->search_arr);
            //获得系统年份
            $year_arr = getSystemYearArr();
            //获得系统月份
            $month_arr = getSystemMonthArr();
            //获得本月的周时间段
            $week_arr = getMonthWeekArr($this->search_arr['week']['current_year'], $this->search_arr['week']['current_month']);
            $this->assign('year_arr', $year_arr);
            $this->assign('month_arr', $month_arr);
            $this->assign('week_arr', $week_arr);
        }
        $this->assign('search_arr', $this->search_arr);
        /**
         * 处理商品分类
         */
        $this->choose_gcid = ($t = intval(input('param.choose_gcid')))>0?$t:0;
        $gccache_arr = model('goodsclass')->getGoodsclassCache($this->choose_gcid,3);
        $this->gc_arr = $gccache_arr['showclass'];
        $this->assign('gc_json',json_encode($gccache_arr['showclass']));
        $this->assign('gc_choose_json',json_encode($gccache_arr['choose_gcid']));
    }

    /**
     * 价格区间统计
     */
    public function pricerange(){
        if(!isset($this->search_arr['search_type']) || !$this->search_arr['search_type']){
            $this->search_arr['search_type'] = 'day';
        }
        $stat_model = model('stat');
        //获得搜索的开始时间和结束时间
        $searchtime_arr = $stat_model->getStarttimeAndEndtime($this->search_arr);
        $where = array();
        $where['order_isvalid'] = 1;//计入统计的有效订单
        $where['order_add_time'] = array('between',$searchtime_arr);
        //商品分类
        if ($this->choose_gcid > 0){
            //获得分类深度
            $depth = $this->gc_arr[$this->choose_gcid]['depth'];
            $where['gc_parentid_'.$depth] = $this->choose_gcid;
        }
        $field = '1';
        $pricerange_arr = ($t = trim(cache('config')['stat_pricerange']))?unserialize($t):'';
        if ($pricerange_arr){
            $stat_arr['series'][0]['name'] = '下单量';
            //设置价格区间最后一项，最后一项只有开始值没有结束值
            $pricerange_count = count($pricerange_arr);
            if ($pricerange_arr[$pricerange_count-1]['e']){
                $pricerange_arr[$pricerange_count]['s'] = $pricerange_arr[$pricerange_count-1]['e'] + 1;
                $pricerange_arr[$pricerange_count]['e'] = '';
            }
            foreach ((array)$pricerange_arr as $k=>$v){
                $v['s'] = intval($v['s']);
                $v['e'] = intval($v['e']);
                //构造查询字段
                if ($v['e']){
                    $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']} and goods_pay_price/goods_num <= {$v['e']},goods_num,0)) as goodsnum_{$k}";
                } else {
                    $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']},goods_num,0)) as goodsnum_{$k}";
                }
            }

            $ordergooods_list = $stat_model->query('SELECT '.$field.' FROM '.config('database.prefix').'statordergoods WHERE order_isvalid='.$where['order_isvalid'].' AND order_add_time BETWEEN '.$searchtime_arr[0].' AND '.$searchtime_arr[1].($this->choose_gcid > 0?(' AND gc_parentid_'.$depth.'='.$this->choose_gcid):''));
            if($ordergooods_list){
                $ordergooods_list= current($ordergooods_list);
                foreach ((array)$pricerange_arr as $k=>$v){
                    //横轴
                    if($v['e']){
                        $stat_arr['xAxis']['categories'][] = $v['s'].'-'.$v['e'];
                    } else {
                        $stat_arr['xAxis']['categories'][] = $v['s'].'以上';
                    }
                    //统计图数据
                    if (isset($ordergooods_list['goodsnum_'.$k])){
                        $stat_arr['series'][0]['data'][] = intval($ordergooods_list['goodsnum_'.$k]);
                    } else {
                        $stat_arr['series'][0]['data'][] = 0;
                    }
                }
            }
            //得到统计图数据
            $stat_arr['title'] = '价格销量分布';
            $stat_arr['legend']['enabled'] = false;
            $stat_arr['yAxis'] = '销量';
            $pricerange_statjson = getStatData_LineLabels($stat_arr);
        } else {
            $pricerange_statjson = '';
        }

        $this->assign('pricerange_statjson',$pricerange_statjson);
        $this->assign('searchtime',implode('|',$searchtime_arr));
        $this->setAdminCurItem('pricerange');
        return $this->fetch('stat_goods_prange');
    }
    /**
     * 热卖商品
     */
    public function hotgoods(){
        if(!isset($this->search_arr['search_type']) || !$this->search_arr['search_type']){
            $this->search_arr['search_type'] = 'day';
        }
        $stat_model = model('stat');
        //获得搜索的开始时间和结束时间
        $searchtime_arr = $stat_model->getStarttimeAndEndtime($this->search_arr);
        $this->assign('searchtime',implode('|',$searchtime_arr));
        $this->setAdminCurItem('hotgoods');
        return $this->fetch('stat_goods_hotgoods');
    }
    /**
     * 热卖商品列表
     */
    public function hotgoods_list(){
        $stat_model = model('stat');
        $type=input('param.type');
        switch ($type){
            case 'goodsnum':
                $sort_text = '下单量';
                break;
            default:
                $type = 'orderamount';
                $sort_text = '下单金额';
                break;
        }
        //构造横轴数据
        for($i=1; $i<=50; $i++){
            //数据
            $stat_arr['series'][0]['data'][] = array('name'=>'','y'=>0);
            //横轴
            $stat_arr['xAxis']['categories'][] = "$i";
        }
        $where = array();
        $where['order_isvalid'] = 1;//计入统计的有效订单
        $searchtime_arr_tmp = explode('|',$this->search_arr['t']);
        foreach ((array)$searchtime_arr_tmp as $k=>$v){
            $searchtime_arr[] = intval($v);
        }
        $where['order_add_time'] = array('between',$searchtime_arr);
        //商品分类
        if ($this->choose_gcid > 0){
            //获得分类深度
            $depth = $this->gc_arr[$this->choose_gcid]['depth'];
            $where['gc_parentid_'.$depth] = $this->choose_gcid;
        }
        //查询统计数据
        $field = ' goods_id,goods_name ';
        switch ($type){
            case 'goodsnum':
                $field .= ' ,SUM(goods_num) as goodsnum ';
                $orderby = 'goodsnum desc';
                break;
            default:
                $type = 'orderamount';
                $field .= ' ,SUM(goods_pay_price) as orderamount ';
                $orderby = 'orderamount desc';
                break;
        }
        $orderby .= ',goods_id';
        $statlist = $stat_model->statByStatordergoods($where, $field, 0, 50, $orderby, 'goods_id');
        foreach ((array)$statlist as $k=>$v){
            switch ($type){
                case 'goodsnum':
                    $stat_arr['series'][0]['data'][$k] = array('name'=>strval($v['goods_name']),'y'=>intval($v[input('get.type')]));
                    break;
                case 'orderamount':
                    $stat_arr['series'][0]['data'][$k] = array('name'=>strval($v['goods_name']),'y'=>floatval($v[input('get.type')]));
                    break;
            }
            $statlist[$k]['sort'] = $k+1;
        }
        $stat_arr['series'][0]['name'] = $sort_text;
        $stat_arr['legend']['enabled'] = false;
        //得到统计图数据
        $stat_arr['title'] = '热卖商品TOP50';
        $stat_arr['yAxis'] = $sort_text;
        $stat_json = getStatData_Column2D($stat_arr);
        $this->assign('stat_json',$stat_json);
        $this->assign('statlist',$statlist);
        $this->assign('sort_text',$sort_text);
        $this->assign('stat_field',$type);
        echo $this->fetch('stat_hotgoods_list');
    }

    /**
     * 商品销售明细
     */
    public function goods_sale(){
        if(!isset($this->search_arr['search_type']) || !$this->search_arr['search_type']){
            $this->search_arr['search_type'] = 'day';
        }
        $stat_model = model('stat');
        //获得搜索的开始时间和结束时间
        $searchtime_arr = $stat_model->getStarttimeAndEndtime($this->search_arr);
        //获取相关数据
        $where = array();
        $where['order_isvalid'] = 1;//计入统计的有效订单
        $where['order_add_time'] = array('between',$searchtime_arr);
        //品牌
        $brand_id = intval(input('param.b_id'));
        if ($brand_id > 0){
            $where['brand_id'] = $brand_id;
        }
        //商品分类
        if ($this->choose_gcid > 0){
            //获得分类深度
            $depth = $this->gc_arr[$this->choose_gcid]['depth'];
            $where['gc_parentid_'.$depth] = $this->choose_gcid;
        }
        if(trim(input('param.goods_name'))){
            $where['goods_name'] = array('like','%'.trim(input('param.goods_name')).'%');
        }
        if(trim(input('param.store_name'))){
            $where['store_name'] = array('like','%'.trim(input('param.store_name')).'%');
        }
        $field = 'goods_id,goods_name,store_id,store_name,goods_commonid,SUM(goods_num) as goodsnum,COUNT(DISTINCT order_id) as ordernum,SUM(goods_pay_price) as goodsamount';
        //排序
        $orderby_arr = array('goodsnum asc','goodsnum desc','ordernum asc','ordernum desc','goodsamount asc','goodsamount desc');
        if (!isset($this->search_arr['orderby']) || !in_array(trim($this->search_arr['orderby']),$orderby_arr)){
            $this->search_arr['orderby'] = 'goodsnum desc';
        }
        $orderby = trim($this->search_arr['orderby']).',goods_id asc';
        //查询记录总条数
        $count_arr = $stat_model->getoneByStatordergoods($where, 'COUNT(DISTINCT goods_id) as countnum');
        $countnum = intval($count_arr['countnum']);
        if (input('param.exporttype') == 'excel'){
            $goods_list = $stat_model->statByStatordergoods($where, $field, 0, 0, $orderby, 'goods_id');
        } else {
            $goods_list = $stat_model->statByStatordergoods($where, $field, array(10,$countnum), 0, $orderby, 'goods_id');
        }
        //导出Excel
        if (input('param.exporttype') == 'excel'){
            //导出Excel
            $excel_obj = new \excel\Excel();
            $excel_data = array();
            //设置样式
            $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
            //header
            $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品名称');
            $excel_data[0][] = array('styleid'=>'s_title','data'=>'平台货号');
            $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺名称');
            $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单商品件数');
            $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单单量');
            $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单金额');
            //data
            foreach ($goods_list as $k=>$v){
                $excel_data[$k+1][] = array('data'=>$v['goods_name']);
                $excel_data[$k+1][] = array('data'=>$v['goods_commonid']);
                $excel_data[$k+1][] = array('data'=>$v['store_name']);
                $excel_data[$k+1][] = array('data'=>$v['goodsnum']);
                $excel_data[$k+1][] = array('data'=>$v['ordernum']);
                $excel_data[$k+1][] = array('data'=>$v['goodsamount']);
            }
            $excel_data = $excel_obj->charset($excel_data,CHARSET);
            $excel_obj->addArray($excel_data);
            $excel_obj->addWorksheet($excel_obj->charset('商品销售明细',CHARSET));
            $excel_obj->generateXML($excel_obj->charset('商品销售明细',CHARSET).date('Y-m-d-H',TIMESTAMP));
            exit();
        } else {
            //查询品牌
            $brand_list = model('brand')->getBrandList(array('brand_apply'=>1));
            $this->assign('brand_list',$brand_list);
            $this->assign('goods_list',$goods_list);
            $this->assign('show_page',$stat_model->page_info->render());
            $this->assign('orderby',$this->search_arr['orderby']);
            $this->setAdminCurItem('goods_sale');
            return $this->fetch('stat_goodssale');
        }
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array('name' => 'pricerange', 'text' => lang('stat_goods_pricerange'), 'url' => url('Statgoods/pricerange')),
            array('name' => 'hotgoods', 'text' => lang('stat_hotgoods'), 'url' => url('Statgoods/hotgoods')),
            array('name' => 'goods_sale', 'text' => lang('stat_goods_sale'), 'url' => url('Statgoods/goods_sale')),
        );
        return $menu_array;
    }
}