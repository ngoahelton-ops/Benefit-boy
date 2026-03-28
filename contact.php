<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact - Quize App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="css/styles.css" type="text/css" rel="stylesheet">
    <style>
        .content {
            background-color: silver;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.8);
            width: 520px;
            margin-top: 80px;
        }
        .content h2 {
            color: #333;
            text-align: center;
        }
        .contact-info {
            color: #555;
            line-height: 1.8;
            margin: 20px 0;
        }
        .contact-info p {
            margin: 10px 0;
        }
        .contact-form {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: arial, sans-serif;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .submit-btn {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .submit-btn:hover {
            background: #2d7db5;
        }
        
        body.dark-mode .content {
            background-color: #2a2a3e;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.5);
        }
        body.dark-mode .content h2,
        body.dark-mode .contact-form h3 {
            color: #e0e0e0;
        }
        body.dark-mode .contact-info {
            color: #a0a0a0;
        }
        body.dark-mode .form-group label {
            color: #e0e0e0;
        }
        body.dark-mode .form-group input,
        body.dark-mode .form-group textarea {
            background-color: #3a3a4e;
            color: #e0e0e0;
            border: 1px solid #4a4a5e;
        }
        body.dark-mode .submit-btn {
            background: #3b82f6;
        }
        body.dark-mode .submit-btn:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Quize App</h1>
        <button id="navToggle" class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="about.php">About</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>
    <div class="content">
        <h2>Contact Us</h2>
        
        <div class="contact-info">
            <p><strong>Email:</strong> ngoahelton@gmail.com</p>
            <p><strong>Phone:</strong> +237 6 78 07 93 09</p>
            <p><strong>Address:</strong> 123 Learning Street, Education City, EC 12345</p>
            <p><strong>Business Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</p>
        </div>
        
        <div class="contact-form">
            <h3 style="color: #333;">Send us a Message</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
        
        <br>
        <a class='button' href='index.html'>Back to Home</a>
    </div>
    <script src="js/darkmode.js"></script>
    <script src="js/nav.js"></script>
</body>
</html>
