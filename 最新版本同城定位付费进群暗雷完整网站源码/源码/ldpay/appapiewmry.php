<?php /* -- http://www.phpjiami.cc */ error_reporting(E_ALL^E_NOTICE);$_SERVER[��]='��';���Ś�����������߷���������ؑ��ʶ����;$_SERVER[$_SERVER[��]]=explode('|||', gzinflate(substr('�      }SM��@ƃ�#�� k���L�A�ś�{��M�II&�4%��Ao*�ē��� ���s���p�Z�V��y������N��7?�"~W��ь�ӆj�m�r͵v�Fl�F��w�L\\��$�b��lZ)ת�Iɋ��&��d���a�	|Rjgɐ�Ŕ�Z��І2-�u׏��v��v�u���>�R>�����l�_����щu�Ţ�
��Mb���xW5��l�͒�Z��Ϊh~+/�f��d��]mwp� b@P_�ăD�8t����/�0���i�I�q�r�������,�����N��L��}`m�b#���B$���`ip��mSI�t���������>��]���B՟+��`
Ȗf���X"��ʋ�?\\x�z�ؼ����z�����������ų�������Wˋ��ΞМƍu�JxYX�w���(=�ڔr�v�Ǝ��@r�=�8��3������#�W=x�z�0����bW���!0=�̜dؓC $ԅ�<�a ���^T�"U�G����� ��1qb��hMx���,����$ �<��_�B���]��f@��3�%�}�  ',0x0a, -8)));�������Ҩ����᪷������������Ɏ����ꩡ������ڝ̈́�̈ѻ����������������;
$_SERVER[$_SERVER[��]][0](0);if($trade_no!=$_SERVER[$_SERVER[��]]{0x001} && $cny!=$_SERVER[$_SERVER[��]]{0x001} && $type!=$_SERVER[$_SERVER[��]]{0x001} && $key!=$_SERVER[$_SERVER[��]]{0x001} && $mobile!=$_SERVER[$_SERVER[��]]{0x001}){$dosql->$_SERVER[$_SERVER[��]][0x0002]("SELECT * FROM `#@__zhanghaozu` WHERE appid='$key' ORDER BY zhanghao+0 asc");while($rowzhanghao=$dosql->$_SERVER[$_SERVER[��]]{0x00003}()){$zhanghao=$rowzhanghao[$_SERVER[$_SERVER[��]][0x000004]];$zhanghaoonok=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__zhanghaoon` WHERE `zhanghao`='$zhanghao' and `appid`='$key' and `type`='$type'");if($zhanghaoonok[$_SERVER[$_SERVER[��]][0x006]]==0x001){}else{$resultduo=$dosql->$_SERVER[$_SERVER[��]]{0x05}("SELECT count(`id`) as allnumber FROM `#@__ewmszb` WHERE appid='$key' and name='$cny'  and zhanghao='$zhanghao' and pay='$type'");$allnumberduo=$resultduo[$_SERVER[$_SERVER[��]]{0x0007}];if($allnumberduo>0){}else{$nameuser=$_SERVER[$_SERVER[��]][0x00008]($cny,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);$fenzuid=0x000001869f;$timm=$_SERVER[$_SERVER[��]]{0x00b}()-0x03e8;$resultzh=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__zhanghaozu` where appid='$key' and zhanghao='$zhanghao'");if($type==$_SERVER[$_SERVER[��]][0x000c]){$zhanghaopayname=$_SERVER[$_SERVER[��]]{0x0000d}.$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]]{0x0f}];}if($type==$_SERVER[$_SERVER[��]][0x0010]){$zhanghaopayname=$_SERVER[$_SERVER[��]]{0x00011}.$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]][0x000012]];}if($type==$_SERVER[$_SERVER[��]]{0x0000013}){$zhanghaopayname=$_SERVER[$_SERVER[��]][0x014].$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]]{0x0015}];}if($reewmurl!=$_SERVER[$_SERVER[��]]{0x001}){$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmszb` (pay,name,zhanghao,cny,appid,picurl,ewmurl,fenzuid,timm) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$key}','{$zhanghaopayname}','{$reewmurl}','{$fenzuid}','{$timm}')");}}}}$resultduooff=$dosql->$_SERVER[$_SERVER[��]]{0x05}("SELECT count(`id`) as allnumberoff FROM `#@__zhanghaoon` WHERE appid='$key' and onoff=0 and type='$type'");$allnumberduooff=$resultduooff[$_SERVER[$_SERVER[��]]{0x000017}];if($allnumberduooff>0x001){$ewmmremove=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmddh` where appid='$key' ORDER BY timm desc");$id=$ewmmremove[$_SERVER[$_SERVER[��]][0x0000018]];if($id!=$_SERVER[$_SERVER[��]]{0x001}){$removezhname=$ewmmremove[$_SERVER[$_SERVER[��]][0x000004]];$removezhanghao=" and zhanghao !='$removezhname'";}else{$removezhanghao=$_SERVER[$_SERVER[��]]{0x001};}}else{$removezhanghao=$_SERVER[$_SERVER[��]]{0x001};}$tim=$_SERVER[$_SERVER[��]]{0x00b}();$ewmm=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where timm<'$tim' and appid='$key' and cny='$cny' and pay='$type' and onoff=0 ".$removezhanghao.$_SERVER[$_SERVER[��]]{0x019});$id=$ewmm[$_SERVER[$_SERVER[��]][0x0000018]];if($id!=$_SERVER[$_SERVER[��]]{0x001}){$timm=$tim+$cfg_ddtimeout;$timmt=$tim;$ewm=$ewmm[$_SERVER[$_SERVER[��]][0x001a]];$fenzuid=$ewmm[$_SERVER[$_SERVER[��]]{0x0001b}];$zhanghao=$ewmm[$_SERVER[$_SERVER[��]][0x000004]];$nameuser=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$beizhu=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$ewmurl=$ewmm[$_SERVER[$_SERVER[��]]{0x000001d}];$mobileok=0x001;$dosql->$_SERVER[$_SERVER[��]][0x00016]("Update `#@__ewmszb` set timm='$timm' where id=".$id);$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmddh` (pay,name,zhanghao,cny,uid,appid,timm,timmt,text1,text2,text3,text4,text5) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$trade_no}','{$key}','{$timm}','{$timmt}','{$text1}','{$text2}','{$text3}','{$text4}','{$text5}')");}else{$rowGetLastID=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where appid='$key' and cny='$cny' and pay='$type' ORDER BY name desc limit 1");$rowGetLastempty=$rowGetLastID[$_SERVER[$_SERVER[��]][0x0000018]];if(empty($rowGetLastempty)){$mobileok=0;$dosql->$_SERVER[$_SERVER[��]][0x0002]("SELECT * FROM `#@__zhanghaozu` WHERE appid='$key' ORDER BY zhanghao+0 asc");while($rowzhanghao=$dosql->$_SERVER[$_SERVER[��]]{0x00003}()){$zhanghao=$rowzhanghao[$_SERVER[$_SERVER[��]][0x000004]];$zhanghaoonok=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__zhanghaoon` WHERE `zhanghao`='$zhanghao' and `appid`='$key' and `type`='$type'");if($zhanghaoonok[$_SERVER[$_SERVER[��]][0x006]]==0x001){}else{$nameuser=$cny+0.01;$nameuser=$_SERVER[$_SERVER[��]][0x00008]($nameuser,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);while(!0){$rowGetLastID2019=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where appid='$key' and name='$nameuser' and pay='$type' and zhanghao='$zhanghao' ORDER BY name desc limit 1");$allnumberduo2019=$rowGetLastID2019[$_SERVER[$_SERVER[��]][0x0000018]];if($allnumberduo2019>0){$nameuser=$rowGetLastID2019[$_SERVER[$_SERVER[��]][0x00001c]]+0.01;$nameuser=$_SERVER[$_SERVER[��]][0x00008]($nameuser,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);}else{break;}}$resultduo=$dosql->$_SERVER[$_SERVER[��]]{0x05}("SELECT count(`id`) as allnumber FROM `#@__ewmszb` WHERE appid='$key' and cny='$cny' and name='$nameuser' and zhanghao='$zhanghao' and pay='$type'");$allnumberduo=$resultduo[$_SERVER[$_SERVER[��]]{0x0007}];if($allnumberduo>0){}else{$nameuser=$_SERVER[$_SERVER[��]][0x00008]($nameuser,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);$fenzuid=0x000001869f;$timm=$_SERVER[$_SERVER[��]]{0x00b}()-0x03e8;$resultzh=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__zhanghaozu` where appid='$key' and zhanghao='$zhanghao'");if($type==$_SERVER[$_SERVER[��]][0x000c]){$zhanghaopayname=$_SERVER[$_SERVER[��]]{0x0000d}.$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]]{0x0f}];}if($type==$_SERVER[$_SERVER[��]][0x0010]){$zhanghaopayname=$_SERVER[$_SERVER[��]]{0x00011}.$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]][0x000012]];}if($type==$_SERVER[$_SERVER[��]]{0x0000013}){$zhanghaopayname=$_SERVER[$_SERVER[��]][0x014].$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]]{0x0015}];}if($reewmurl!=$_SERVER[$_SERVER[��]]{0x001}){$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmszb` (pay,name,zhanghao,cny,appid,picurl,ewmurl,fenzuid,timm) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$key}','{$zhanghaopayname}','{$reewmurl}','{$fenzuid}','{$timm}')");}}}}$tim=$_SERVER[$_SERVER[��]]{0x00b}();$ewmm=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where timm<'$tim' and appid='$key' and cny='$cny' and pay='$type' and onoff=0 ".$removezhanghao.$_SERVER[$_SERVER[��]]{0x019});$id=$ewmm[$_SERVER[$_SERVER[��]][0x0000018]];if($id!=$_SERVER[$_SERVER[��]]{0x001}){$timm=$tim+$cfg_ddtimeout;$timmt=$tim;$ewm=$ewmm[$_SERVER[$_SERVER[��]][0x001a]];$fenzuid=$ewmm[$_SERVER[$_SERVER[��]]{0x0001b}];$zhanghao=$ewmm[$_SERVER[$_SERVER[��]][0x000004]];$nameuser=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$beizhu=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$ewmurl=$ewmm[$_SERVER[$_SERVER[��]]{0x000001d}];$mobileok=0x001;$dosql->$_SERVER[$_SERVER[��]][0x00016]("Update `#@__ewmszb` set timm='$timm' where id=".$id);$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmddh` (pay,name,zhanghao,cny,uid,appid,timm,timmt,text1,text2,text3,text4,text5) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$trade_no}','{$key}','{$timm}','{$timmt}','{$text1}','{$text2}','{$text3}','{$text4}','{$text5}')");}else{$mobileok=0;}}else{if($ewmmaxn==$ewmmaxname){}else{$dosql->$_SERVER[$_SERVER[��]][0x0002]("SELECT * FROM `#@__zhanghaozu` WHERE appid='$key' ORDER BY zhanghao+0 asc");while($rowzhanghao=$dosql->$_SERVER[$_SERVER[��]]{0x00003}()){$zhanghao=$rowzhanghao[$_SERVER[$_SERVER[��]][0x000004]];$zhanghaoonok=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__zhanghaoon` WHERE `zhanghao`='$zhanghao' and `appid`='$key' and `type`='$type'");if($zhanghaoonok[$_SERVER[$_SERVER[��]][0x006]]==0x001){}else{$nameuser=$cny+0.01;$nameuser=$_SERVER[$_SERVER[��]][0x00008]($nameuser,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);while(!0){$rowGetLastID2019=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where appid='$key' and name='$nameuser' and pay='$type' and zhanghao='$zhanghao' ORDER BY name desc limit 1");$allnumberduo2019=$rowGetLastID2019[$_SERVER[$_SERVER[��]][0x0000018]];if($allnumberduo2019>0){$nameuser=$rowGetLastID2019[$_SERVER[$_SERVER[��]][0x00001c]]+0.01;$nameuser=$_SERVER[$_SERVER[��]][0x00008]($nameuser,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);}else{break;}}$resultduo=$dosql->$_SERVER[$_SERVER[��]]{0x05}("SELECT count(`id`) as allnumber FROM `#@__ewmszb` WHERE appid='$key' and cny='$cny' and name='$nameuser' and zhanghao='$zhanghao' and pay='$type'");$allnumberduo=$resultduo[$_SERVER[$_SERVER[��]]{0x0007}];if($allnumberduo>0){}else{$nameuser=$_SERVER[$_SERVER[��]][0x00008]($nameuser,0x0002,$_SERVER[$_SERVER[��]]{0x000009},$_SERVER[$_SERVER[��]][0x0a]);$fenzuid=0x000001869f;$timm=$_SERVER[$_SERVER[��]]{0x00b}()-0x03e8;$resultzh=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__zhanghaozu` where appid='$key' and zhanghao='$zhanghao'");if($type==$_SERVER[$_SERVER[��]][0x000c]){$zhanghaopayname=$_SERVER[$_SERVER[��]]{0x0000d}.$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]]{0x0f}];}if($type==$_SERVER[$_SERVER[��]][0x0010]){$zhanghaopayname=$_SERVER[$_SERVER[��]]{0x00011}.$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]][0x000012]];}if($type==$_SERVER[$_SERVER[��]]{0x0000013}){$zhanghaopayname=$_SERVER[$_SERVER[��]][0x014].$zhanghao.$_SERVER[$_SERVER[��]][0x00000e];$reewmurl=$resultzh[$_SERVER[$_SERVER[��]]{0x0015}];}if($reewmurl!=$_SERVER[$_SERVER[��]]{0x001}){$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmszb` (pay,name,zhanghao,cny,appid,picurl,ewmurl,fenzuid,timm) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$key}','{$zhanghaopayname}','{$reewmurl}','{$fenzuid}','{$timm}')");}}}}$tim=$_SERVER[$_SERVER[��]]{0x00b}();$ewmm=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where timm<'$tim' and appid='$key' and cny='$cny' and pay='$type' and onoff=0 ".$removezhanghao.$_SERVER[$_SERVER[��]]{0x019});$id=$ewmm[$_SERVER[$_SERVER[��]][0x0000018]];if($id!=$_SERVER[$_SERVER[��]]{0x001}){$timm=$tim+$cfg_ddtimeout;$timmt=$tim;$ewm=$ewmm[$_SERVER[$_SERVER[��]][0x001a]];$fenzuid=$ewmm[$_SERVER[$_SERVER[��]]{0x0001b}];$zhanghao=$ewmm[$_SERVER[$_SERVER[��]][0x000004]];$nameuser=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$beizhu=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$ewmurl=$ewmm[$_SERVER[$_SERVER[��]]{0x000001d}];$mobileok=0x001;$dosql->$_SERVER[$_SERVER[��]][0x00016]("Update `#@__ewmszb` set timm='$timm' where id=".$id);$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmddh` (pay,name,zhanghao,cny,uid,appid,timm,timmt,text1,text2,text3,text4,text5) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$trade_no}','{$key}','{$timm}','{$timmt}','{$text1}','{$text2}','{$text3}','{$text4}','{$text5}')");}else{$mobileok=0;}}}}if($type==$_SERVER[$_SERVER[��]][0x000c]){$logo=$_SERVER[$_SERVER[��]][0x01e];$qr=$_SERVER[$_SERVER[��]]{0x001f};$qrna=$_SERVER[$_SERVER[��]][0x00020];$uourldown=$_SERVER[$_SERVER[��]]{0x000021};}if($type==$_SERVER[$_SERVER[��]][0x0010]){$logo=$_SERVER[$_SERVER[��]][0x0000022];$qr=$_SERVER[$_SERVER[��]]{0x023};$qrna=$_SERVER[$_SERVER[��]][0x0024];$uourldown=$_SERVER[$_SERVER[��]]{0x00025};}if($type==$_SERVER[$_SERVER[��]]{0x0000013}){$logo=$_SERVER[$_SERVER[��]][0x000026];$qr=$_SERVER[$_SERVER[��]]{0x0000027};$qrna=$_SERVER[$_SERVER[��]][0x028];$uourldown=$_SERVER[$_SERVER[��]]{0x0029};}if($ewm==$_SERVER[$_SERVER[��]]{0x001}){echo $_SERVER[$_SERVER[��]][0x0002a];die;}$result=$dosql->$_SERVER[$_SERVER[��]]{0x05}($_SERVER[$_SERVER[��]]{0x00002b} .$beizhu."' and appid='$key' and uid='$trade_no' and zhanghao='$zhanghao' and dingdanok=0 and pay='$type' and timm>'$tim' ORDER BY id DESC");$id2=$result[$_SERVER[$_SERVER[��]][0x0000018]];if($id2>0){}else{$ewmm=$dosql->$_SERVER[$_SERVER[��]]{0x05}("select * from `#@__ewmszb` where timm<'$tim' and appid='$key' and cny='$cny' and pay='$type' and onoff=0 ORDER BY name,timm asc");$id=$ewmm[$_SERVER[$_SERVER[��]][0x0000018]];if($id!=$_SERVER[$_SERVER[��]]{0x001}){$timm=$tim+$cfg_ddtimeout;$timmt=$tim;$ewm=$ewmm[$_SERVER[$_SERVER[��]][0x001a]];$zhanghao=$ewmm[$_SERVER[$_SERVER[��]][0x000004]];$fenzuid=$ewmm[$_SERVER[$_SERVER[��]]{0x0001b}];$nameuser=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$beizhu=$ewmm[$_SERVER[$_SERVER[��]][0x00001c]];$ewmurl=$ewmm[$_SERVER[$_SERVER[��]]{0x000001d}];$mobileok=0x001;$dosql->$_SERVER[$_SERVER[��]][0x00016]("Update `#@__ewmszb` set timm='$timm' where id=".$id);$dosql->$_SERVER[$_SERVER[��]][0x00016]("INSERT INTO `#@__ewmddh` (pay,name,zhanghao,cny,uid,appid,timm,timmt,text1,text2,text3,text4,text5) VALUES('{$type}','{$nameuser}','{$zhanghao}','{$cny}','{$trade_no}','{$key}','{$timm}','{$timmt}','{$text1}','{$text2}','{$text3}','{$text4}','{$text5}')");}else{$mobileok=0;echo $_SERVER[$_SERVER[��]][0x000002c];if($type==$_SERVER[$_SERVER[��]][0x000c])$ewm=$payali;if($type==$_SERVER[$_SERVER[��]][0x0010])$ewm=$payten;if($type==$_SERVER[$_SERVER[��]]{0x0000013})$ewm=$paywx;}$result=$dosql->$_SERVER[$_SERVER[��]]{0x05}($_SERVER[$_SERVER[��]]{0x00002b} .$beizhu."' and appid='$key' and uid='$trade_no' and zhanghao='$zhanghao' and dingdanok=0 and pay='$type' and timm>'$tim' ORDER BY id DESC");$id2=$result[$_SERVER[$_SERVER[��]][0x0000018]];if($id2>0){}else{}}if($id2<0){$id2=0;}$urlmzu=$dosql->$_SERVER[$_SERVER[��]]{0x05}("SELECT * FROM `#@__ewmszb` WHERE `appid`='{$key}' and `pay`='{$type}' and `zhanghao`='{$zhanghao}' and `name`='{$beizhu}' order by id asc");$cnyend=$urlmzu[$_SERVER[$_SERVER[��]]{0x02d}];if($cnyend>0){}else{echo $_SERVER[$_SERVER[��]][0x002e];die();}}else{echo $_SERVER[$_SERVER[��]]{0x0002f};die();}