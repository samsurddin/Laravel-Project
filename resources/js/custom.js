$(document).ready(function() {
    // feather.replace()
    
    // Store initial image size
    function setImageSize() {
        var imageSize = Math.floor($('.zooma-main img:first-child').height());    
        if(imageSize <= 0) {
            requestAnimationFrame(setImageSize);
        } else {
            // $('.zooma-main').css({width: imageSize, height: imageSize });
            $('.zooma-main img').addClass('is-loaded');
        }
    }
  
    requestAnimationFrame(setImageSize);
  

  
    // Populate thumbnails
    $('.zooma-main').children().clone().appendTo('.zooma-thumbnail');

    // Set state for first image
    $('.product img:first-child').addClass('is-active');
  
    // Thumbnail hover event listener
    $('.zooma-thumbnail img').on('click', function() {
        $('.product img').removeClass('is-active is-zoomed-in').prop('style', '').off('mousemove');
        $('.product img:nth-child(' + ($(this).index()+1) + ')').addClass('is-active');   
    });
  
    // Main image click to zoom event listener
    $('.zooma-main img').on('click', function(e) {
        // Toggle zoom-out cursor and unset max-width
        $(this).toggleClass('is-zoomed-in');

        // Zoom in
        if ($(this).hasClass('is-zoomed-in')) {
            // Variables for calculating relative position
            var scale = e.target.naturalWidth / $(e.target).parent().width();
            var max = -(1 - 1/scale);

            // Adjust mouse scale to the full-size image, then redraw
            e.offsetX *= scale;
            e.offsetY *= scale;
            calculateZoom(e);

            // Mouse event listener
            $(this).on('mousemove', calculateZoom);

            function calculateZoom(e) {       
                var x = e.offsetX * max + 'px';
                var y = e.offsetY * max + 'px';
                $(e.target).css({left: x, top: y});
            }
        } else { // Zoom out
            $(this).off('mousemove').prop('style', '');
        }
    });

    // compare table hover
    $('#compare').find('td').hover(function() {
        var t = parseInt($(this).index()) + 1;
        $(this).parents('table').find('td:nth-child(' + t + ')').addClass('highlighted');
    }, function() {
        var t = parseInt($(this).index()) + 1;
        $(this).parents('table').find('td:nth-child(' + t + ')').removeClass('highlighted');
    });

    // quantity input
    $('.quantity').on('click', '.btn-minus', function(event) {
        event.preventDefault();
        var qty_curr_val = parseInt($('.quantity').find('input.qty').val())
        if (qty_curr_val==1) {
            return;
        }

        $('.quantity').find('input.qty').val(qty_curr_val-1);
    });
    $('.quantity').on('click', '.btn-plus', function(event) {
        event.preventDefault();
        // var qty_curr_val = $('.quantity').find('input.qty').val()
        // if (qty_curr_val==0) {
        //     return;
        // }

        $('.quantity').find('input.qty').val(parseInt($('.quantity').find('input.qty').val())+1);
    });

    $(document).find('.show-section').on('click', 'a', function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        let target = $(this).parent().data('target');

        if ($(this).parent().hasClass('hidden')) {
            $(this).parent().removeClass('hidden')
            $(this).parent().addClass('showing')
            $(this).find('input').val('yes')
            $('.'+target).slideDown(300);
        } else {
            $(this).parent().removeClass('showing')
            $(this).parent().addClass('hidden')
            $(this).find('input').val('no')
            $('.'+target).slideUp(500);
        }
    });

    // remove FontAwesome SVG fill color
    $('.svg-inline--fa').find('path').removeAttr('fill')


    // sticky menu
    window.addEventListener('scroll', function() {
        // console.log('scrolled')
        if (window.scrollY > 250) {
            // console.log('scrolled > 250')
            document.getElementById('navbar_top').classList.add('fixed-top');
            // add padding top to show content behind navbar
            navbar_height = document.querySelector('.navbar').offsetHeight;
            document.body.style.paddingTop = navbar_height + 'px';
        } else {
            // console.log('scrolled < 50')
            document.getElementById('navbar_top').classList.remove('fixed-top');
            // remove padding top from body
            document.body.style.paddingTop = '0';
        } 
    });
});


// Select2 Js //

var menu = [
    "Top"
]

$(document).ready(function(){
    $('#js-example-basic-single').select2({
        data:menu
    });
});
$(document).ready(function(){
    $('#ih').select2({
        data:menu
    });
});
$(document).ready(function(){
    $('#sec_all').select2({
        data:menu
    });
});
$(document).ready(function(){
    $('#sec_all2').select2({
        data:menu
    });
});

$(document).ready(function(){
    $("#ajax-example-basic-single").select2({
        "ajax":"./contact/data.json",
        "columns":[
            {'data':'id'}
        ]
    })
})

$(document).ready(function(){
    $('#select-example-basic-single').select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#js-example-theme-multiple").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#select_to").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#select_tofinal").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#tags").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#Payment").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#bdt").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#inv").select2({
        data:menu
    })
})

$(document).ready(function(){
    $("#item").select2({
        data:menu
    })
})
