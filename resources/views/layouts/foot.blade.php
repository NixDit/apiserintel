        <!--begin::Javascript-->
        <!--begin::Theme mode setup on page load-->
		<script>
            if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }
        </script>
		<!--end::Theme mode setup on page load-->
		<script>var HOST_URL = "{{ url('/') }}";</script>
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
                    'baseUrl' 	=> url('/')
            ]) !!}
        </script>
        <script src="{{ asset('js/app.js?v='.rand())}}"></script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js?v='.rand()) }}"></script>
		<script src="{{ asset('metronic/assets/js/scripts.bundle.js?v='.rand()) }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used by this page)-->
		<script src="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v='.rand()) }}"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js?v='.rand()) }}"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used by this page)-->
		<script src="{{ asset('metronic/assets/js/widgets.bundle.js?v='.rand()) }}"></script>
		<script src="{{ asset('metronic/assets/js/custom/widgets.js?v='.rand()) }}"></script>
		<script src="{{ asset('metronic/assets/js/custom/apps/chat/chat.js?v='.rand()) }}"></script>
		<script src="{{ asset('metronic/assets/js/custom/utilities/modals/upgrade-plan.js?v='.rand()) }}"></script>
		<script src="{{ asset('metronic/assets/js/custom/utilities/modals/create-app.js?v='.rand()) }}"></script>
		<script src="{{ asset('metronic/assets/js/custom/utilities/modals/users-search.js?v='.rand()) }}"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>