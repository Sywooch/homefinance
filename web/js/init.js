//// balance sheet
$(function() {
	$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );
	$("#balancesheet-period_start").datepicker({
		firstDay: 1,	
		dateFormat : 'yy-mm-dd'
	});
});

//// transaction
$(function() {
	$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );
	$("#transaction-date").datepicker({
		firstDay: 1,	
		dateFormat : 'yy-mm-dd'
	});
})
