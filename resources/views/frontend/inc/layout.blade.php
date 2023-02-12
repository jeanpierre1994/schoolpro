<!--
Author: W3layouts
Author URL: http://w3layouts.com
-->
<!doctype html>
<html lang="en">

  <!-- inc head -->
  @include('frontend.inc.head')
  <!-- end head -->

  <body>

<!-- Top Menu 1 -->
@include('frontend.inc.top_menu')
<!-- end Top Menu 1 -->

@yield("main-slide") 

<!-- inc flash-alert -->
@include('flash-message')
@include('sweetalert::alert')

<!-- end inc flash-alert -->


@yield("contenu")

<!-- footer -->
@include('frontend.inc.footer')
<!-- end footer -->

<script src="{{ asset("frontpage/assets/js/jquery-3.3.1.min.js") }}"></script>
<!-- //footer-28 block -->
</section>

<!-- script -->
@include('frontend.inc.jsfile')
<!-- //script -->

@yield("js-script")


</body>

</html>
<!-- // grids block 5 -->