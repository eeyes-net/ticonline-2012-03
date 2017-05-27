$(document).ready(function(){
	$('#startDate').DatePicker({
	format:'Y-m-d',
	date: $('#startDate').val(),
	current: $('#startDate').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		$('#startDate').DatePickerSetDate($('#startDate').val(), true);
	},
	onChange: function(formated, dates){
		$('#startDate').val(formated);
		$('#startDate').DatePickerHide();
	}
});

$('#endDate').DatePicker({
	format:'Y-m-d',
	date: $('#endDate').val(),
	current: $('#endDate').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		$('#endDate').DatePickerSetDate($('#endDate').val(), true);
	},
	onChange: function(formated, dates){
		$('#endDate').val(formated);
		$('#endDate').DatePickerHide();
	}
});

$('#acDate').DatePicker({
	format:'Y-m-d',
	date: $('#acDate').val(),
	current: $('#acDate').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		$('#acDate').DatePickerSetDate($('#acDate').val(), true);
	},
	onChange: function(formated, dates){
		$('#acDate').val(formated);
		$('#acDate').DatePickerHide();
	}
});
$('.myDate').DatePicker({
	format:'Y-m-d',
	date: $('.myDate').val(),
	current: $('.myDate').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		$('.myDate').DatePickerSetDate($('.myDate').val(), true);
	},
	onChange: function(formated, dates){
		$('.myDate').val(formated);
		$('.myDate').DatePickerHide();
	}
});

$('#myDate').DatePicker({
	format:'Y-m-d',
	date: $('#myDate').val(),
	current: $('#myDate').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		$('#myDate').DatePickerSetDate($('#myDate').val(), true);
	},
	onChange: function(formated, dates){
		$('#myDate').val(formated);
		$('#myDate').DatePickerHide();
	}
});
});