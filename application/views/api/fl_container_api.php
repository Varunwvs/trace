<h1>test</h1>

 <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
// setTimeout(
//     function(){
//     window.location.reload(1);
$(document).ready(function(){
  sendRequest();
  function sendRequest(){
      $.ajax({
        url: "FLCronController/process_batch_containers",
        success: 
          function(data){
          //$('#listposts').html(data); //insert text of test.php into your div
           
        },
        complete: function() {
      // Schedule the next request when the current one's complete
      //alert('Hi');
      setInterval(sendRequest, 10000); // The interval set to 5 seconds
     }
    });
  };
});

    
   //},10000);
</script>  