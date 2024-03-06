<aside id="sidebar" class="js-sidebar">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo">
            <a href="#"><i class="fa-solid fa-person-booth pe-2"></i>VU Services</a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Admin Elements
            </li>
            <li class="sidebar-item">
                <a href="/" class="sidebar-link">
                    <i class="fa-solid fa-house pe-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-users pe-2"></i>
                    Student
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('students.create') }}" class="sidebar-link">Add Student</a>
                    </li>
                    <li class="sidebar-item">
                        {{-- <a href="{{ route('students.studentlist') }}" class="sidebar-link">Student List</a> --}}
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('search-student') }}" class="sidebar-link">Student List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('search-department.index') }}" class="sidebar-link">Search Department</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('trackrecord') }}" class="sidebar-link">Track Records</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#posts" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-money-bill-wave pe-2"></i>
                    Payment
                </a>
                <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    {{-- <li class="sidebar-item">
                        <a href="{{ route('money.add') }}" class="sidebar-link">Add Money</a>
                    </li> --}}
                    <li class="sidebar-item">
                        <a href="{{ route('searchaddmoney.search') }}" class="sidebar-link">Add Money</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('payment.show') }}" class="sidebar-link">Payment</a>
                    </li>
                    <li class="sidebar-item">
                        <a href= "{{ route('generatereport') }}" class="sidebar-link">Generate Report</a>
                    </li>
                </ul>
            </li>


            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#services" data-bs-toggle="collapse"
                    aria-expanded="false">
                    <i class="fa-solid fa-store pe-2"></i> Services
                </a>
                <ul id="services" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('services.list') }}" class="sidebar-link">Service List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('services.create') }}" class="sidebar-link">Add Service</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('searchpayservice.search') }}" class="sidebar-link">Pay for Service</a>
                    </li>
                </ul>
            </li>


            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#auth" data-bs-toggle="collapse"
                    aria-expanded="false">
                    <i class="fa-solid fa-circle-user pe-2"></i>
                    Auth
                </a>

                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">

                    @guest

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Forgot Password</a>
                        </li>
                    @endguest

                    @auth
                        <li class="sidebar-item">
                            <span>{{ auth()->user()->name }}</span>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('login.perform') }}" class="sidebar-link">Login</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('logout.perform') }}" class="sidebar-link">Logout</a>
                        </li>
                    @endauth

                </ul>
            </li>


            </li>
            <li class="sidebar-header">
                Bulletin Board News
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#multi" data-bs-toggle="collapse"
                    aria-expanded="false"><i class="fa-solid fa-newspaper pe-2"></i>
                    Recent News
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#level-1"
                            data-bs-toggle="collapse" aria-expanded="false">Level 1</a>
                        <ul id="level-1" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Programming Club</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Office Notices</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
