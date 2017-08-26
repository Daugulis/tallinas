$(function(){
	var form = $("div.container form");
	var err = {'name':true,'mail':true,'phone':true,'message':true};
	var validate = function(event, err){
		var value = event.value;
		var name = event.name;
		if(value == ''){
			err[name] = true;
			$(event).addClass('error');
		}else{
			delete err[name];
			$(event).removeClass('error');
		}
	}
	
	$("a#join-button").click(function(){
		form.find('input[type=text], select').each(function(){
			validate(this, err);
		})
		form.submit();
	})
	
	form.find('input[type=text], select').blur(function(){
		validate(this, err);
	})
	
	Object.size = function(obj) {
		var size = 0, key;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) size++;
		}
		return size;
	};

	// Get the size of an object

	
	form.submit(function(){
		var size = Object.size(err);
		if(typeof err != 'undefined' && size > 0){
			return false;
		}
		return true;
	})
})