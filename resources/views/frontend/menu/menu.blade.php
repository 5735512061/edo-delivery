@extends("/frontend/layouts/template/template")
<style>
@media only screen and (max-width: 768px) {
    #mobile {
      display: inline !important;
      margin-top: -6em !important;
    }
    #desktop {
      display: none;
    }
}
</style>
@section("content")
<iframe id="desktop" style="width:100%;height:720px;" src="https://online.anyflip.com/wrrot/ydtn/index.html"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe>
<iframe id="mobile" style="display: none; width:100%;height:720px;" src="https://online.anyflip.com/wrrot/ydtn/index.html"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe>
@endsection
