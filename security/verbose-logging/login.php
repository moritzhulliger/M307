<?php
// Verbose Login Function - Educational Demonstration
// This demonstrates a common security vulnerability: information disclosure


// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Simulated user database
$valid_users = [
    'ygonzales@gmail.com' => [
        'password' => 'SecurePass123!',
        'name' => 'Yolanda Gonzales',
        'role' => 'admin'
    ],
    'admin@company.com' => [
        'password' => 'admin123',
        'name' => 'Administrator',
        'role' => 'admin'
    ],
    'john.doe@company.com' => [
        'password' => 'password123',
        'name' => 'John Doe',
        'role' => 'user'
    ],
    'sarah.smith@company.com' => [
        'password' => 'mypassword',
        'name' => 'Sarah Smith',
        'role' => 'user'
    ]
];

function verbose_login() {
    global $valid_users;
    
    // Get POST data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $function = isset($_POST['function']) ? $_POST['function'] : '';
    
    // Validate that this is a login request
    if ($function !== 'login') {
        return [
            'status' => 'error',
            'message' => 'Invalid function specified'
        ];
    }
    
    // Validate required fields
    if (empty($username) || empty($password)) {
        return [
            'status' => 'error',
            'message' => 'Username and password are required'
        ];
    }
    
    // VULNERABILITY: Check if email exists first (information disclosure)
    if (!array_key_exists($username, $valid_users)) {
        return [
            'status' => 'error',
            'message' => 'Email does not exist'  // This reveals valid vs invalid emails
        ];
    }
    
    // Check password
    if ($valid_users[$username]['password'] !== $password) {
        return [
            'status' => 'error',
            'message' => 'Invalid password'  // This confirms the email exists
        ];
    }
    
    // Successful login
    return [
        'status' => 'success',
        'message' => 'Login successful',
        'user' => [
            'email' => $username,
            'name' => $valid_users[$username]['name'],
            'role' => $valid_users[$username]['role']
        ]
    ];
}

// Main execution
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    $result = verbose_login();
    echo json_encode($result);
} else {
    // Show a simple form for testing
    ?>
    <head>
        <title>Verbose Login Demo</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input[type="email"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
            button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background-color: #0056b3; }
            .result { margin-top: 20px; padding: 10px; border-radius: 4px; }
            .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
            .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
            .info { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; margin-bottom: 20px; }
        </style>
    </head>
        <h1>Verbose Login Vulnerability Demo</h1>
        
        <div class="info">
            <strong>Educational Purpose:</strong> This demonstrates a common vulnerability where login forms 
            provide different error messages for invalid emails vs invalid passwords, allowing attackers 
            to enumerate valid user accounts.
            <br><br>
        </div>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="email" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div id="result"></div>
        
        <script>
            document.getElementById('loginForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData();
                formData.append('username', document.getElementById('username').value);
                formData.append('password', document.getElementById('password').value);
                formData.append('function', 'login');
                
                try {
                    const response = await fetch('', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    const resultDiv = document.getElementById('result');
                    resultDiv.className = 'result ' + result.status;
                    resultDiv.innerHTML = '<strong>' + result.status.toUpperCase() + ':</strong> ' + result.message;
                    
                    if (result.status === 'success' && result.user) {
                        resultDiv.innerHTML += '<br><strong>Welcome:</strong> ' + result.user.name + ' (' + result.user.role + ')';
                    }
                } catch (error) {
                    const resultDiv = document.getElementById('result');
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = '<strong>ERROR:</strong> ' + error.message;
                }
            });
        </script>
    <?php
}
?>