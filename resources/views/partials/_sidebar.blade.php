<div id="sidebar-wrapper" class="bg-primary">
    <div class="simplebar-scroll-content">
        <div class="simplebar-content">
            <div class="brand-logo">
                <a href="#">
                    <img src="{{ asset('images/logos/logo2.png')}}" class="logo-icon mt-4" alt="logo icon"
                        width="150px">
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
                        <li> <a href="{{ route('admins.products.index') }}">{{ __('lang.products') }}</a> </li>
                        <li><a href="{{ route('admins.client-offers.index') }}">{{ __('lang.offers') }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();">
                        <span>{{ __('lang.users') }}</span>
                        <i class="fa fa-angle-left float-left"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admins.veterinarians.index') }}">{{ __('lang.veterinarians') }}</a></li>
                        <li><a href="{{ route('admins.drivers.index') }}">{{ __('lang.drivers') }}</a></li>
                        <li><a href="{{ route('admins.clients.index') }}">{{ __('lang.clients') }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();">
                        <span>{{ __('lang.reports') }}</span>
                        <i class="fa fa-angle-left float-left"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a
                                href="{{ route('admins.service-provider-report.index') }}">{{ __('lang.service_providers') }}</a>
                        </li>
                    </ul>
                </li>

                <li> <a href="{{ route('admins.invoices.index') }}">{{ __('lang.invoices') }}</a> </li>
                <li> <a href="{{ route('admins.animals.index') }}">{{ __('lang.animals') }}</a> </li>
                <li> <a href="{{ route('admins.sizes.index') }}">{{ __('lang.sizes') }}</a> </li>
                <li> <a href="{{ route('admins.durations.index') }}">{{ __('lang.durations') }}</a> </li>
                <li> <a href="{{ route('admins.cars.index') }}">{{ __('lang.cars') }}</a> </li>

                <li> <a href="{{ route('admins.suggestions.index') }}">{{ __('lang.suggestions') }}</a> </li>
                <li> <a href="{{ route('admins.admin-settings.index') }}">{{ __('lang.general_settings') }}</a> </li>
                <li> <a href="{{ route('admins.advertisements.index') }}">{{ __('lang.advertisements') }}</a> </li>
            </ul>
        </div>
    </div>
</div>
