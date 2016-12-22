$(function(){

    var ul = $('#droptext ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),
	url: 'upimg.php'
        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {

            // Append the file name and file size
            //tpl.find('p').text(data.files[0].name)
            //             .append('<i>' + formatFileSize(data.files[0].size) + '</i>');
	ul.find('p').text(data.files[0].name)
	//alert(data.files[0].name);
		//document.getElementsByTagName('div')[2].style.backgroundImage = none;
            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        }

    });

    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

});