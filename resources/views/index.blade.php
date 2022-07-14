<!--begin::Head-->
@include('layouts.head')
<!--end::head-->
<!--begin::Main-->
<!--begin::Root-->
@yield('root')
<!--end::Root-->
<!--begin::Drawers-->
<!--begin::Activities drawer-->
@include('layouts.includes.activities')
<!--end::Activities drawer-->
<!--begin::Chat drawer-->
@include('layouts.includes.chat')
<!--end::Chat drawer-->
<!--end::Drawers-->
<!--end::Main-->
<!--begin::Engage drawers-->
<!--begin::Demos drawer-->
@include('layouts.includes.demos')
<!--end::Demos drawer-->
<!--begin::Help drawer-->
@include('layouts.includes.help')
<!--end::Help drawer-->
<!--end::Engage drawers-->
<!--begin::Engage toolbar-->
@include('layouts.includes.engage')
<!--end::Engage toolbar-->
<!--begin::Scrolltop-->
@include('layouts.includes.scrolltop')
<!--end::Scrolltop-->
<!--begin::Modals-->
<!--begin::Modal - Upgrade plan-->
@include('layouts.includes.upgrade_plan')
<!--end::Modal - Upgrade plan-->
<!--begin::Modal - Create App-->
@include('layouts.includes.create_app')
<!--end::Modal - Create App-->
<!--begin::Modal - View Users-->
@include('layouts.includes.view_users')
<!--end::Modal - View Users-->
<!--begin::Modal - Users Search-->
@include('layouts.includes.users_search')
<!--end::Modal - Users Search-->
<!--begin::Modal - Invite Friends-->
@include('layouts.includes.invite_friends')
<!--end::Modal - Invite Friend-->
<!--end::Modals-->
<!--begin::Foot-->
@include('layouts.foot')
<!--end::Foot-->