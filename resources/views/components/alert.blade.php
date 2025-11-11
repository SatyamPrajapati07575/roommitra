<!-- Modern Alert Component -->
@if(session('success'))
    <div class="alert alert-modern alert-success" role="alert">
        <div class="alert-icon">
            <i class='bx bx-check-circle'></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">Success!</h4>
            <p class="alert-message">{{ session('success') }}</p>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class='bx bx-x'></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-modern alert-danger" role="alert">
        <div class="alert-icon">
            <i class='bx bx-error-circle'></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">Error!</h4>
            <p class="alert-message">{{ session('error') }}</p>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class='bx bx-x'></i>
        </button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-modern alert-warning" role="alert">
        <div class="alert-icon">
            <i class='bx bx-error'></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">Warning!</h4>
            <p class="alert-message">{{ session('warning') }}</p>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class='bx bx-x'></i>
        </button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-modern alert-info" role="alert">
        <div class="alert-icon">
            <i class='bx bx-info-circle'></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">Info!</h4>
            <p class="alert-message">{{ session('info') }}</p>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class='bx bx-x'></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-modern alert-danger" role="alert">
        <div class="alert-icon">
            <i class='bx bx-error-circle'></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title">Please fix the following errors:</h4>
            <ul class="alert-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class='bx bx-x'></i>
        </button>
    </div>
@endif

<script>
// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-modern');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>
