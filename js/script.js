// JavaScript Document //
//@codekit-prepend "extra-script.js";
$(document).ready(function () {


/* ===========================================
	Load Calls
   =========================================*/
	getErrors();

	_mobile = false;

	if ($('html').hasClass('mobile')) _mobile = true;

    if (_mobile) { $('.mobileButton').html('mobile: ' + $(window).width()); }





    function fixBody() {
         _bodyCol = $('.bodyCol').outerHeight();
        _navCol = $('.navCol').outerHeight();
        if (_navCol < _bodyCol) {
            $('.navCol').height(_bodyCol);
        } else {
            $('.bodyCol').height(_navCol);
        }
    }

    fixBody();



    //Mobile Slideout
    $('#navButton').click(function (e) {
        e.preventDefault();
        if ($('body').hasClass('nav-open')) {
            $('body').removeClass('nav-open');
        } else {
            $('body').addClass('nav-open');
        }
    });



	//Show refusal modal
	if ($('html').hasClass('disabled')) {
		$('#restricted').modal();
    }

    $('#modalRemove').click(function () {
        console.log('clicked');
        window.history.back();
    });

	//Login Popup
	//Find Login
	var _login;
	$('.quickNav ul li a').each(function () {
		if ($(this).html() === 'Login') {
			_login = $(this);
		}
	});

	if (_login !== undefined) {
		_login.click(function (e) {
			$('.popupLogin').css('display', 'block').animate({
				height: 300
			}, 1000);
		});

		$('.icon-remove-sign').click(function (e) {
			$('.popupLogin').animate({
				height: 0
			}, 1000, function () {
				$('.popupLogin').css('display', 'none');
			});
		});
	}






/* ===========================================
	Site  Methods
   =========================================*/

	//Add Phone
	$('.addPhone').live('click', function (e) {
		e.preventDefault();
		$span = $(this).parent('span');
		$paragraph = $(this).parent('span').parent('p');


		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: {'addPhone': 1},
			success: function (data) {
				$span.hide();
				$paragraph.after(data);
				//$('.data').html(data);
			}
		});
	});


	$('.alpha').live('click', function (e) {
		e.preventDefault();
		_sel = $(this).attr('sel');

		$.ajax({
			url: '/ajax/ajax_submit.php',
			type: 'POST',
			data: {'supplementAlpha' : _sel },
			success: function (data) {
				$('#supplements').html(data);
			}
		});

	});


    $('.fpTabs article').click(function () {
		$(this).siblings('').removeClass('active').end().addClass('active');
	});

    $('.collapse-content').collapse();



    if ($('html').has('#alphaButtons').length) {
        console.log('Alpha exist');

        _win = $(window);
        _alpha = $('#alphaButtons');
        _spacer = _alpha.offset().top;


        _win.scroll(function () {
            if (!_alpha.hasClass('fix') && _win.scrollTop() > _alpha.offset().top) {
                _alpha.addClass('fix');
                _alpha.siblings('.span10').addClass('fixSibling');
            } else if (_alpha.hasClass('fix') && _win.scrollTop() < _spacer) {
                _alpha.removeClass('fix');
                _alpha.siblings('.span10').removeClass('fixSibling');
            }
        });
    }


/* ===========================================
	Search Methods
   =========================================*/

	if (!$('html').hasClass('mobile')) {
		$("#search").autocomplete( "/ajax/ajax_submit.php",
			{
				autofill: true,
				matchSubset: false,
				matchContains: false,
				formatItem: function(row, i, max) { return row[0]; },
				formatMatch: function(row, i, max) { return row[0]; },
				formatResult: function(row) { return row[0]; },
				extraParams: { 'searchAutoComplete': 1 }
			});
	}

	$('.pagination li a').live('click', function (e) {
		e.preventDefault();

		if ($('.pagination').attr('id') === 'noSearch') return;

		$pageNumber = $(this).parent('li').attr('sel');
		$search = $(this).parent('li').parent('ul').attr('data-term');
        $classname = $(this).parent('li').parent('ul').attr('data-class');
        $.ajax({
			url: '/ajax/ajax_submit.php',
			type: 'POST',
			data: {'search' : $search, 'pageNumber': $pageNumber, 'classname': $classname},
			success: function (data) {
				$('.search-results').html(data);
			}
		});

	});


	$('.pagination li input').live('focusout', function (e) {
		$search = $(this).parent('li').parent('ul').attr('sel');
		$pageNumber = $(this).val();

		$.ajax({
			url: '/ajax/ajax_submit.php',
			type: 'POST',
			data: {'search' : $search, 'pageNumber': $pageNumber},
			success: function (data) {
				$('.mainContent article').html(data);
			}
		});
	});


/* ===========================================
	Error Methods
   =========================================*/


	function getErrors() {
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'errorPlacement': 1},
			dataType: 'json',
			success: function (data) {
				//$('.data').html(data);
				$('#dialog').modal({
					style: data.style,
					text: data.text,
					reportError: data.reportError
				});
			}
		});
	}

	function postError(type, text) {
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'addError': text, 'type': type},
			success: function (data) {
				getErrors();
			}
		});
	}




/* ===========================================
	Form Submitting
   =========================================*/


	$('form#formSubmit').live('submit', function(e) {
		e.preventDefault();

		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		});

		var $this = $(this);
		validate($this);

		var $error = 1;
		var $count = $this.children('fieldset').find(':input:not(button)').hasClass('hasError');

		if ($count) {
			$error = -1;
		}

		if ($error == 1) {
			ajaxFormSubmit($this);
		}

	});


	//Validation on Submit for Forms
	function ajaxFormSubmit(object) {
		var $datastring = object.serialize();
		_button = object.find('button');
		_html = _button.html();

		$.ajax({
			type: 'POST',
			url: '/ajax/ajax_submit.php',
			data: $datastring,
			onSubmit: _button.html('<img src="/images/admin/ajax-loader.gif" /> Loading').addClass('disabled'),
			success: function (data) {
				_button.remove();
				$('.data').html(data);
				postError('message', data);
				getErrors();
			},
			error: function(xhr, textStatus, errThrown) {
                _button.html(_html);
				//$('.data').html(data);
				postError('error', 'Something went wrong with out System. Please try again later');
				getErrors();
            }
		});
	}


	$('.honeyPot').prepend('<p class="checkbox"><input type="checkbox" name="real" id="real"  sel="" /><label>I am not a spam bot</label></p>');


/* ===========================================
	Individaul Forms
   =========================================*/
   $("#loginSubmit").live('click' , function(e) {
        $('#formLogin').submit();
    });


	//Submit for Login Form
	$('#formLogin').submit( function(e) {
		e.preventDefault();

		var $datastring = $(this).serialize();

		_button = $(this).find('button');
		_html = _button.html();


		$.ajax({
			type: 'POST',
			url: '/ajax/ajax_submit.php',
			data: $datastring,
			dataType : 'json',
			onSubmit: _button.html('<img src="/images/admin/ajax-loader.gif" /> Loading').addClass('disabled'),
			success: function (data) {
                //$('.errors').html(data);
				if (data.refer !== null) {
					document.location = data.refer;
				} else if (data.error !== null){
					_button.html(_html).removeClass('disabled');
					$('.errors').html(data.error);
                    $('.errors').addClass('label label-important');
				}
			},
			error: function(xhr, textStatus, errThrown) {
                _button.html(_html);
				//$('.data').html(textStatus+' '+errThrown)
				postError('error','Something went wrong with out System. Please try again later');
				getErrors();
            }
		});
	});



    $('form#formContact').live('submit', function(e) {
        e.preventDefault();

        $(this).find('[placeholder]').each(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
            }
        });

        var $this = $(this);
        validate($this);

        var $error = 1;
        var $count = $this.children('fieldset').find(':input:not(button)').hasClass('hasError');

        if ($count) {
            $error = -1;
        }

        if ($error == 1) {
            ContactFormSubmit($this);
        }

    });


    //Validation on Submit for Forms
    function ContactFormSubmit(object) {
        var $datastring = object.serialize();
        _button = object.find('button');
        _html = _button.html();

        $.ajax({
            type: 'POST',
            url: '/ajax/ajax_submit.php',
            data: $datastring,
            onSubmit: _button.html('<img src="/images/admin/ajax-loader.gif" /> Loading').addClass('disabled'),
            success: function (data) {
                _button.remove();
                $('.message').html(data);

            },
            error: function(xhr, textStatus, errThrown) {
                _button.html(_html);
                //$('.data').html(data);
                postError('error', 'Something went wrong with out System. Please try again later');
                getErrors();
            }
        });
    }


/* ===========================================
	Form Actions
   =========================================*/

	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() === '' || input.val() === input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		}
	}).blur();





/* ===========================================
	Mobile Scripts
   =========================================*/


/* ===========================================
	prepend scripts
   =========================================*/

/* E-commerce Plugin */
/* ===========================================
    Shopping Cart Scripts
   =========================================*/

    $('.add-to-cart').live('click', function(e) {
        e.preventDefault();
        _itemNumber = $(this).attr('data-id');
        _price = $(this).attr('data-price');
        _this = $(this);
        $.ajax({
            type: 'POST',
            url: '/ajax/ajax_submit.php',
            data: {
                'addToCart': _itemNumber,
                'price': _price
            },
            dataType: 'json',
            success: function(data) {
               //console.log(data);
                $('.full-cart').html(data.cart);
                $('.mini-cart').html(data.mini);
				_this.html(data.button);
                _this.addClass('item-added');
            },
            error: function(xhr, textStatus, errThrown) {
                console.log(errThrown);
                postError('error', 'Something went wrong with out System. Please try again later');
                getErrors();
            }
        });
    });

    $('.openCart').live('click', function(e) {
        e.preventDefault();
        $('.popupShoppingCart').slideDown(1000);
    });

    $('.closeCart').live('click', function (e) {
        e.preventDefault();
        $('.popupShoppingCart').slideUp(1000);
    });


    $('.productQuantity').live('focusout', function() {

        _quan = $(this).val();
        _item = $(this).attr('data-product_id');
        _this = $(this);


        $.ajax({
            type: 'POST',
            url: '/ajax/ajax_submit.php',
            data: {
                'changeQuantity': _quan,
                'ItemNumber': _item
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                _this.parent('td').next('.price').text(data.singlePrice);
                _this.parent('td').siblings('#productPrice').val(data.formPrice);
                $('.totalPrice').html(data.totalPrice);
                $('#totalPrice').val(data.formTotal);

                $('.mini-cart').html(data.mini);

                // $('.salesTax').html(data.salesTax);
                // $('#salesTax').val(data.salesTax);
            },
            error: function(xhr, textStatus, errThrown) {
                postError('error', 'Something went wrong with out System. Please try again later');
                getErrors();
            }
        });
    });

    $('.removeProduct').live('click', function(e) {
        _item = $(this).attr('data-product_id');
        _this = $(this);

        $.ajax({
            type: 'POST',
            url: '/ajax/ajax_submit.php',
            data: {
                'removeProduct': 1,
                'ItemNumber': _item
            },
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                _this.parent('td').parent('tr').slideUp(500);
                $('.miniCart').html(data.mini);
                $('.totalPrice').html(data.totalPrice);
            },
            error: function(xhr, textStatus, errThrown) {
                postError('error', 'Something went wrong with out System. Please try again later');
                getErrors();
            }
        });
    });


    $('form#orderSubmit').live('submit', function(e) {
        e.preventDefault();


        var $this = $(this);
        validate($this);

        var $error = 1;
        var $count = $this.children('fieldset').find(':input:not(button)').hasClass('hasError');

        if ($count) {
            $error = -1;
        }

        if ($error == 1) {
            orderFormSubmit($(this));
        }

    });


    //Validation on Submit for Forms

    function orderFormSubmit(object) {
        var $datastring = object.serialize();
        _button = object.find('.checkout-button');
        _html = _button.html();

        $.ajax({
            type: 'POST',
            url: '/ajax/ajax_submit.php',
            data: $datastring,
            dataType: 'json',
            onSubmit: _button.html('Processing <i class="icon-spinner icon-spin icon-large"></i>').addClass('disabled').attr('disabled', 'disabled'),
            success: function(data) {
                $('.orderMessage').html(data);
                if (data.error !== "") {
                    $('.orderMessage').addClass('alert-error alert').html(data.error);
                    _button.html(_html);
                } else {
                    window.location.href = data.refer;
                }
            },
            error: function(xhr, textStatus, errThrown) {
                _button.html(_html);
                postError('error', 'Something went wrong with out System. Please try again later');
                getErrors();
            }
        });
    }


    $('.cancelOrder').live('click', function(e) {
        e.preventDefault();
        _id = $(this).attr("data-transId");
        _answer = confirm("Are you sure you want to cancel your order?");
        _button = $(this);
        _html = $(this).html();
        if (_answer) {
            $.ajax({
                type: 'POST',
                url: '/ajax/ajax_submit.php',
                data: { 'cancelOrder': _id },
                dataType: 'json',
                onSubmit: _button.html('<img src="/images/admin/ajax-loader.gif" />Cancelling Your Order').addClass('disabled').attr('disabled', 'disabled'),
                success: function(data) {
                    if (data.error !== null) {
                        console.log(data.error);
                        postError('error', 'We cannot cancel your order online at this time. Please call us to cancel your order.');
                        getErrors();
                    } else {
                        window.location = data.refer;
                    }
                },
                error: function(xhr, textStatus, errThrown) {
                    postError('error', 'We cannot cancel your order online at this time. Please call us to cancel your order.');
                    getErrors();
                }
            });
        }
    });

    //Mini Shopping Cart Button
    if (_mobile) {
        $('.cartButton').on('click', function (e) {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                $(this).children('a').html('My Cart');
            } else {
                $(this).toggleClass('open');
                $(this).children('a').html('Close');
                e.preventDefault();
            }
        });

        $('.viewCheckout').on('click', function (e) {
            window.location = $(this).attr('href');
        });
    } else {
        $('.cartButton').hover(function() {
            $('.miniCart').toggleClass('active');
        }, function() {
            $('.miniCart').toggleClass('active');
        });
    }







    $('.fillCheckout').click(function(e) {
        e.preventDefault();
        $('#first_name').val('Bob');
        $('#last_name').val('Sagat');
        $('#phone').val('469.556.9406');
        $('.email').val('bob@fullhouse.com');

        $('#address').val('1234 Any St.');
        $('#address2').val('suite 240');
        $('#city').val('Anytown');
        $('#state').val('44');
        $('#zip').val('66766');

        $('#ccnumber').val('4417119669820331'); //.val('asdasdasdfasdf');//
        $('#cc_type').val('visa');
        $('#expire').val('10/16');
        $('#ccv').val('887');
        $('#cardName').val('Robert Sagat');
    });

    $('.fillJoin').click(function() {
        $('#first').val('Zack');
        $('#last').val('Davis');
        $('#email').val('zack2721@me.com');
        $('#phonenumber').val('469.556.9406');


        $('#address1').val('2721 Pinto Dr.');
        $('#address2').val('suite 240');
        $('#city').val('Denton');
        $('#state').val('44');
        $('#zip').val('76210');
        $('#password').val('12345');
        $('#confirmPassword').val('12345');
    });

    $('.clear-cart').click(function (e) {
		e.preventDefault();
		_this = $(this);
		$.ajax({
			type: 'POST',
            url: '/ajax/ajax_submit.php',
            data: { 'clearCart': 1 },
            success: function(data) {
                document.location.reload();
            },
            error: function(xhr, textStatus, errThrown) {
                postError('error', 'We cannot cancel your order online at this time. Please call us to cancel your order.');
                getErrors();
            }
		});
    });



/* End E-commerce Plugin */

}); //End document ready
