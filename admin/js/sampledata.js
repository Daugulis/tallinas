function chStatus(id, url)
{
	$.ajax({
		type: 'POST',
		url: url+id,
		data: ''
	}).done(function(data) {
		var obj = $.parseJSON(data);
		if (obj.status=='1')
		{
			$('#status'+obj.id).attr('src', '/admin/img/icon-green-done.png');
		}
		else
		{
			$('#status'+obj.id).attr('src', '/admin/img/icon-grey-done.png');
		}		
	});
}

function deleteRow(id, url)
{
	if (confirm('Удалить запись?'))
	{
		$.ajax({
			type: 'POST',
			url: url+id,
			data: ''
		}).done(function(data) {
			$('#item'+id).slideUp(function() { $(this).remove(); 
				$('#items').find('.user-items-item').each(function(index) {
					$(this).removeClass('grey');
					if (index/2==Math.ceil(index/2))
					{
						$(this).addClass('grey');
					}
				});
			});
		});
	}
}

function showRows(url, params)
{
	$.ajax({
		type: 'POST',
		url: url,
		data: params
	}).done(function(data) {
		$('#items').html(data);
		$("#items").sortable({
			axis: 'y',		
			items: ".user-items-item",
			handle: ".move",
			stop: function( event, ui ) {
				$('#items').find('.user-items-item').each(function(index) {
					$(this).removeClass('grey');
					if (Math.ceil(index/2) == index/2)
					{
						$(this).addClass('grey');
					}
				});
				$.ajax({
					type: 'POST',
					url: $('#iform #lefturl').val(),
					data: $('#iform').serialize()
				}).done(function(data) {
					//
				});
			}
		});
	});
}

function editRow(id, url)
{
	$.ajax({
		type: 'POST',
		url: url+id,
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$( ".rdate" ).datepicker({ dateFormat: "dd.mm.yy" });
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function saveRow(url, form, urlf, pf)
{
	$('#popup').fadeOut('normal', function() {
		var p = $('#'+form).serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: p
		}).done(function(data) {
			closePopup();
			showRows(urlf, pf);
		});
	});
}

function addRow(url)
{
	$.ajax({
		type: 'POST',
		url: url,
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$( ".rdate" ).datepicker({ dateFormat: "dd.mm.yy" });
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}