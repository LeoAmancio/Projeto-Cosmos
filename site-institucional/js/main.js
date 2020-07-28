var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    autoplay: {
        delay: 2500
    },
    loop: true,
    direction: 'horizontal',

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    }

  })

function toggleNav() {    
  document.querySelector("nav").classList.toggle("showNav")
}

var modal1 = document.querySelector(".m1");
var modal2 = document.querySelector(".m2");
var modal3 = document.querySelector(".m3");

function toggleModal(n) {
  if(n == 1) {
    modal1.classList.toggle("showModal");
  }else if (n == 2) {
    modal2.classList.toggle("showModal");
  }else {
    modal3.classList.toggle("showModal");
  }
  document.getElementsByTagName("body")[0].classList.toggle("noScroll");
}

function windowOnClick(event) {
  if(event.target === modal1) {
    toggleModal(1);
  }else if(event.target === modal2) {
    toggleModal(2);
  }else if(event.target === modal3) {
    toggleModal(3);
  }
}

window.addEventListener("click", windowOnClick);

$(window).bind('scroll', function () {
  if ($(window).scrollTop() > 500) {
      $('.header').addClass('fixed');
      $('#header-logoCosmos').attr("src","img/logo/cosmos-logo-white.png");
  } else {
      $('.header').removeClass('fixed');
      $('#header-logoCosmos').attr("src","img/logo/cosmos-logo-black.png");
  }
});

$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 600, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});

