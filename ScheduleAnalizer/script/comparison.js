/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
	options = {
		chart: {
			renderTo: 'highchart',
			type: 'column',
			backgroundColor: '#eeeeee'
		},
		title: {
			text: 'Среднее время занятости'
		},
		xAxis: {
			categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
		},
		yAxis: {
			title: {
				text: 'Время (часов)'
			}
		},
		series: [{
				name: 'A',
				data: [1, 1, 1, 1, 1, 1],
				color: '#FF5C5C'
			}, {
				name: 'B',
				data: [1, 1, 1, 1, 1, 1],
				color: '#2C70D5'
			}]
	};	

	chart = new Highcharts.Chart(options);

	function updateData(lvl, pos) {
		var el = pos === 'left' ? 'lel_' : 'rel_';
		console.log("Updatting using: "+lvl+" "+$('#'+el+'1').val()+" "+$('#'+el+'2').val()+" "+$('#'+el+'3').val()+" "+$('#'+el+'4').val()+" "+$('#'+el+'5').val());
		$.get('time.php', {
			level: lvl,
			type: $('#'+el+'1').val(), 
			faculty: $('#'+el+'2').val(), 
			year: $('#'+el+'3').val(), 
			group: $('#'+el+'4').val(), 
			prof: $('#'+el+'5').val()
		}, function(data, status) {
			var cdata = [];
			var vals = data.split(' ');
			$.each(vals, function(i, v) {
				cdata.push(parseFloat(v));
			});
//			chart.series[0].setData([1,2,3,4,5,6]);
			console.log('result: '+data+' <=> '+cdata);
			if (pos === 'left') {
//				chart.series[0].data.length = 0;
				chart.series[0].setData(cdata,true);
//				chart.series[0].data.push(cdata);
//				console.log('setting data into left series[0]');
			} else {
//				chart.series[1].data.length = 0;
				chart.series[1].setData(cdata,true);
//				chart.series[1].data.push(cdata);
//				console.log('setting data into right series[1]');
			}
		});
	}
	
	function dataOn(data, i, type) {
		$('#'+type+'el_'+i).html(data);
		for (j = i+1; j <= 5; j++) {
			$('#'+type+'el_'+j).html('');
		}
	}

	
	
	$.get('schedule.php', {req: 'year'}, function (data, status) {
		if (status !== "success") {
			alert("STATUS RETURN: "+status);
		} else {
			$('#lel_3').html(data);
			$('#rel_3').html(data);
			$('#lel_4').html('');
			$('#rel_4').html('');
		}
	});	

	$('#lel_1').change(function() {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {req: 'faculty'}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 2, 'l');
				}
			});	
			updateData('overall', 'left');
		}
	});

	$('#rel_1').change(function() {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {req: 'faculty'}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 2, 'r');
				}
			});	
			updateData('overall', 'right');
		}
	});
	
	$('#lel_2').change(function() {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {req: 'year'}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 3, 'l');
				}
			});	
			updateData('faculty', 'left');
		}
	});

	$('#rel_2').change(function() {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {req: 'year'}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 3, 'r');
				}
			});	
			updateData('faculty', 'right');
		}
	});
	
	$('#lel_3').change(function () {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {
				req: 'group', 
				faculty: $('#lel_2').find(':selected').val(),
				year: $('#lel_3').find(':selected').val()
			}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 4, 'l');
				}
			});	
			updateData('year', 'left');
		}
	});
	
	$('#lel_4').change(function () {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {
				req: 'proflist', 
				group: $('#lel_4').find(':selected').val()
			}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 5, 'l');
				}
			});	
			updateData('group', 'left');
		}
	});
	
	$('#rel_3').change(function () {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {
				req: 'group', 
				faculty: $('#rel_2').find(':selected').val(),
				year: $('#rel_3').find(':selected').val()
			}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 4, 'r');
				}
			});	
			updateData('year', 'right');
		}
	});
	
	$('#rel_4').change(function () {
		if ($(this).find(':selected').text().trim().length > 0) {
			$.get('schedule.php', {
				req: 'proflist', 
				group: $('#rel_4').find(':selected').val()
			}, function (data, status) {
				if (status !== "success") {
					alert("STATUS RETURN: "+status);
				} else {
					dataOn(data, 5, 'r');
				}
			});	
			updateData('group', 'right');
		}
	});

	$('#lel_5').change(function() {
		if ($(this).find(':selected').text().trim().length > 0) {
			updateData('prof', 'left');
		}
	});

	$('#rel_5').change(function() {
		if ($(this).find(':selected').text().trim().length > 0) {
			updateData('prof', 'right');
		}
	});
});
