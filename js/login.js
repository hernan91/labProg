$().ready(function(){
	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});
	$('#buttonIngresar.ui.button').click(function(e){
		e.preventDefault();
		let passwordField = $('#password');
		let cryptedPassword = CryptoJS.MD5(passwordField.val());
		$('#cryptedPasswordField').val(cryptedPassword);
		$('#loguear.ui.form').submit();		
	});
});