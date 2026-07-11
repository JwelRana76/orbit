<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            @if (setting()->logo)
                <img src="/upload/{{ setting()->logo }}" alt="" width="80px">    
            @endif
            <img src="/upload/default.png" alt="" width="80px">
        </div>
        <div class="sidebar-brand-text">{{ setting()->name_short }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{Request::is('pathology*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#pathology"
            aria-expanded="true" aria-controls="pathology">
            <i class="fas fa-fw fa-home"></i>
            <span>Pathology</span>
        </a>
        <div id="pathology" class="collapse {{Request::is('pathology*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('pathology/test*')?'active':''}}" href="{{route('test.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Test</a>
                <a class="collapse-item {{Request::is('pathology/patient/create')?'active':''}}" href="{{route('pathology.patient.create')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Add Patient</a>
                <a class="collapse-item {{Request::is('pathology/patient')?'active':''}}" href="{{route('pathology.patient.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Patient</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Request::is('admission*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#admission"
            aria-expanded="true" aria-controls="admission">
            <i class="fas fa-fw fa-home"></i>
            <span>Admission</span>
        </a>
        <div id="admission" class="collapse {{Request::is('admission*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('admission/patient/create')?'active':''}}" href="{{route('admission.patient.create')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Add Patient</a>
                <a class="collapse-item {{Request::is('admission/patient')?'active':''}}" href="{{route('admission.patient.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Patient</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Request::is('lens*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#lens"
            aria-expanded="true" aria-controls="lens">
            <i class="fas fa-fw fa-home"></i>
            <span>Lens</span>
        </a>
        <div id="lens" class="collapse {{Request::is('lens*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('lens/index*')?'active':''}}" href="{{route('lens.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i>Lens List</a>
                <a class="collapse-item {{Request::is('lens/supplier*')?'active':''}}" href="{{route('lens.supplier.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Supplier</a>
                <a class="collapse-item {{Request::is('lens/purchase')?'active':''}}" href="{{route('lens.purchase.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Purchase List</a>
                <a class="collapse-item {{Request::is('lens/purchase/create')?'active':''}}" href="{{route('lens.purchase.create')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Purchase Create</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Request::is('hrm*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#hrm"
            aria-expanded="true" aria-controls="hrm">
            <i class="fas fa-fw fa-home"></i>
            <span>HRM</span>
        </a>
        <div id="hrm" class="collapse {{Request::is('hrm*')?'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('hrm/department*')?'active':''}}" href="{{route('department.index')}}"><i class="fas fa-fw fa-arrow-right mr-2"></i> Department</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{Request::is('setting*')?'':'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Setting</span>
        </a>
        <div id="collapsePages" class="collapse {{Request::is('setting*')?'show':''}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('setting/doctor*')?'active':''}}" href="{{ route('doctor.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Doctor</a>
                <a class="collapse-item {{Request::is('setting/bed*')?'active':''}}" href="{{ route('bed.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Bed</a>
                <a class="collapse-item {{Request::is('setting/division*')?'active':''}}" href="{{ route('division.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Division</a>
                <a class="collapse-item {{Request::is('setting/district*')?'active':''}}" href="{{ route('district.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>District</a>
                <a class="collapse-item {{Request::is('setting/upazila*')?'active':''}}" href="{{ route('upazila.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Upazila</a>
                <a class="collapse-item {{Request::is('setting/blood_group*')?'active':''}}" href="{{ route('blood_group.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Blood Group</a>
                <a class="collapse-item {{Request::is('setting/gender*')?'active':''}}" href="{{ route('gender.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Gender</a>
                <a class="collapse-item {{Request::is('setting/religion*')?'active':''}}" href="{{ route('religion.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Religion</a>
                <a class="collapse-item {{Request::is('setting/role')?'active':''}}" href="{{ route('role.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Role</a>
                <a class="collapse-item {{Request::is('setting/user')?'active':''}}" href="{{ route('user.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>User</a>
                <a class="collapse-item {{Request::is('setting/site_setting')?'active':''}}" href="{{ route('site_setting.index') }}"> <i class="fas fa-fw fa-arrow-right mr-2"></i>Site Setting</a>
            </div>
        </div>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->