# Changelog — Radyo Mevlana

## [1.4.0] — 2026-05-16

### Eklendi
- **Günün Sözü Entegrasyonu**: Editör yazılarında "Günün Sözü" işaret kutucuğu eklendi
  - Admin panelinden herhangi bir editör yazısı tek tıkla günün sözü olarak seçilebilir
  - Seçili yazı ana sayfada Günün Sözü kutusunda özet + "Devamını oku" bağlantısıyla gösterilir
  - Aynı anda yalnızca bir yazı aktif olabilir; yeni seçimde önceki otomatik temizlenir
  - Tick'siz durumda AlQuran API'den gelen söz gösterilmeye devam eder
- **Shoutcast Geçmiş Import**: `shoutcast:import-history` artisan komutu; `played.html?sid=1` parse edilerek son çalınan parçalar veritabanına aktarılır
- **Son Çalan Parçalar Genişletildi**: Limit 10'dan 20'ye çıkarıldı; AJAX güncellemesi de 20 parça döndürür
- **Ana Sayfa Motto Şeridi**: Hero bölümü altında manevi motto satırı eklendi
- **21 Editör Yazısı**: Nefsin Yedi Mertebesi, Letâifler, Rüya/Yakaza/Keşif, 40 Kilit-40 Anahtar ve diğer konuları kapsayan manevi içerik serisi eklendi

### Düzeltildi
- Editör yazısı detay sayfasında HTML içerik `{{ }}` ile escape edilerek ham etiketler görünüyordu; `{!! !!}` ile düzeltildi
- `<h3>`, `<ul>`, `<blockquote>`, `<strong>` etiketleri artık Tailwind prose sınıflarıyla doğru biçimleniyor

---

## [1.3.0] — 2026-05-11

### Eklendi
- **Banner Yönetimi**: Admin panelinden tarih aralıklı reklam banner sistemi
  - Konumlar: Ana Sayfa, İçerik Altı, Hutbeler, Duyurular sayfaları
  - Aktif/pasif durumu, başlangıç–bitiş tarihi, sıralama desteği
- **PDF İçerik Çıkarma**: `hutbe:fill-content` komutu ile PDF'ten hutbe metni extraction
- **Hutbe Arşiv Scraper Düzeltmesi**: KKTC arşiv hutbelerinin farklı HTML formatı desteklendi (class='baslik'), 250+ hutbe çekilebiliyor

### Düzeltildi
- KKTC hutbe detay sayfalarının login gerektirmesi nedeniyle login metni içerik olarak kaydediliyordu; login sayfası tespiti eklendi
- Hutbe show sayfasındaki "Kaynağa git" linki kaldırıldı, yerini "PDF İndir" butonu aldı
- Blade layout'ta `@else@yield` direktiflerinin aynı satırda kullanımı derleme hatasına yol açıyordu; `@php` bloğu ile yeniden yapılandırıldı

---

## [1.2.0] — 2026-05-09

### Eklendi
- **İletişim Formu**: `/iletisim` rotası, ContactController, görünüm ve nav linki

### Düzeltildi
- Production `.htaccess`: `ea-php83` handler ile PHP 8.3.30 kullanımı (ea-php82 cageFS nedeniyle PHP 7.4 veriyordu)
- Deployment setup scripti: migrate:fresh ile tablo çakışması sorunu giderildi

---

## [1.1.0] — 2026-05-08

### Eklendi
- **Production Deployment**: radyomevlana.com canlıya alındı
- **Laravel Scheduler Cron Job**: cPanel API ile `schedule:run` her dakika çalışıyor
- **KKTC + Evkaf Otomatik Senkronizasyon**: 08:00, 20:00 ve 09:00 cron görevleri

---

## [1.0.0] — 2026-05-07

### İlk Sürüm
- Canlı radyo streaming (Shoutcast entegrasyonu)
- Hutbe yönetimi (KKTC Din İşleri scraper)
- Duyuru yönetimi (KKTC + Evkaf scraper)
- Editör yazıları modülü
- Ezan vakitleri yönetimi
- Günlük ayet ve hadis (Al-Quran API)
- Müzik istek sistemi
- Admin paneli (giriş, dashboard, tüm CRUD işlemleri)
- Menü yönetimi (header/footer)
- Sayfa ve SEO yönetimi
- Cloudflare arkasında cPanel shared hosting deployment
