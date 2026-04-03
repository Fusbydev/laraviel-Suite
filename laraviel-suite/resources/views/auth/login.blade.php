<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap');

        :root {
            --text-color: #070504;
            --background: #fdfbfa;
            --primary: #cb7c43;
            --secondary: #ecb187;
            --accent: #f38f47;
            --light-shadow: rgba(0, 0, 0, 0.1);
            --dark-shadow: rgba(0, 0, 0, 0.3);
        }

        body {
            background-color: var(--background);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            box-shadow: 0 8px 20px var(--light-shadow);
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        input, button {
            border-radius: 50px !important;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 8px var(--accent);
        }

        label {
            font-weight: 500;
            margin-bottom: 8px;
        }

        button {
            color: #fff !important;
            background-color: var(--primary) !important;
            border: none !important;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--accent) !important;
        }

        .form-control {
            border: 1px solid #ddd;
            padding: 10px 20px;
        }

        a {
            color: var(--primary) !important;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--accent) !important;
        }

        .text-danger {
            font-size: 0.9rem;
            font-style: italic;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-family: 'Libre Baskerville', serif;
            font-weight: 700;
            color: var(--primary);
        }

        .form-header p {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>

<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-header">
            <h2>Login</h2>
            <p>Welcome back! Please log in to your account.</p>
        </div>

                <div class="field-group mb-4">
                    <label for="password" class="form-label">Security Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="••••••••" required style="border-right: none;">
                        <button class="btn" type="button" onclick="togglePass('password', this)" 
                                style="background: rgba(254, 243, 226, 0.04); border: 1px solid rgba(254, 243, 226, 0.12); border-left: none; color: var(--brand-cream);">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="meta-row">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link" style="margin-left: auto;">Forgot Access?</a>
                    @endif
                </div>

                <button type="submit" class="btn-premium" id="submitBtn">
                    <span id="btnText">Log In</span>
                </button>
            </form>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot your password?</a>
            @endif
            <button type="submit" class="btn btn-primary px-4 py-2">Log in</button>
        </div>
    </form>

    <script>
        // Add loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            btn.classList.add('loading');
            text.textContent = 'Verifying...';
        });

        function togglePass(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>

</html>
