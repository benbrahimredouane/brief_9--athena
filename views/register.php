<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Register</title>
    <style>
        /* Shared CSS with Login Page */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #f4f7f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .block {
            background-color: #ffffff;
            width: 90%;
            max-width: 450px; /* Slightly wider for longer forms */
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .block__title {
            margin-bottom: 8px;
            color: #1a1a1a;
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
        }

        .block__subtitle {
            color: #666;
            margin-bottom: 24px;
            text-align: center;
            font-size: 0.95rem;
        }

        .block__error {
            background-color: #fff1f0;
            color: #d85140;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid #ffa39e;
            text-align: center;
        }

        .block__form {
            display: flex;
            flex-direction: column;
            gap: 12px; /* Tightened gap for more fields */
        }

        /* Label Styling */
        .block__label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            margin-bottom: -8px; /* Pulls label closer to its input */
            margin-left: 4px;
        }

        .block__input {
            width: 100%;
            border-radius: 8px;
            border: 1.5px solid #e1e1e1;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .block__input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .block__btn {
            padding: 14px;
            border-radius: 8px;
            border: none;
            color: #ffffff;
            background-color: #6366f1;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 12px;
        }

        .block__btn:hover {
            background-color: #4f46e5;
        }

        .block__msg {
            margin-top: 24px;
            font-size: 0.9rem;
            color: #666;
            text-align: center;
        }

        .block__link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="block">
        <h1 class="block__title">Create Account</h1>
        <p class="block__subtitle">Join the Athena community today</p>

        <?php if (isset($error)): ?>
            <p class="block__error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form class="block__form" method="POST" action="index.php?action=register">
            <label class="block__label">Username</label>
            <input class="block__input" type="text" name="username" placeholder="johndoe123" required>
            
            <label class="block__label">Email Address</label>
            <input class="block__input" type="email" name="email" placeholder="name@company.com" required>
            
            <label class="block__label">Password</label>
            <input class="block__input" type="password" name="password" placeholder="••••••••" required>
            
            <label class="block__label">Confirm Password</label>
            <input class="block__input" type="password" name="confirm_password" placeholder="••••••••" required>
            
            <button class="block__btn" type="submit">Create Account</button>
        </form>

        <p class="block__msg">
            Already have an account? <a class="block__link" href="index.php?action=login">Log in</a>
        </p>
    </div>
</body>
</html>