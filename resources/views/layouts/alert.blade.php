@push('css')
    <style>
      .alert {
        z-index: 999;
        text-align: center;
        padding: 10px;
      }
    </style>
@endpush

@if($message = session('success'))
<div class="alert bg-green-100 text-green-600 p-3 rounded-none w-full fixed top-0">
{{ $message }}
</div>
@endif

@if($message = session('info'))
<div class="alert bg-yellow-100 text-yellow-600 p-3 rounded-none w-full fixed top-0">
{{ $message }}
</div>
@endif

@if($message = session('error'))
<div class="alert bg-red-100 text-red-600 p-3 rounded-none w-full fixed top-0">
{{ $message }}
</div>
@endif

@push('js')
<script>
    window.setTimeout(function() {
      $(".alert").fadeTo(200, 0).slideUp(200, function(){
        $(this).remove(); 
      });
    }, 3000);
  </script>
@endpush