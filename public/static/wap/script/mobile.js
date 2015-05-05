$(document).ready(function(){
	$('.bottom-nav-ul-li .submenu').click(function(e){
		e.preventDefault();
		
		if ($('.bottom-nav-explor').not($(this).next()).hasClass('bottom-nav-explor-block')) {
            $('.bottom-nav-explor').removeClass('bottom-nav-explor-block');
        }

		$(this).next().toggleClass('bottom-nav-explor-block');
		
		//console.log(a);
	});
});