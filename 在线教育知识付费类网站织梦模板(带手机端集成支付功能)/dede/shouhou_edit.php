<?php

/**

 * 评论编辑

 *

 * @version        $Id: shouhou_edit.php 1 19:09 2010年7月12日Z tianya $

 * @package        DedeCMS.Administrator

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__)."/config.php");

CheckPurview('sys_shouhou');

$id = isset($id) && is_numeric($id) ? $id : 0;

$ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL'])? "shouhou_main.php" : $_COOKIE['ENV_GOBACK_URL'];

if(empty($dopost)) $dopost = "";



if($dopost=='edit')

{

    $msg = cn_substrR($msg, 3500);

    $adminmsg = trim($adminmsg);

    if($adminmsg!="")

    {

        $adminmsg = cn_substrR($adminmsg, 1500);

        $adminmsg = str_replace("<","&lt;", $adminmsg);

        $adminmsg = str_replace(">","&gt;", $adminmsg);

        $adminmsg = str_replace("  ","&nbsp;&nbsp;", $adminmsg);

        $adminmsg = str_replace("\r\n","<br/>\n", $adminmsg);

        $msg = $msg;

        $gmsg = $adminmsg;

		$gtime = time();

    }

    $query = "UPDATE `#@__shouhou` SET username='$username',msg='$msg',gtime='$gtime',gmsg='$gmsg',ischeck=1 WHERE id=$id";

    $dsql->ExecuteNoneQuery($query);

    ShowMsg("成功回复一则留言！",$ENV_GOBACK_URL);

    exit();

}

$query = "SELECT * FROM `#@__shouhou` WHERE id=$id";

$row = $dsql->GetOne($query);

include DedeInclude('templets/shouhou_edit.htm');