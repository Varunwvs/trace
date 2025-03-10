//Product active count
setTimeout(function(){
    $.post("FertilizerController/prdCount",
      {get_count:true},
      function(result){
        $("#pcount").html(result);        
      }
    );
},1000);

//Product deleted count
setTimeout(function(){
  $.post("FertilizerController/dprdCount",
    {get_count:true},
    function(result){
      $("#dpcount").html(result);
    }
  );
},1000);

//Batch active count
setTimeout(function(){
  $.post("FertilizerController/bthCount",
    {get_count:true},
    function(result){
      $("#bcount").html(result);
    }
  );
},1000);

//Batch deleted count
setTimeout(function(){
  $.post("FertilizerController/bthdCount",
    {get_count:true},
    function(result){
      $("#dbcount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("FertilizerController/cthCount",
    {get_count:true},
    function(result){
      $("#ccount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("FertilizerController/cthdCount",
    {get_count:true},
    function(result){
      $("#dccount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("FertilizerController/totCount",
    {get_count:true},
    function(result){
      $("#tcount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("FertilizerController/rtotCount",
    {get_count:true},
    function(result){
      $("#rcount").html(result);
    }
  );
},1000);


