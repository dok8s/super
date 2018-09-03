function SubChk()
{	
 if(document.all.super_agents_id.value=='')
 { document.all.super_agents_id.focus(); alert("总代理请务必输入!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("帐号请务必输入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("密码请务必输入!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("确认密码请务必输入!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("密码确认错误,请重新输入!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("代理商名称请务必输入!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }
 
  if(document.all.winloss_s.value=='')
 { document.all.winloss_s.focus(); alert("请选择总代理佔成数!!"); return false; }
  if(document.all.winloss_a.value=='')
 { document.all.winloss_a.focus(); alert("请选择代理商佔成数!!"); return false; } 
 var winloss_a,winloss_s;
 winloss_s=eval(document.all.winloss_s.value);
 winloss_a=eval(document.all.winloss_a.value); 
 //if ((winloss_s+winloss_a-100) < 20 )
 //{
 //  if (winloss_s==0 && winloss_a==100)
 //  {
//
 //  }else{
 //    alert("超过成数~~请重新选择");
 //    document.all.winloss_s.focus();
 //    return false;
 //  }
 //}
 //if ((winloss_s+winloss_a-100) > 50 )
 //{
 //  if (winloss_s==0 && winloss_a==100)
 //  {
//
 //  }else{
 //    alert("低于成数~~请重新选择");
 //    document.all.winloss_s.focus();
 //    return false;
 //  }
 //} 
 if ((document.all.old_sid.value!=document.all.super_agents_id.value) && document.all.keys.value=='upd')
 {alert("你已变更此代理商之总代理~~请重新设定其所属会员之详细设定!!")}
 if(!confirm("是否确定写入代理商?"))
 {
  return false;
 }
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}