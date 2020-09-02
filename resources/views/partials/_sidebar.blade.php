<div id="sidebar-wrapper" class="bg-primary">
  <div class="simplebar-scroll-content">
    <div class="simplebar-content">
      <div class="brand-logo">
        <a href="#">
          <img src="{{ asset('images/logos/logo2.png')}}" class="logo-icon mt-4" alt="logo icon" width="150px">
        </a>
      </div>
      <ul class="sidebar-menu mt-4">
        <li class="sidebar-header">{{ __('lang.menu') }}</li>
        <li>
          <a href="javaScript:void();">
           <span>{{ __('lang.veterinary') }}</span>
            <i class="fa fa-angle-left float-left"></i>
          </a>
          <ul class="sidebar-submenu">
            <li><a href="{{ route('admins.vet-requests.index') }}">{{ __('lang.requests') }}</a></li>
            <li><a href="{{ route('admins.vet-offers.index') }}">{{ __('lang.offers') }}</a></li>
          </ul>
        </li>
        <li>
          <a href="javaScript:void();">
           <span>{{ __('lang.delivery') }}</span>
            <i class="fa fa-angle-left float-left"></i>
          </a>
          <ul class="sidebar-submenu">
            <li><a href="{{ route('admins.driver-requests.index') }}">{{ __('lang.requests') }}</a></li>
            <li><a href="{{ route('admins.driver-offers.index') }}">{{ __('lang.offers') }}</a></li>
          </ul>
        </li>
        <li>
          <a href="javaScript:void();">
           <span>{{ __('lang.products') }}</span>
            <i class="fa fa-angle-left float-left"></i>
          </a>
          <ul class="sidebar-submenu">
            <li><a href="{{ route('admins.home.index') }}">{{ __('lang.products') }}</a></li>
            <li><a href="{{ route('admins.home.index') }}">{{ __('lang.offers') }}</a></li>
          </ul>
        </li>


        <li> <a href="{{ route('admins.time-slots.index') }}">{{ __('lang.time_slots') }}</a> </li>
        <li> <a href="{{ route('admins.admin-settings.index') }}">{{ __('lang.general_settings') }}</a> </li>
      </ul>
    </div>
  </div>
</div>