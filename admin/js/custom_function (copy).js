function statusModifier(type,element){
		var id=$(element).attr('data-team');
		$("#loader_"+id).css("visibility","visible");
		var url ='';
		switch (type) {
				
						
                               case "game":					url = BASE_URL+"/games/set-status";
                                                break;
                                case "math":					url = BASE_URL+"/maths/set-status";
                                                break;
                                
                                case "free-item":				url = BASE_URL+"/free-item/set-status";
                                                break;
		}
		
		
		$(element).find('i').removeClass('fa fa-check-square-o');
		$(element).find('i').removeClass('glyphicon glyphicon-remove-sign');
		$(element).find('i').addClass('fa fa-spinner');
		$.ajax({
				url:url,
				type:"POST",
				data:{"id":id,_token: CSRF_TOKEN},
				success:function(msg){
						//alert($(this).prop('data-status'));
						if ($(element).hasClass("btn-success")==true) {
								$(element).addClass("btn-primary");
								$(element).removeClass("btn-success");
								$(element).attr('title','Inactive');
								$(element).find('i').removeClass('fa fa-spinner');
								$(element).find('i').addClass('glyphicon glyphicon-remove-sign');
                                                                $('.status-'+id).html('<a href="javascript:" class="btn btn-default btn-xs btn-primary"><i class="fa"></i>Inactive</a>');
						}
						else if ($(element).hasClass("btn-primary")==true) {
								$(element).addClass("btn-success");
								$(element).removeClass("btn-primary");
								$(element).find('i').removeClass('fa fa-spinner');
								$(element).find('i').addClass('fa fa-check-square-o');
								$(element).attr('title','Active');
                                                                $('.status-'+id).html('<a href="javascript:" class="btn btn-default btn-xs btn-success"><i class="fa"></i>Active</a>');
						}
						$("#loader_"+id).css("visibility","hidden");
				}
		});
}


function serviceStatusModifier(type,element){
		var id=$(element).attr('data-team'); 
		$("#loader_"+id).css("visibility","visible");
		var url ='';
		$(element).find('i').removeClass('fa fa-check-square-o');
		$(element).find('i').removeClass('glyphicon glyphicon-remove-sign');
		$(element).find('i').addClass('fa fa-spinner');
		
		switch(type){
				case 'car_wash':		url= BASE_URL+"/service/carwash/set_service_status";
														break;
				case 'car_repair':	        url= BASE_URL+"/service/carrepair/set_service_status";
														break;
				case 'in_home':			url= BASE_URL+"/service/inhome/set_service_status";
														break;
                case "set_price": 	        url = BASE_URL+"/services/set_price/set-status";
                        break;
		}
		
		
		//url = BASE_URL+"/service/carwash/set_service_status";
		$.ajax({
				url: url,
				type:"POST",
				data:{"id":id,_token: CSRF_TOKEN},
				success:function(msg){
						if ($(element).hasClass("btn-success")==true) { 
								$(element).addClass("btn-primary");
								$(element).removeClass("btn-success");
								$(element).attr('title','Done');
								$(element).find('i').removeClass('fa fa-spinner');
								$(element).find('i').addClass('glyphicon glyphicon-remove-sign');
                                                                
                                                                
                                                                $(element).parent().prev('td').find('.service-status').removeClass('label-success');
                                                                $(element).parent().prev('td').find('.service-status').addClass('label-danger');
                                                                $(element).parent().prev('td').find('.service-status').text('Pending');
                                                                
								
						}
						else if ($(element).hasClass("btn-primary")==true) { 
								$(element).addClass("btn-success");
								$(element).removeClass("btn-primary");
								$(element).find('i').removeClass('fa fa-spinner');
								$(element).find('i').addClass('fa fa-check-square-o');
								$(element).attr('title','Pending');
                                                                
                                                                $(element).parent().prev('td').find('.service-status').removeClass('label-danger');
                                                                $(element).parent().prev('td').find('.service-status').addClass('label-success');
                                                                $(element).parent().prev('td').find('.service-status').text('Done');
								
						}
						$("#loader_"+id).css("visibility","hidden");
				}
		});

		
}

$(function(){
                $('.services').change(function(){
                        var service_id = $(this).val();
                        $.ajax({
                                    type:'POST',
                                    url: BASE_URL+'/get-services',
                                    dataType : 'json',
                                    data:"_token="+CSRF_TOKEN+"&service_id="+service_id,
                                    beforeSend: function() {},
                                    success:function(response){
                                                var sub_service_id = 0;
                                                if ($('.sub_service').is('[data-element]')) {
                                                      sub_service_id = $('.sub_service').attr('data-element');
                                                }
                                                var res = '';
                                                $.each(response.services, function( index, value ) {
                                                                var selecte = '';
                                                                if (sub_service_id == index) {
                                                                                selecte = 'selected';
                                                                }
                                                                res += '<option value="'+index+'" '+selecte+'>'+value+'</option>'
                                                });
                                                $('.sub_service').html(res);
                                    }
                        });
                    });
                    $('.makes').change(function(){
                        var make_id = $(this).val();
                        $.ajax({
                                    type:'POST',
                                    url: BASE_URL+'/get-model',
                                    dataType : 'json',
                                    data:"_token="+CSRF_TOKEN+"&make_id="+make_id,
                                    beforeSend: function() {},
                                    success:function(response){
                                                var model_id = 0;
                                                if ($('.get_model').is('[data-element]')) {
                                                      model_id = $('.get_model').attr('data-element');
                                                }
                                                var res = '<option value="">Select model</option>';
                                                $.each(response.services, function( index, value ) {
                                                                var select = '';
                                                                if (model_id == index) {
                                                                                select = 'selected';
                                                                }
                                                                res += '<option value="'+index+'" '+select+'>'+value+'</option>'
                                                });
                                                $('.get_model').html(res);
                                    }
                        });
                    });
                    $('.makes').trigger('change');
                if ($('.sub_service').is('[data-element]')) {
                $( ".services" ).trigger( "change" );
                }
                if ($('.get_model').is('[data-element]')) {
                $( ".makes" ).trigger( "change" );
                }
});