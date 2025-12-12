<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">
    <title>Petshop Lala - Your Trusted Pet Care Partner</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; padding-top: 50px; background: #f9f9f9; }

        /* Navigation */
        nav { position: fixed; top: 0; width: 100%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; padding: 5px 0; }
        .nav-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; gap: 30px; }
        .logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; text-decoration: none; }
        .logo img { width: 32px; height: 32px; object-fit: contain; }
        .logo span { font-weight: 900; color: #FF8C42; font-size: 1.2em; white-space: nowrap; }

        .nav-links { display: flex; gap: 35px; list-style: none; align-items: center; flex-grow: 1; justify-content: center; }
        .nav-links a { text-decoration: none; color: #333; font-size: 1.15em; letter-spacing: 0.3px; transition: color 0.3s, transform 0.3s; cursor: pointer; white-space: nowrap; padding: 6px 10px; border-radius: 8px; }
        .nav-links a:hover, .nav-links a.active { color: #FF8C42; background: rgba(255, 140, 66, 0.1); transform: translateY(-2px); }

        .nav-right { display: flex; align-items: center; gap: 18px; flex-shrink: 0; }
        .cart-icon { position: relative; cursor: pointer; }
        .cart-icon svg { width: 26px; height: 26px; transition: transform 0.3s; color: #333; }
        .cart-icon:hover svg { transform: scale(1.1); color: #FF8C42; }
        .cart-badge { position: absolute; top: -6px; right: -6px; background: #FF8C42; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.65em; font-weight: 700; }

        /* Profile Dropdown */
        .profile-dropdown { position: relative; }
        .profile-trigger { display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 6px 12px; border-radius: 50px; transition: background 0.3s; border: 2px solid transparent; }
        .profile-trigger:hover { background: rgba(255, 140, 66, 0.1); border-color: rgba(255, 140, 66, 0.3); }

        /* Default Avatar Style */
        .profile-avatar { width: 34px; height: 34px; border-radius: 50%; background-color: #FF8C42; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2em; border: 2px solid #FF8C42; flex-shrink: 0; }

        .profile-name { font-weight: 600; color: #333; font-size: 0.9em; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .dropdown-arrow { width: 16px; height: 16px; transition: transform 0.3s; flex-shrink: 0; color: #666; }
        .profile-dropdown.active .dropdown-arrow { transform: rotate(180deg); color: #FF8C42; }

        .dropdown-menu { position: absolute; top: calc(100% + 15px); right: 0; background: white; border-radius: 14px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); min-width: 240px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s; z-index: 1001; }
        .profile-dropdown.active .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }

        .dropdown-item { padding: 12px 18px; display: flex; align-items: center; gap: 10px; text-decoration: none; color: #333; transition: background 0.3s; border-bottom: 1px solid #f5f5f5; font-size: 0.9em; }
        .dropdown-item:last-child { border-bottom: none; border-radius: 0 0 14px 14px; }
        .dropdown-item:first-child { border-radius: 14px 14px 0 0; }
        .dropdown-item:hover { background: rgba(255, 140, 66, 0.1); }
        .dropdown-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .dropdown-item.logout { color: #dc2626; }
        .dropdown-item.logout:hover { background: rgba(220, 38, 38, 0.1); }

        /* Auth Buttons */
        .auth-buttons { display: flex; gap: 10px; align-items: center; }
        .btn-login, .btn-register { padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.9em; text-decoration: none; transition: all 0.3s; white-space: nowrap; }
        .btn-login { color: #FF8C42; background: white; border: 2px solid #FF8C42; }
        .btn-login:hover { background: rgba(255, 140, 66, 0.1); transform: translateY(-2px); }
        .btn-register { color: white; background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%); border: none; box-shadow: 0 2px 8px rgba(255, 140, 66, 0.3); }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(255, 140, 66, 0.4); }

        /* Modal & Form Styles */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 2000; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: white; border-radius: 20px; width: 90%; max-width: 500px; padding: 30px; position: relative; max-height: 90vh; overflow-y: auto; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .modal-header h2 { color: #FF8C42; font-size: 1.5em; }
        .close-modal { width: 30px; height: 30px; cursor: pointer; color: #666; transition: color 0.3s; }
        .close-modal:hover { color: #FF8C42; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group input { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1em; transition: border-color 0.3s; }
        .form-group input:focus { outline: none; border-color: #FF8C42; }

        /* Toast */
        .toast { position: fixed; top: 100px; right: 30px; background: white; padding: 20px 25px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); display: none; align-items: center; gap: 15px; z-index: 10000; animation: slideIn 0.3s ease-out; }
        .toast.show { display: flex; }
        .toast.success { border-left: 5px solid #4caf50; }
        .toast.error { border-left: 5px solid #f44336; }
        @keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-icon { width: 24px; height: 24px; }
        .toast-message { flex: 1; font-weight: 600; color: #333; }
        .toast-close { width: 20px; height: 20px; cursor: pointer; color: #999; }

        /* Responsive */
        @media (max-width: 1200px) { .nav-container { padding: 0 30px; gap: 25px; } .nav-links { gap: 25px; } .nav-links a { font-size: 1.15em; } }
        @media (max-width: 992px) { .nav-links { gap: 20px; } .nav-links a { font-size: 1.1em; } .profile-name { display: none; } }
        @media (max-width: 768px) { .nav-container { padding: 0 20px; } .logo span { font-size: 1.2em; } .nav-links { display: none; } .toast { right: 15px; left: 15px; top: 90px; } }
    </style>
</head>
<body>

<div class="toast" id="toast">
    <svg class="toast-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    <span class="toast-message" id="toastMessage"></span>
    <svg class="toast-close" onclick="hideToast()" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
</div>

@include('components.navbar')

@auth
<div class="modal" id="editProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Profile</h2>
            <svg class="close-modal" onclick="closeEditProfile()" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </div>

        <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="userName" value="{{ Auth::user()->name }}" placeholder="Enter your name">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="userEmail" value="{{ Auth::user()->email }}" placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" id="userPhone" value="{{ Auth::user()->phone ?? '' }}" placeholder="Enter your phone">
            </div>

            <button type="submit" class="btn-register" style="width: 100%; padding: 12px; margin-top: 20px;">Save Changes</button>
        </form>
    </div>
</div>
@endauth

<main>
    @include('sections.home')
    @include('sections.appointment')
    @include('sections.products')
    @include('sections.contact')
</main>

<script>
    // Toast Notification
    function showToast(message, type = 'success') {
        if (!message) return;
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        toast.className = `toast ${type} show`;
        toastMessage.textContent = message;
        setTimeout(hideToast, 4000);
    }

    function hideToast() {
        document.getElementById('toast').classList.remove('show');
    }

    function updateCartBadge() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartBadge');
                if (data.count > 0) {
                    if (badge) badge.textContent = data.count;
                    else {
                        const newBadge = document.createElement('span');
                        newBadge.id = 'cartBadge';
                        newBadge.className = 'cart-badge';
                        newBadge.textContent = data.count;
                        document.querySelector('.cart-icon').appendChild(newBadge);
                    }
                } else if (badge) badge.remove();
            });
    }

    // Toggle Profile Dropdown
    function toggleDropdown(event) {
        event.stopPropagation(); // Prevent immediate closing
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking anywhere else
    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && dropdown.classList.contains('active')) {
            // If click is OUTSIDE the dropdown container, close it
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        }
    });

    // Edit Profile Modal
    function openEditProfile(event) {
        event.preventDefault();
        document.getElementById('editProfileModal').classList.add('active');
        document.getElementById('profileDropdown').classList.remove('active');
    }

    function closeEditProfile() {
        document.getElementById('editProfileModal').classList.remove('active');
    }

    const modal = document.getElementById('editProfileModal');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === this) closeEditProfile();
        });
    }

    // Scroll Nav Highlight
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href') || '';
            if (!href.startsWith('#')) return;
            e.preventDefault();
            const targetId = href.substring(1);
            const target = document.getElementById(targetId);
            if (target) {
                document.querySelectorAll('.nav-links a').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('main > section');
        const navLinks = document.querySelectorAll('.nav-links a');
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - 150) current = section.getAttribute('id');
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) link.classList.add('active');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        try { updateCartBadge(); } catch (e) {}
    });

    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
</script>

@include('layouts.footer')

</body>
</html>
