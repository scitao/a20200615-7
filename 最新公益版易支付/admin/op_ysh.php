<?php
$mod='blank';
include("../includes/common.php");
$title='易商户配置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
if(isset($_POST['submit'])) {
    foreach ($_POST as $x => $value) {
        if($x=='pwd')continue;
        $value=daddslashes($value);
        $DB->query("insert into opao_config set `x`='{$x}',`j`='{$value}' on duplicate key update `j`='{$value}'");
    }
    echo "<script language='javascript'>alert('报告老大，您的接口信息已修改成功！');window.location.href='./op_ysh.php';</script>";
    exit();
}
?>
    <div class="header bg-<?php echo $conf['adminmb_ys']?> pb-6"><div class="container-fluid"><div class="header-body"><div class="row align-items-center py-4"><div class="col-lg-6 col-7"><h6 class="h2 text-white d-inline-block mb-0">易商户配置</h6><nav aria-label="breadcrumb"class="d-none d-md-inline-block ml-md-4"><ol class="breadcrumb breadcrumb-links breadcrumb-dark"><li class="breadcrumb-item"><a href="#!"><i class="fas fa-home"></i></a></li><li class="breadcrumb-item"><a href="#!">接口设置</a></li><li class="breadcrumb-item active" aria-current="page">易商户配置</li></ol></nav></div></div></div></div>
    </div>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card-wrapper">
            <!-- Custom form validation -->
            <div class="card">
              <!-- Card header -->
              <div class="card-header">
                <h3 class="mb-0">易商户官网&nbsp;&nbsp;<a target="_blank" href="https://www.1shanghu.com/i/00EJTE"><font color="#FF0000">点击进入</font></a></h3>
              </div>
              <!-- Card body -->
              <div class="card-body"><form class="needs-validation"action="./op_ysh.php?mod=site_n"method="post"role="form"><div class="form-row"><div class="col-md-12 mb-3"><label class="form-control-label">微信商户ID:</label><input type="text"name="wx_eshanghu_sub_mch_id"class="form-control"value="<?php echo $conf['wx_eshanghu_sub_mch_id'];?>"></div></div><div class="form-row"><div class="col-md-12 mb-3"><label class="form-control-label">易商户AppKey:</label><input type="text"name="wx_eshanghu_app_key"class="form-control"value="<?php echo $conf['wx_eshanghu_app_key'];?>"></div></div><div class="form-row"><div class="col-md-12 mb-3"><label class="form-control-label">易商户APP_SECRET:</label><input type="text"name="wx_eshanghu_app_secret"class="form-control"value="<?php echo $conf['wx_eshanghu_app_secret'];?>"></div></div><div class="form-group"><div class="custom-control custom-checkbox mb-3"><input class="custom-control-input"id="invalidCheck"type="checkbox"required=""><label class="custom-control-label"for="invalidCheck">我已确保为本人修改信息</label></div></div><button class="btn btn-<?php echo $conf['adminmb_ys']?> form-control"type="submit"name="submit">确定修改</button></form></div>
            </div>
          </div>
        </div>
      </div>
      <!-- 主页结束 -->
<?php include 'foot.php';?>