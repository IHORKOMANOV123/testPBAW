<?php

// Helper functions for the application can be added here.

/**
 * Checks if the current user has the required role(s).
 * Assumes role is stored in $_SESSION['user_role'] and $conf is available globally.
 *
 * @param mixed $role_needed A single role (string) or an array of allowed roles. Null allows any user (including guests).
 * @return bool True if the user has the required role, false otherwise.
 */
function checkRole($role_needed) {
    global $conf; // Need access to global config for default role

    // Retrieve user's role from session, default to 'guest' if not set
    // Use default_role from config, ensure it's defined in config.php
    $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : (isset($conf->default_role) ? $conf->default_role : 'guest');

    // If no specific role is needed, access is granted
    if ($role_needed === null) {
        return true;
    }

    // Ensure $role_needed is an array for easy checking
    $roles_allowed = (array) $role_needed;

    // Check if the user's role is directly in the allowed list
    if (in_array($user_role, $roles_allowed)) {
        return true;
    }

    // Optional: Add role hierarchy checks if needed (e.g., admin inherits user)
    // Example: Admin can do anything a 'user' can do
    if ($user_role === 'admin' && in_array('user', $roles_allowed)) {
        return true;
    }

    // If no match found, access is denied
    return false;
}

// Add other global helper functions below as needed
// function anotherHelperFunction() { ... }
