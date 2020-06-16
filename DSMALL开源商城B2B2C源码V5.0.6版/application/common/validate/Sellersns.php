<?php

namespace app\common\validate;


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
 * 验证器
 */
class  Sellersns extends Validate
{
    protected $rule = [
        ['content','require|length:1,140','内容不能为空且不能超过140个字'],
        ['goods_url','url','url格式不正确,请输入这正确的格式!']
    ];

    protected $scene = [
        'store_sns_save' => ['content', 'goods_url'],
    ];
}