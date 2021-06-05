<!-- this file for the error and success messages -->

@if (count($errors) > 0)
<!--this is an object, thats why we don't use:
     foreach ($errors as $error)
-->
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif