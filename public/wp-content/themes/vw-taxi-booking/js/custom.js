// Slider
jQuery(document).ready(function() {
  jQuery('.slider-section .owl-carousel').owlCarousel({
    loop: true,
    margin: 15,
    nav: true,
    navText: ["<span class='left-btn p-3'></span>", "<span class='right-btn p-3'></span>"], 
    dots: false,
    rtl: false,
    items: 1,
    autoplay: true,
    autoplayTimeout: 5000,
    animateOut: 'fadeOut',
  });
});

// Testimonial
jQuery(document).ready(function() {
  jQuery('.testimonial-section .owl-carousel').owlCarousel({
    loop: true,
    margin: 15,
    nav: true,
    navText: ["<span class='left-btn p-3'></span>", "<span class='right-btn p-3'></span>"], 
    dots: false,
    rtl: false,
    responsive: {
    0: { 
      items: 1 
    },
    768: { 
      items: 2 
    },
    992: { 
      items: 2 
    },
    1200: { 
      items: 3 
    }
  },
  autoplay: true,
  });
});

// News Sections
jQuery(document).ready(function() {
  jQuery('.news-section .owl-carousel').owlCarousel({
    loop: true,
    margin: 15,
    nav: false,
    dots: false,
    rtl: false,
    responsive: {
    0: { 
      items: 1 
    },
    768: { 
      items: 2 
    },
    992: { 
      items: 2 
    },
    1200: { 
      items: 3 
    }
  },
  autoplay: true,
  });
});

// Scroll to Top
window.onscroll = function() {
  const vw_taxi_booking_button = document.querySelector('.scroll-top-box');
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    vw_taxi_booking_button.style.display = "block";
  } else {
    vw_taxi_booking_button.style.display = "none";
  }
};

document.querySelector('.scroll-top-box a').onclick = function(event) {
  event.preventDefault();
  window.scrollTo({top: 0, behavior: 'smooth'});
};

// tabs.js
document.addEventListener("click", e => {  if (e.target.parentElement.classList.contains("tab-title")  ) { vw_taxi_booking_redTab(e) }  });

[...document.querySelectorAll("div.main-tab div")].forEach((tabTile, index) => {
    tabTile.classList.toggle('active', index == 0)
  });
[...document.querySelectorAll(".tab-content")].forEach((tabcontent, index) => {
  tabcontent.classList.toggle('active', index == 0)
  });
function vw_taxi_booking_redTab(e) {  
  let vw_taxi_booking_tabTiles = [...document.querySelectorAll("div.main-tab div")];
  let vw_taxi_booking_tabcontents = [...document.querySelectorAll(".tab-content")];
  let vw_taxi_booking_activeTabIndex = vw_taxi_booking_tabTiles.findIndex(tab => { return tab == e.target.parentElement })
  vw_taxi_booking_tabTiles.forEach((tabTile, index) => {
    tabTile.classList.toggle('active', index === vw_taxi_booking_activeTabIndex)
  })
  vw_taxi_booking_tabcontents.forEach((tabcontent, index) => {
  tabcontent.classList.toggle('active', index === vw_taxi_booking_activeTabIndex)
  })
}

// Taxi Form
jQuery(document).ready(function($){
  if ($(".mpStyle.mptbm_transport_search_area").length) {

    $(".mpStyle.mptbm_transport_search_area")
      .addClass("taxi-popup-box")
      .prepend('<span class="taxi-popup-close">&times;</span>')
      .hide();

    if ($(".taxi-popup-overlay").length === 0) {
      $("body").append('<div class="taxi-popup-overlay"></div>');
    }

    $(".wp-block-button a:contains('book now')").on("click", function(e){
      e.preventDefault();
      $(".taxi-popup-overlay").fadeIn();
      $(".taxi-popup-box").fadeIn();
    });

    $(document).on("click", ".taxi-popup-overlay, .taxi-popup-close", function(){
      $(".taxi-popup-box").fadeOut();
      $(".taxi-popup-overlay").fadeOut();
    });

  }
});