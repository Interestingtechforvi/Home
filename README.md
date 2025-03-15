<html lang="en" role="document">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Interesting tech for V I</title>
    <script src="https://www.gstatic.com/firebasejs/9.21.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.21.0/firebase-auth-compat.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        h1, h2 {
            color: #2c3e50;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 0;
        }
        button:hover {
            background-color: #2980b9;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body role="main">
    <header>
        <h1>Interesting tech for V I</h1>
        <p>Your Multy Featured application for Unique and interesting tools .</p>
    </header>
    
    <main>
        <h1>Login to Your Account</h1>
        <p>Welcome to Interesting tech for V I! We are dedicated to providing you with essencial multiple tools and useful features designed to assist visually impaired individuals. Please log in to access exclusive features and tools tailored for your needs.</p>
        <p>If you already have an account, please sign in using your Google account or your email and password. If you are a new user, kindly create an account to begin.!</p>
        
        <button id="googleSignInBtn" role="button" aria-label="Continue with Google">Continue with Google</button>
        <button id="emailSignInBtn" role="button" aria-label="Continue with Email and Password">Continue with Email and Password</button>

        <div id="emailForm" style="display: none;" role="form" aria-labelledby="emailFormLabel">
            <h2 id="emailFormLabel">Email and Password Login</h2>
            <p>Please enter your Correct email and create a strong password that you can remember. So that another user can't able to use or sell your details. </p>
            <input type="email" id="email" placeholder="Please Enter your email " aria-required="true" aria-label="Email" />
            <input type="password" id="password" placeholder="Enter your password" aria-required="true" aria-label="Password" />
            <button id="submitEmailBtn" role="button" aria-label="Login">Login</button>
            <button id="signUpEmailBtn" role="button" aria-label="Sign Up with Email and Password">Sign Up</button>
            <p>If you don’t have an account yet, click on the "Sign Up" button to create a new account.</p>
        </div>

        <div id="signupForm" style="display: none;" role="form" aria-labelledby="signupFormLabel">
            <h2 id="signupFormLabel">Create New Account</h2>
            <p>Please enter your email, password, and confirm your password to create a new account.</p>
            <input type="email" id="signupEmail" placeholder="Enter your email" aria-required="true" aria-label="Email" />
            <input type="password" id="signupPassword" placeholder=" Create your New password" aria-required="true" aria-label="Create strong Password" />
            <input type="password" id="confirmPassword" placeholder="Confirm your password" aria-required="true" aria-label="Re enter and Confirm Password" />
            <button id="submitSignupBtn" role="button" aria-label="Create Account">Create Account</button>
            <button id="cancelSignupBtn" role="button" aria-label="Cancel Signup">Cancel</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024/2025 Interesting tech for V I. All rights reserved.</p>
    </footer>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyCe-tHLxNX0g3cRDIJM2f2dfGfhvd1BQcc",
    authDomain: "interesting-tech-for-v-i.firebaseapp.com",
    projectId: "interesting-tech-for-v-i",
    storageBucket: "interesting-tech-for-v-i.appspot.com",
    messagingSenderId: "984478442998",
    appId: "1:984478442998:web:0810b7708925c6a03b13d7",
    measurementId: "G-WS50501H3Y"
        };

        const app = firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();

        const googleSignInBtn = document.getElementById('googleSignInBtn');
        const emailSignInBtn = document.getElementById('emailSignInBtn');
        const emailForm = document.getElementById('emailForm');
        const signupForm = document.getElementById('signupForm');
        const submitEmailBtn = document.getElementById('submitEmailBtn');
        const signUpEmailBtn = document.getElementById('signUpEmailBtn');
        const submitSignupBtn = document.getElementById('submitSignupBtn');
        const cancelSignupBtn = document.getElementById('cancelSignupBtn');

        document.addEventListener("DOMContentLoaded", () => {
            if (isUserLoggedIn()) {
                window.location.href = "https://rawcdn.githack.com/Interestingtechforvi/Home/refs/heads/main/itvihome.html";
            }
        });

        googleSignInBtn.addEventListener('click', () => {
            const provider = new firebase.auth.GoogleAuthProvider();
            auth.signInWithPopup(provider)
                .then((result) => {
                    setLoginCookie(true);
                    window.location.href = "https://rawcdn.githack.com/Interestingtechforvi/Home/refs/heads/main/itvihome.html";
                })
                .catch((error) => {
                    alert('Error during Google sign-in: ' + error.message);
                });
        });

        emailSignInBtn.addEventListener('click', () => {
            emailForm.style.display = 'block';
            googleSignInBtn.style.display = 'none';
            emailSignInBtn.style.display = 'none';
        });

        signUpEmailBtn.addEventListener('click', () => {
            emailForm.style.display = 'none';
            signupForm.style.display = 'block';
        });

        submitEmailBtn.addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email && password) {
                auth.signInWithEmailAndPassword(email, password)
                    .then(() => {
                        setLoginCookie(true);
                        window.location.href = "https://rawcdn.githack.com/Interestingtechforvi/Home/refs/heads/main/itvihome.html";
                    })
                    .catch((error) => {
                        alert('Error during email sign-in: ' + error.message);
                    });
            } else {
                alert('Please enter both email and password.');
            }
        });

        submitSignupBtn.addEventListener('click', () => {
            const email = document.getElementById('signupEmail').value;
            const password = document.getElementById('signupPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (email && password && confirmPassword) {
                if (password === confirmPassword) {
                    auth.createUserWithEmailAndPassword(email, password)
                        .then(() => {
                            setLoginCookie(true);
                            window.location.href = "https://rawcdn.githack.com/Interestingtechforvi/Home/refs/heads/main/itvihome.html";
                        })
                        .catch((error) => {
                            alert('Error during sign-up: ' + error.message);
                        });
                } else {
                    alert('Passwords do not match. Please try again. And type same password in boath edit boxes. ');
                }
            } else {
                alert('Please fill in all fields.');
            }
        });

        cancelSignupBtn.addEventListener('click', () => {
            signupForm.style.display = 'none';
            emailForm.style.display = 'block';
        });

        function setLoginCookie(isLoggedIn) {
            const expiryDate = new Date();
            expiryDate.setTime(expiryDate.getTime() + (30 * 24 * 60 * 60 * 1000)); 
            const expires = "expires=" + expiryDate.toUTCString();
            document.cookie = "account=" + isLoggedIn + ";" + expires + ";path=/";
        }

        function removeLoginCookie() {
            document.cookie = "account=false; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }

        function isUserLoggedIn() {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith('account=')) {
                    return cookie.split('=')[1] === 'true';
                }
            }
            return false;
        }
    </script>
</body>
</html>
