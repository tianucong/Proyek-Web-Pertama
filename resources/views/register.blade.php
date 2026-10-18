<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
  <form method="POST" action="/register"
        class="bg-white p-8 rounded-2xl shadow-md w-full max-w-sm flex flex-col gap-4">
    @csrf

    <h1 class="text-2xl font-bold text-center">Buat Akun</h1>

    @if (session('sukses'))
      <p class="bg-green-100 text-green-700 p-3 rounded-lg text-sm">{{ session('sukses') }}</p>
    @endif

    <div>
      <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama"
             class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500" />
      @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
             class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500" />
      @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <input type="password" name="password" placeholder="Password (min. 8 karakter)"
             class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500" />
      @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <input type="password" name="password_confirmation" placeholder="Ulangi password"
           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl outline-none focus:border-blue-500" />

    <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl">
      Daftar
    </button>
  </form>
</body>
</html>