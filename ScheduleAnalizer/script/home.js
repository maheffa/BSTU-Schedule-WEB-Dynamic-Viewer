/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//function updateFaculty() {
//	req = new XMLHttpRequest();
//	req.onreadystatechange = function() {
//		if (req.readyState === 4 && req.status === 200) {
//			document.getElementById('sel_2').innerHTML = req.responseText;
//		}
//	};
//	req.open(GET, 'schedule.php?req=faculty');
//}

$(document).ready(function(){
	
	function fix_td_color() {
		$('tr.scd_para td').each(function(i){
			if ($(this).find(":visible").length > 0 || i%7 === 0) {
				$(this).css('background-color','white');
				$(this).css('color','black');
			} else {
				$(this).css('background-color','#333333');
				$(this).css('color','white');
			}	
			$(this).css('width','14.2%');
		});
		$('tr.scd_para td').on({
			mouseenter: function () {
				//				alert('Entering');
				if($(this).find('div:visible').length > 0) {
					//					var t = 'vao' + $(this).children(':visible').length;
					//					$(this).children().each(function(){
					//						t + ', ' + $(this).text();
					//					});
					//					alert('holla! '+t);
					//					$(this).children().each(function(i) {
					//						if (i === 0) $(this).hide();
					//						else $(this).show();
					//					});
					$(this).find('div:visible p:not(:first-child)').show();
					$(this).find('div:visible p:first-child').hide();
				}
			},
			mouseleave: function () {
				//				alert('Leave');
				//				if($(this).children(':visible').length > 0) {
				//					alert('leaving');
				//				}
				if($(this).find('div:visible').length > 0) {
					//					$(this).children().each(function(i){
					//					if (i === o) $(this).show();
					//					else $(this).hide();
					//					});
					$(this).find('div:visible p:not(:first-child)').hide();
					$(this).find('div:visible p:first-child').show();
				}
			}
		});
		$('tr.scd_para td').find('div:visible p:not(:first-child)').hide();
		$('tr.scd_para td').find('div:visible p:first-child').show();	
		
	}
	
	
	$('.znam').hide();
	$('.scd_para td div p:not(:first-child)').hide();
	//	$('.chisl').hide();
	//	
	//	$("#sub_get_scd").on('click',function(){
	//		$('input[name="type"]').val($('#sel_1').val());
	//		$('input[name="faculty"]').val($('#sel_2').val());
	//		$('input[name="year"]').val($('#sel_3').val());
	//		$('input[name="group"]').val($('#sel_4').val());
	//		$(this).submit();
	//	});
	
	$('#scd_type input').on('change', function(){
		var type_scd = $('input[name="scd_type"]:checked', '#scd_type').val();
		if (type_scd === "0") {
			//			$('.chisl:hidden').slideDown("slow");
			//			$('.znam:visible').slideUp("slow");
			$('.chisl:hidden').show();
			$('.znam:visible').hide();
		}
		else {
			//			$('.chisl:visible').slideDown("slow");
			//			$('.znam:hidden').slideUp("slow");
			$('.chisl:visible').hide();
			$('.znam:hidden').show();
			
		}
		fix_td_color();
	});
	
	$.get('schedule.php', {req: 'faculty'}, function (data, status) {
		//		alert('loaded');
		if (status !== "success") {
			alert("STATUS RETURN: "+status);
		} else {
			//			alert(data);
			$('#sel_2').html(data);
			$('#sel_3').html('');
			$('#sel_4').html('');
		}
		//		$('#sub_get_scd').attr('disabled', true);
	});
	
	
	$('#sel_1').change(function () {
		$('#sel_2').val('');
		$('#sel_3').html('');
		$('#sel_4').html('');
		$('#sel_5').html('');
	});
	
	$('#sel_2').change(function () {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {req: 'year'}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					$('#sel_3').html(data);
					$('#sel_4').html('');
				}
			});	
		}
		//		$('#sub_get_scd').attr('disabled', true);
	});
	
	$('#sel_3').change(function () {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', 
			{
				req: 'group', 
				faculty: $('#sel_2').find(':selected').val(),
				year: $('#sel_3').find(':selected').val()}, 
			function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					$('#sel_4').html(data);
				}
			});	
		}
		//		$('#sub_get_scd').attr('disabled', true);
	});
	
	$('#sel_4').change(function () {
		//		if($('#sel_1').children(':selected').val() === 1) {
		//			if ($(this).find(':selected').text().trim().length > 0) {
		//				$('#sub_get_scd').removeAttr('disabled');
		//			} else {
		//				$('#sub_get_scd').attr('disabled', true);
		//			}
		//		}
		//		else {
		if ($(this).find(':selected').text().trim().length > 0) {
			//				alert('sending: proflist'+$('#sel_4').find(':selected').text());
			$.get('schedule.php',
			{
				req: 'proflist', 
				group: $('#sel_4').find(':selected').val()}, 
			function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					$('#sel_5').html(data);
				}
			});	
			//			}
			//			$('#sub_get_scd').attr('disabled', true);
		}
	});
	
	//	$('#sel_5').change(function () {
	//		if ($(this).find(':selected').text().trim().length > 0) {
	//			$('#sub_get_scd').removeAttr('disabled');
	//		} else {
	//			$('#sub_get_scd').attr('disabled', true);
	//		}
	//	});
	
	$('#sub_get_scd').on('click', function (e) {
		$.get('schedule.php', 
		{
			req: 'schedule', 
			type: $('#sel_1').find(':selected').val(),
			profname: $('#sel_5').find(':selected').val(),
			group: $('#sel_4').find(':selected').val()}, 
		function (data, status) {
			if (status !== "success") {
				alert("STATUS RETURN: "+status);
			} else {
				$('#schedule_tbl').html(data);
				$('.znam').hide();
			}
			fix_td_color();
		});		
	});
	
	fix_td_color();
});