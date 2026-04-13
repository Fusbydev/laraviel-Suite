<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        input, select, button {
            border-radius: 50px !important;
        }

        input:focus, select:focus {
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

        .form-select {
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
    <form method="POST" action="/register">
        <div class="form-header">
            <h2>Create Account</h2>
            <p>Fill in the form add a new employee.</p>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
            <div class="text-danger mt-1">{{ $errors->first('name') }}</div>
        </div>

                    <!-- Role Selection -->
                    <div class="col-md-12">
                        <label for="role" class="form-label">System Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Choose a level of access</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                        </select>
                        @if($errors->has('role'))
                            <div class="text-danger">{{ $errors->first('role') }}</div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">Security Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control" 
                                   placeholder="Min. 8 characters" required style="border-right: none;">
                            <button class="btn" type="button" onclick="togglePass('password', this)" 
                                    style="background: rgba(254, 243, 226, 0.04); border: 1px solid rgba(191, 167, 93, 0.15); border-left: none; color: var(--brand-cream);">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <div class="text-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Key</label>
                        <div class="input-group">
                            <input id="password_confirmation" type="password" name="password_confirmation" 
                                   class="form-control" placeholder="Re-type password" required style="border-right: none;">
                            <button class="btn" type="button" onclick="togglePass('password_confirmation', this)" 
                                    style="background: rgba(254, 243, 226, 0.04); border: 1px solid rgba(191, 167, 93, 0.15); border-left: none; color: var(--brand-cream);">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="/login" class="text-decoration-none small">Already registered?</a>
            <button type="submit" class="btn btn-primary px-4 py-2">Register</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
