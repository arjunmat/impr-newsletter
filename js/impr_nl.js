jQuery(document).ready(function ($) {
	$('.impr_newsletter .impr_nl_btn').click(function () {
		var elem = $(this).closest('.impr_newsletter');
		elem.find('.impr_error').hide();
		var email = elem.find('.impr_nl_input').val();
		
		var emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		if(email == '')
		{
			elem.find('.impr_error').html('Please enter an email to register.');
			elem.find('.impr_error').show();
			return false;
		}
		else if(!emailPattern.test(email))
		{
			elem.find('.impr_error').html('Please enter a valid email address to register.');
			elem.find('.impr_error').show();
			return false;
		}
		
		var data = {
			'action': 'impr_nl_signup'
			,'email': email
		};

		$.ajax({
			url: impr_nl_ajaxurl
			,data: data
			,type: 'POST'
			,dataType: 'json'
			,success: function (resp) {
				if(resp == 'success')
				{
					elem.find('.impr_nl_input').val('');
					elem.find('.impr_error').html('Thank you for subscribing to our newsletter.<br> We won\'t spam you, we promise.');
					elem.find('.impr_error').show();
					elem.find('.impr_error').fadeOut(10000);
				}
				else
				{
					elem.find('.impr_error').html('Sorry. An error occurred. Please try again.');
					elem.find('.impr_error').show();
					elem.find('.impr_error').fadeOut(10000);
				}
			}
		});
	});
});