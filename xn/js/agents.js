function CheckSTOP(str,chk){
	var enable_s = document.all.enable.value;
	var page = document.all.page.value;
	if(chk=='Y'){
		if(confirm("Bạn có chắc chắn muốn kích hoạt đại lý này không?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='S'){
		if(confirm("Bạn có chắc chắn tạm ngừng tác nhân không?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='N'){
		if(confirm("Bạn có chắc chắn muốn hủy kích hoạt đại lý không?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
}
function CheckDEL(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("Bạn có chắc chắn muốn xóa tác nhân không?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}