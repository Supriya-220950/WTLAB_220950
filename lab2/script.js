/**
 * SmartCare Lab 2 - Advanced UI with Animations and Interactivity
 * Features: Dynamic date, table interactions, card animations, navigation
 */

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Main initialization function
 */
function initializeApp() {
    updateCurrentDate();
    initSidebarNavigation();
    initCardInteractions();
    initTableHoverEffects();
    initSmoothScroll();
    addAnimationTriggers();
}

/**
 * Update and display current date
 */
function updateCurrentDate() {
    const dateElement = document.getElementById('date');
    if (dateElement) {
        const today = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        dateElement.innerText = today.toLocaleDateString('en-US', options);
    }
}

/**
 * Initialize sidebar navigation with active state
 */
function initSidebarNavigation() {
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            navItems.forEach(navItem => navItem.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get the section name
            const sectionName = this.textContent.trim().split(' ')[1];
            console.log('Navigated to:', sectionName);
            showNotification(`Navigating to ${sectionName} section`);
        });
    });
}

/**
 * Initialize card click interactions
 */
function initCardInteractions() {
    const cards = document.querySelectorAll('.card');
    
    cards.forEach((card, index) => {
        card.addEventListener('click', function() {
            const title = this.querySelector('h3').textContent.trim();
            handleCardClick(title);
        });

        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });
}

/**
 * Handle card click event
 */
function handleCardClick(cardTitle) {
    console.log('Card clicked:', cardTitle);
    showNotification(`Opening: ${cardTitle}`);
}

/**
 * Initialize table row hover effects
 */
function initTableHoverEffects() {
    const rows = document.querySelectorAll('.table-row-hover');
    
    rows.forEach(row => {
        row.addEventListener('click', function() {
            const patientName = this.querySelector('td').textContent.trim();
            console.log('Selected patient:', patientName);
            showNotification(`Patient: ${patientName} selected`);
        });
    });
}

/**
 * Initialize smooth scrolling for navigation
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const element = document.querySelector(href);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

/**
 * Add animation triggers on scroll
 */
function addAnimationTriggers() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideUp 0.6s ease-out forwards';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card, .stat-card, .update-card').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Show notification (temporary alert system)
 */
function showNotification(message) {
    console.log('Notification:', message);
    // You can replace this with a toast notification library later
    // For now, using console
}

/**
 * Format date to readable string
 */
function formatDate(date) {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(date);
}

/**
 * Format time to readable string
 */
function formatTime(date) {
    return new Intl.DateTimeFormat('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    }).format(date);
}

/**
 * Get patient statistics (example data)
 */
function getPatientStats() {
    return {
        totalPatients: 450,
        appointmentsToday: 12,
        reportsAvailable: 156,
        completionRate: 89
    };
}

/**
 * Update statistics dynamically
 */
function updateStatistics() {
    const stats = getPatientStats();
    console.log('Current Statistics:', stats);
}

// Log application state on load
console.log('SmartCare Lab2 - Advanced UI Dashboard Loaded');
console.log('Features Enabled: Animations, Card Interactions, Table Effects, Smooth Scrolling');

// Update stats periodically (example)
setInterval(updateStatistics, 30000);
