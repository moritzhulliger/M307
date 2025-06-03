<?php
// WARNUNG: Dies ist eine Demonstration für UNSICHERE Token-Generierung
// NUR für Bildungszwecke - NIEMALS in Produktionsumgebungen verwenden!

session_start();

// Simulierte Benutzerdatenbank
$users = [
    'admin' => ['email' => 'admin@company.com', 'password' => 'admin123'],
    'user1' => ['email' => 'user1@example.com', 'password' => 'password123'],
    'test' => ['email' => 'test@example.com', 'password' => 'test123']
];

// UNSICHERE Token-Generierung (nur für Demo!)
function generateWeakToken() {
    return str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
}

// Token speichern (normalerweise in Datenbank)
if (!isset($_SESSION['reset_tokens'])) {
    $_SESSION['reset_tokens'] = [];
}

// API-Modus erkennen (für Brute Force)
$is_api = isset($_GET['api']) || isset($_POST['api']) || 
          (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
          isset($_GET['action']) || 
          (isset($_POST['action']) && $_POST['action'] !== '');

if ($is_api) {
    header('Content-Type: application/json');
    
    $action = $_GET['action'] ?? $_POST['action'] ?? '';
    
    switch ($action) {
        case 'request_reset':
            $email = $_POST['email'] ?? $_GET['email'] ?? '';
            
            if (empty($email)) {
                echo json_encode(['error' => 'E-Mail erforderlich', 'success' => false]);
                exit;
            }
            
            foreach ($users as $username => $user_data) {
                if ($user_data['email'] === $email) {
                    $token = generateWeakToken();
                    $_SESSION['reset_tokens'][$token] = [
                        'username' => $username,
                        'timestamp' => time(),
                        'used' => false
                    ];
                    echo json_encode([
                        'success' => true,
                        'token' => $token,
                        'message' => "Token generiert für $email",
                        'username' => $username,
                    ]);
                    exit;
                }
            }
            echo json_encode(['error' => 'E-Mail nicht gefunden', 'success' => false]);
            exit;
            
        case 'reset_password':
        case 'try_token':
            $token = $_POST['token'] ?? $_GET['token'] ?? '';
            $new_password = $_POST['new_password'] ?? $_GET['new_password'] ?? '';
            
            if (empty($token)) {
                echo json_encode(['error' => 'Token erforderlich', 'success' => false]);
                exit;
            }

            if (empty($new_password)) {
                echo json_encode(['error' => 'Neues Passwort erforderlich', 'success' => false]);
                exit;
            }
            
            if (isset($_SESSION['reset_tokens'][$token]) && !$_SESSION['reset_tokens'][$token]['used']) {
                $username = $_SESSION['reset_tokens'][$token]['username'];
                $_SESSION['reset_tokens'][$token]['used'] = true;
                
                echo json_encode([
                    'success' => true,
                    'message' => "TREFFER! Token $token gültig für $username",
                    'username' => $username,
                    'token' => $token,
                    'new_password' => $new_password
                ]);
            } else {
                echo json_encode(['error' => 'Ungültiger Token', 'success' => false, 'token' => $token, 'ladida' => $_SESSION['reset_tokens']]);
            }
            exit;
            
        case 'list_tokens':
            $active_tokens = [];
            foreach ($_SESSION['reset_tokens'] as $token => $data) {
                if (!$data['used']) {
                    $active_tokens[] = [
                        'token' => $token,
                        'username' => $data['username']
                    ];
                }
            }
            echo json_encode(['active_tokens' => $active_tokens, 'count' => count($active_tokens)]);
            exit;
            
        case 'clear_tokens':
            $_SESSION['reset_tokens'] = [];
            echo json_encode(['message' => 'Alle Token gelöscht', 'success' => true]);
            exit;
            
        default:
            echo json_encode([
                'info' => 'Brute Force Demo API',
                'usage' => [
                    'request_reset' => '?action=request_reset&email=admin@company.com',
                    'try_token' => '?action=try_token&token=123',
                    'list_tokens' => '?action=list_tokens',
                    'clear_tokens' => '?action=clear_tokens'
                ],
                'emails' => ['admin@company.com', 'user1@example.com', 'test@example.com']
            ]);
            exit;
    }
}

// Ab hier: Normale HTML-Ausgabe für Browser
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsichere Passwort Reset Demo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 700px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .warning { background: #ffebee; color: #c62828; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #c62828; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        button:hover { background: #005a87; }
        .success { background: #e8f5e8; color: #2e7d32; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .error { background: #ffebee; color: #c62828; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .info { background: #e3f2fd; color: #1565c0; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .token-display { font-family: monospace; font-size: 18px; font-weight: bold; background: #f5f5f5; padding: 10px; border-radius: 4px; }
        .code-block { background: #f5f5f5; padding: 15px; border-radius: 4px; font-family: monospace; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚨 Unsichere Passwort Reset Demo</h1>
        
        <div class="warning">
            <strong>WARNUNG:</strong> Dies ist eine Demonstration unsicherer Praktiken!<br>
            Die Token sind nur 3-stellig und daher extrem leicht zu erraten.<br>
            <strong>NIEMALS in echten Anwendungen verwenden!</strong>
        </div>

        <?php
        // Passwort Reset anfordern
        if (isset($_POST['request_reset'])) {
            $email = $_POST['email'] ?? '';
            $user_found = false;
            
            foreach ($users as $username => $user_data) {
                if ($user_data['email'] === $email) {
                    $token = generateWeakToken();
                    $_SESSION['reset_tokens'][$token] = [
                        'username' => $username,
                        'timestamp' => time(),
                        'used' => false
                    ];
                    $user_found = true;
                    echo "<div class='success'>Reset-Token generiert für $email</div>";
                    echo "<div class='token-display'>Ihr Token: $token</div>";
                    echo "<div class='info'>Token ist bereit für Brute Force Test!</div>";
                    break;
                }
            }
            
            if (!$user_found) {
                echo "<div class='error'>E-Mail-Adresse nicht gefunden!</div>";
            }
        }

        // Passwort zurücksetzen
        if (isset($_POST['reset_password'])) {
            $token = $_POST['token'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            
            if (isset($_SESSION['reset_tokens'][$token]) && !$_SESSION['reset_tokens'][$token]['used']) {
                $username = $_SESSION['reset_tokens'][$token]['username'];
                $_SESSION['reset_tokens'][$token]['used'] = true;
                echo "<div class='success'>Passwort für Benutzer '$username' erfolgreich zurückgesetzt!</div>";
                echo "<div class='info'>Neues Passwort: $new_password (nur Demo)</div>";
            } else {
                echo "<div class='error'>Ungültiger oder bereits verwendeter Token!</div>";
            }
        } 
        ?>

        <h2>1. Reset-Token anfordern</h2>
        <form method="POST">
            <div class="form-group">
                <label for="email">E-Mail-Adresse:</label>
                <input type="email" id="email" name="email" required>
                <small>Verfügbare E-Mails: admin@company.com, user1@example.com, test@example.com</small>
            </div>
            <button type="submit" name="request_reset">Token generieren</button>
        </form>

        <h2>2. Passwort zurücksetzen</h2>
        <form method="POST">
            <div class="form-group">
                <label for="token">Reset-Token (3-stellig):</label>
                <input type="text" id="token" name="token" maxlength="3" pattern="[0-9]{3}" required>
                <small>Nur 3 Ziffern (000-999) - sehr unsicher!</small>
            </div>
            <div class="form-group">
                <label for="new_password">Neues Passwort:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <button type="submit" name="reset_password">Passwort zurücksetzen</button>
        </form>

        <h2>🔧 Brute Force Anleitung</h2>
        <div class="info">
            <strong>So funktioniert der Brute Force Angriff:</strong><br>
            1. Generieren Sie zuerst einen Token oben<br>
            2. Verwenden Sie das Script im Ordner script.sh mit <i>sh ./scrip.sh</i><br>
            3. Das Script probiert alle Token von 000-999 durch<br>
            4. Bei Erfolg wird "success": true zurückgegeben
        </div>


        <h3>Warum ist das unsicher?</h3>
        <ul>
            <li><strong>Nur 1000 Möglichkeiten:</strong> Token von 000-999 sind in Sekunden durchprobiert</li>
            <li><strong>Keine Rate Limits:</strong> Unbegrenzte Versuche in kurzer Zeit</li>
            <li><strong>Schwache Entropie:</strong> Vorhersagbare Zufallszahlen</li>
            <li><strong>Keine Zeitbegrenzung:</strong> Token laufen nie ab</li>
            <li><strong>Keine Sicherheitsmaßnahmen:</strong> Kein Logging, Blocking, etc.</li>
        </ul>
    </div>
</body>
</html>