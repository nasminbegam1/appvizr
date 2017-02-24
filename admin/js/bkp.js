$(function() {
	$.validator.addMethod("emailExist",function (value, element)
	{
	    var returnVal 	= true;
	    $.ajax({
		async:false,
		type: 'post',
		data:{
			'_token'    		:   CSRF_TOKEN,
			'emailAddressR'     	:   value
		},
		url: BASE_URL + '/emailExist',
		beforeSend: function(){
		},
		success: function(data){
			if (parseInt(data) > 0 ) {
				returnVal = false;
			}
		}
	    });
	    return returnVal;
	},'Your email address is already exist');
	
	$("#programInterest").validate({
		// Specify the validation rules
		rules: {
		   from_year				: "required",
		   to_year				: "required",
		   contact_name				: "required",
		   contact_phone			: "required",
		   contact_email              		: {required:true,email :true,emailExist :true},
		   contact_fax				: "required",
		   science_teacher			: "required",
		   grade_level				: "required",
		   school_district			: "required",
		   school_name				: "required",
		   month_materials			: "required",
		   presentation				: "required",
		},
		
		// Specify the validation error messages
		messages: {
		    from_year		: "Please enter From Year",
		    to_year		: "Please enter To Year",
		    contact_name	: "Please enter contact name",
		    contact_phone	: "Please enter contact phone",
		    contact_email       : {required : "Please enter Email Address",
					   email :"Please enter valid email Address"},
		    contact_fax		: "Please enter contact fax",
		    science_teacher	: "Are you the Science Teacher?",
		    grade_level		: "Please select Grade Level",
		    school_district	: "Please enter school district",
		    school_name		: "Please enter school name",
		    month_materials	: "Select Month Materials Desired in School",
		    presentation	: "Would you like a Free Demo/Presentation - 45 min",
		},
		
		submitHandler: function(form) {
		    form.submit();
		}
	});
	
	$("#login_form").validate({
		// Specify the validation rules
		rules: {
		   email              		: {required:true,email :true},
		   password			: "required",
		},
		
		// Specify the validation error messages
		messages: {
		    email       : {required : "Please enter Email Address",
					   email :"Please enter valid email Address"},
		    password	: "Please enter password",
		},
		
		submitHandler: function(form) {
		    form.submit();
		}
	});
	
	$("#login_form").validate({
		// Specify the validation rules
		rules: {
		   email              		: {required:true,email :true},
		   password			: "required",
		},
		
		// Specify the validation error messages
		messages: {
		    email       : {required : "Please enter Email Address",
					   email :"Please enter valid email Address"},
		    password	: "Please enter password",
		},
		
		submitHandler: function(form) {
		    form.submit();
		}
	});
	
	$("#teacher-change-password").validate({
		// Specify the validation rules
		rules: {
		   password              	: "required",
		   confirm_password		: {equalTo: "#password",required : true},
		},
		
		// Specify the validation error messages
		messages: {
		    password		: "Please enter password",
		    confirm_password 	: {equalTo: "Please enter the same password again.",
					       required : "Please Re-enter Password"}
		},
		submitHandler: function(form) {
		    form.submit();
		}
	});
	$("#parent_login").validate({
		rules: {
		   teacher_code              	: "required"
		},
		messages: {
		    teacher_code		: "Please enter teacher code"
		},
		submitHandler: function(form) {
		    form.submit();
		}
	});
	
	$('.freeItemChange').change(function(){
		if (this.value != '') {
			$('.couponCodeShow').show();
		}else{
			$('.couponCodeShow').hide();
		}
	});
	$('.freeItemChange').trigger('change');
	
	$("#save_student").validate({
		rules: {
		   student_name              	: "required"
		},
		messages: {
		    student_name		: "Please enter Student Name"
		},
		submitHandler: function(form) {
		    form.submit();
		}
	});
	
});
