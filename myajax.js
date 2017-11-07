function newAjax()
{
  var request;
  try
  {
    request=new XMLHttpRequest();
  }
  catch(e1)
  {
    try
    {
      request=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e2)
    {
      try
      {
        request=new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e3)
      {
        request=false;
      }
    }
  }
  return request;
}



function onSend()
{
  var messageBox=document.getElementById("messageBox");
  var messageText=messageBox.value;  
  
  var request=newAjax();
  request.open("POST", "post.php",true);
  request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  request.onreadystatechange=function()
  {
    if(this.readyState==4)
    {
      if(this.status==200)
      {
        alert("Ответ сервера: " + this.responseText);
      }
      else alert("Ошибка AJAX: " + this.statusText);
    }
    else
    {
      
    }
  }     

  var params='phrase=' + messageText;
  request.send(params);
  messageBox.value="";
}




