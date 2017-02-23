<div class="row" style="margin-left:0px;" id="newdatadiv">
 <div class="span12 cpydata">
   <div class="span4">
          <div class="control-group" >
            <label class="control-label">Invoice No.</label>
            <div class="controls" id="ins_list_place" style="margin-left: 0px;">

            </div>
        </div>
    </div>
    <div class="span4">  
       <div class="control-group">
        <label class="control-label" >Name</label>
        <div class="controls" id="ledger_name_place" style="margin-left: 166px;">
        </div>
    </div>  
</div>
<div class="span4">
    <div class="control-group">
        <label class="control-label span3" style="text-align: left;">Amount</label>
        <div class="controls span6">
            <input type="text" style="width: 90%;margin-left:-20px;" name="amount" id="amnt_place" autocomplete="off"  class="m-wrap" onKeyUp="allLetter(this.value,this.id);"/>
        </div>
        <div class="controls span2"> 
            <label>
                <img src="assets/images/plus.png"  class="ad" id="add1"> &nbsp;
                <img src="assets/images/cross.png" class="rd" id="delete1">
            </label>

         </div>
    </div><input type="hidden" value="1" id="count" name="count" class="count" />       
</div>  
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
 $(".ad").click(function() {
  var adv = $('#count').val();
  var counts= parseInt(adv)+1;

    $.ajax({
            type:"post",
            url:"cpyajx.php",
            data:"",
      }).done(function(response) {

         $("#vit").append(""+response+"");
         $('#count').val(counts);
         }); 

   });
});
</script>
<script type="text/javascript">
$('#newdatadiv').load(function(){
    alert();
     var ledger_type=document.getElementById("ledger_type").value;      
             var query="?ledger_type=" + ledger_type;
             xobj.open("GET","ajax_page.php" +query,true);
             if(xobj.readyState==4 && xobj.status==200)
               {
               document.getElementById("ledger_name_place").innerHTML=xobj.responseText; 
                load_data();
               }
              
   });
</script>
