function CheckSTOP(str,chk){
	var enable_s = document.all.enable.value;
	var page = document.all.page.value;
	if(chk=='Y'){
		if(confirm("是否确定启用该代理商?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='S'){
		if(confirm("是否确定暂停该代理商?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='N'){
		if(confirm("是否确定停用该代理商?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
}
function CheckDEL(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("是否确定删除该代理商?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}