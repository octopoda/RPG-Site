$(document).ready(function () {

/* Archive Plugin */

/* ===========================================
    Load Calls
   =========================================*/



   function adjustHeight() {
    $('#archive-download').tooltip();

    _mHeight = $('.archive-menu').height();
    _cHeight = $('.archive-content').height();


    if (_mHeight > _cHeight) {
        $('.archive-content').height(_mHeight);
    } else {
        $('.archive-menu').height(_cHeight);
    }
   }

   adjustHeight();



    $('.year').live('click', function (e) {
        _this = $(this);
        _parent = $(this).parent('li');

        _open = _parent.siblings('.open');
        console.log(_open.children('a').html());
        _open.children('.monthList').hide();


        if (_parent.hasClass('open')) {
            _this.next('.monthList').slideUp(500);
        } else {
            _this.next('.monthList').slideDown(500);
        }


        _parent.toggleClass('open');
    });


    $('.category').live('click', function (e) {
        _this = $(this);
        _parent = $(this).parent('li');


        if (_parent.hasClass('open')) {
            _this.next('.subList').slideUp(500);
        } else {
            _this.next('.subList').slideDown(500);
        }

        _parent.toggleClass('open');
    });

    $('.month').live('click', function (e) {
        e.preventDefault();
        _archiveId = $(this).parent('li').attr('sel');


        $.ajax({
            url: '/ajax/ajax_submit.php',
            type: 'POST',
            data: {'monthClick': _archiveId},
            onSubmit : $('.archive-content').html('<img src="/images/admin/ajax-loader.gif" alt="loading" /> Loading'),
            success: function (data) {
                $('.archive-content').html(data);
                adjustHeight();
            }
        });
    });

    $('.subCategory').live('click', function (e) {
        e.preventDefault();
        _categoryId = $(this).parent('li').attr('sel');

        $.ajax({
            url: '/ajax/ajax_submit.php',
            type: 'POST',
            data: {'catClick': _categoryId},
            onSubmit : $('.archive-content').html('<img src="/images/admin/ajax-loader.gif" alt="loading" /> Loading'),
            success: function (data) {
                $('.archive-content').html(data);
                adjustHeight();
            }
        });

    });



    $('#archiveSearch').click(function (e) {
        e.preventDefault();
        _a = $('.archive-search');

        if (_a.hasClass('active')) {
            _a.removeClass('active');
        } else {
            _a.addClass('active');
        }
    });

    $('#archive-search').submit(function (e) {
        e.preventDefault();
        _string = $('#archiveSearch').val();
        console.log(_string);


        $.ajax({
            url: '/ajax/ajax_submit.php',
            type: 'POST',
            data: {'archiveSearch': _string},
            success: function (data) {
                $('.archive-content').html(data);
                adjustHeight();
            }
        });

    });

    $('.pagination li a').live('click', function (e) {
        e.preventDefault();
        $pageNumber = $(this).parent('li').attr('sel');
        $search = $(this).parent('li').parent('ul').attr('data-term');

        $.ajax({
            url: '/ajax/ajax_submit.php',
            type: 'POST',
            data: {'archiveSearch' : $search, 'archivePageNumber': $pageNumber},
            success: function (data) {
                $('.archive-content').html(data);
                adjustHeight();
            }
        });

    });




/* End Archive Plugin */


});