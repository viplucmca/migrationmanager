/**
 * Lead Form Navigation
 * Handles sidebar navigation and scroll-to-section functionality
 * Matches client edit page behavior
 */

(function() {
    'use strict';
    
    /**
     * Toggle sidebar on mobile
     */
    window.toggleSidebar = function() {
        const sidebar = document.getElementById('sidebarNav');
        if (sidebar) {
            sidebar.classList.toggle('mobile-open');
        }
    };
    
    /**
     * Scroll to specific section and update navigation
     */
    window.scrollToSection = function(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            // Smooth scroll to section
            section.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
            
            // Update active navigation item
            updateActiveNav(sectionId);
            
            // Close sidebar on mobile
            const sidebar = document.getElementById('sidebarNav');
            if (sidebar && window.innerWidth <= 992) {
                sidebar.classList.remove('mobile-open');
            }
        }
    };
    
    /**
     * Update active navigation item
     */
    function updateActiveNav(sectionId) {
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.classList.remove('active');
            const onClick = item.getAttribute('onclick');
            if (onClick && onClick.includes(sectionId)) {
                item.classList.add('active');
            }
        });
    }
    
    /**
     * Scroll spy - Update nav based on scroll position
     */
    function initScrollSpy() {
        const sections = document.querySelectorAll('.content-section');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.3) {
                    updateActiveNav(entry.target.id);
                }
            });
        }, {
            threshold: [0, 0.3, 0.5, 0.7, 1],
            rootMargin: '-100px 0px -50% 0px'
        });
        
        sections.forEach(section => {
            observer.observe(section);
        });
    }
    
    /**
     * Go back with refresh
     */
    window.goBackWithRefresh = function() {
        window.location.href = document.referrer || '{{ route("admin.leads.index") }}';
    };
    
    /**
     * Initialize on DOM ready
     */
    function initialize() {
        // Init scroll spy
        initScrollSpy();
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebarNav');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (sidebar && toggle && window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebarNav');
            if (sidebar && window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
            }
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }
    
})();

