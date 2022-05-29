<div class="main-sidebar">
<aside id="sidebar-wrapper">
	<div class="sidebar-brand">
		<a href="{{ url('/') }}">Mini POS</a>
	</div>
	<div class="sidebar-brand sidebar-brand-sm">
		<a href="{{ url('/') }}">M-POS</a>
	</div>
	<ul class="sidebar-menu">          
		<li class="nav-item dropdown">
			<a href="{{ url('/') }}" target="_blank" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>            
		</li>
		<li class="menu-header">Master</li>
		<li class="nav-item dropdown {{ set_active(['categories.index', 'products.index']) }}">
			<a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Master</span></a>
			<ul class="dropdown-menu">
				<li class="{{ set_active('categories.index') }}"><a class="nav-link" href="{{ route('categories.index') }}">Kategori</a></li>              
				<li class="{{ set_active('products.index') }}"><a class="nav-link" href="{{ route('products.index') }}">Produk</a></li>   								
			</ul>
		</li>          		        
	</ul>	
</aside>
</div>