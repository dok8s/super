function CheckKey()
{
if(event.keyCode == 45) return true;
 if(event.keyCode < 48 || event.keyCode > 57 )
  return false;
}