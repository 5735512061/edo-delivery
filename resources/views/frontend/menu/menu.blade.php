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
{{-- <iframe id="desktop" style="width:100%;height:720px;" src="https://drive.google.com/file/d/19OYBVksA82QHyIqG3_oEVzO07DPYLkj9/view?usp=sharing"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe> --}}
{{-- <iframe id="mobile" style="display: none; width:100%;height:720px;" src="https://drive.google.com/file/d/19OYBVksA82QHyIqG3_oEVzO07DPYLkj9/view?usp=sharing"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe> --}}

<iframe id="desktop" src="https://drive.google.com/file/d/1QY6Q7Tc1uXVKvUX_CJITi2seXUb5-_2Z/preview" style="width:100%;height:1200px;" allow="autoplay"></iframe>
<iframe id="mobile" src="https://drive.google.com/file/d/1QY6Q7Tc1uXVKvUX_CJITi2seXUb5-_2Z/preview" style="display: none; width:100%;height:1200px;" allow="autoplay"></iframe>

@endsection
