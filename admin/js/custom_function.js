$(function(){
   
   $('.confirmMsg').click(function(){
      var r = confirm("Are you sure?");
      if (r == false) {
         return false;
      }
      
   });
   $('.datepicker-default').datepicker({
        format: "yyyy-mm-dd"
   });

    setTimeout(function () {
        $("#flashmessage").animate({opacity: 1.0}, 1000).fadeOut("900")
    }, 10000
    );
    $("#closemessage").click( function () { $(this).parent("div").fadeOut("slow"); });
    
    // For City location dropdown
    $('#catSelect').change(function() {
        var catId=$(this).val();
        var dataString= "catId="+catId;
        $(this).parent().after('<div class="loader" style="padding-top:50px;padding-left:75px;"><img src="'+_baseUrl+'images/loading12.gif" alt="loading subcategory" /></div>');
        $.ajax({
        url: _baseUrl+"consultant/get_subcategory",  
        type: 'POST',
        data: dataString,
        dataType : 'json',
        success: function(sc) {
            $('.loader').slideUp(200, function() {
                    $(this).remove();
            });
            var res = '';
            if (sc.length > 0 ) {
               
               var selectedArr = $('#selectSubCategory').attr('data-select');
               var resultArray = selectedArr.split(',').map(function(selectedArr){return selectedArr;});
               $.each(sc,function(index,value){
                  var selectVal = '';
                  if ($.inArray(value.id, resultArray) > -1){
                     selectVal = "selected";
                  }
                  res += '<option value="'+value.id+'" '+selectVal+'>'+value.subcat_name+'</option>';
               });
               
            }
            $('#selectSubCategory').html(res);
        }
       });
    });
    
   $('#catSelect').trigger("change");
   
   // For ajax call //
   /*
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
     $.ajax({ url: 'http://182.73.137.51/appvizr/admin/category/test',
           data: {action: 'test',_csrf : csrfToken},
           type: 'post',
           success: function(output) {
                        alert(output);
                    }
    });
    */
    
});


