// Simple JavaScript functions for the Student Management System

// Function to confirm delete actions
function confirmDelete(message) {
    return confirm(message || "Are you sure you want to delete this record?");
}

// Function to validate login form
function validateLoginForm() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    if (username.trim() === '') {
        alert('Please enter your username');
        return false;
    }
    
    if (password.trim() === '') {
        alert('Please enter your password');
        return false;
    }
    
    return true;
}

// Function to validate user form (faculty/student)
function validateUserForm() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    
    if (name.trim() === '') {
        alert('Please enter the name');
        return false;
    }
    
    if (email.trim() === '') {
        alert('Please enter the email');
        return false;
    }
    
    if (phone.trim() === '') {
        alert('Please enter the phone number');
        return false;
    }
    
    return true;
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add form validation to login forms
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            if (!validateLoginForm()) {
                e.preventDefault();
            }
        });
    }
    
    // Add form validation to user forms
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', function(e) {
            if (!validateUserForm()) {
                e.preventDefault();
            }
        });
    }
    
    // Add delete confirmation to delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirmDelete()) {
                e.preventDefault();
            }
        });
    });
});