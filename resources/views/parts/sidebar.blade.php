<div class="sidebar-menu">
	<ul class="menu">
		@php
			use Illuminate\Support\Facades\Route;

			$menus = collect(session('menus'));
			$route = Route::currentRouteName();
		@endphp
		@foreach ($menus->where('level', 0) as $item)
			@if($menus->where('parent_id', $item->id)->where('level', 1)->count() > 0)
				<li class="sidebar-title"><h6>{{ $item->menu }}</h6></li>
				<hr>
			@endif
			@foreach ($menus->where('parent_id', $item->id)->where('level', 1) as $menu)
				@if ($menus->where('parent_id', $item->id)->where('level', 2)->count() > 0)
					<li class="sidebar-item has-sub">
						<a href="#" class='sidebar-link'> <i class="bi bi-stack"></i> <span>{{ $menu->menu }}</span> </a>
						<ul class="submenu">
							@foreach ($menus->where('parent_id', $item->id)->where('level', 2) as $submenu)
								<li class="submenu-item">
									<a href="component-alert.html">{{ $submenu->menu }}</a>
								</li>
							@endforeach
						</ul>
					</li>
				@else
					<li class="sidebar-item {{ $menu->routing == $route ? 'active' : '' }}">
						<a href="{{ route($menu->routing) }}" class='sidebar-link'>
							<i class="fa {{ $menu->icon }}"></i> <span>{{ $menu->menu }}</span>
						</a>
					</li>
				@endif
			@endforeach
		@endforeach
	</ul>
</div>