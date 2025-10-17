<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Pendukung Keputusan Cerdas BLT-DD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --brand:#1e90ff;
      --brand-600:#187bcd;
      --bg:#f4f9ff;
    }
    body {
      background: var(--bg);
      font-family: "Poppins", sans-serif;
    }
    .btn-brand {
      background: var(--brand);
      color:#fff;
      transition: all 0.3s;
      font-weight: 500;
    }
    .btn-brand:hover {
      background: var(--brand-600);
      color:#fff;
      transform: scale(1.02);
    }
    .card-header.brand {
      background: linear-gradient(90deg,#1e90ff,#6fb8ff);
      color:#fff;
      text-align: center;
    }
    .card {
      border: none;
      border-radius: 16px;
    }
    .form-control:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 0.2rem rgba(30,144,255,0.25);
    }
    .title-container {
      text-align: center;
      margin-bottom: 25px;
    }
    .title-container h4 {
      color: var(--brand);
      font-weight: 700;
    }
    .title-container p {
      color: #555;
      font-size: 0.95rem;
    }
  </style>
</head>

<body>
  <div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="row w-100 justify-content-center">
      <div class="col-12 col-sm-10 col-md-6 col-lg-5 col-xl-4">
        
     

        <!-- Kartu Login -->
        <div class="card shadow-lg">
          <div class="card-header brand py-3">
            <h1>Sistem Pendukung keputusan cerdas penerima BLT-DD</h1>
         
          <p>Desa Sungai Duri II</p>
          </div>
          <div class="card-body p-4">
            
            @if ($errors->any())
              <div class="alert alert-danger py-2 mb-3">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" class="form-control" name="username" value="{{ old('username') }}" required placeholder="Masukkan username Anda">
              </div>

              <div class="mb-3 position-relative">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
                  <span class="input-group-text bg-white" id="togglePassword" style="cursor:pointer;">
                    <i class="bi bi-eye-slash"></i>
                  </span>
                </div>
              </div>

              <button class="btn btn-brand w-100 mt-2" type="submit">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
              </button>
            </form>
          </div>

          <div class="card-footer text-center py-2">
            <small class="text-secondary">&copy; {{ date('Y') }} Desa Sungai Duri II - Sistem Pendukung Keputusan Cerdas BLT-DD</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bi-eye');
      this.querySelector('i').classList.toggle('bi-eye-slash');
    });
  </script>

</body>
</html>
