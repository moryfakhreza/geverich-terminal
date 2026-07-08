<!-- TOP BAR -->
<header class="topbar">

    <div class="logo">
        GEVERICH TERMINAL
    </div>

    <div class="topbar-right">

        <div id="todayDate"></div>

        <div id="clock"></div>

    </div>

</header>

<nav class="navbar">

    <a href="?page=dashboard">Dashboard</a>

    <a href="?page=journal">Journal</a>

    <a href="?page=analytics">Analytics</a>

    <a href="?page=calendar">Calendar</a>
    <a href="?page=news">News</a>
    <a href="?page=heatmap">Heatmap</a>
    <a href="index.php?page=ai">AI Assistant</a>
    <?php if (isLoggedIn()): ?>

        <a href="index.php?page=logout" class="nav-logout">
            Logout
        </a>


    <?php endif; ?>

</nav>