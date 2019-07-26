$(document).ready(function(){
		
		$( "#group-name" ).autocomplete({
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
	$(document).ready(function(){
		$('#infoModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');

			$.ajax({
				type : 'post',
				url : '../bin/details/detailsapcp.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
		});
	});
	$(document).ready(function(){
		$('#editModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');

			$.ajax({
				type : 'post',
				url : '../bin/update/updateapcp.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
		});
	});
	$(document).ready(function(){	 
		$('#deleteModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');

			$.ajax({
				type : 'post',
				url : '../bin/deleteapcp.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
		});
	});


	$(document).ready(function() {

		$("#hide").click(function(){
			$("#tbup").hide();
			$("#wrap-tbl").style.marginTop = "0";
		});
		$("#show").click(function(){
			$("#tbup").show();
			$("#wrap-tbl").style.marginTop = "430px";

		});
	});



	function getch($val){
		if ($val == "Carabao-Draft" || $val == "Carabao-Breeder" || $val == "Carabao-Dairy" || $val == "Carabao-Fattener") {
			$('#rate').val('6.75');
		}
		else if ($val == "Cattle-Draft" || $val == "Cattle-Breeder" || $val == "Catte-Dairy" || $val == "Catte-Fattener"){
			$('#rate').val('6.75');	
		}
		else if ($val == "Horse-Draft" || $val == "Horse-Breeder" || $val == "Horse-Working"){	
			$('#rate').val('6.75');	
		}
		else if ($val == "Swine-Breeder"){	
			$('#rate').val('7');	
		}
		else if ($val == "Swine-Fattener"){	
			$('#rate').val('4');	
		}
		else if ($val == "Goat-Fattener"){	
			$('#rate').val('10');	
		}
		else if ($val == "Goat-Breeder"){	
			$('#rate').val('10');	
		}
		else if ($val == "Sheep-Fattener"){	
			$('#rate').val('10');	
		}
		else if ($val == "Sheep-Breeder"){	
			$('#rate').val('10');	
		}
		else if ($val == "Poultry-Layers"){	
			$('#rate').val('2.54');	
		}
		else if ($val == "Poultry-Pullets"){	
			$('#rate').val('2.54');	
		}
		else {
			$('#rate').val('0.00');	
		}
	}

	function find_ids($val){
		var xz = $('#srch').val();

		$('#displaydata > tbody').empty();

		$.ajax({
			type: 'POST',
			url: '../searchapcp.php',
			data: 'ids='+ xz,
			success: function(e){
				$('#displaydata > tbody').html(e);
			}
		});

	}
	$(document).keypress(function(evt){
		if (evt.keyCode=="96"){
			$('#myModal').modal('show');
			$('#group-name').focus();

		}

	});


	$(document).on('show.bs.modal', '.modal', function () {
		var zIndex = 1040 + (10 * $('.modal:visible').length);
		$(this).css('z-index', zIndex);
		setTimeout(function() {
			$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
		}, 0);
	});	

	function getaddress($x){
		var i = $x;
		$('#town').empty();

		$.ajax({
			type : 'post',
			url : '../ajax_address.php', 
			data :  { id:i }, /*$('#farmersform').serialize(), */
			success : function(data){
				$('#town').html(data);

			}
		});


	}

	$(document).ready(function() {
		$('#prem_loading').multiselect({
			nonSelectedText: 'Additional Premium Loading',
			enableFiltering: true,
			includeSelectAllOption: true,
			maxHeight: 400,
			dropUp: true	
		});
	});