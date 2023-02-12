<section class="w3l-footer-29-main">
    <div class="footer-29">
        <div class="container">
            <div class="d-grid grid-col-4 footer-top-29">
                <div class="footer-list-29 footer-1">
                    <h6 class="footer-title-29">Contact Us</h6>
                    <ul>
                        <li><p><span class="fa fa-map-marker"></span> {{$etablissement->sigle ? $etablissement->sigle : ''}}</p></li>
                        <li><a href="#"><span class="fa fa-phone"></span> +(229) {{$etablissement->telephone ? $etablissement->telephone : '97000000'}}</a></li>
                        <li><a href="mailto:{{$etablissement->email ? $etablissement->email : 'info@mail.com'}}" class="mail"><span class="fa fa-envelope-open-o"></span> {{$etablissement->email ? $etablissement->email : 'info@mail.com'}}</a></li>
                    </ul>
                    <div class="main-social-footer-29">
                        <a href="#facebook" class="facebook"><span class="fa fa-facebook"></span></a>
                        <a href="#twitter" class="twitter"><span class="fa fa-twitter"></span></a>
                        <a href="#instagram" class="instagram"><span class="fa fa-instagram"></span></a>
                        <a href="#google-plus" class="google-plus"><span class="fa fa-google-plus"></span></a>
                        <a href="#linkedin" class="linkedin"><span class="fa fa-linkedin"></span></a>
                    </div>
                </div>
                <div class="footer-list-29 footer-2">
                    <ul>
                        <h6 class="footer-title-29">Liens</h6>
                        <li><a href="#">Evenemment</a></li>
                        <li><a href="#">Calendrie</a></li> 
                    </ul>
                </div>
                <div class="footer-list-29 footer-3">
                   
                    <h6 class="footer-title-29">Newsletter </h6>
            <form action="#" class="subscribe" method="post">
              <input type="email" name="email" placeholder="Email" required="">
              <button><span class="fa fa-envelope-o"></span></button>
            </form>
            <p></p>
            <p></p>
          
                </div>
                <div class="footer-list-29 footer-4">
                    <ul>
                        <h6 class="footer-title-29">Lien utile</h6>
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">A propos</a></li>
                        <li><a href="#">FAQ</a></li> 
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="d-grid grid-col-2 bottom-copies">
                <p class="copy-footer-29">© 2022 - {{date('Y')}} {{$etablissement->sigle ? $etablissement->sigle : 'School Pro'}}. All rights reserved | Designed by <a href="#">- - -</a></p>
                 <ul class="list-btm-29">
                        <li><a href="#link"></a></li>
                        <li><a href="#link"></a></li>                        
                  </ul>
            </div>
        </div>
    </div>
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
      <span class="fa fa-angle-up"></span>
    </button>
    <script>
      // When the user scrolls down 20px from the top of the document, show the button
      window.onscroll = function () {
        scrollFunction()
      };
  
      function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          document.getElementById("movetop").style.display = "block";
        } else {
          document.getElementById("movetop").style.display = "none";
        }
      }
  
      // When the user clicks on the button, scroll to the top of the document
      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
    <!-- /move top -->
  </section>