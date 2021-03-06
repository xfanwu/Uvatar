/**
 * Created by wuxxf on 29/03/15.
 *
 * Version 0.1
 *
 * API for Uvatar
 *
 * Usage:
 * ======
 *
 * Required: jQuery, jQuery md5 plugin
 *
 * Warning: https not support yet
 *
 * 1. You should define the host server name which your Uvatar running on.
 *    example: 'localhost'
 *
 * 2. You need a hash email address with md5.
 *
 * 3. You can define the format or size of your image
 *
 * 4. Put this script in your web page ( Don't forget the jQuery )
 *
 * 5.1 Add your hash in src attribute of img tag
 *
 * 5.2 Add '.uvatar-image' class in the img tag
 *    Ex. <img src="john.smith@oula.com" class="uvatar-image" />
 *
 */

// set your server name
var host = 'localhost:8000';


// (optional) Set image format (jpg by default)
// Support formats: jpg, png, bmp

// (optional) Set image size (250 x 250px by default)

$(document).ready(function () {

    var ext = 'jpg';

    var size = 200;

    $('.uvatar-image').each(function () {
        var hash = $(this).attr('src');
        var image = 'http://' + host + '/image/' + hash + '/' + size + '/' + ext;
        $(this).attr('src', image);
    });

    $('.uvatar-image-by-email').each(function () {
        var email = $(this).attr('src');
        var image = 'http://' + host + '/image/' + 'email/' + email + '/' + size + '/' + ext;
        $(this).attr('src', image);
    });

    $('#btn-email').click(function () {
        $('input[name="email-format"]').each(function () {
            if(($(this).prop('checked'))) {
                ext = $(this).val();
            }
        });

        size = $('#email-size').val();
        var email = $('#email').val();
        var result = 'http://' + host + '/image/' + 'email/' + email + '/' + size + '/' + ext;
        $('#result-p').html(result);
        $('#result-img').attr('src', result)
    });

    $('#btn-md5').click(function () {
        $('input[name="md5-format"]').each(function () {
            if(($(this).prop('checked'))) {
                ext = $(this).val();
            }
        });

        size = $('#email-size').val();
        var md5 = $('#md5').val();
        var result = 'http://' + host + '/image/'  + md5 + '/' + size + '/' + ext;
        $('#result-p').html(result);
    });
});


