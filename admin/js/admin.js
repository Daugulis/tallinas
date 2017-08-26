var uploaders = new Array();
var DJS = new Object();

$(document).ready(function() {
	$('#mpopupbg').click(function() { $('#mpopup').fadeOut(); });
});

function closePopup()
{
	$('#popup').fadeOut();
	$('#overley').fadeOut();
}

function savePopupData(url, form)
{
	$('#popup').fadeOut('normal', function() {
		var p = $('#'+form).serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: p
		}).done(function(data) {
				closePopup();
			$('#pcontent').html(data);
			//$('#popup').fadeIn();
			if ($('#rlevel').val()=="1")
			{
				var pid = $('#ncat').data('p');
				var cid = $('#ncat').data('id');
				$('#cat'+cid).hide();
				$('#cat'+cid).appendTo('#catt'+pid);
				$('#cat'+cid).slideDown();
				$('#catt0').find('.table-item').each(function(index) {
					$(this).removeClass('grey');
					if (Math.ceil(index/2) != index/2)
					{
						$(this).addClass('grey');
					}
				});
			}
			if ($('#rlevel').val()=="3")
			{
				var pid = $('#ncat').data('p');
				var cid = $('#ncat').data('id');
				$('#sub3-'+cid).hide();
				$('#sub3-'+cid).appendTo('#sub2-'+pid);
					
				$('#sub2-'+pid).find('.cell-2-2-line').each(function(index) {
					var sb = $(this).find('div').eq(0);
					if (index==0)
					{
						sb.removeClass('main-sub2');
						sb.removeClass('sub2');
						sb.addClass('main-sub2');
					}
					else
					{
						sb.removeClass('main-sub2');
						sb.removeClass('sub2');
						sb.addClass('sub2');
					}
				});
				$('#sub3-'+cid).slideDown(function() {
					
				});	
			}
			if ($('#rlevel').val()=="2")
			{
				var pid = $('#ncat').data('p');
				var cid = $('#ncat').data('id');
				$('#cat'+pid+'but-'+cid).hide();
				$('#cat'+pid+'but-'+cid).appendTo('#cat'+pid+'-1');
				//alert($('#cat'+pid+'-1 .cell-2-line').eq(0).find('.cell-2-1').length);
				if ($('#cat'+pid+'-1 .cell-2-line').eq(0).find('.cell-2-1').length=="1")
				{
					$('#cat'+pid+'-1 .cell-2-line').eq(0).remove();
				}
				$('#cat'+pid+'-1').find('.cell-2-line').each(function(index) {
					$(this).find('.cell-2-1').eq(1).find('a').hide();
					var sb = $(this).find('.cell-2-1').eq(0).find('div').eq(0);
					if (index==0)
					{
						sb.removeClass('main-sub');
						sb.removeClass('sub');
						sb.addClass('main-sub');
					}
					else
					{
						sb.removeClass('main-sub');
						sb.removeClass('sub');
						sb.addClass('sub');
					}
					$(this).css('border-left', 'solid 1px #D6D6D6');
					$(this).removeClass('subcl');
				});
				$('#cat'+pid+'-1').find('.cell-2-line').eq(-1).addClass('subcl');
					$('#cat'+pid+'-1').find('.cell-2-line').eq(-1).find('.cell-2-1').eq(1).find('a').show();
				$('#cat'+pid+'but-'+cid).slideDown(function() {
					
				});				
			}
			setCSort();
		});
	});
}

function deleteItem(url, id, p)
{
	if (confirm('Удалить запись?'))
	{
		$('#'+p+id).slideUp("normal", function() { $(this).remove(); });
		$.ajax({
			type: 'POST',
			url: url,
			data: 'del='+id
		}).done(function(data) {
			//alert(data);
		});
	}
}

function addUploader(param)
{
	uploaders[param[0]] = null;
	uploaders[param[0]] = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',
		autostart : true,
		upname: param[0],
		browse_button : param[1], // you can pass in id...
		container: param[2], // ... or DOM Element itself
		url : param[6],
		flash_swf_url : '/admin/js/Moxie.swf',
		silverlight_xap_url : '/admin/js/Moxie.xap',
		
		filters : {
			max_file_size : '20mb',
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png,jpg,jpeg,svg"},
				{title : "Text files", extensions : "pdf,doc,txt,xls,xlam,xlsb,xltm,xlsm,xlsx,docx"}
			]
			/*mime_types : "image/*, application/*, text/*" */
		},

		init: {
			PostInit: function() {
				//
			},

			FilesAdded: function(up, files) {
				plupload.each(files, function(file) {
					//document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
					//alert(file.name);
					var fn = param[3];
					DJS[fn](param[0], file);
				});
				up.refresh();
				up.start();
			},

			UploadProgress: function(up, file) {
				//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
				var fn = param[5];
				DJS[fn](up, file, param[0]);
			},

			FileUploaded:function(up, file, resp) {
				var fn = param[4];
				DJS[fn](up, file, resp, param[0]);
			},

			Error: function(up, err) {
				//document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	});
	uploaders[param[0]].init();
}


function generateSlug(value)
{

	var answer = ""
		  , a = {};

	   a["Ё"]="YO";a["Й"]="I";a["Ц"]="TS";a["У"]="U";a["К"]="K";a["Е"]="E";a["Н"]="N";a["Г"]="G";a["Ш"]="SH";a["Щ"]="SCH";a["З"]="Z";a["Х"]="H";a["Ъ"]="'";
	   a["ё"]="yo";a["й"]="i";a["ц"]="ts";a["у"]="u";a["к"]="k";a["е"]="e";a["н"]="n";a["г"]="g";a["ш"]="sh";a["щ"]="sch";a["з"]="z";a["х"]="h";a["ъ"]="'";
	   a["Ф"]="F";a["Ы"]="I";a["В"]="V";a["А"]="a";a["П"]="P";a["Р"]="R";a["О"]="O";a["Л"]="L";a["Д"]="D";a["Ж"]="ZH";a["Э"]="E";
	   a["ф"]="f";a["ы"]="i";a["в"]="v";a["а"]="a";a["п"]="p";a["р"]="r";a["о"]="o";a["л"]="l";a["д"]="d";a["ж"]="zh";a["э"]="e";
	   a["Я"]="Ya";a["Ч"]="CH";a["С"]="S";a["М"]="M";a["И"]="I";a["Т"]="T";a["Ь"]="'";a["Б"]="B";a["Ю"]="YU";
	   a["я"]="ya";a["ч"]="ch";a["с"]="s";a["м"]="m";a["и"]="i";a["т"]="t";a["ь"]="'";a["б"]="b";a["ю"]="yu";
		a["Ā"]="a";a["Ē"]="E";a["Ū"]="U";a["Ī"]="I";a["Š"]="S";a["Ģ"]="G";a["Ķ"]="K";a["Ļ"]="L";a["Ž"]="Z";a["Č"]="C";a["Ņ"]="N";
		a["ā"]="a";a["ē"]="e";a["ū"]="u";a["ī"]="i";a["š"]="s";a["ģ"]="g";a["ķ"]="k";a["ļ"]="l";a["ž"]="z";a["č"]="c";a["ņ"]="n";
		var word = value;
	   for (i in word){
		 if (word.hasOwnProperty(i)) {
		   if (a[word[i]] === undefined){
			 answer += word[i];
		   } else {
			 answer += a[word[i]];
		   }
		 }
	   }
	   value = answer;

	return value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
}

function setCookie(cname, cvalue, exdays)
{
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
} 

function getCookie(cname)
{
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++)
	{
		var c = ca[i].trim();
		if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	}
	return "";
} 