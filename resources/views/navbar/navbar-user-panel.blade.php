<style>
    .round{
        display: inline-block;
        vertical-align: middle;
        transform: translateZ(0);
        box-shadow: 0 0 1px rgba(0, 0, 0, 0);
        backface-visibility: hidden;
        -moz-osx-font-smoothing: grayscale;
        transition-duration: 0.3s;
        transition-property: transform;
    }
    .round:hover,
    .round:focus,
    .round:active {
        transform: scale(1.1);
    }
</style>
@if($user)
    <li class="dropdown dropdown-user nav-item">
        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
            <div class="user-nav d-sm-flex d-none">
                <span class="user-name text-bold-600">{{ $user->name }}</span>
                <span class="user-status"><i class="fa fa-circle text-success"></i> {{ trans('admin.online') }}</span>
            </div>
            <span>
            <img class="round" src="{{ $user->getAvatar() }}" alt="avatar" height="40" width="40" />
        </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ admin_url('auth/setting') }}" class="dropdown-item">
                <i class="feather icon-user"></i> {{ trans('admin.setting') }}
            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="{{ admin_url('auth/logout') }}">
                <i class="feather icon-power"></i> {{ trans('admin.logout') }}
            </a>
        </div>
    </li>
@endif
