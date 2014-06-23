$(document).ready(function() {

    var aurl = "/wp-content/themes/ashleyandnewey/assets/ajax/";

    $('body').addClass('ex_highlight_row');

    var rTable = $('#reservation-table').dataTable( {
        "sPaginationType": "full_numbers",
        'bScrollCollapse': false,
        'bPaginate': true,
        'bStateSave': false,
        "sDom": 'CT<"clear">lfrtip',
        "aaSorting": [[1, 'desc']],
        "oTableTools": {
            "sSwfPath": "/wp-content/themes/ashleyandnewey/assets/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.pdf",
                    'sTitle': 'A&N reservations'
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.xls"
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF (selected)",
                    "bSelectedOnly": "true",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.pdf",
                    'sTitle': 'A&N reservations'
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel (selected)",
                    "bSelectedOnly": "true",
                    "mColumns": [ 0, 1, 2, 3, 4 ],
                    "sFileName": "A&N_reservations.xls"
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF (visible)",
                    "bSelectedOnly": "true",
                    "mColumns": "visible",
                    "sFileName": "A&N_reservations.pdf",
                    'sTitle': 'A&N reservations'
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel (visible)",
                    "bSelectedOnly": "true",
                    "mColumns": "visible",
                    "sFileName": "A&N_reservations.xls"
                }
            ]
        }
    } );


/*
	$("#rTable .confirmation", rTable.fnGetNodes()).each(function(){
	    $(this).on("click", function(){
	        var thise = $(this);
	        var id = $(this).data('id');
	        var values = { id : id };
			$(thise).parent().html();
	
	        $.ajax({
	            type: "POST",
	            url:  aurl + "reserve-confirmation.php",
	            data: values,
	            cache: false,
	            success: function(){
	                $(thise).parent().html('');
	            }
	        });
	  
	        return false;
	    });
    });

*/

    $("body").on( "click", "#rTable .confirmation", function(){
        var thise = $(this);
        var id = $(this).data('id');
        var values = { id : id };
		$(thise).parent().html();

        $.ajax({
            type: "POST",
            url:  aurl + "reserve-confirmation.php",
            data: values,
            cache: false,
            success: function(){
                $(thise).parent().html('');
            }
        });
  
        return false;
    });

    $("body").on( "click", "#rTable .delete", function(){
        var thise = $(this);
        var id = $(this).data('id');
        var values = { id : id };
        $.ajax({
            type: "POST",
            url:  aurl + "reserve-delete.php",
            data: values,
            cache: false,
            success: function(){
                rTable.fnDeleteRow( $('tr[data-id="'+id+'"]')[0] );
            }
        });
        return false;
    });

    $("body").on( "click", "#rTable .change", function(){
        var dateid = $(this).data('dateid');
        var tourid = $(this).data('tourid');
        var seldiv = $('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"]').find(".selectdiv");
		if (seldiv.css("display") == "none") {
			$(".selectdiv").css("display", "none");
			seldiv.css("display", "inline");
		} else {
			$(".selectdiv").css("display", "none");
		}
	});


    $("body").on( "click", "#rTable button.unreserve", function(){
		$(".selectdiv").css("display", "none");
        var thise = $(this);
        var id = $(this).data('resid');
        var tourid = $(this).data('tourid');
        var dateid = $(this).data('dateid');
        var values = { id : id };
        if (id != 0) {
	        $.ajax({
	            type: "POST",
	            url:  aurl + "resas-unreserve.php",
	            data: values,
	            cache: false,
	            success: function(){
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] .reserver').html("");
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] .status').html("free");
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] button.unreserve').css("display", "none");
					$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] select.res_select').data("resid", 0);
	            }
	        });
        }
        return false;
    });

    $("#rTable").on("change", 'select.res_select', function() {
        var dateid = $(this).data("dateid");
        var tourid = $(this).data("tourid");
		var userid = $('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] select.res_select option').filter(":selected").data("id");
		if (userid != "no") {
	        var resid = $(this).data("resid");
	        var date = $(this).data("date");
//	        alert("dateid=" + dateid + " userid=" + userid +" tourid=" + tourid + " resid=" + resid);
	        var values = {
	            tourid: tourid, 
	            dateid: dateid,
	            resid: resid,
	            userid: userid,
	            date: date
	        };
	
	        var request = $.ajax({
	            type: "POST",
	            url: aurl + "resas-reserve.php",
	            data: values,
	            cache: false,
	            success: function(msg) {
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] .status').html("confirmed");
	            	reserver = $('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] select.res_select option').filter(":selected").html()
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] .reserver').html(reserver);
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] button.unreserve').css("display", "inline");
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] select.res_select').data("resid", msg);
	            	$('tr[data-dateid="'+dateid+'"][data-id="'+tourid+'"] button.unreserve').data("resid", msg);
	            }
	        });
		}
		$('tr[data-dateid="'+dateid+'"] .selectdiv').css("display", "none");		
    });


    var uTable = $('#useractivity-table').dataTable( {
        "sPaginationType": "full_numbers",
        'bScrollCollapse': false,
        'bPaginate': true,
        'bStateSave': false,
        "aaSorting": [[0, 'desc']]
    });

} );

function conf(message){
    var answer = confirm(message)
    if (answer){
        return false;
    }
    return false;
}