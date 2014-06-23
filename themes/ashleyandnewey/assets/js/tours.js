jQuery(document).ready(function() {

    jQuery('#acf-dates .acf-button').click(function(){
        var password = jQuery.password(25,false);
        setTimeout( function() {
            if (jQuery('#acf-dates .repeater table tbody .row:last .sub_field:last input').val()==""){
                jQuery('#acf-dates .repeater table tbody .row:last .sub_field:last input').delay().val(password);
            }
        }, 100);
//        alert(jQuery('#acf-dates .repeater table tbody .row:last input:nth-last-child(1)').delay().val("2"));
    });
    jQuery(document).on('click', '#acf-dates .add-row-before', function(){
        var password = jQuery.password(25,false);
        tttthis = jQuery(this);
        setTimeout( function() {
            if (jQuery(tttthis).parent().parent().prev("tr").children(".sub_field").last().children("div").children("input").val()==""){
                jQuery(tttthis).parent().parent().prev("tr").children(".sub_field").last().children("div").children("input").val(password);
//                alert(jQuery(tttthis).parent().parent().prev("tr").children(".sub_field").last().children("div").children("input").val());
            }
//            alert(jQuery(tttthis).parent().parent().prev("tr").children(".sub_field").last().children("div").children("input").val());
        }, 100);
//        alert(jQuery('#acf-dates .repeater table tbody .row:last input:nth-last-child(1)').delay().val("2"));
    });
});

jQuery.extend({
    password: function (length, special) {
        var iteration = 0;
        var password = "";
        var randomNumber;
        if(special == undefined){
            var special = false;
        }
        while(iteration < length){
            randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
            if(!special){
                if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
                if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
                if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
                if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
            }
            iteration++;
            password += String.fromCharCode(randomNumber);
        }
        return password;
    }
});