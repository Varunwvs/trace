//Product active count
setTimeout(function(){
    $.post("MicroirrigationController/prdCount",
      {get_count:true},
      function(result){
        $("#pcount").html(result);        
      }
    );
},1000);

//Product deleted count
setTimeout(function(){
  $.post("MicroirrigationController/dprdCount",
    {get_count:true},
    function(result){
      $("#dpcount").html(result);
    }
  );
},1000);

//Batch active count
setTimeout(function(){
  $.post("MicroirrigationController/bthCount",
    {get_count:true},
    function(result){
      $("#bcount").html(result);
    }
  );
},1000);

//Batch deleted count
setTimeout(function(){
  $.post("MicroirrigationController/bthdCount",
    {get_count:true},
    function(result){
      $("#dbcount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("MicroirrigationController/cthCount",
    {get_count:true},
    function(result){
      $("#ccount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("MicroirrigationController/cthdCount",
    {get_count:true},
    function(result){
      $("#dccount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("MicroirrigationController/totCount",
    {get_count:true},
    function(result){
      $("#tcount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("MicroirrigationController/rtotCount",
    {get_count:true},
    function(result){
      $("#rcount").html(result);
    }
  );
},1000);

setTimeout(function(){
  $.post("MicroirrigationController/asCount",
    {get_count:true},
    function(result){
      $("#ascount").html(result);
    }
  );
},1000);


