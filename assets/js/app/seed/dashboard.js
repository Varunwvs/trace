//Product active count
setTimeout(function(){
    $.post("SeedController/prdCount",
      {get_count:true},
      function(result){
        $("#pcount").html(result);        
      }
    );
},1000);

//Product deleted count
setTimeout(function(){
  $.post("SeedController/dprdCount",
    {get_count:true},
    function(result){
      $("#dpcount").html(result);
    }
  );
},1000);

//Batch active count
setTimeout(function(){
  $.post("SeedController/bthCount",
    {get_count:true},
    function(result){
      $("#bcount").html(result);
    }
  );
},1000);

//Batch deleted count
setTimeout(function(){
  $.post("SeedController/bthdCount",
    {get_count:true},
    function(result){
      $("#dbcount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("SeedController/cthCount",
    {get_count:true},
    function(result){
      $("#ccount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("SeedController/cthdCount",
    {get_count:true},
    function(result){
      $("#dccount").html(result);
    }
  );
},1000);

//Container active count
setTimeout(function(){
  $.post("SeedController/totCount",
    {get_count:true},
    function(result){
      $("#tcount").html(result);
    }
  );
},1000);

//Container deleted count
setTimeout(function(){
  $.post("SeedController/rtotCount",
    {get_count:true},
    function(result){
      $("#rcount").html(result);
    }
  );
},1000);


