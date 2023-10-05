

$.noConflict();

jQuery(document).ready(function(e) {
    
    // jQuery('#tc_aside').on("hover", function(e){
    //     jQuery('body').toggleClass('aside-minimize-hover');
    // })
    // jQuery("#tc_aside").hover(function () {
    //     jQuery('body').toggleClass("aside-minimize-hover");
    // });

    //sidebar menu active
    // jQuery('#basic-input .nav-link').on("click", function(e){
    //   console.log('ac');
      
    //   jQuery('.nav-collapse').addClass('show');
    // });

    //Mobile Menu
    

    // jQuery('.aside-overlay').on('click', function () {
    //     jQuery('#tc_aside').removeClass('aside-on');
    //     jQuery('.aside-overlay').removeClass('active');

    //     //put this when close popup and show scrollbar in body
    //     // bodyScrollLock.enableBodyScroll(targetElement);

    //     // jQuery('html').css('overflow', 'auto');
    //     // jQuery('body').css('overflow', 'auto');
    // });

    // Account offCanvas
    // jQuery('#tc_quick_user_toggle').on("click", function(e){
    //     jQuery('#kt_quick_user').addClass('offcanvas-on');
    // });
    // jQuery('#kt_quick_user_close').on("click", function(e){
    //     jQuery('#kt_quick_user').removeClass('offcanvas-on');
    // });


    // jQuery('#tc_header_mobile_topbar_toggle').on("click", function(e){
    //     jQuery('body').toggleClass('topbar-mobile-on');
    // });




    // theme dark
    // jQuery('#radio-light').on('click', function(e){
    //     jQuery('#radio-dark').parent('label').removeClass('active');
    //     jQuery('body').removeClass('dark');
    //     jQuery('#radio-light').attr("checked", "checked");
    //     jQuery('#radio-dark').removeAttr("checked", "");
    //     jQuery('#radio-light').parent('label').addClass('active');

    // })

    // jQuery('#radio-dark').on('click', function(e){
    //     jQuery('#radio-light').parent('label').removeClass('active');
    //     jQuery('body').addClass('dark');
    //     jQuery('#radio-dark').attr("checked", "checked");
    //     jQuery('#radio-light').removeAttr("checked", "");
    //     jQuery('#radio-dark').parent('label').addClass('active');
    // })

    
    jQuery('.btn-rtl').on('click', function(e){
      jQuery('.btn-rtl').toggleClass('active');
      jQuery('body').toggleClass('rtl');
      jQuery('#kt_color_panel').removeClass('offcanvas-on');
      
    })

    // //theme color
    // jQuery('#color-theme-blue').on('click', function(e){
    //   jQuery('body').removeClass('color-theme-red');
    //   jQuery('body').addClass('color-theme-blue');
      
    // })

    // jQuery('#color-theme-red').on('click', function(e){
    //   jQuery('body').removeClass('color-theme-blue');
    //   jQuery('body').addClass('color-theme-red');
    // })
    


    // validation for form fields

    // jQuery( "#myform" ).validate({
    //   rules: {
    //     email: {
    //       required: true
    //     }
    //   }
    // });
    
});

const counters = document.querySelectorAll('.counter');
const speed = 200; // The lower the slower

counters.forEach(counter => {
	const updateCount = () => {
		const target = +counter.getAttribute('data-target');
		const count = +counter.innerText;

		// Lower inc to slow and higher to slow
		const inc = target / speed;

		// console.log(inc);
		// console.log(count);

		// Check if target is reached
		if (count < target) {
			// Add inc to count and output in counter
			counter.innerText = count + inc;
			// Call function every ms
			setTimeout(updateCount, 1);
		} else {
			counter.innerText = target;
		}
	};

	updateCount();
});



/* Get the documentElement (<html>) to display the page in fullscreen */
// var elem = document.documentElement;

/* View in fullscreen */
// function openFullscreen() {
    
    
  
    
// }


/* Close fullscreen */
// function closeFullscreen() {
    
//   }

// Custom for pacejs
// paceOptions = {
//   elements: true
// };

// for classic Editor
// ClassicEditor.create( document.querySelector( '#editor' ),{
//     toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ],
//     alignment: {
//       options: [ 'left', 'right' ]
//     }
// }).catch( error => {
//     console.error( error );
// });

// for data tables
// jQuery(document).ready( function () {
// 	jQuery('#myTable').DataTable();
// });


// (function($){
//   jQuery(window).on("load",function(){
//     jQuery(".my-custom-scrollbar").mCustomScrollbar(
//       {
//         setHeight:true
//       }
//     );
//   });
// })(jQuery);


// (function(jQuery){
//   var tabCarousel = jQuery('.addproduct-js');
//       if (tabCarousel.length) {
          
//           tabCarousel.each(function(){
//               var thisCarousel = jQuery(this),
//                   item =  jQuery(this).data('item'),
//                   itemmobile =  jQuery(this).data('itemmobile');
                  
                      
              
//               thisCarousel.slick({
//                   dots: false,
//                   arrows: true,
//                   infinite: true,
//                   //rtl:true,
//                   speed: 300,
//                   slidesToShow: item || 3,
//                   slidesToScroll: item || 4,
//                   adaptiveHeight: true,
//                       responsive: [
//                           {
//                               breakpoint: 1200,
//                               settings: {
//                                   slidesToShow: 3,
//                                   slidesToScroll: 3
//                               }
//                           },
//                           {
//                           breakpoint: 992,
//                           settings: {
//                               slidesToShow: 2,
//                               slidesToScroll: 2
//                           }
//                       },
//                       {
//                           breakpoint: 768,
//                           settings: {
//                               slidesToShow: 1,
//                               slidesToScroll: 1
//                           }
//                       },
//                   {
//                       breakpoint: 576,
//                       settings: {
//                           slidesToShow: itemmobile || 1,
//                           slidesToScroll: itemmobile || 1
//                       }
//                   }]
//               });
//           });
//       };
      
// })(jQuery);  