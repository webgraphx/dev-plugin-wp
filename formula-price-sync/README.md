# Formula Price Sync (طلا ارز پرو)

**Version:** 2.0.0-R17-IMPROVED  
**Author:** WebGraphx  
**Requires:** WordPress 5.8+, PHP 7.4+, WooCommerce 5.0+

افزونه قیمت‌گذاری خودکار محصولات ووکامرس بر اساس نرخ ارز، طلا و فرمول‌های سفارشی.

## قابلیت‌های اصلی

- همگام‌سازی خودکار قیمت از منابع (Navasan, TGJU, Nobitex, Manual)
- فرمول‌های سفارشی برای طلا ۱۸ عیار و محصولات عمومی
- پشتیبانی از محصولات ساده و متغیر (Variable)
- Circuit Breaker برای پایداری API
- لاگ کامل تغییرات قیمت و System Health
- لایسنس راست‌چین / ژاکت
- Action Scheduler برای صف پردازش
- پشتیبانی کامل از HPOS ووکامرس

## نصب

1. فایل zip را در پیشخوان وردپرس > افزونه‌ها > افزودن > بارگذاری نصب کنید.
2. افزونه را فعال کنید.
3. به منوی **Formula Price Sync** بروید و تنظیمات را انجام دهید.

## توسعه

```bash
composer install
npm install   # برای e2e (اختیاری)
./vendor/bin/phpunit
bash bin/build-release.sh
```

## لایسنس

GPL-2.0-or-later
