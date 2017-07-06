(function($) {

    // USE STRICT
    "use strict";

    //----------------------------------------------------/
    // Predefined Variables
    //----------------------------------------------------/
    var $window 	= $(window),
        $document 	= $(document),
        $body 		= $('body'),
        $basepath	= $('body').data('basepath'),
        $pageloader = $('#page-loader'),
        $noresults 	= $('#no-results-box');


    //----------------------------------------------------/
    // Location listing page
    //----------------------------------------------------/
    
    if ($body.hasClass('load-page-explore')) {
    	var search 	= location.search;
    	var getUrl	= 'explore' + search + '&ajax_on=1';
    	$.ajax({
    		url: getUrl,
    		success: function (result) {
    			if (typeof result !== "object") {
    				result = $.parseJSON(result);
    			}
    			
    			if (result.venues.length > 0) {
	    			$('#list-container').html(result.venues);
	    			$('#query-term').html(result.q);

                    // Hide page loader
                    $pageloader.hide().parent('#no-results').hide();

	    			// Initialize Google Map
	    			$('#google-map').googleMap();

	    			// Add Google Map Markers
				    if (result.coords.length > 0) {
				    	$.each(result.coords, function (k, v) {
				    		$("#google-map").addMarker({coords: [v.lat, v.lng]});
				    	});
				    }
	    		} else {
                    $pageloader.hide();
	    			$noresults.show();
	    		}
    		}
    	});
    }


    //----------------------------------------------------/
    // Account page - listing user's custom locations
    //----------------------------------------------------/
    

    if ($body.hasClass('load-page-account')) {
        $.ajax({
            url : 'account',
            data: { ajax_on:1, get_custom_list:1 },
            success: function (result) {
                if (typeof result !== "object") {
                    result = $.parseJSON(result);
                }
                
                if (result.venues.length > 0) {
                    $('#list-container').html(result.venues);
                    $('#query-term').html(result.q);

                    // Hide page loader
                    $pageloader.hide().parent('#no-results').hide();

                    // Initialize Google Map
                    $('#google-map').googleMap();

                    // Add Google Map Markers
                    if (result.coords.length > 0) {
                        $.each(result.coords, function (k, v) {
                            $("#google-map").addMarker({coords: [v.lat, v.lng]});
                        });
                    }
                } else {
                    $pageloader.hide();
                    $noresults.show();
                }
            }
        });
    }

    //----------------------------------------------------/
    // Image listing page
    //----------------------------------------------------/
    
    if ($body.hasClass('load-page-photo')) {
    	var id 		= $('#photo-list').data('id');
    	var name 	= $('#photo-list').data('name');
    	var coords 	= $('#photo-list').data('coords');
    	var getUrl 	= $basepath+'explore/photo/'+id+'/'+name+'/'+coords+'?ajax_on=1';
    	
    	$.ajax({
    		url : getUrl,
    		success : function (result) {
    			if (typeof result !== "object") {
    				result = $.parseJSON(result);
    			}
    			if (typeof result.location === "object") {
    				$('.venue-name').html(result.location.location_name);
	    			$('.categories .item').html(result.location.categories);
	    			$('.venue-city').html(result.location.location_city);
	    			$('.venue-state').html(result.location.location_state);
	    			$('.venue-country').html(result.location.location_country);
    			}	    
    			if (result.photos.length > 0) {
	    			$('#photo-list-container').html(result.photos);

                    // Hide page loader
                    $pageloader.hide().parent('#no-results').hide();
    			} else {
                    $pageloader.hide();
                    $noresults.show();
                }
    		}
    	});
    }


    //----------------------------------------------------/
    // User Login
    //----------------------------------------------------/
    
    $('#loginBtn').on('click', function (e) {
        e.preventDefault();
        var postData = {
            ajax_on : 1,
            login   : 1,
            username: $('#username').val(),
            password: $('#password').val()
        }
        $.ajax({
            url : 'login',
            type: 'POST',
            data: postData,
            beforeSend: function () {
                $('#no-results').fadeIn();
            },
            success : function (result) {
                if (typeof result !== "object") {
                    result = $.parseJSON(result);
                }
                $('#no-results').fadeOut();
                if (result.success) {
                    $('#loginFrm')[0].reset();
                    location.href = 'home';
                } else {
                    alert(result.error);
                }
            }
        });
    });

    //----------------------------------------------------/
    // Create account
    //----------------------------------------------------/
    
    $('#createAccountBtn').on('click', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to create an account?')) {
            var postData = {
                ajax_on         : 1,
                create_account  : 1,
                name            : $('#name').val(),
                surname         : $('#surname').val(),
                username        : $('#username').val(),
                password        : $('#password').val()
            }
            $.ajax({
                url : 'register',
                type: 'POST',
                data: postData,
                beforeSend: function () {
                    $('#no-results').fadeIn();
                },
                success : function (result) {
                    if (typeof result !== "object") {
                        result = $.parseJSON(result);
                    }
                    $('#no-results').fadeOut();
                    if (result.success) {
                        $('#registerFrm')[0].reset();
                        alert('Congrats! Your account has been successfully created!');
                    } else {
                        alert(result.error);
                    }
                }
            });
        }
    });


    //----------------------------------------------------/
    // Save / Remove Locations to/from user's custom list
    //----------------------------------------------------/

    $document.on('click', '.buttons .btn-save', function () {
        if ($body.hasClass('user-logged-in')) {
            if (confirm('Are you sure you want to add this to custom list')) {
                var $this    = $(this);
                var postData = {
                    ajax_on     : 1,
                    custom_list : 1,
                    location    : $this.closest('.content-holder').find('.venue-name').data('location')
                };
                if ($this.hasClass('is-favourite')) {
                    postData.action = 'remove';
                } else {
                    postData.action = 'add';
                }
                $.ajax({
                    url : 'account',
                    type: 'POST',
                    data: postData,
                    beforeSend: function () {
                        $('#no-results').fadeIn();
                    },
                    success : function (result) {
                        if (typeof result !== "object") {
                            result = $.parseJSON(result);
                        }
                        $('#no-results').fadeOut();
                        if (result.success) {
                            if ($this.hasClass('is-favourite')) {
                                if ($body.hasClass('load-page-account')) {
                                    $this.closest('.location-box').parent('#loc-container').remove();
                                } else {
                                    $this.removeClass('is-favourite').children('.label').text('Save to List');
                                }
                            } else {
                                $this.addClass('is-favourite').children('.label').text('Remove from List');
                            }
                            alert('Request successfully processed!');
                        } else {
                            alert(result.error);
                        }
                    }
                });
            }
        }
    });

}(jQuery));