// JavaScript cho navbar và navigation
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Authentication handling
    const authSection = document.getElementById('auth-section');
    const loggedInSection = document.getElementById('logged-in-section');
    const loggedOutSection = document.getElementById('logged-out-section');
    const logoutBtn = document.getElementById('logout-btn');
    
    // Check authentication status (này có thể được mở rộng để tích hợp với Firebase)
    function checkAuthStatus() {
        // Placeholder cho authentication check
        // Có thể tích hợp với Firebase Auth ở đây
        const isLoggedIn = false; // Thay đổi logic này theo nhu cầu
        
        if (isLoggedIn) {
            if (loggedInSection) loggedInSection.classList.remove('hidden');
            if (loggedOutSection) loggedOutSection.classList.add('hidden');
        } else {
            if (loggedInSection) loggedInSection.classList.add('hidden');
            if (loggedOutSection) loggedOutSection.classList.remove('hidden');
        }
    }
    
    // Logout functionality
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            // Placeholder cho logout logic
            // Có thể tích hợp với Firebase Auth ở đây
            console.log('Logging out...');
            checkAuthStatus();
        });
    }
    
    // Initialize auth status
    checkAuthStatus();
    
    // Smooth scrolling cho navigation links
    const navLinks = document.querySelectorAll('a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Active nav link highlighting
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-link');
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href === currentPath || (currentPath === '/' && href === '/')) {
            item.classList.add('active');
        }
    });
});