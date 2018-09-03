<!--
function CheckSTOP(str,chk){
	var enable_s = document.all.enable.value;
	var page = document.all.page.value;
	if(chk=='Y'){
		if(confirm("是否确定启用该会员?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='S'){
		if(confirm("是否确定暂停该会员?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='N'){
		if(confirm("是否确定停用该会员?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
}
function CheckDEL(str)
{
 var agents = document.all.super_agents_id.value;
 var enable_s = document.getElementById('enable').value;
 var page = document.all.page.value;
 if(confirm("是否确定删除该会员?"))
  document.location=str+"&agents="+agents+"&active=3&enable="+enable_s+"&page="+page;
}
-->