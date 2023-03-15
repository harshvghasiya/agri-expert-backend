<!doctype html>
<html lang="en">

@include('layouts.head')

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        @include('layouts.header')
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>

        @include('layouts.footer')
    </div>

    @include('layouts.theme-customizer')

    @include('layouts.javascript')
    @yield('script')
    @include('layouts.flashmessage')

</body>

</html>
