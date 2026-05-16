# Radyo Mevlana

İslami içerikli 24 saat kesintisiz yayın yapan bir internet radyo platformu. KKTC Din İşleri Başkanlığı hutbe arşivi, ezan vakitleri, günün ayeti/hadisi, editör yazıları ve müzik istek sistemi ile birlikte gelir.

## Özellikler

- **Canlı Radyo** — Shoutcast entegrasyonu, anlık şarkı takibi, son 20 çalınan parça geçmişi
- **Hutbeler** — KKTC Din İşleri'nden otomatik çekilen haftalık hutbe arşivi; PDF metin çıkarma desteği
- **Duyurular** — KKTC ve Evkaf duyuruları otomatik senkronizasyon
- **Ezan Vakitleri** — Günlük namaz vakitleri yönetimi (KKTC)
- **Günlük İçerik** — Al-Quran API entegrasyonu ile günlük ayet ve hadis
- **Editör Köşesi** — Yöneticinin kaleme aldığı manevi yazılar; seçilen yazı ana sayfada "Günün Sözü" olarak gösterilir
- **Günün Sözü** — Admin panelinden tek tıkla herhangi bir editör yazısını günün sözü olarak işaretle; ana sayfada özet + "Devamını oku" linki
- **Banner Yönetimi** — Admin panelinden tarih aralıklı reklam/banner yönetimi (4 konum)
- **İletişim Formu** — Ziyaretçilerden mesaj alma
- **Müzik İsteği** — Dinleyicilerden şarkı isteği toplama
- **SEO Yönetimi** — Sayfa bazlı meta title/description/og yönetimi
- **Menü Yönetimi** — Header ve footer linkleri admin panelinden düzenleme
- **Admin Paneli** — Tüm içerik yönetimi için kapsamlı admin arayüzü

## Gereksinimler

- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+
- Composer
- Laravel 12.x

## Kurulum (Yerel Geliştirme)

```bash
git clone https://github.com/MEHMET-UZUNCA/radyomevlana.git
cd radyomevlana
composer install
cp .env.example .env
php artisan key:generate
# .env dosyasını düzenle (DB bilgileri, Shoutcast URL vb.)
php artisan migrate --seed
php artisan serve
```

## Production Deployment (cPanel/Shared Hosting)

1. `public/` içeriğini `public_html/` klasörüne kopyala
2. Geri kalan dosyaları `home` dizinine yükle
3. `public_html/.htaccess` dosyasına PHP 8.3 handler ekle:
   ```apache
   AddHandler application/x-httpd-ea-php83 .php
   ```
4. `.env` dosyasını production ayarlarıyla oluştur
5. Veritabanı ve tabloları oluştur:
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=InitialDataSeeder
   ```
6. cPanel'den cron job ekle (her dakika):
   ```
   /opt/alt/php83/usr/bin/php /home/KULLANICI/artisan schedule:run
   ```

## Zamanlanmış Görevler

| Görev | Sıklık | Açıklama |
|-------|--------|----------|
| `shoutcast:poll` | Her 30 saniye | Anlık şarkı bilgisi güncelleme |
| `daily:fetch` | Gece 00:05 | Günlük ayet ve hadis çekme |
| `kktc:scrape` | 08:00 + 20:00 | KKTC hutbe ve duyuru senkronizasyon |
| `evkaf:scrape` | 09:00 | Evkaf haber ve duyuru senkronizasyon |
| `hutbe:fill-content` | Manuel | PDF'ten hutbe metni çıkarma |
| `shoutcast:import-history` | Manuel | Shoutcast geçmiş parça listesini içe aktar |

## Admin Paneli

`/admin/login` → Kullanıcı adı ve şifreyle giriş

Varsayılan admin hesabı `db:seed` ile oluşturulur (`InitialDataSeeder`).

### Günün Sözü Seçimi

Admin → Editör Köşesi → herhangi bir yazıyı düzenle → "⭐ Günün Sözü olarak göster" kutucuğunu işaretle. Aynı anda yalnızca bir yazı günün sözü olabilir; yeni seçim yapıldığında önceki otomatik temizlenir.

## Ortam Değişkenleri

| Değişken | Açıklama |
|----------|----------|
| `APP_URL` | Site adresi |
| `DB_*` | Veritabanı bağlantı bilgileri |
| `MAIL_FROM_ADDRESS` | Mail gönderen adres |
| `SHOUTCAST_URL` | Shoutcast sunucu adresi (Settings tablosundan da ayarlanabilir) |

## Lisans

Özel kullanım. Tüm haklar saklıdır. © 2026 Mehmet Uzunca
