<?

  
include('../system/inc.php');
include('./admin_config.php');
include('./check.php');
$nav='kouliang';

if ( isset($_POST['提交']) ) {

 	null_back($_POST['num'],'请输入笔数');
	null_back($_POST['nums'],'请输入扣量');
	
	
 	$_data['num'] = $_POST['num'];
	$_data['nums'] = $_POST['nums'];
 
	$str = arrtoinsert($_data);
	$sql = 'update '.flag.'kouliang set '.arrtoupdate($_data).' where id = '.$_GET['id'].'';
	if (mysql_query($sql)) {
		$order = mysql_insert_id();
 	}  {
		alert_href('修改成功!','kouliang.php');
	}
}
  			?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>修改扣量</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
	
 
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
	<? include('header.php');?>
		
	<? include('left.php');?><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="admin_index.php"><span class="glyphicon glyphicon-home">管理首页</span></a></li>
				<li class="active">修改扣量</li>
			</ol>
		</div><!--/.row-->
		
 <br>
   
	 
			 
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> 修改扣量</div>
					<div class="panel-body">
						<?php
					$result = mysql_query('select * from '.flag.'kouliang where id = '.$_GET['id'].' ');
					if ($row = mysql_fetch_array($result)){
					?>
 					
						<form class="form-horizontal" action="" method="post">
							<fieldset>
							
							                 
                 
					   
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">用户信息</label>
									<div class="col-md-9">
  								                         			                <input   type="text"  class="form-control"   value="<?=get_user('username',$row['uid'])?> UID:<?=$row['uid']?>"  readonly  >

  

							</div>
								</div>
						 
							
							
										<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">笔数</label>
									<div class="col-md-9">
 			                <input name="num" type="text"  class="form-control"   value="<?=$row['num']?>" placeholder="请输入笔数"    >

 
 
 
							</div>
								</div>
											<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">扣量</label>
									<div class="col-md-9">
 
 			                <input name="nums" type="text"   class="form-control"  value="<?=$row['nums']?>"  placeholder="请输入扣量"    >

 
 
							</div>
								</div>
							
							
					 
								
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-12 widget-right">
						 <input name="提交" class="btn"  type="hidden"    value="提交">

										<button type="submit" class="btn btn-default btn-md pull-right">修改</button>
									</div>
								</div>
							</fieldset>
						</form>
						<? }?>
					</div>
				</div>
				
		  </div>
			<!--/.col-->
			<!--/.col-->
        </div>
		<!--/.row-->
	</div>	<!--/.main-->
		  

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
