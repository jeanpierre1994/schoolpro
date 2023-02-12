
<section class="w3l-main-slider" id="home">
    <!-- main-slider -->
    <div class="companies20-content">
     
      <div class="owl-one owl-carousel owl-theme">
        <div class="item">
          <li>
            <div class="slider-info banner-view bg bg2" data-selector=".bg.bg2">
              <div class="banner-info">
                <div class="container">
                  <div class="banner-info-bg mx-auto text-center">
                    <h5>School Pro</h5>
                   <a class="btn btn-secondary btn-theme2 mt-md-5 mt-4" href="{{route('inscription')}}">Inscription</a>
                  </div>                  
                </div>
              </div>
            </div>
          </li>
        </div> 
      </div>
    </div>
  
  </div>
  
  
    <script src="{{ asset("frontpage/assets/js/owl.carousel.js") }}"></script>
    <!-- script for -->
    <script>
      $(document).ready(function () {
        $('.owl-one').owlCarousel({
          loop: true,
          margin: 0,
          nav: false,
          responsiveClass: true,
          autoplay: false,
          autoplayTimeout: 5000,
          autoplaySpeed: 1000,
          autoplayHoverPause: false,
          responsive: {
            0: {
              items: 1,
              nav: false
            },
            480: {
              items: 1,
              nav: false
            },
            667: {
              items: 1,
              nav: true
            },
            1000: {
              items: 1,
              nav: true
            }
          }
        })
      })
    </script>
    <!-- //script -->
    <!-- /main-slider -->
  </section>