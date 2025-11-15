<div class="admin-header"
    style="display: flex; justify-content: space-between; align-items: center;">
    <div class="admin-brand">
        <img src="{{ asset('media/anm-logo.png') }}" alt="Admin Logo" width="40" height="auto">
    </div>
    <div class="admin-actions">
        <form action="{{ route('logout') }}" method="POST">@csrf<button class="logout-button">Logout</button></form>
    </div>
</div>
