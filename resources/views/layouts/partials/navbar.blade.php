<nav class="navbar navbar-expand px-3 border-bottom">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-text ps-5">
        <span id="current-date"></span>
        <span id="current-time"></span>
    </div>

    <div class="navbar-collapse navbar">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                    <img src="{{ asset('image/profile.jpg') }}" class="avatar img-fluid rounded" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Setting</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>


    <script>
        // JavaScript code to update date and time
        function updateDateTime() {
            const currentDateTime = new Date();
            const formattedDate = currentDateTime.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric', });
            const formattedTime = currentDateTime.toLocaleTimeString();

            document.getElementById('current-date').innerHTML = `<span class="text-primary">${formattedDate}</span>, `;
            document.getElementById('current-time').innerHTML = `<span class="text-success">${formattedTime}</span>`;

        }

        // Update date and time every second
        setInterval(updateDateTime, 1000);

        // Initial update
        updateDateTime();
    </script>
</nav>


