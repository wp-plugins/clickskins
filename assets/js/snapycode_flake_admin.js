// JavaScript Document

  jQuery(document).ready(function(){
        jQuery('#flake_color').wpColorPicker();
});

function spc_upload_image(obj) {



        var parent=jQuery(obj).parent().parent('div.spc_image_upload');

        var inputField = jQuery(parent).find("input.spc_image_url");

        var fileFrame = wp.media.frames.file_frame = wp.media({

            multiple: false

        });

        fileFrame.on('select', function() {

            var url = fileFrame.state().get('selection').first().toJSON();

            inputField.val(url.url);

            jQuery(parent)

            .find("div.spc_image_wrap")

            .html('<img src="'+url.url+'" height="100" width="100" />');

        });

        fileFrame.open();



}



function spc_remove_image(obj)

{

	 var parent=jQuery(obj).parent().parent('div.spc_image_upload');

	 var inputField = jQuery(parent).find("input.spc_image_url");

	 var imageHolder = jQuery(parent).find(".spc_image_wrap");

	 

	 inputField.val('');

	 imageHolder.html('');

	 

	 

}	





/*

* Function to show messages

*/

function show_message(msg, type)

{

	var msg_class = 'isa_error';

		

	switch(type)

	{

		case 'success':

			msg_class = 'isa_success';

		break;

		case 'error':

			msg_class = 'isa_error';

		break;			

		case 'info':

			msg_class = 'isa_info';

		break;				

		case 'warning':

			msg_class = 'isa_warning';

		break;

	}

	

	jQuery("#spc_notifications").html('<div class="'+msg_class+'">'+ msg +'</div>');

	jQuery(window).scrollTop(jQuery("#notify_scroll").offset().top);

}



/*

* randon charecter

*/

function randomCharGen(length)

{

	var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";

	//var string_length = 8;

	var string_length = length;

	var randomstring = '';

	var charCount = 0;

	var numCount = 0;



	for (var i=0; i<string_length; i++) {

		// If random bit is 0, there are less than 3 digits already saved, and there are not already 5 characters saved, generate a numeric value. 

		if((Math.floor(Math.random() * 2) == 0) && numCount < 3 || charCount >= 5) {

			var rnum = Math.floor(Math.random() * 10);

			randomstring += rnum;

			numCount += 1;

		} else {

			// If any of the above criteria fail, go ahead and generate an alpha character from the chars string

			var rnum = Math.floor(Math.random() * chars.length);

			randomstring += chars.substring(rnum,rnum+1);

			charCount += 1;

		}

	}



	return randomstring;	

}



/*

* Function to validate date Y-m-d

*/

function validateDate(date) { 

    var re = /^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;

    return re.test(date);

} 

/*

* Function to validate email

*/

function validateEmail(email) { 

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(email);

} 



