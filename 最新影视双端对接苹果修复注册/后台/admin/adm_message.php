﻿<?php
require_once 'globals.php';
include_once 'header.php';
 $sql="select * from cl_message where 1";
 $queryc=$db->query($sql);
 $nums=$db->num_rows($queryc);

 $enums=30;  //每页显示的条目数 
 $page=isset($_GET['page']) ? intval($_GET['page']) : 1;
 $av_url = $_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);
 $url="adm_message.php?page=";
 $bnums=($page-1)*$enums;
 
 $ids = isset($_POST['ids']) ? $_POST['ids'] : '';
 if($ids){
	$idss = '';
	foreach ($ids as $value) {
		$idss .= $value.",";
	}
	$idss = rtrim($idss, ",");
	$sql="DELETE FROM `cl_message` WHERE `uid` in ($idss)";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('删除成功');</script>";
	}
 }
?>


    <div class="tpl-page-container tpl-page-header-fixed">



        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                管理列表
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">
                    <li class="tpl-left-nav-item">
                        <a href="index.php" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-home"></i>
                            <span>首页</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="adm_user.php" class="nav-link">
                             <i class="fa fa-user" aria-hidden="true"></i>
                            <span>用户管理</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="adm_message.php" class="nav-link active">
                             <i class="fa fa-pencil-square" aria-hidden="true"></i>
                            <span>用户反馈</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="add_user.php" class="nav-link tpl-left-nav-link-list">
                             <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <span>添加用户</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>

                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="fa fa-gear" aria-hidden="true"></i>
                            <span>配置中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="edit_sz.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>软件配置</span>
                                    
                                </a>
                              <a href="edit_zfgl.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>支付配置</span>
                                </a>
                                <a href="adm_set.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>注册管理</span>
                                </a>
                                <a href="edit_gg.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>广告管理</span>
		</a>

                            </li>
                        </ul>
                    </li>

                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list ">
                           <i class="fa fa-vimeo-square" aria-hidden="true"></i>
                            <span>卡密中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                           <li>
                                <a href="adm_kami.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>卡密管理</span>
                                    
                                </a>

                                <a href="add_kami.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>卡密生成</span>
                                </a>

                                    <a href="out_kami.php">
                                       <i class="am-icon-angle-right"></i>
                                        <span>卡密导出</span>
                                    </a>

                                        <a href="del_kami.php">
                                            <i class="am-icon-angle-right"></i>
                                            <span>卡密清理</span>

                                        </a>
                            </li>
                        </ul>
                    </li>
                   <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                           <i class="fa fa-play-circle" aria-hidden="true"></i>
                            <span>视频管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                           <li>
                                <a href="shipin_sc.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>上传视频</span>
                                    
                                </a>
                                
                                <a href="shipin_data.php">
                                    <i class="am-icon-angle-right "></i>
                                    <span>视频管理</span>
                                    
                                </a>

                                <a href="shipin_fl.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>视频分类</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>


<div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                用户中心
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">反馈管理</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 反馈管理
                    </div>
                


                </div>
                <div class="tpl-block">
                 <div class="am-u-sm-12 am-u-md-3">  
               <form action="adm_user.php" method="post" name="suer" id="suer">


</form>
                 </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                          
<form action="" method="post" name="form_log" id="form_log">
    <div class="am-scrollable-horizontal">
  <table width="100%" id="adm_log_list" class="am-table am-table-striped am-table-hover table-main am-text-nowrap">
  <thead>
      <tr>
		<th><input type="checkbox" onclick="checkAll();" class="ids" id="all"/></th>
		<th><b>用户名</b></th>
		<th><b>反馈内容</b></th>
		<th><b>反馈时间</b></th>
		<th><b>回复内容</b></th>
		<th><b>回复时间</b></th>
        <th class="table-set"><b>管理</b></th>
      </tr>
	</thead>
 	<tbody>
<?php
 $username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
 //$sql="select * from cl_message";
 $sql="select * from cl_message where 1 order by uid desc limit $bnums,$enums";
 $query=$db->query($sql);
 while($rows=$db->fetch_array($query)){
?>
      <tr>
      <td><input type="checkbox" name="ids[]" value="<?php echo $rows['uid']; ?>" class="ids" /></td>
	  <td><?php echo $rows['username']; ?></td>
      <td><input  type="text" class="mdui-textfield-input mdui-col-md-11" name="dqrenshu" value="<?php echo $rows['txt'];?>" id="txtnr" /></td>
	  <td><?php echo gmdate("Y-m-d H:i:s",$rows['time']+8*3600); ?></td>
<td><input  type="text" class="mdui-textfield-input mdui-col-md-11" name="dqrenshu" value="<?php echo $rows['hftxt'];?>" id="hfnr" /></td>
	  <td><?php echo gmdate("Y-m-d H:i:s",$rows['hftime']+8*3600); ?></td>
	  <td>
	  	<div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a href="edit_hf.php?uid=<?php echo $rows['uid'];?>" target="_self" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 回复</a>
                                                    </div>
                                                </div>
	  </td>
      </tr>
<?php
 }
?>
	</tbody>
	</table>
</div>
	<div class="list_footer">
	选中项：<a href="javascript:void(0);" onclick="delsubmit()" class="care">删除</a>
	</div>
</form>
<?php if($username == ''): ?>
<div class="page"><?php echo pagination($nums,$enums,$page,$url); ?></div>
<?php endif; ?>
<script>
function checkAll() {
    var code_Values = document.getElementsByTagName("input");
	var all = document.getElementById("all");
    if (code_Values.length) {
        for (i = 0; i < code_Values.length; i++) {
            if (code_Values[i].type == "checkbox") {
                code_Values[i].checked = all.checked;
            }
        }
    } else {
        if (code_Values.type == "checkbox") {
            code_Values.checked = all.checked;
        }
    }
}
function delsubmit(){
	var delform = document.getElementById("form_log");
	delform.submit();
}
var div = document.getElementById('adm_user'); 
div.setAttribute("class", "show"); 
</script>
</div>	</div>
   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>