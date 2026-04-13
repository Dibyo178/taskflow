<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskFlow – @yield('title', 'Task Manager')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:         #0d0f14;
            --bg-card:    #13161e;
            --bg-hover:   #1a1e2a;
            --border:     #232736;
            --border-hi:  #2e3347;
            --accent:     #6c63ff;
            --accent-2:   #ff6584;
            --accent-3:   #43e8b0;
            --text:       #e8eaf0;
            --muted:      #6b7280;
            --muted-2:    #9ca3af;
            --pending:    #f59e0b;
            --progress:   #6c63ff;
            --done:       #43e8b0;
            --high:       #ff6584;
            --medium:     #f59e0b;
            --low:        #43e8b0;
            --radius:     12px;
            --radius-sm:  6px;
            --shadow:     0 4px 24px rgba(0,0,0,.45);
        }
        html { scroll-behavior: smooth; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            min-height: 100vh;
        }
        .layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 240px; background: var(--bg-card);
            border-right: 1px solid var(--border);
            padding: 28px 0; display: flex; flex-direction: column;
            position: sticky; top: 0; height: 100vh; flex-shrink: 0;
        }
        .sidebar-logo { padding: 0 24px 28px; border-bottom: 1px solid var(--border); }
        .logo-mark {
            font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .logo-sub { font-size: 11px; color: var(--muted); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 2px; }
        .sidebar-nav { padding: 20px 12px; flex: 1; }
        .nav-label { font-size: 10px; letter-spacing: 1.8px; text-transform: uppercase; color: var(--muted); padding: 0 12px; margin-bottom: 8px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: var(--radius-sm);
            color: var(--muted-2); text-decoration: none;
            font-size: 14px; font-weight: 500; transition: all .18s ease; margin-bottom: 2px;
        }
        .nav-item:hover, .nav-item.active { background: var(--bg-hover); color: var(--text); }
        .nav-item.active { color: var(--accent); }
        .nav-icon { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-footer { padding: 20px 24px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); }

        /* Main */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .topbar {
            background: var(--bg-card); border-bottom: 1px solid var(--border);
            padding: 16px 32px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .topbar-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; }
        .topbar-actions { display: flex; gap: 10px; align-items: center; }
        .content { padding: 32px; flex: 1; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500;
            cursor: pointer; border: none; text-decoration: none;
            transition: all .18s ease; white-space: nowrap;
        }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #7b74ff; box-shadow: 0 0 20px rgba(108,99,255,.35); transform: translateY(-1px); }
        .btn-ghost { background: transparent; color: var(--muted-2); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg-hover); color: var(--text); }
        .btn-danger { background: rgba(255,101,132,.12); color: var(--accent-2); border: 1px solid rgba(255,101,132,.25); }
        .btn-danger:hover { background: rgba(255,101,132,.22); }
        .btn-sm { padding: 6px 12px; font-size: 13px; }

        /* Cards */
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); }
        .card:hover { border-color: var(--border-hi); }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; letter-spacing: .4px; text-transform: uppercase; }
        .badge-pending     { background: rgba(245,158,11,.14); color: var(--pending); }
        .badge-in-progress { background: rgba(108,99,255,.14); color: var(--progress); }
        .badge-completed   { background: rgba(67,232,176,.14);  color: var(--done); }
        .priority-high     { background: rgba(255,101,132,.14); color: var(--high); }
        .priority-medium   { background: rgba(245,158,11,.14);  color: var(--medium); }
        .priority-low      { background: rgba(67,232,176,.14);  color: var(--low); }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 500; color: var(--muted-2); }
        .form-control {
            width: 100%; background: var(--bg); border: 1px solid var(--border);
            border-radius: var(--radius-sm); color: var(--text); padding: 10px 14px;
            font-family: 'DM Sans', sans-serif; font-size: 14px; transition: border-color .18s; outline: none;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(108,99,255,.12); }
        .form-control::placeholder { color: var(--muted); }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-error { font-size: 12px; color: var(--accent-2); margin-top: 5px; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: rgba(67,232,176,.1); border: 1px solid rgba(67,232,176,.3); color: var(--done); }
        .alert-error   { background: rgba(255,101,132,.1); border: 1px solid rgba(255,101,132,.3); color: var(--accent-2); }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; position: relative; overflow: hidden; transition: transform .18s, border-color .18s; }
        .stat-card:hover { transform: translateY(-2px); border-color: var(--border-hi); }
        .stat-card::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
        .stat-card.total::after    { background: linear-gradient(90deg, var(--accent), var(--accent-2)); }
        .stat-card.pending::after  { background: var(--pending); }
        .stat-card.progress::after { background: var(--progress); }
        .stat-card.done::after     { background: var(--done); }
        .stat-card.overdue::after  { background: var(--accent-2); }
        .stat-value { font-family: 'Syne', sans-serif; font-size: 32px; font-weight: 800; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; }

        /* Task grid */
        .tasks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
        .task-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; display: flex; flex-direction: column; gap: 12px; transition: transform .18s, border-color .18s, box-shadow .18s; }
        .task-card:hover { transform: translateY(-3px); border-color: var(--border-hi); box-shadow: var(--shadow); }
        .task-card-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
        .task-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; line-height: 1.3; flex: 1; text-decoration: none; color: var(--text); transition: color .15s; }
        .task-title:hover { color: var(--accent); }
        .task-desc { font-size: 13px; color: var(--muted-2); line-height: 1.5; flex: 1; }
        .task-meta { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        .task-footer { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 12px; }
        .task-date { font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 5px; }
        .task-date.overdue { color: var(--accent-2); }
        .task-actions { display: flex; gap: 6px; }

        /* Filter bar */
        .filter-bar { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
        .filter-bar form { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; flex: 1; }

        /* Pagination */
        .pagination { display: flex; gap: 6px; justify-content: center; margin-top: 32px; }
        .page-link { padding: 7px 13px; border-radius: var(--radius-sm); background: var(--bg-card); border: 1px solid var(--border); color: var(--muted-2); text-decoration: none; font-size: 14px; transition: all .15s; }
        .page-link:hover, .page-link.active { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* Empty state */
        .empty-state { text-align: center; padding: 64px 32px; }
        .empty-icon  { font-size: 48px; margin-bottom: 16px; }
        .empty-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; margin-bottom: 8px; }
        .empty-desc  { color: var(--muted); font-size: 14px; margin-bottom: 24px; }

        /* Detail */
        .detail-grid    { display: grid; grid-template-columns: 1fr 280px; gap: 24px; }
        .detail-body    { padding: 28px; border-right: 1px solid var(--border); }
        .detail-sidebar { padding: 24px; display: flex; flex-direction: column; gap: 20px; }
        .detail-label   { font-size: 11px; letter-spacing: 1.2px; text-transform: uppercase; color: var(--muted); margin-bottom: 6px; }

        /* Animations */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp .3s ease forwards; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .content { padding: 20px 16px; }
            .topbar  { padding: 14px 16px; }
            .tasks-grid  { grid-template-columns: 1fr; }
            .stats-grid  { grid-template-columns: repeat(2, 1fr); }
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-mark">TaskFlow</div>
            <div class="logo-sub">Task Manager</div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Navigation</div>
            <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.index') && !request('status') ? 'active' : '' }}">
                <span class="nav-icon">◈</span> All Tasks
            </a>
            <a href="{{ route('tasks.index', ['status' => 'pending']) }}" class="nav-item {{ request('status') === 'pending' ? 'active' : '' }}">
                <span class="nav-icon">○</span> Pending
            </a>
            <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}" class="nav-item {{ request('status') === 'in_progress' ? 'active' : '' }}">
                <span class="nav-icon">◑</span> In Progress
            </a>
            <a href="{{ route('tasks.index', ['status' => 'completed']) }}" class="nav-item {{ request('status') === 'completed' ? 'active' : '' }}">
                <span class="nav-icon">●</span> Completed
            </a>
            <div class="nav-label" style="margin-top:20px">Actions</div>
            <a href="{{ route('tasks.create') }}" class="nav-item">
                <span class="nav-icon">＋</span> New Task
            </a>
        </nav>

    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-title">@yield('page-title', 'Tasks')</div>
            <div class="topbar-actions">
                @yield('topbar-actions')
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">＋ New Task</a>
            </div>
        </header>
        <main class="content">
            @if(session('success'))
                <div class="alert alert-success fade-up">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error fade-up">✕ {{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 3500);
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', e => {
            if (!confirm(btn.dataset.confirm)) e.preventDefault();
        });
    });
</script>
@stack('scripts')
</body>
</html>
