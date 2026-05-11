<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş – Radyo Mevlana Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-green-700 rounded-2xl mb-3">
                <i class="fa-solid fa-radio text-white text-2xl"></i>
            </div>
            <h1 class="text-white font-bold text-xl">Radyo Mevlana</h1>
            <p class="text-gray-400 text-sm">Admin Paneli</p>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
            @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/30 text-red-400 rounded-lg px-3 py-2.5 mb-4 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-gray-400 text-xs mb-1.5 block">Kullanıcı Adı</label>
                    <input type="text" name="username" required autofocus value="{{ old('username') }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label class="text-gray-400 text-xs mb-1.5 block">Şifre</label>
                    <input type="password" name="password" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-green-500">
                </div>
                <button type="submit"
                    class="w-full bg-green-700 hover:bg-green-600 text-white font-semibold py-3 rounded-xl transition">
                    Giriş Yap
                </button>
            </form>
        </div>
    </div>
</body>
</html>
