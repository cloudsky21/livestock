//jquery-ui autocomplete here
$(document).ready(function() {
    $("#group-name").autocomplete({
        source: '../bin/search_group.php',
        messages: {
            noResults: function(count) {
                console.log("There were no matches.")
            },
            results: function(count) {
                console.log("There were " + count + " matches")
            }
        }
    });

});

$(document).ready(function() {
    $("#assured-id").autocomplete({
        source: '../bin/search/search_f_id.php',
        messages: {
            noResults: function(count) {
                console.log("There were no matches.")
            },
            results: function(count) {
                console.log("There were " + count + " matches")
            }
        }
    });

});






$(document).ready(function() {
    $('#infoModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type: 'post',
            url: '../bin/details/details.php', //Here you will fetch records 
            data: 'rowid=' + rowid, //Pass $id
            success: function(data) {
                $('.fetched-data').html(data); //Show fetched data from database
            }
        });
    });
});

function address(val) {
    $('#town').empty();
    var dropselect = val;

    $.ajax({
        type: "POST",
        url: "selects.php",
        data: {
            'id': dropselect
        },
        success: function(data) {
            $("#townbrgy").html(data);
        }
    });
}
$(document).keypress(function(evt) {
    if (evt.keyCode == "96") {
        $('#myModal').modal('show');
        $('#group-name').focus();

    }

});
$(document).ready(function() {
    $('#editModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');

        $.ajax({
            type: 'post',
            url: '../bin/update/update.php', //Here you will fetch records 
            data: 'rowid=' + rowid, //Pass $id
            success: function(data) {
                $('.fetched-data').html(data); //Show fetched data from database
            }
        });
    });
});

$(document).ready(function() {
    $('#deleteModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');

        $.ajax({
            type: 'post',
            url: '../delete.php', //Here you will fetch records 
            data: 'rowid=' + rowid, //Pass $id
            success: function(data) {
                $('.fetched-data').html(data); //Show fetched data from database
            }
        });
    });
});
window.onload = function() {
    var input = document.getElementById("group-name").focus();
}


$(document).ready(function() {
    $("#animal-type").change(function() {
        var val = $("#animal-type option:selected").val();
        var gHeads = parseFloat($('#head-count').val());

        if (val == "Carabao-Draft" || val == "Carabao-Breeder" || val == "Carabao-Dairy" || val == "Carabao-Fattener") {
            $('#rate').val('5');
            if(!isNaN(gHeads)) {
                $('#cover').val(gHeads * 15000);	
            }
            else {
                alert('Head-count is not a number');	
            }
    
        }
        else if (val == "Cattle-Draft" || val == "Cattle-Breeder" || val == "Cattle-Dairy" || val == "Cattle-Fattener"){
            $('#rate').val('5');
            if(!isNaN(gHeads)) {
                $('#cover').val(gHeads * 15000);	
            }
            else {
                alert('Head-count is not a number');	
            }	
        }
        else if (val == "Horse-Draft" || val == "Horse-Breeder" || val == "Horse-Working"){	
            $('#rate').val('5');
            if(!isNaN(gHeads)) {
                $('#cover').val(gHeads * 15000);	
            }
            else {
                alert('Head-count is not a number');	
            }	
        }
        else if (val == "Swine-Breeder"){	
            $('#rate').val('3.5');
            if(!isNaN(gHeads)) {
                $('#cover').val(gHeads * 10000);	
            }
            else {
                alert('Head-count is not a number');	
            }	
        }
        else if (val == "Swine-Fattener"){	
            $('#rate').val('1.75');
            if(!isNaN(gHeads)) {
                $('#cover').val(gHeads * 7000);	
            }
            else {
                alert('Head-count is not a number');	
            }	
        }
        else if (val == "Goat-Fattener"){	
            $('#rate').val('6');           
        }
        else if (val == "Goat-Milking"){	
            $('#rate').val('6');
           
        }
        else if (val == "Goat-Breeder"){	
            $('#rate').val('6');
           
        }
        else if (val == "Sheep-Fattener"){	
            $('#rate').val('6');
            
        }
    else if (val == "Sheep-Breeder"){	
            $('#rate').val('6');
            
        }
        else if (val == "Poultry-Layers"){	
            $('#rate').val('2.6');            
    
        }
        else if (val == "Poultry-Pullets"){	
            $('#rate').val('2.6');	
        }
        else if (val == "Poultry-Broilers"){	
            $('#rate').val('1');    
        }
        else {
            $('#rate').val('0.00');	
        }

    });
});



$(document).ready(function() {
    $('.dropdown-toggle').dropdown()
});

$(document).ready(function() {
    $("#flash-msg").delay(3000).fadeOut("slow");
});

$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });
});
$(document).ready(function() {

    $('.ajax_link').popover({
        title: fetchData,
        html: true,
        placement: 'right'
    });

    function fetchData() {
        var fetch_data = '';
        var element = $(this);
        var id = element.attr("id");
        $.ajax({
            url: "ajax.php",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: function(data) {
                fetch_data = data;
            }
        });
        return fetch_data;
    }
});

$(document).on('show.bs.modal', '.modal', function() {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

function insertData() {
    var ids = $('#ids').val();
    var sn = $('#lname').val();
    var fn = $('#fname').val();
    var mn = $('#mname').val();
    var bd = $('#bday').val();
    var adr = $('#address').val();

    $.ajax({
        url: "insertfarmer.php",
        type: "POST",
        data: {
            'ids': ids,
            'snn': sn,
            'fnn': fn,
            'mnn': mn,
            'bdd': bd,
            'adres': adr
        },
        dataType: "JSON",
        success: function(sd) {
            console.log(sd);
        },
        error: function(err) {
            alert(err);
        }
    });



}


function typeAnimal(val) {
    $('#purpose').empty();

    if (val == "Carabao" || val == "Cattle") {

        var items = [

            {
                "value": 'Breeder',
                "text": 'Breeder'
            },
            {
                "value": 'Fattener',
                "text": 'Fattener'
            },
            {
                "value": 'Draft',
                "text": 'Draft'
            },
            {
                "value": 'Dairy',
                "text": 'Dairy'
            }

        ];


        $.each(items, function(i, item) {
            $('#purpose').append($('<option>', {
                value: item.value,
                text: item.text
            }));
        });




    } else if (val == "Horse") {

        var items = [


            {
                "value": 'Draft',
                "text": 'Draft'
            }

        ];


        $.each(items, function(i, item) {
            $('#purpose').append($('<option>', {
                value: item.value,
                text: item.text
            }));
        });


    } else if (val == "Goat" || val == "Sheep") {

        var items = [


            {
                "value": 'Breeder',
                "text": 'Breeder'
            },
            {
                "value": 'Fattener',
                "text": 'Fattener'
            },
            {
                "value": 'Dairy',
                "text": 'Dairy'
            }

        ];


        $.each(items, function(i, item) {
            $('#purpose').append($('<option>', {
                value: item.value,
                text: item.text
            }));
        });


    } else if (val == "Swine") {

        var items = [


            {
                "value": 'Breeder',
                "text": 'Breeder'
            },
            {
                "value": 'Fattener',
                "text": 'Fattener'
            }

        ];


        $.each(items, function(i, item) {
            $('#purpose').append($('<option>', {
                value: item.value,
                text: item.text
            }));
        });


    } else if (val == "Poultry") {

        var items = [


            {
                "value": 'Broilers',
                "text": 'Broilers'
            },
            {
                "value": 'Layers',
                "text": 'Layers'
            },
            {
                "value": 'Pullets',
                "text": 'Pullets'
            }

        ];


        $.each(items, function(i, item) {
            $('#purpose').append($('<option>', {
                value: item.value,
                text: item.text
            }));
        });


    }

}



function getaddress($x) {

    var i = $x;
    $('#town').empty();

    $.ajax({
        type: 'post',
        url: '../ajax_address.php',
        data: {
            id: i
        },
        /*$('#farmersform').serialize(), */
        success: function(data) {
            $('#town').html(data);
        }
    });


}




/*

	function find_ids(	){
		var xz = $("#pref").val() + $("#srch").val();
		$('#displaydata > tbody').empty();

		$.ajax({
			type: 'POST',
			url: '../search.php',
			data: 'ids='+ xz,
			success: function(e){
				$('#displaydata > tbody').html(e);

			},
			error: function(d){
				alert("ERROR: " + d);
			}
		});

	}

	*/