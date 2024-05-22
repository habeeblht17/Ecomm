import './bootstrap';

//SwiperJs
// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// import Swiper and modules styles
import 'swiper/css';
//import 'swiper/css/navigation';
import 'swiper/css/pagination';
import Alpine from 'alpinejs';

// Start AlpineJS
window.Alpine = Alpine;
Alpine.start();


// init Swiper:
const swiper = new Swiper('.swiper', {
  // configure Swiper to use modules
  modules: [Navigation, Pagination, Autoplay],
  speed: 1200,
  loop: true,

  autoplay: {
    delay: 4500,
    disableOnInteraction: false,
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

});
