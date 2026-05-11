@extends('layouts.app')
@section('title', 'İletişim')
@section('description', 'Radyo Mevlana ile iletişime geçin.')

@section('content')

{{-- Hero --}}
<div class="relative overflow-hidden bg-brand-dark py-16 px-4">
    <div class="absolute inset-0 opacity-5"
         style="background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22><path d=%22M40 0 L80 40 L40 80 L0 40Z%22 fill=%22none%22 stroke=%22white%22 stroke-width=%221%22/></svg>');background-size:80px 80px;"></div>
    <div class="relative max-w-3xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 px-4 py-1.5 rounded-full text-gold text-sm mb-4">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>İletişim</span>
        </div>
        <p class="arabic text-gold text-2xl leading-loose mb-4">وَتَعَاوَنُوا عَلَى الْبِرِّ وَالتَّقْوَىٰ</p>
        <p class="text-white/40 text-xs mb-6">İyilik ve takva üzerine yardımlaşın. (Mâide 5/2)</p>

        {{-- Motto --}}
        <blockquote class="border-l-4 border-gold/60 pl-5 text-left bg-white/5 rounded-r-xl py-4 pr-4">
            <p class="text-white/80 text-sm leading-relaxed italic">
                Teknolojinin imkânlarını kullanarak geniş kitlelere ulaşmak,
                yenilikçi yaklaşımlarla İslami değerleri çağımıza uygun teknolojilerle aktarmak
                ve yeni kalplere, yeni yüreklere dokunmak ümidiyle…
            </p>
            <footer class="mt-3 text-gold text-xs font-semibold">— Mehmet Uzunca</footer>
        </blockquote>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Sol: iletişim bilgileri --}}
    <div class="space-y-5">
        <div>
            <h2 class="font-bold text-gray-800 text-lg mb-4">Bize Ulaşın</h2>
            <p class="text-gray-500 text-sm leading-relaxed">
                Görüş, öneri veya sorularınız için aşağıdaki form aracılığıyla
                ya da doğrudan e-posta ile iletişime geçebilirsiniz.
            </p>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg bg-brand-pale flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-envelope text-brand text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">E-posta</p>
                    <a href="mailto:mehmetuzunca85@gmail.com"
                       class="text-sm text-brand font-medium hover:underline">
                        mehmetuzunca85@gmail.com
                    </a>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg bg-brand-pale flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-radio text-brand text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Radyo</p>
                    <p class="text-sm text-gray-700 font-medium">Radyo Mevlana — İslami Radyo</p>
                    <p class="text-xs text-gray-400">24 saat kesintisiz yayın</p>
                </div>
            </div>
        </div>

        {{-- Motto kartı tekrar küçük --}}
        <div class="bg-brand rounded-xl p-5 text-white">
            <p class="arabic text-gold text-lg leading-loose mb-2 text-center">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
            <p class="text-white/70 text-xs leading-relaxed text-center">
                Şüphesiz, Allah'ın rahmetinden ancak kâfirler topluluğu ümit keser.
            </p>
        </div>
    </div>

    {{-- Sağ: form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <h3 class="font-bold text-gray-800 text-base mb-6 flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-brand"></i>
                Mesaj Gönder
            </h3>

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-5 py-4 flex items-start gap-3">
                <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach($errors->all() as $err)
                    <li class="flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-xs"></i> {{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            İsim Soyisim <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Adınız ve soyadınız"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand transition @error('name') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            E-posta <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="ornek@mail.com"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand transition @error('email') border-red-400 @enderror">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Konu <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                           placeholder="Mesajınızın konusu"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand transition @error('subject') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Mesaj <span class="text-red-400">*</span>
                    </label>
                    <textarea name="message" rows="6"
                              placeholder="Mesajınızı buraya yazın…"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand transition resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <p class="text-xs text-gray-400">
                        <i class="fa-solid fa-shield-halved mr-1"></i>
                        Bilgileriniz üçüncü taraflarla paylaşılmaz.
                    </p>
                    <button type="submit"
                            class="bg-brand text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-brand-light transition flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-paper-plane"></i> Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
