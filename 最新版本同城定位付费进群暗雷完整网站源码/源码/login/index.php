<? include('../system/inc.php'); 
if ($_POST['act']=='log')
{
null_back($_POST['username'],'5G云资源网www.yunziyuan.com.cn请输入用户名');	
null_back($_POST['password'],'5G云资源网www.yunziyuan.com.cn请输入用户密码');	

 
 $result = mysql_query('select * from '.flag.'user where username=  "'.$_POST['username'].'"  and password=  "'.$_POST['password'].'" ');
if ($row = mysql_fetch_array($result))
{
$_SESSION['member_id'] = $row['ID']; 
alert_url('/member/');
}
else
{
	alert_href('5G云资源网www.yunziyuan.com.cn用户名或密码不正确','');	
	
}
	}
	
	
	
	if ($_POST['act']=='reg')
{
null_back($_POST['username'],'请输入用户名');	
null_back($_POST['password'],'请输入用户密码');	
null_back($_POST['qq'],'请输入用户QQ');	
null_back($_POST['card'],'请输入邀请码');	

$yqm=base64_decode($_POST['card']);

if  ($_POST['shangji']!='')
{
 $result = mysql_query('select * from '.flag.'user where ID=  '.$_POST['shangji'].'    ');
if (!$row = mysql_fetch_array($result))
{ alert_back('5G云资源网www.yunziyuan.com.cn注册失败:推荐人ID'.$_POST['shangji'].'不存在');	}
 
}


 $result = mysql_query('select * from '.flag.'user where ID=  '.$yqm.'    ');
if ($row = mysql_fetch_array($result))
{ $shangjiid=$row['ID'];	}

 
else
{
 $result = mysql_query('select * from '.flag.'yqm where card=  "'.$_POST['card'].'"  and  uid  = 0   ');
if (!$row = mysql_fetch_array($result))
{ alert_back('5G云资源网www.yunziyuan.com.cn注册失败:邀请码'.$_POST['card'].'不正确/已被使用');	}
}

 


 
 $result = mysql_query('select * from '.flag.'user where username=  "'.$_POST['username'].'"   ');
if ($row = mysql_fetch_array($result))
{
	alert_back('5G云资源网www.yunziyuan.com.cn注册失败:用户名'.$_POST['username'].'已被注册');	

}
else
{
		$_data['rmb'] = 0;
		$_data['sxf'] = 0;
		$_data['ticheng'] = $site_morenticheng;
	$_data['username'] =$_POST['username'];
	$_data['nickname'] =$_POST['username'];
	$_data['password'] =$_POST['password'];
if ($_POST['shangji']!='' && $shangjiid=='')
	{$_data['shangji'] =$_POST['shangji'];}

if ( $shangjiid!='')
	{$_data['shangji'] =$shangjiid;}



	$_data['qq'] =$_POST['qq'];
	$_data['date'] =date('Y-m-d H:i:s');
  	$str = arrtoinsert($_data);
	$sql = 'insert into '.flag.'user ('.$str[0].') values ('.$str[1].')';
	 if (mysql_query($sql))
	{
		$uid = mysql_insert_id();
		$cardsql = 'update  '.flag.'yqm set  uid = '.$uid.'  where card="'.$_POST['card'].'" and uid = 0 ';
	  mysql_query($cardsql);
	 
	 
	  alert_href('注册成功','/login.php');}	
	 else
	 {	alert_back('注册失败:数据写入失败!');	}
 	
}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>登录</title>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/sign-up-login.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/inputEffect.css" />
<link rel="stylesheet" href="css/tooltips.css" />
<link rel="stylesheet" href="css/spop.min.css" />

<script src="js/jquery.min.js"></script>
<script src="js/snow.js"></script>
<script src="js/jquery.pure.tooltips.js"></script>
<script src="js/spop.min.js"></script>
<script>	
	(function() {
		// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
		if (!String.prototype.trim) {
			(function() {
				// Make sure we trim BOM and NBSP
				var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
				String.prototype.trim = function() {
					return this.replace(rtrim, '');
				};
			})();
		}

		[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
			// in case the input is already filled..
			if( inputEl.value.trim() !== '' ) {
				classie.add( inputEl.parentNode, 'input--filled' );
			}

			// events:
			inputEl.addEventListener( 'focus', onInputFocus );
			inputEl.addEventListener( 'blur', onInputBlur );
		} );

		function onInputFocus( ev ) {
			classie.add( ev.target.parentNode, 'input--filled' );
		}

		function onInputBlur( ev ) {
			if( ev.target.value.trim() === '' ) {
				classie.remove( ev.target.parentNode, 'input--filled' );
			}
		}
	})();
	
	$(function() {	
		$('#login #login-password').focus(function() {
			$('.login-owl').addClass('password');
		}).blur(function() {
			$('.login-owl').removeClass('password');
		});
		$('#login #register-password').focus(function() {
			$('.register-owl').addClass('password');
		}).blur(function() {
			$('.register-owl').removeClass('password');
		});
		$('#login #register-repassword').focus(function() {
			$('.register-owl').addClass('password');
		}).blur(function() {
			$('.register-owl').removeClass('password');
		});
		$('#login #forget-password').focus(function() {
			$('.forget-owl').addClass('password');
		}).blur(function() {
			$('.forget-owl').removeClass('password');
		});
	});
	
	function goto_register(){
		$("#register-username").val("");
		$("#register-password").val("");
		$("#register-repassword").val("");
		$("#register-code").val("");
		$("#tab-2").prop("checked",true);
	}
	
	function goto_login(){
		$("#login-username").val("");
		$("#login-password").val("");
		$("#tab-1").prop("checked",true);
	}
	
	function goto_forget(){
		$("#forget-username").val("");
		$("#forget-password").val("");
		$("#forget-code").val("");
		$("#tab-3").prop("checked",true);
	}
	
	function login(){//登录
		var username = $("#login-username").val(),
			password = $("#login-password").val(),
			validatecode = null,
			flag = false;
		//判断用户名密码是否为空
		if(username == ""){
			$.pt({
        		target: $("#login-username"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"用户名不能为空"
        	});
			flag = true;
		}
		if(password == ""){
			$.pt({
        		target: $("#login-password"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"密码不能为空"
        	});
			flag = true;
		}
		//用户名只能是15位以下的字母或数字
		var regExp = new RegExp("^[a-zA-Z0-9_]{1,15}$");
		if(!regExp.test(username)){
			$.pt({
        		target: $("#login-username"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"用户名必须为15位以下的字母或数字5G云资源网www.yunziyuan.com.cn"
        	});
			flag = true;
		}
		
		if(flag){
			return false;
		}else{//登录
			//调用后台登录验证的方法
			alert('登录成功');
			return false;
		}
	}
	
	//注册
	function register(){
		var username = $("#register-username").val(),
			password = $("#register-password").val(),
			repassword = $("#register-repassword").val(),
			code = $("#register-code").val(),
			flag = false,
			validatecode = null;
		//判断用户名密码是否为空
		if(username == ""){
			$.pt({
        		target: $("#register-username"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"用户名不能为空"
        	});
			flag = true;
		}
		if(password == ""){
			$.pt({
        		target: $("#register-password"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"密码不能为空"
        	});
			flag = true;
		}else{
			if(password != repassword){
				$.pt({
	        		target: $("#register-repassword"),
	        		position: 'r',
	        		align: 't',
	        		width: 'auto',
	        		height: 'auto',
	        		content:"两次输入的密码不一致"
	        	});
				flag = true;
			}
		}
		//用户名只能是15位以下的字母或数字
		var regExp = new RegExp("^[a-zA-Z0-9_]{1,15}$");
		if(!regExp.test(username)){
			$.pt({
        		target: $("#register-username"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"用户名必须为15位以下的字母或数字"
        	});
			flag = true;
		}
		//检查用户名是否已经存在
		//调后台代码检查用户名是否已经被注册
		
		//检查注册码是否正确
		//调后台方法检查注册码，这里写死为11111111
		if(code != '11111111'){
			$.pt({
		        target: $("#register-code"),
		        position: 'r',
		        align: 't',
		        width: 'auto',
		        height: 'auto',
		        content:"注册码不正确"
		       });
			flag = true;
		}
		
		
		if(flag){
			return false;
		}else{//注册
			spop({			
				template: '<h4 class="spop-title">&#29275;&#30721;&#23627;&#119;&#119;&#119;&#46;&#110;&#105;&#117;&#109;&#97;&#119;&#117;&#46;&#99;&#111;&#109;注册成功</h4>即将于3秒后返回登录',
				position: 'top-center',
				style: 'success',
				autoclose: 3000,
				onOpen : function(){
					var second = 2;
					var showPop = setInterval(function(){
						if(second == 0){
							clearInterval(showPop);
						}
						$('.spop-body').html('<h4 class="spop-title">&#29275;&#30721;&#23627;&#119;&#119;&#119;&#46;&#110;&#105;&#117;&#109;&#97;&#119;&#117;&#46;&#99;&#111;&#109;注册成功</h4>即将于'+second+'秒后返回登录');
						second--;
					},1000);
				},
				onClose : function(){
					goto_login();
				}
			});
			return false;
		}
	}
	
	//重置密码
	function forget(){
		var username = $("#forget-username").val(),
			password = $("#forget-password").val(),
			code = $("#forget-code").val(),
			flag = false,
			validatecode = null;
		//判断用户名密码是否为空
		if(username == ""){
			$.pt({
        		target: $("#forget-username"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"用户名不能为空"
        	});
			flag = true;
		}
		if(password == ""){
			$.pt({
        		target: $("#forget-password"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"密码不能为空"
        	});
			flag = true;
		}
		//用户名只能是15位以下的字母或数字
		var regExp = new RegExp("^[a-zA-Z0-9_]{1,15}$");
		if(!regExp.test(username)){
			$.pt({
        		target: $("#forget-username"),
        		position: 'r',
        		align: 't',
        		width: 'auto',
        		height: 'auto',
        		content:"用户名必须为15位以下的字母或数字"
        	});
			flag = true;
		}
		//检查用户名是否存在
		//调后台方法
		
		//检查注册码是否正确
		if(code != '11111111'){
			$.pt({
		        target: $("#forget-code"),
		        position: 'r',
		        align: 't',
		        width: 'auto',
		        height: 'auto',
		        content:"注册码不正确"
		       });
			flag = true;
		}
		
		
		
		if(flag){
			return false;
		}else{//重置密码
			spop({			
				template: '<h4 class="spop-title">重置密码成功</h4>&#29275;&#30721;&#23627;&#119;&#119;&#119;&#46;&#110;&#105;&#117;&#109;&#97;&#119;&#117;&#46;&#99;&#111;&#109;即将于3秒后返回登录',
				position: 'top-center',
				style: 'success',
				autoclose: 3000,
				onOpen : function(){
					var second = 2;
					var showPop = setInterval(function(){
						if(second == 0){
							clearInterval(showPop);
						}
						$('.spop-body').html('<h4 class="spop-title">重置密码成功</h4>即将于'+second+'秒后返回登录');
						second--;
						},1000);
				},
				onClose : function(){
					goto_login();
				}
			});
			return false;
		}
	}
	
	
	
	
	
	
	
</script>
<style type="text/css">
html{width: 100%; height: 100%;}

body{
	background-image: url(images/daili.jpg);
	background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    position: relative;
    text-align: center;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}
#login .loginform, #register .loginform {
    margin-top: 0px;
    position: relative;
    border: 1px solid #ddd;
    background-color: #fff;
    position: relative;
    max-width: 500px;
    padding: 0;
}
#login .loginform .form-actions, #register .loginform .form-actions {
    border-top: 1px solid #F0F8FF;
    background-color: #F0F8FF;
    padding: 30px 90px;
    text-align: right;
}
#MZT-DL{
	border-radius: 50px;
	font-family: 'Microsoft Yahei';
	font-size: 16px;
	color: #fff!important;
	line-height: 1.2;
	padding: 0 20px; 
	width:100%;
	height: 50px!important;
	background: #a64bf4;
	border-color: #a64bf4;
	 margin-bottom: 30px;
}
#MZT{
	
	    border-radius: 50px;
    font-family: 'Microsoft Yahei';
    font-size: 16px;
    color: #a64bf4;
    line-height: 3.2;
    padding: 0 20px;
    width: 100%;
    height: 50px;
    background: #a64bf4;
    border-color: #a64bf4;
    border-top: 1px solid #a64bf4;
    background-color: #F0F8FF;
    margin-bottom: 65px;
}
.input__field--hideo {
    padding: 1.5em 0.85em 0.85em 5em;
    width: 100%;
    background: transparent;
    -webkit-transform: translate3d(1em, 0, 0);
    transform: translate3d(1em, 0, 0);
    -webkit-transition: -webkit-transform 0.3s;
    transition: transform 0.3s;
}
.input__label--hideo {
    position: absolute;
    padding: 1.8em 0 0;
    width: 4em;
    height: 100%;
}
.input {
    position: relative;
    z-index: 1;
    display: inline-block;
    margin: 1.5em;
    max-width: 350px;
    width: calc(100% - 2em);
    vertical-align: top;
}
.snow-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 100001; }

</style>
</head>
<body>
	
	<!-- 登录控件 -->
	<div id="login">
		<input id="tab-1" type="radio" name="tab" class="sign-in hidden" checked />
		<input id="tab-2" type="radio" name="tab" class="sign-up hidden" />
		<input id="tab-3" type="radio" name="tab" class="sign-out hidden" />
		<div class="wrapper">
			<!-- 登录页面 -->
			<div class="login sign-in-htm">
				<form class="container offset1 loginform"  method="post">
				<input  type="hidden"  name="act" value="log" />
 					
					<div class="pad input-container">
						<section class="content">
							<span class="input input--hideo">
								<input class="input__field input__field--hideo" type="text" id="login-username" 
									autocomplete="off" placeholder="请输入用户名" name="username" tabindex="1" maxlength="15" />
								<label class="input__label input__label--hideo" for="login-username">
									<i class="fa fa-fw fa-user icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							<span class="input input--hideo">
								<input class="input__field input__field--hideo" type="password"   name="password" id="login-password" placeholder="请输入密码" tabindex="2" maxlength="15"/>
								<label class="input__label input__label--hideo" for="login-password">
									<i class="fa fa-fw fa-lock icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
						</section>
					</div>
					<div class="form-actions" style="padding: 0px 90px;">
						<input class="btn btn-primary" id="MZT-DL"  type="submit" tabindex="3"   value="登录" />
						<a tabindex="4" class="btn pull-left btn-link text-muted"   style="display:none" onClick="goto_forget()">忘记密码?</a>
					<div>	<a tabindex="5" class="btn btn-link text-muted" id="MZT" onClick="goto_register()">注册</a></div>
					</div>
				</form>
			</div>
			<!-- 忘记密码页面 -->
			<div class="login sign-out-htm">
				<form action="#" method="post" class="container offset1 loginform">
					<!-- 猫头鹰控件 -->
					<div id="owl-login" class="forget-owl">
						<div class="hand"></div>
						<div class="hand hand-r"></div>
						<div class="arms">
							<div class="arm"></div>
							<div class="arm arm-r"></div>
						</div>
					</div>
					<div class="pad input-container">
						<section class="content">
							<span class="input input--hideo">
								<input class="input__field input__field--hideo" name="username" type="text" id="forget-username" autocomplete="off" placeholder="请输入用户名"/>
								<label class="input__label input__label--hideo" for="forget-username">
									<i class="fa fa-fw fa-user icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							<span class="input input--hideo">
								<input class="input__field input__field--hideo"  type="text" id="forget-code" autocomplete="off" placeholder="请输入密码"/>
								<label class="input__label input__label--hideo" for="forget-code">
									<i class="fa fa-fw fa-wifi icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							<span class="input input--hideo">
								<input class="input__field input__field--hideo" type="password" id="forget-password" placeholder="请重置密码" />
								<label class="input__label input__label--hideo" for="forget-password">
									<i class="fa fa-fw fa-lock icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
						</section>
					</div>
					<div class="form-actions">
						<a class="btn pull-left btn-link text-muted" onClick="goto_login()">返回登录&#29275;&#30721;&#23627;&#119;&#119;&#119;&#46;&#110;&#105;&#117;&#109;&#97;&#119;&#117;&#46;&#99;&#111;&#109;</a>
						<input class="btn btn-primary" type="button" onClick="forget()" value="重置密码" 
							style="color:white;"/>
					</div>
				</form>
			</div>
			<!-- 注册页面 -->
			<div class="login sign-up-htm">
				<form action="#" method="post" class="container offset1 loginform">
				<input  type="hidden" name="act" value="reg"/>
					<!-- 猫头鹰控件 -->
					<div id="owl-login" class="register-owl">
						<div class="hand"></div>
						<div class="hand hand-r"></div>
						<div class="arms">
							<div class="arm"></div>
							<div class="arm arm-r"></div>
						</div>
					</div>
					<div class="pad input-container">
						<section class="content">
							<span class="input input--hideo">
								<input class="input__field input__field--hideo" type="text"  name="username" id="register-username" 
									autocomplete="off" placeholder="请输入用户名" maxlength="15"/>
								<label class="input__label input__label--hideo" for="register-username">
									<i class="fa fa-fw fa-user icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							<span class="input input--hideo">
								<input class="input__field input__field--hideo"  name="password" type="password" id="register-password" placeholder="请输入密码" maxlength="15"/>
								<label class="input__label input__label--hideo" for="register-password">
									<i class="fa fa-fw fa-lock icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							<span class="input input--hideo">
								<input class="input__field input__field--hideo" type="nunmber" name="qq" id="register-repassword" placeholder="请输入QQ" maxlength="15"/>
								<label class="input__label input__label--hideo" for="register-repassword">
									<i class="fa fa-fw fa-lock icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							
							<span class="input input--hideo">
								<input class="input__field input__field--hideo"    value="<?=$_REQUEST['uid']?>" name="shangji" type="text" placeholder="推荐人"/>
								<label class="input__label input__label--hideo" for="register-code">
									<i class="fa fa-fw fa-wifi icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
							
							
							<span class="input input--hideo">
								<input class="input__field input__field--hideo"   name="card" type="text" id="register-code" autocomplete="off" placeholder="请输入邀请码"/>
								<label class="input__label input__label--hideo" for="register-code">
									<i class="fa fa-fw fa-wifi icon icon--hideo"></i>
									<span class="input__label-content input__label-content--hideo"></span>
								</label>
							</span>
						</section>
					</div>
					<div class="form-actions">
								<input class="btn btn-primary" style="color: white; width: 130px; height: 50px;background-color: #899DDA; border-color: #899DDA;border-radius: 40px;"   type="submit"  value="注册" 
							style="color:white;"/>
						<a class="btn pull-left btn-link text-muted" style=" color: #899DDA; width: 130px; height: 50px; border-radius: 40px;line-height: 35px; background: #899DDA;border-color: #899DDA;border-top: 1px solid #899DDA; background-color: #F0F8FF;" onClick="goto_login()">返回登录</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div style="text-align:center;">
</div>
</body>
</html>