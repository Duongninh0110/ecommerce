/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

// change price according to size

$(document).ready(function(){


	$("#selSize").change(function(){

		var idSize = $(this).val();
		if(idSize == ""){
			return false;
		}
		$.ajax({
			type:'get',
			url:'/get-product-price',
			data:{idSize:idSize},
			success: function(resp){

				var arr = resp.split('#');
				// alert(resp);
				$("#getPrice").html("$"+arr[0]);
				$("#price").val(arr[0]);
				if(arr[1]==0){
					$("#cartButton").hide();
					$("#Availability").text("Out of Stock");
				}else{
					$("#cartButton").show();
					$("#Availability").text("In Stock");
				}	
			}, error: function(){
				alert("Error");
			} 
		});		
	});

});

//Replace Image with alterlative image
$(document).ready(function(){

	$(".changeImage").click(function(){
		var image = $(this).attr('src');
		$(".mainImage").attr("src",image);

	// $(".changeImage").click(function(){
	// 	var image = $(this).attr('src');
	// 	$("#mainImage").attr("src",image);
	});

});



$(document).ready(function () {

    $("#registerForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                accept: "[a-zA-Z]+"
            },
            email: {
                required: true,
                email:true,
                remote: "/check-email" 
            },
            password: {
                required: true,
                minlength: 6  
            }
        },
        messages: {
            name: {
                required: "this field is required",
                minlength: "Name must have at least 2 letter",
                accept:"Name must contain letters only"
            },
            email: {
                required: "Email is required",
                email:"Please enter valid email",
                remote:"The email already exist"
            },
            password: {
                required: "Enter password",
                minlength: "Name should be at least 6 characters long" 
            }
        },
        // submitHandler: function (form) { // for demo
        //     alert('valid form');  // for demo
        //     return false;  // for demo
        // }
    });

    //Password Strength script

    $('#myPassword').passtrength({
        minChars: 4,
        passwordToggle: true,
        tooltip: true,
        eyeImg:"/images/frontend_images/eye.svg"
  	});

  	$("#loginForm").validate({
        rules: {
            
            email: {
                required: true,
                email:true
                 
            },
            password: {
                required: true
                
            }
        },
        messages: {
           
            email: {
                required: "Email is required",
                email:"Please enter valid email",
                remote:"The email already exist"
            },
            password: {
                required: "Please provide your password",
                
            }
        },
        // submitHandler: function (form) { // for demo
        //     alert('valid form');  // for demo
        //     return false;  // for demo
        // }
    });

    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                accept: "[a-zA-Z]+"
            },
            address: {
                required: true,
                minlength: 4,
                 
            },
            city: {
                required: true,
                minlength: 4,
            },
            state: {
                required: true,
                minlength: 4, 
            },
            country: {
                required: true,
                
            },
            pincode: {
                required: true,
                minlength: 4,
            },
            mobile: {
                required: true,
                minlength: 4,
            },

        },
        messages: {
            name: {
                required: "this field is required",
                minlength: "Name must have at least 2 letter",
                accept:"Name must contain letters only"
            },
            address: {
                required: "Address is required",
                minlength: "Name must have at least 4 letter",
            },
            city: {
                required: "City is required",
                minlength: "Name must have at least 4 letter",
            },
            state: {
                required: "State is required",
                minlength: "Name must have at least 4 letter",
            },
            country: {
                required: "Country is required",
                
            },
            pincode: {
                required: "Pincode is required",
                minlength: "Name must have at least 4 letter",
            },
            mobile: {
                required: "Mobile is required",
                minlength: "Name must have at least 4 letter",
            },
        },
        // submitHandler: function (form) { // for demo
        //     alert('valid form');  // for demo
        //     return false;  // for demo
        // }
    });

    

    $("#current_pwd").keyup (function(){

        var current_pwd = $("#current_pwd").val();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url:'check-user-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                // alert(resp);
                if(resp=="false"){
                    $("#chkPwd").html("<font color:'red'> Current Password is Incorrect</font>");

                }else if(resp=="true"){
                    $("#chkPwd").html("<font color:'green'> Current Password is Correct</font>");

                }
            }, error:function(){
                alert("Error");
            }
        });

    });
    $("#passwordForm").validate({
        rules:{
            current_pwd:{
                required: true,
                minlength:6,
                maxlength:20
            },

            new_pwd:{
                required: true,
                minlength:6,
                maxlength:20
            },

            confirm_pwd:{
                required:true,
                minlength:6,
                maxlength:20,
                equalTo:"#new_pwd"
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });


});





