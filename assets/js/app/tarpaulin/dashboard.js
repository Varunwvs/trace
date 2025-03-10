//Product active count
setTimeout(function(){
    $.post("TarpaulinController/prdCount",
      {get_count:true},
      function(result){
        $("#pcount").html(result);        
      }
    );
},1000);

//Product deleted count
setTimeout(function(){
  $.post("TarpaulinController/dprdCount",
    {get_count:true},
    function(result){
      $("#dpcount").html(result);
    }
  );
},1000);

//Batch active count
setTimeout(function(){
  $.post("TarpaulinController/bthCount",
    {get_count:true},
    function(result){
      $("#bcount").html(result);
    }
  );
},1000);

//Batch deleted count
setTimeout(function(){
  $.post("TarpaulinController/bthdCount",
    {get_count:true},
    function(result){
      $("#dbcount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("TarpaulinController/cthCount",
    {get_count:true},
    function(result){
      $("#ccount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("TarpaulinController/cthdCount",
    {get_count:true},
    function(result){
      $("#dccount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("TarpaulinController/totCount",
    {get_count:true},
    function(result){
      $("#tcount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("TarpaulinController/rtotCount",
    {get_count:true},
    function(result){
      $("#rcount").html(result);
    }
  );
},1000);


