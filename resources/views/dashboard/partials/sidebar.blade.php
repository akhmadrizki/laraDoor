<section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
        <li class="{{ Request::route()->getName() == 'admin.index' ? 'active' : null }}">
            <a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>
</section>