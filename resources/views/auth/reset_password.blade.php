@extends('auth.auth')
@section('title')
    {{ trans('message.reset_password') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center">
                    <h3 class="">{{ trans('message.reset_password') }}</h3>

                </div>

                <div class="form-body">
                    {{ Form::open([
                        'id' => 'resetPassword',
                        'class' => 'FromSubmit row g-3',
                        'url' => route('admin.update_password', $user->forgot_password_token),
                        'enctype' => 'multipart/form-data',
                    ]) }}
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">{{ trans('message.new_password_label') }}</label>
                        <input type="text" name="password" class="form-control password" id="inputEmailAddress"
                            placeholder="{{ trans('message.new_password_label') }}">
                        <span class="text-danger error_form" id="password_error"></span>

                        <div class="form-group mt-2">
                            <button type="button"
                                class="btn btn-info text-light genrate_password">{{ trans('message.generate_password') }}</button>
                        </div>
                    </div>
                     <div class="col-md-12 text-end"> <a
                            href="{{ route('admin.login') }}">{{ trans('message.login_here') }}</a>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i
                                    class="bx bxs-lock-open"></i>{{ trans('message.reset_password') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.genrate_password').on('click', function(event) {
                event.preventDefault();
                cap = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
                nonal = "$%!#"
                it = "1234567890"
                randnum = Math.ceil(Math.random() * 8)
                non_alpha = Math.ceil(Math.random() * 2)
                var password = Math.random().toString(36).slice(-6) + cap.toString(2).slice(randnum,
                        randnum + 1) + nonal.toString(4).slice(non_alpha, non_alpha + 1) + it.toString(1)
                    .slice(randnum, randnum + 1)
                $('.password').attr('type', 'text');
                $('.password').val(password);
            });

        });
    </script>
@endsection
