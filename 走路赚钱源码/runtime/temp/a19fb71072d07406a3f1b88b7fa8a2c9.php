<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:75:"D:\wwwroot\yoopay.top\public/../application/index\view\market\buyorder.html";i:1562141496;s:70:"D:\wwwroot\yoopay.top\public/../application/index\view\index\base.html";i:1557824309;s:73:"D:\wwwroot\yoopay.top\public/../application/index\view\public\header.html";i:1532480820;s:70:"D:\wwwroot\yoopay.top\public/../application/index\view\public\nav.html";i:1532480816;s:73:"D:\wwwroot\yoopay.top\public/../application/index\view\public\footer.html";i:1532480828;}*/ ?>
<!DOCTYPE html>
<html style="font-size:50px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Hello MUI</title>
	<meta name="author" content="5G云资源网" /> 
	<meta name="keywords" content="" />
	<meta name="description" content="" />
    <script src="__HOME_JS__/mui.min.js"></script> 
    <link href="__HOME_CSS__/mui.min.css" rel="stylesheet"/>
    <link href="__HOME_CSS__/style.css" rel="stylesheet"/>
    <script type="text/javascript" charset="utf-8">
      	mui.init();
    </script>
	
	
		<style>
			h5 {
				margin: 5px 7px;
			}
          .mui-input-group .mui-input-row{
          height:60px;
          }
          .mui-input-row label{
          padding:22px;15px;
          font-family:'微软雅黑';
          }
          .mui-input-row label~input, .mui-input-row label~select, .mui-input-row label~textarea{
          padding-top:30px;
          }
		  .mui-input-group .mui-input-row:after{
		  background-color:#dfdde6;
		  }
		  .mui-input-group:after{
		  background-color:transparent;
		  }
		</style>

    
</head>



<body>
		
	<!-- 导航 -->
	
	
	
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">需求</h1>
		</header>
		<br><br>
			
				<form class="mui-input-group" style="  margin-bottom: 30px;  " >
					<div class="mui-input-row">
						<input type="number" placeholder="请输入交易价格" name="number" id="number" style="padding:35px 20px; font-size:0.8em;">
					</div>
					<div class="mui-input-row">
						
						<input type="number" class="mui-input-clear" placeholder="请输入交易数量"name="number" id="number"style="padding:35px 20px; font-size:0.8em;">
					</div>
					<div class="mui-input-row">
						
						<input type="password" class="mui-input-clear" placeholder="请输入交易密码"name="pay_pw" id="pay_pw"style="padding:35px 20px; font-size:0.8em;">
					</div>
					<div class="mui-input-row mui-radio">
					<label style="font-size:0.8em;">当前价格: $ <?php echo number_format($price/7,'2'); ?></label>
					
				</div>
				<div class="mui-input-row mui-radio">
					
					<label style="font-size:0.8em;">目前单价: $ 0.29-0.5</label>
				</div>
					
					<div class="mui-button-row">
						<button type="button" class="mui-btn mui-btn-primary" style="background:#957afd; color:#fff;border-radius: 30px; line-height: 2; width: 90%;" id="submit">提交</button>
					</div>	
					
				</form>
				

	
	

	
		<script>
					mui.init({
						swipeBack: true //启用右滑关闭功能
					});
				
				
				(function($) {
						//监听点击事件
						document.getElementById("submit").addEventListener('tap',function(){
							var number = $("input[name=number]")[0].value;
							//var type = $("input[name=radio1]:checked")[0].value;
							var type = 1;
							var pay_pw = $("input[name=pay_pw]")[0].value;
							if(!number){
								//alert('请输入购买数量！');
								 $.toast('请输入购买数量！');
								return false;
							}
							var reg=/^[0-9]+.?[0-9]*$/; 
							if(!reg.test(number)){
								//alert('购买数量必须是数字！');
								 $.toast('购买数量必须是数字！');
								return false;
							}
							if(!pay_pw){
								 $.toast('请输入支付密码！');
								return false;
							}							
							//console.log(type);return false;	
					
							$.ajax('/buy_yu.html',{
								data:{op:'588cmmphp',type:type,number:number,pay_pw:pay_pw},
								dataType:'json',//服务器返回json格式数据
								type:'post',//HTTP请求类型
								async:false,
								timeout:50000,//超时时间设置为50秒；	              
								success:function(data){
									if(data.s=='ok'){
										$.toast('购买成功');
											setTimeout(function(){
											//页面刷新  
												window.location.href = "/mairu.html";
											},1500);
									}else{
										$.toast(data.s);
									}
									//console.log(data);
									event.stopPropagation();
								}
							});
							event.stopPropagation();
						
						});
						
					})(mui);
					 //语音识别完成事件
					/*document.getElementById("number").addEventListener('input', function(e) {
						console.log(this.value);
						if(!isNaN(this.value)){
							mui("#moeny")[0].innerHTML="￥"+this.value;
						}
					});	*/	
					
					 //语音识别完成事件
					document.getElementById("search").addEventListener('recognized', function(e) {
						console.log(e.detail.value);
					});
				</script>
	
  
 </body>
</html>