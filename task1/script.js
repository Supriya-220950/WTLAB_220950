/**
 * SmartCare - Basic Healthcare Dashboard
 * Task 1: Basic Website Structure with JavaScript Functionality
 */

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    updateCurrentDate();
    initializeNavigation();
    addButtonClickListeners();
});

/**
 * Update current date display
 */
function updateCurrentDate() {
    const dateElement = document.getElementById('currentDate');
    if (dateElement) {
        const today = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        dateElement.textContent = today.toLocaleDateString('en-US', options);
    }
}

/**
 * Initialize navigation with active state management
 */
function initializeNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Get the section id
            const sectionId = this.getAttribute('href').substring(1);
            console.log('Navigating to section:', sectionId);
        });
    });
}

/**
 * Add click event listeners to all buttons
 */
function addButtonClickListeners() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const card = this.closest('.card');
            const cardTitle = card ? card.querySelector('h3').textContent : 'Unknown';
            handleButtonClick(cardTitle);
        });
    });
}

/**
 * Handle button click actions
 */
function handleButtonClick(cardTitle) {
    console.log('Button clicked for:', cardTitle);
    showNotification(`Opening details for: ${cardTitle}`);
}

/**
 * Show notification message
 */
function showNotification(message) {
    console.log('Notification:', message);
    // Alert for demonstration
    alert(message);
}

/**
 * Get current date in formatted string
 */
function getCurrentDate() {
    const today = new Date();
    return today.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}

/**
 * Format time in 12-hour format
 */
function formatTime(date) {
    return date.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true
    });
}
