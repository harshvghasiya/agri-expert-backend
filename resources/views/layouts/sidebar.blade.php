<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ uploadAndDownloadUrl() }}admin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{ trans('message.app_name') }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">{{ trans('message.dashboard') }}</div>
            </a>
        </li>

         @php
            if (\Route::is('admin.' . expertRouteName() . 'index') ||\Route::is('admin.' . expertRouteName() . 'view') || \Route::is('admin.' . expertRouteName() . 'create') || \Route::is('admin.' . expertRouteName() . 'edit')) {

                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp
        <li class="{{ $mainliclass }}">
            <a href="{{ route('admin.expert.index') }}" class="">
                <div class="parent-icon"> <i class="lni lni-users"></i>
                </div>
                <div class="menu-title">{{ trans('message.expert') }}</div>
            </a>
        </li>

        @php
            if (\Route::is('admin.' . farmerRouteName() . 'index') || \Route::is('admin.' . farmerRouteName() . 'create') || \Route::is('admin.' . farmerRouteName() . 'edit')) {

                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp
        <li class="{{ $mainliclass }}">
            <a href="{{ route('admin.farmer.index') }}" class="">
                <div class="parent-icon"> <i class="lni lni-network"></i>
                </div>
                <div class="menu-title">{{ trans('message.farmer') }}</div>
            </a>
        </li>

        @php
            if (\Route::is('admin.' . questionRouteName() . 'index') || \Route::is('admin.' . questionRouteName() . 'create') || \Route::is('admin.' . questionRouteName() . 'edit')) {

                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp
        <li class="{{ $mainliclass }}">
            <a href="{{ route('admin.question.index') }}" class="">
                <div class="parent-icon"> <i class="fadeIn animated bx bx-question-mark"></i>
                </div>
                <div class="menu-title">{{ trans('message.question') }}</div>
            </a>
        </li>

        @php
            if (\Route::is('admin.' . answerRouteName() . 'index') || \Route::is('admin.' . answerRouteName() . 'create') || \Route::is('admin.' . answerRouteName() . 'edit')) {

                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp
        <li class="{{ $mainliclass }}">
            <a href="{{ route('admin.answer.index') }}" class="">
                <div class="parent-icon"> <i class="fadeIn animated bx bx-message-rounded-check"></i>
                </div>
                <div class="menu-title">{{ trans('message.answer') }}</div>
            </a>
        </li>


        @php
            if (\Route::is('admin.' . cropRouteName() . 'index') || \Route::is('admin.' . cropRouteName() . 'create') || \Route::is('admin.' . cropRouteName() . 'view') || \Route::is('admin.' . cropRouteName() . 'edit') || \Route::is('admin.' . queryRouteName() . 'index') || \Route::is('admin.' . queryRouteName() . 'create') || \Route::is('admin.' . queryRouteName() . 'edit')) {
                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp

        <li class="{{ $mainliclass }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fadeIn animated bx bx-donate-blood"></i>
                </div>
                <div class="menu-title">{{ trans('message.crops') }}</div>
            </a>
            <ul class="{{ $ulclass }}">
                <li @if (\Route::is('admin.' . cropRouteName() . 'index') ||
                    \Route::is('admin.' . cropRouteName() . 'create') ||
                    \Route::is('admin.' . cropRouteName() . 'view') ||
                    \Route::is('admin.' . cropRouteName() . 'edit')) class="mm-active" @endif> <a
                        href="{{ route('admin.crop.index') }}"><i class="bx bx-right-arrow-alt"></i>
                        {{ trans('message.crop') }} </a> </li>
                <li @if (\Route::is('admin.' . queryRouteName() . 'index') ||
                    \Route::is('admin.' . queryRouteName() . 'create') ||
                    \Route::is('admin.' . queryRouteName() . 'edit')) class="mm-active" @endif> <a
                        href="{{ route('admin.query.index') }}"><i class="bx bx-right-arrow-alt"></i>
                        {{ trans('message.crop_query') }} </a> </li>
            </ul>
        </li>

        @php
            if (\Route::is('admin.' . schemeRouteName() . 'index') || \Route::is('admin.' . schemeRouteName() . 'create') || \Route::is('admin.' . schemeRouteName() . 'view') || \Route::is('admin.' . schemeRouteName() . 'edit')) {
                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp
        <li class="{{ $mainliclass }}">
            <a href="{{ route('admin.scheme.index') }}" class="">
                <div class="parent-icon"><i class="fadeIn animated bx bx-store-alt"></i>
                </div>
                <div class="menu-title">{{ trans('message.scheme') }}</div>
            </a>
        </li>

        @php
            if (\Route::is('admin.' . adminRouteName() . 'index') || \Route::is('admin.' . adminRouteName() . 'create') || \Route::is('admin.' . adminRouteName() . 'edit')) {

                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {
                $mainliclass = '';
                $ulclass = '';
            }
        @endphp
        <li class="{{ $mainliclass }}">
            <a href="{{ route('admin.admin_user.index') }}" class="">
                <div class="parent-icon"> <i class="fadeIn animated bx bx-user-check"></i>
                </div>
                <div class="menu-title">{{ trans('message.admin') }}</div>
            </a>
        </li>

        @php
            if (\Route::is('admin.' . basicSettingRouteName() . 'setting') || \Route::is('admin.' . basicSettingRouteName() . 'mail_config') || \Route::is('admin.' . emailTemplateRouteName() . 'index') || \Route::is('admin.' . emailTemplateRouteName() . 'create') ||
                \Route::is('admin.' . emailTemplateRouteName() . 'preview') || \Route::is('admin.' . emailTemplateRouteName() . 'edit')) {

                $mainliclass = 'mm-active';
                $ulclass = 'mm-show mm-collapse';
            } else {

                $mainliclass = '';
                $ulclass = '';
            }
        @endphp

        <li class="{{ $mainliclass }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cookie"></i>
                </div>
                <div class="menu-title">{{ trans('message.general_setting') }}</div>
            </a>
            <ul class="{{ $ulclass }}">
                <li> <a href="{{ route('admin.basic_setting.setting') }}"><i class="bx bx-right-arrow-alt"></i>
                        {{ trans('message.basic_setting') }} </a> </li>
                <li> <a href="{{ route('admin.basic_setting.mail_config') }}"><i class="bx bx-right-arrow-alt"></i>
                        {{ trans('message.mail_config') }} </a> </li>

                <li @if (\Route::is('admin.' . emailTemplateRouteName() . 'index') ||
                    \Route::is('admin.' . emailTemplateRouteName() . 'create') ||
                    \Route::is('admin.' . emailTemplateRouteName() . 'preview') ||
                    \Route::is('admin.' . emailTemplateRouteName() . 'edit')) class="mm-active" @endif> <a
                        href="{{ route('admin.email_template.index') }}"><i class="bx bx-right-arrow-alt"></i>
                        {{ trans('message.email_template') }} </a> </li>
            </ul>
        </li>

        

    </ul>
</div>
