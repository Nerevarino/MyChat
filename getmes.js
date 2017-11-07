function getMessages()
{
  var serverOutput;
  var chatView=document.getElementById('chatview');
  
  var request=newAjax();
  request.open("GET", "get.php",true);
  request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  request.onreadystatechange=function()
  {
    if(this.readyState==4)
    {
      if(this.status==200)
      {
        serverOutput=this.responseText;
        chatView.innerHTML=serverOutput;
      }
      // else alert("Ошибка AJAX: " + this.statusText);
    }
    else
    {
      
    }
  }     
  request.send('');  
}
