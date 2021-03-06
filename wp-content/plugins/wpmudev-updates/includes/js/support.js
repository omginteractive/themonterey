 jQuery(document).ready(function($) {

    // Topic title length checking
	$("body")
		.on("blur", "#topic", function () {
			var $title = $("#topic"),
				title = $title.length ? $title.val() : false
			;
			if ($title.length && title.length < 30) {
				$("#error-short_title").show();
			}
		})
		.on("focus", "#topic", function () {
			$("#error-short_title").hide();
		})
	;

	$('#qa-submit').click(function() {
		$('#qa-form').submit();
		return false;
	});
	$('#qa-form').submit(function() {
		var formReturn = true;
		if (!$('#topic').val()) {
			$('#error_topic').slideDown();
			formReturn = false;
		}
		if (!$('#q-and-a').val() && !$('#q-and-a').find("option:selected").attr("forum_id")) {
			$('#error_project').slideDown();
			formReturn = false;
		}
		if (!$('#post_content').val()) {
			$('#error_content').slideDown();
			formReturn = false;
		}

		if (formReturn) {
			var form_data = $('#qa-form').serialize();
			$('#qa-table .error').hide();
			$('#qa-posting').show();
			$('#qa-form input, #qa-form select, #qa-form textarea').attr('disabled', 'disabled');
			$('#qa-submit').hide();
			$('#qa-form').css('opacity', '0.6');
			$.post(ajaxurl + '?action=wpmudev_support_post', form_data, function(json) {
				if (!json.response) {
					$('#qa-form input, #qa-form select, #qa-form textarea').removeAttr('disabled');
					$('#qa-form').css('opacity', '1');
					$('#qa-posting').hide();
					$('#qa-submit').show();
					$('#error_ajax span').html(json.data);
					$('#error_ajax').show();
				} else {
					$('#qa-form').hide();
					$('#success_ajax a').attr('href', json.data);
					$('#success_ajax').show();
				}
			}, 'json');
		}
		return false;
	});

	$('#q-and-a').change(function() {
		if ($(this).val())
			$('#forum_id').val( $(this).find("option:selected").parent().attr("forum_id") );
		else
			$('#forum_id').val( $(this).find("option:selected").attr("forum_id") );
	});

	//handle forum search box
	$('#forum-search-go').click(function() {
		var searchUrl = 'http://premium.wpmudev.org/forums/search.php?q=' + $('#search_projects').val();
		window.open(searchUrl, '_blank');
		return false;
	});
	//catch the enter key
	$('#search_projects').keypress(function(e) {
			if(e.which == 13) {
					$(this).blur();
					$('#forum-search-go').focus().click();
			}
	});
	
	$('.accordion-title p').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var $_txtSpan  = jQuery(this).find('span.ui-hide-triangle').prev(),
			$_triangle = jQuery(this).find('span.ui-hide-triangle'),
			$_content  = jQuery(this).parent().find('ul');

		function show() {
			$_txtSpan.text('HIDE');
			$_content.slideDown( 'fast','swing' );
		}

		function hide() {
				$_txtSpan.text('SHOW');
				$_content.slideUp( 'fast','swing' );
		}

		if($_txtSpan.length){
			//$_txtSpan.text() === 'SHOW' ? show() : hide();
			$_content.is(":visible") ? hide() : show();
			$_triangle.toggleClass('ui-show-triangle');
		}
	});

	// lightbox toggler
	$('#tips').on('click', function(){
		$('.overlay').height( $('#wpcontent').height() );
		$('.overlay').show(1, function(){ $( this ).toggleClass( 'on' ); } );
		return false;
	});

	$('.overlay').on('click', function(e){ 
		$( this ).toggleClass( 'on' ).hide();
	});


	// handle container heights, raw js because fast & simple

	(function(){
		var isDisabled = document.getElementById( 'support-disabled' );

		if ( isDisabled ) { 
			document.getElementById( 'wpbody-content' ).style.paddingTop = 0;
			processHeight( 'support-layer' );
			window.onresize = function(){
				processHeight( 'support-layer' );
			}

		} else {
			processHeight( 'wpcontent' );
			window.onresize = function(){
				processHeight( 'wpcontent' );
			}
		}
	})();

	function processHeight( element ) {							// accepts ID string, as many agruments as needed
		for ( var i = 0, j=arguments.length; i < j; i++ ) {

			var el 		  = document.getElementById( arguments[i] ),
				docHeight = getDocHeight(),
				uaHeight  = $(window).height();

			if ( el ) { 
				if ( docHeight > uaHeight ){
					el.removeAttribute('style');
					docHeight = getDocHeight();
					el.style.height = docHeight + 'px';
				} else {
					el.removeAttribute('style');
					docHeight = getDocHeight();
					el.style.height = uaHeight + 'px';
				}
			}
		}

		// get document height function
		// credit to James Padolsey (http://james.padolsey.com/javascript/get-document-height-cross-browser/)
		function getDocHeight() {
		    var D = document;
		    return Math.max(
		        Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
		        Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
		        Math.max(D.body.clientHeight, D.documentElement.clientHeight)
		    );
		}
	}
});
