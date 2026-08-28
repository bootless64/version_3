# مستندات کامل تغییرات نسخه ۲ به نسخه ۳
# ASA Center — Full Changelog: Version 2 → Version 3

> این فایل تمام تغییرات پایگاه داده، کدها، کلاس‌ها، متدها و ویژگی‌های جدید اضافه‌شده در نسخه ۳ را نسبت به نسخه ۲ به‌صورت کامل و دقیق شرح می‌دهد.
> هیچ ویژگی از نسخه ۲ حذف نشده است. نسخه ۳ یک **superset** کامل از نسخه ۲ است.

---

## فهرست مطالب

1. [خلاصه کلی تغییرات](#۱-خلاصه-کلی-تغییرات)
2. [تغییرات پایگاه داده — جداول جدید](#۲-تغییرات-پایگاه-داده--جداول-جدید)
3. [تغییرات پایگاه داده — تغییر جداول موجود](#۳-تغییرات-پایگاه-داده--تغییر-جداول-موجود)
4. [ماژول فروشگاه و خرید مقاله](#۴-ماژول-فروشگاه-و-خرید-مقاله)
5. [ماژول پیشنهاد مقاله علمی](#۵-ماژول-پیشنهاد-مقاله-علمی)
6. [ماژول مقالات بین‌المللی و صفحات علمی](#۶-ماژول-مقالات-بینالمللی-و-صفحات-علمی)
7. [ماژول درخواست مشاوره](#۷-ماژول-درخواست-مشاوره)
8. [ماژول لاگ‌های سیستمی](#۸-ماژول-لاگهای-سیستمی)
9. [ماژول مسدودسازی IP](#۹-ماژول-مسدودسازی-ip)
10. [ماژول تنظیمات سایت](#۱۰-ماژول-تنظیمات-سایت)
11. [بهبودهای ماژول مقالات](#۱۱-بهبودهای-ماژول-مقالات)
12. [بهبودهای ماژول تیکت](#۱۲-بهبودهای-ماژول-تیکت)
13. [بهبودهای امنیتی — قفل اکانت](#۱۳-بهبودهای-امنیتی--قفل-اکانت)
14. [سرویس لاگینگ (LoggingService)](#۱۴-سرویس-لاگینگ-loggingservice)
15. [میدلور جدید (CheckBannedIp)](#۱۵-میدلور-جدید-checkbannedip)
16. [صفحات جدید (Views)](#۱۶-صفحات-جدید-views)
17. [مسیرهای جدید (Routes)](#۱۷-مسیرهای-جدید-routes)
18. [پرمیشن‌های جدید](#۱۸-پرمیشنهای-جدید)

---

## ۱. خلاصه کلی تغییرات

| ردیف | ماژول / بخش | نوع تغییر |
|------|-------------|-----------|
| ۱ | فروشگاه و خرید مقاله | جدید |
| ۲ | پیشنهاد مقاله علمی | جدید |
| ۳ | مقالات بین‌المللی و صفحات علمی | جدید |
| ۴ | درخواست مشاوره | جدید |
| ۵ | لاگ‌های سیستمی پیشرفته | جدید |
| ۶ | مسدودسازی IP | جدید |
| ۷ | تنظیمات سایت | جدید |
| ۸ | قفل اکانت پس از login ناموفق | جدید |
| ۹ | سرویس LoggingService | جدید |
| ۱۰ | میدلور CheckBannedIp | جدید |
| ۱۱ | بهبود ماژول مقالات (قیمت، فایل چکیده، تأیید/رد) | بهبود |
| ۱۲ | بهبود ماژول تیکت (دسته‌بندی، اولویت، نقش گیرنده) | بهبود |
| ۱۳ | صفحه جذب استعداد | جدید |

---

## ۲. تغییرات پایگاه داده — جداول جدید

### ۲.۱ جدول `orders` (سفارشات)

**فایل migration:** `2026_07_31_130018_create_orders_table.php`

```
orders
├── id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── user_id             BIGINT UNSIGNED — کلید خارجی به جدول users (cascade delete)
├── status              ENUM('pending','paid','failed','expired') DEFAULT 'pending'
│                       — وضعیت سفارش: در انتظار / پرداخت شده / ناموفق / منقضی
├── transaction_id      VARCHAR NULLABLE — شناسه تراکنش از درگاه پرداخت
├── total_amount        BIGINT — مبلغ کل سفارش به تومان
├── payment_method      VARCHAR NULLABLE — روش پرداخت
├── paid_at             TIMESTAMP NULLABLE — زمان پرداخت موفق
├── buyer_name          VARCHAR — نام خریدار
├── buyer_email         VARCHAR — ایمیل خریدار
├── buyer_phone         VARCHAR — شماره تلفن خریدار
├── terms_accepted      BOOLEAN DEFAULT false — تأیید قوانین
├── admin_note          TEXT NULLABLE — یادداشت مدیریت
├── created_at          TIMESTAMP
├── updated_at          TIMESTAMP
└── deleted_at          TIMESTAMP NULLABLE — SoftDelete
```

**کاربرد:** هر بار که کاربر اقدام به خرید مقاله می‌کند، یک رکورد سفارش ایجاد می‌شود. یک کاربر می‌تواند همزمان فقط یک سفارش با وضعیت `pending` داشته باشد (سبد خرید فعال).

---

### ۲.۲ جدول `order_items` (آیتم‌های سفارش)

**فایل migration:** `2026_07_31_130028_create_order_items_table.php`

```
order_items
├── id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── order_id    BIGINT UNSIGNED — کلید خارجی به جدول orders (cascade delete)
├── article_id  BIGINT UNSIGNED — کلید خارجی به جدول articles (cascade delete)
├── price       BIGINT — قیمت مقاله در زمان خرید (snapshot قیمت)
├── created_at  TIMESTAMP
└── updated_at  TIMESTAMP
```

**کاربرد:** هر مقاله‌ای که به سبد خرید اضافه می‌شود، یک آیتم در این جدول ثبت می‌شود. قیمت در زمان خرید ذخیره می‌شود تا تغییرات آتی قیمت مقاله روی سفارش‌های قبلی تأثیر نگذارد.

---

### ۲.۳ جدول `user_downloads` (دانلودهای کاربران)

**فایل migration:** `2026_07_31_130038_create_user_downloads_table.php`

```
user_downloads
├── id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── user_id       BIGINT UNSIGNED — کلید خارجی به جدول users (cascade delete)
├── article_id    BIGINT UNSIGNED — کلید خارجی به جدول articles (cascade delete)
├── order_id      BIGINT UNSIGNED — کلید خارجی به جدول orders (cascade delete)
├── downloaded_at TIMESTAMP NULLABLE — زمان آخرین دانلود (null یعنی هنوز دانلود نشده)
├── created_at    TIMESTAMP
└── updated_at    TIMESTAMP
```

**کاربرد:** بعد از پرداخت موفق، برای هر مقاله خریداری‌شده یک رکورد ایجاد می‌شود. این جدول به‌عنوان «کنترل دسترسی دانلود» عمل می‌کند. قبل از هر دانلود بررسی می‌شود که کاربر در این جدول رکورد داشته باشد.

---

### ۲.۴ جدول `article_proposals` (پیشنهادات مقاله)

**فایل migration:** `2026_07_18_152444_create_article_proposals_table.php`  
**فایل migration تکمیلی:** `2026_07_31_000000_add_submission_fields_to_article_proposals_table.php`

```
article_proposals
├── id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── user_id          BIGINT UNSIGNED — کلید خارجی به جدول users (cascade delete)
├── submission_type  VARCHAR DEFAULT 'article'
│                    — نوع ارسال: article / thesis / proposal_article / proposal_thesis
├── title            VARCHAR — عنوان مقاله یا پایان‌نامه
├── authors          VARCHAR — نویسندگان
├── student_name     VARCHAR NULLABLE — نام دانشجو (برای پایان‌نامه)
├── supervisor       VARCHAR NULLABLE — استاد راهنما
├── research_field   VARCHAR NULLABLE — حوزه تحقیق
├── keywords         VARCHAR NULLABLE — کلیدواژه‌ها
├── description      TEXT NULLABLE — توضیحات
├── title_explanation TEXT NULLABLE — توضیح عنوان (برای پیشنهادات)
├── similar_status   VARCHAR NULLABLE — وضعیت مشابه: exists / not_exists
├── similar_year     VARCHAR NULLABLE — سال کار مشابه
├── similar_place    VARCHAR NULLABLE — محل ارائه کار مشابه
├── similar_link     VARCHAR NULLABLE — لینک کار مشابه
├── type             ENUM('national','international') — بومی یا بین‌المللی
├── publication_year VARCHAR — سال انتشار
├── thesis_type      VARCHAR NULLABLE — نوع پایان‌نامه: thesis / dissertation
├── defense_year     VARCHAR NULLABLE — سال دفاع
├── file             VARCHAR NULLABLE — مسیر فایل اصلی
├── abstract_file    VARCHAR NULLABLE — مسیر فایل چکیده
├── status           ENUM('pending','approved','rejected') DEFAULT 'pending'
├── admin_note       TEXT NULLABLE — یادداشت ادمین هنگام رد پیشنهاد
├── created_at       TIMESTAMP
├── updated_at       TIMESTAMP
└── deleted_at       TIMESTAMP NULLABLE — SoftDelete
```

**کاربرد:** کاربران می‌توانند مقاله، پایان‌نامه، پیشنهاد مقاله یا پیشنهاد پایان‌نامه برای درج در سایت پیشنهاد دهند. ادمین پیشنهاد را بررسی و تأیید یا رد می‌کند. در صورت تأیید، به‌صورت خودکار یک رکورد در جدول `articles` ایجاد می‌شود.

---

### ۲.۵ جدول `consultation_requests` (درخواست‌های مشاوره)

**فایل migration:** `2026_07_18_200000_create_consultation_requests_table.php`

```
consultation_requests
├── id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── company_name  VARCHAR — نام شرکت متقاضی
├── phone         VARCHAR — شماره تماس
├── email         VARCHAR NULLABLE — ایمیل (اختیاری)
├── service_type  ENUM('ISO15408','ISO25000','penetration_test','document_management')
│                 — نوع خدمت درخواستی
├── status        ENUM('pending','responded') DEFAULT 'pending'
│                 — وضعیت: پاسخ داده نشده / پاسخ داده شده
├── created_at    TIMESTAMP
└── updated_at    TIMESTAMP
```

**کاربرد:** شرکت‌ها از طریق فرم عمومی سایت (بدون نیاز به ثبت‌نام) درخواست مشاوره ارسال می‌کنند. ادمین می‌تواند وضعیت هر درخواست را به «پاسخ داده شده» تغییر دهد.

---

### ۲.۶ جدول `system_logs` (لاگ‌های سیستم)

**فایل migration:** `2026_08_21_111637_create_system_logs_table.php`  
**فایل migration تکمیلی:** `2026_08_21_212117_add_user_name_to_system_logs_table.php`

```
system_logs
├── id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── event_time          TIMESTAMP DEFAULT CURRENT_TIMESTAMP — زمان دقیق رویداد
├── event_type          VARCHAR(100) — نوع رویداد (مثلاً: authentication_attempt)
├── event_category      VARCHAR(50) — دسته‌بندی: auth / data / security / system / admin / entity / session / user_management
├── event_result        BOOLEAN — نتیجه: true=موفق، false=ناموفق
├── user_id             BIGINT UNSIGNED NULLABLE — کلید خارجی به users (nullOnDelete)
├── user_name           VARCHAR(100) NULLABLE — نام کاربر (snapshot برای حفظ بعد از حذف کاربر)
├── user_ip             VARCHAR(45) NULLABLE — آدرس IP کاربر (تا IPv6)
├── user_agent          VARCHAR NULLABLE — مرورگر / User Agent
├── session_id          VARCHAR NULLABLE — شناسه session
├── method              VARCHAR(10) NULLABLE — متود HTTP: GET/POST/PATCH/DELETE
├── url                 VARCHAR NULLABLE — آدرس کامل درخواست
├── route_name          VARCHAR NULLABLE — نام route در Laravel
├── description         TEXT NULLABLE — توضیح فارسی رویداد
├── details             JSON NULLABLE — اطلاعات تکمیلی به‌صورت آرایه
├── error_message       TEXT NULLABLE — پیام خطا در صورت شکست
├── affected_entity     VARCHAR NULLABLE — نام موجودیت تأثیرپذیر (مثلاً: article)
├── affected_entity_id  BIGINT UNSIGNED NULLABLE — شناسه موجودیت تأثیرپذیر
├── created_at          TIMESTAMP
└── updated_at          TIMESTAMP

INDEXES:
├── (event_time, event_type, user_id) — برای جستجوی ترکیبی
└── (event_category, event_result) — برای فیلتر بر اساس دسته و نتیجه
```

**کاربرد:** تمام رویدادهای مهم سیستم در این جدول ذخیره می‌شوند: ورود/خروج کاربران، تغییرات داده، عملیات مدیریتی، خطاها، تغییرات پیکربندی و غیره.

---

### ۲.۷ جدول `banned_ips` (IP های مسدود)

**فایل migration:** `2026_08_21_220001_create_banned_ips_table.php`

```
banned_ips
├── id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── ip         VARCHAR(45) UNIQUE — آدرس IP مسدودشده (IPv4 یا IPv6)
├── reason     VARCHAR NULLABLE — دلیل مسدودسازی
├── banned_by  BIGINT UNSIGNED NULLABLE — کلید خارجی به users (nullOnDelete) — توسط چه کاربری بن شده
├── created_at TIMESTAMP
└── updated_at TIMESTAMP
```

**کاربرد:** ادمین می‌تواند آدرس‌های IP مشکوک را مسدود کند. میدلور `CheckBannedIp` قبل از هر درخواست این جدول را بررسی می‌کند.

---

### ۲.۸ جدول `settings` (تنظیمات سایت)

**فایل migration:** `2026_08_20_231056_create_settings_table.php`

```
settings
├── id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
├── key        VARCHAR UNIQUE — کلید تنظیم (مثلاً: password_min_length)
├── value      TEXT NULLABLE — مقدار تنظیم
├── created_at TIMESTAMP
└── updated_at TIMESTAMP
```

**کاربرد:** ذخیره تنظیمات قابل تغییر سایت به صورت key-value. فعلاً شامل تنظیمات رمزعبور (`password_min_length` و `password_complexity`) می‌شود. ساختار طراحی شده تا در آینده تنظیمات بیشتری اضافه شود.

---

## ۳. تغییرات پایگاه داده — تغییر جداول موجود

### ۳.۱ جدول `articles` — ستون‌های جدید

**فایل migration 1:** `2026_07_17_214322_update_articles_table_for_public_articles.php`

```diff
articles
+ keywords         VARCHAR NULLABLE — کلیدواژه‌های مقاله
+ authors          VARCHAR NULLABLE — نام نویسندگان
+ publication_year VARCHAR NULLABLE — سال انتشار
+ abstract_file    VARCHAR NULLABLE — مسیر فایل چکیده
+ is_published     BOOLEAN DEFAULT true — آیا منتشر شده؟
```

**فایل migration 2:** `2026_07_17_222345_add_description_to_articles_table.php`

```diff
articles
+ description TEXT NULLABLE — توضیح کوتاه مقاله
```

**فایل migration 3:** `2026_07_18_160549_add_admin_note_to_articles_table.php`

```diff
articles
+ admin_note TEXT NULLABLE — یادداشت ادمین هنگام رد یا توضیح
```

**فایل migration 4:** `2026_07_31_125958_add_price_fields_to_articles_table.php`

```diff
articles
+ price        BIGINT NULLABLE — قیمت به تومان (null یعنی رایگان)
+ is_free      BOOLEAN DEFAULT true — آیا رایگان است؟
+ price_set_by BIGINT UNSIGNED NULLABLE — کلید خارجی به users (کسی که قیمت را تعیین کرده)
```

**دلیل تغییرات:** برای پشتیبانی از مقالات بین‌المللی (نیاز به نویسنده، سال، کلیدواژه) و همچنین سیستم فروشگاه (نیاز به قیمت و وضعیت رایگان/پولی).

---

### ۳.۲ جدول `tickets` — ستون‌های جدید

**فایل migration 1:** `2026_06_12_183002_add_category_and_priority_to_tickets_table.php`

```diff
tickets
+ category ENUM('technical','financial','support','content','other') DEFAULT 'other'
+           — دسته‌بندی تیکت: فنی / مالی / پشتیبانی / محتوا / سایر
+ priority  ENUM('low','medium','high') DEFAULT 'medium'
+           — اولویت تیکت: پایین / متوسط / بالا
```

**فایل migration 2:** `2026_07_17_152035_add_receiver_role_to_tickets_table.php`

```diff
tickets
+ receiver_role ENUM('admin','support','coach','delegate') NULLABLE
+               — نقش گیرنده تیکت (وقتی گیرنده مشخص نیست، به یک نقش ارسال می‌شود)
```

**دلیل تغییرات:** امکان فیلتر و اولویت‌بندی تیکت‌ها، و ارسال تیکت به یک نقش (مثلاً همه پشتیبان‌ها) به‌جای یک فرد مشخص.

---

### ۳.۳ جدول `users` — ستون‌های جدید

**فایل migration:** `2026_08_21_220002_add_login_lock_columns_to_users_table.php`

```diff
users
+ login_attempts TINYINT UNSIGNED DEFAULT 0 — تعداد تلاش‌های ناموفق ورود
+ locked_until   TIMESTAMP NULLABLE — تا چه زمانی اکانت قفل است (null یعنی قفل نیست)
```

**دلیل تغییرات:** پیاده‌سازی مکانیسم قفل اکانت بعد از چند بار ورود ناموفق متوالی.

---

### ۳.۴ پرمیشن‌های جدید در جداول Spatie

**فایل migration:** `2026_07_31_135229_add_manage_orders_permission.php`

```
permissions جدید:
└── manage_orders (fa_name: مدیریت سفارشات)
    └── داده می‌شود به: admin, support
```

**فایل migration:** `2026_08_20_231716_add_manage_settings_permission.php`

```
permissions جدید:
└── manage_settings (fa_name: مدیریت تنظیمات)
    └── داده می‌شود به: admin, support
```

---

## ۴. ماژول فروشگاه و خرید مقاله

### ۴.۱ کنترلر `ShopController`

**فایل:** `app/Http/Controllers/ShopController.php`  
**مسیر:** تمام روت‌ها زیر `/shop` قرار دارند و نیاز به احراز هویت دارند.

#### متد `__construct(LoggingService $logger)`
تزریق سرویس لاگینگ از طریق Dependency Injection. این الگو در تمام کنترلرهای جدید نسخه ۳ استفاده شده.

#### متد `addToCart(Request $request, $articleId)` — POST `/shop/add-to-cart/{article}`
افزودن مقاله به سبد خرید.

**منطق:**
1. مقاله را پیدا می‌کند (باید approved و is_published باشد)
2. چک می‌کند مقاله رایگان نباشد (is_free=false)
3. چک می‌کند کاربر قبلاً مقاله را نخریده باشد (جدول user_downloads)
4. چک می‌کند مقاله قبلاً در سبد کاربر نباشد
5. با `firstOrCreate` یک سفارش pending پیدا یا ایجاد می‌کند
6. یک `OrderItem` ایجاد می‌کند با قیمت لحظه‌ای مقاله
7. مجموع `total_amount` سفارش را به‌روز می‌کند
8. رویداد را لاگ می‌کند
9. JSON response برمی‌گرداند (مناسب برای AJAX)

**برمی‌گرداند:** `JSON { success: bool, message: string }`

#### متد `cart()` — GET `/shop/cart`
نمایش سبد خرید کاربر.

سفارش `pending` کاربر را با رابطه `items.article` لود می‌کند و به view ارسال می‌کند.

#### متد `removeFromCart($itemId)` — DELETE `/shop/remove-from-cart/{item}`
حذف یک آیتم از سبد خرید با شناسه آیتم.

**منطق امنیتی:** چک می‌کند که آیتم متعلق به کاربر جاری باشد و سفارش در وضعیت `pending` باشد. اگر بعد از حذف سبد خالی شد، سفارش هم حذف می‌شود.

#### متد `removeFromCartByArticle($articleId)` — DELETE `/shop/remove-from-cart-article/{article}`
حذف مقاله از سبد خرید با شناسه مقاله (برای استفاده در صفحه جزئیات مقاله).

با try/catch پوشیده شده و JSON response برمی‌گرداند.

#### متد `checkout()` — GET `/shop/checkout`
نمایش صفحه تسویه حساب.

سفارش `pending` کاربر را با `firstOrFail` لود می‌کند (اگر سبد خالی باشد 404 می‌دهد).

#### متد `processPayment(Request $request)` — POST `/shop/process-payment`
پردازش فرم پرداخت.

**validation فیلدها:**
- `buyer_name` — required
- `buyer_email` — required|email
- `buyer_phone` — required
- `terms_accepted` — required|accepted (checkbox)

**منطق:**
1. اطلاعات خریدار را در سفارش ثبت می‌کند
2. متغیر `$paymentSuccess = false` (فعلاً پرداخت شبیه‌سازی‌شده غیرفعال است)
3. در صورت موفقیت (درون `DB::transaction`):
   - وضعیت سفارش به `paid` تغییر می‌کند
   - `transaction_id` ثبت می‌شود
   - برای هر مقاله یک رکورد در `user_downloads` ایجاد می‌شود
4. به صفحه success یا failed redirect می‌کند

#### متد `paymentSuccess($orderId)` — GET `/shop/payment-success/{order}`
نمایش صفحه پرداخت موفق. فقط سفارش‌های `paid` کاربر جاری نمایش داده می‌شوند.

#### متد `paymentFailed($orderId)` — GET `/shop/payment-failed/{order}`
نمایش صفحه پرداخت ناموفق. فقط سفارش‌های `pending` کاربر جاری نمایش داده می‌شوند.

#### متد `downloadPurchasedArticle($articleId)` — GET `/shop/download/{article}`
دانلود مقاله خریداری‌شده.

**منطق امنیتی:**
1. اگر مقاله رایگان بود، مستقیم دانلود (بدون چک خرید)
2. در غیر این صورت بررسی می‌کند کاربر در `user_downloads` رکورد داشته باشد
3. اگر دسترسی نداشت، 403 می‌دهد
4. زمان `downloaded_at` را به‌روز می‌کند
5. فایل را از `storage/app/public/` سرو می‌کند

#### متد `downloadFile($article)` — private
متد خصوصی داخلی برای سرو فایل. مسیر فیزیکی فایل را بررسی می‌کند و با `response()->download()` ارسال می‌کند.

#### متد `manageOrders(Request $request)` — GET `/dashboard/manage-orders`
لیست تمام سفارشات برای ادمین با فیلترهای: شناسه، نام خریدار، وضعیت، بازه تاریخ.

#### متد `showOrder($id)` — GET `/dashboard/manage-orders/{order}`
نمایش جزئیات یک سفارش برای ادمین، شامل آیتم‌ها و دانلودها.

#### متد `updateOrderStatus(Request $request, $id)` — PATCH `/dashboard/manage-orders/{order}/update-status`
تغییر وضعیت سفارش توسط ادمین.

**مقادیر معتبر وضعیت:** `pending` / `paid` / `failed` / `expired`  
همچنین `admin_note` را ذخیره می‌کند.

#### متد `orderDetails($id)` — GET `/dashboard/order-details/{order}`
نمایش جزئیات سفارش. اگر کاربر `manage_orders` permission داشت، همه سفارشات را می‌بیند. در غیر این صورت فقط سفارش‌های خودش.

#### متد `destroyOrder($id)` — DELETE `/dashboard/manage-orders/{order}`
حذف سفارش به‌همراه `items` و `downloads` مرتبط.

#### متد `myOrders()` — GET `/dashboard/my-orders`
لیست سفارشات پرداخت‌شده (`paid`) کاربر جاری.

---

### ۴.۲ مدل `Order`

**فایل:** `app/Models/Order.php`

```php
use SoftDeletes; // حذف نرم

$fillable = [
    'user_id', 'status', 'transaction_id', 'total_amount',
    'payment_method', 'paid_at', 'buyer_name', 'buyer_email',
    'buyer_phone', 'terms_accepted', 'admin_note'
];

$casts = [
    'total_amount'   => 'integer',
    'terms_accepted' => 'boolean',
    'paid_at'        => 'datetime',
];
```

**رابطه‌ها:**
- `user()` — belongsTo User — کاربر خریدار
- `items()` — hasMany OrderItem — آیتم‌های سفارش
- `downloads()` — hasMany UserDownload — دانلودهای مرتبط

**Accessor ها:**
- `getStatusLabelAttribute()` — برچسب فارسی وضعیت سفارش
- `getStatusBadgeClassAttribute()` — کلاس Bootstrap برای نمایش badge وضعیت

---

### ۴.۳ مدل `OrderItem`

**فایل:** `app/Models/OrderItem.php`

```php
$fillable = ['order_id', 'article_id', 'price'];
$casts = ['price' => 'integer'];
```

**رابطه‌ها:**
- `order()` — belongsTo Order
- `article()` — belongsTo Article

---

### ۴.۴ مدل `UserDownload`

**فایل:** `app/Models/UserDownload.php`

```php
$fillable = ['user_id', 'article_id', 'order_id', 'downloaded_at'];
$casts = ['downloaded_at' => 'datetime'];
```

**رابطه‌ها:**
- `user()` — belongsTo User
- `article()` — belongsTo Article
- `order()` — belongsTo Order

---

### ۴.۵ ویوهای فروشگاه

| فایل | مسیر | توضیح |
|------|------|-------|
| `shop/cart.blade.php` | `/shop/cart` | نمایش سبد خرید با لیست مقالات و قیمت‌ها |
| `shop/checkout.blade.php` | `/shop/checkout` | فرم اطلاعات خریدار و تأیید قوانین |
| `shop/payment-success.blade.php` | `/shop/payment-success/{order}` | صفحه پرداخت موفق با لینک دانلود |
| `shop/payment-failed.blade.php` | `/shop/payment-failed/{order}` | صفحه پرداخت ناموفق |
| `dashboard/manage-orders.blade.php` | `/dashboard/manage-orders` | لیست سفارشات برای ادمین با فیلتر و modal تغییر وضعیت |
| `dashboard/my-orders.blade.php` | `/dashboard/my-orders` | لیست سفارشات پرداخت‌شده کاربر |
| `dashboard/order-details.blade.php` | `/dashboard/order-details/{order}` | جزئیات کامل یک سفارش (هم برای کاربر هم ادمین) |

---

## ۵. ماژول پیشنهاد مقاله علمی

### ۵.۱ کنترلر `ArticleProposalController`

**فایل:** `app/Http/Controllers/ArticleProposalController.php`

#### متد `index()` — GET `/submit-proposal`
نمایش صفحه ارسال پیشنهاد و لیست پیشنهادات کاربر جاری.

اگر کاربر لاگین نکرده باشد، به صفحه ورود redirect می‌کند (به‌جای استفاده از middleware).

#### متد `store(Request $request)` — POST `/submit-proposal`
ذخیره پیشنهاد جدید. این متد بزرگ‌ترین متد در سیستم است و ۴ نوع ارسال مختلف را پشتیبانی می‌کند:

**نوع ۱: `article` (مقاله)**
- validation: title، authors، keywords، description، type (national/international)، publication_year، file (max 30MB)، abstract_file (اختیاری، max 20MB)
- اعتبارسنجی سال: برای ملی باید شمسی ۱۳۸۰–۱۴۰۵، برای بین‌المللی میلادی ۱۹۹۰–۲۰۲۶
- فایل‌ها در `public/proposals/article/files/` و `public/proposals/article/abstracts/` ذخیره می‌شوند

**نوع ۲: `thesis` (پایان‌نامه / رساله)**
- validation: thesis_type، title، student_name، supervisor، research_field، defense_year، file (اجباری)، abstract_file (اجباری)
- سال دفاع شمسی ۴ رقمی
- فایل‌ها در `public/proposals/thesis/` ذخیره می‌شوند

**نوع ۳: `proposal_article` (پیشنهاد موضوع مقاله)**
- validation: title، title_explanation، keywords، similar_status (exists/does_not_exist/no_info)
- فیلدهای similar_year، similar_place، similar_link فقط اگر similar_status='exists' ذخیره می‌شوند
- فایل اختیاری است

**نوع ۴: `proposal_thesis` (پیشنهاد موضوع پایان‌نامه)**
- مشابه proposal_article به‌علاوه thesis_type

#### متد `destroy($id)` — DELETE `/submit-proposal/{id}`
کاربر فقط پیشنهادات خودش با وضعیت `pending` را می‌تواند حذف کند. فایل‌های ذخیره‌شده هم حذف می‌شوند.

#### متد `approveProposal($id)` — POST `/dashboard/manage-proposals/{id}/approve`
تأیید پیشنهاد توسط ادمین. این متد اتوماتیک یک مقاله جدید در جدول `articles` می‌سازد:

**منطق تبدیل پیشنهاد به مقاله:**
- بر اساس نوع (`submission_type`) فیلدهای مقاله پر می‌شوند
- برای `thesis`: نام دانشجو و استاد راهنما در فیلد `authors` ترکیب می‌شوند
- فایل‌ها از مسیر proposals به مسیر articles کپی می‌شوند (نه move، تا نسخه اصلی محفوظ بماند)
- مقاله با status='approved' و is_published=true ذخیره می‌شود
- وضعیت پیشنهاد به 'approved' تغییر می‌کند
- رویداد لاگ می‌شود

#### متد `rejectProposal(Request $request, $id)` — POST `/dashboard/manage-proposals/{id}/reject`
رد پیشنهاد توسط ادمین با امکان وارد کردن `admin_note` برای توضیح دلیل رد.

#### متد `destroyProposal($id)` — DELETE `/dashboard/manage-proposals/{id}`
حذف پیشنهاد توسط ادمین. فایل‌های فیزیکی هم حذف می‌شوند.

---

### ۵.۲ مدل `ArticleProposal`

**فایل:** `app/Models/ArticleProposal.php`

```php
use SoftDeletes; // حذف نرم
```

**رابطه‌ها:**
- `user()` — belongsTo User — کاربر پیشنهاددهنده

**Accessor ها:**
- `getStatusLabelAttribute()` — برچسب فارسی: «در انتظار تایید» / «تایید شده» / «رد شده»
- `getStatusBadgeClassAttribute()` — کلاس Bootstrap badge برای هر وضعیت

---

### ۵.۳ ویوهای پیشنهاد مقاله

| فایل | توضیح |
|------|-------|
| `scientific/submit-proposal.blade.php` | صفحه عمومی ارسال پیشنهاد با ۴ تب برای ۴ نوع ارسال |

---

## ۶. ماژول مقالات بین‌المللی و صفحات علمی

### ۶.۱ کنترلر `ScientificController`

**فایل:** `app/Http/Controllers/ScientificController.php`

یک کنترلر ساده با ۴ متد که فقط view برمی‌گردانند:

| متد | مسیر | ویو |
|-----|------|-----|
| `researchInternational()` | GET `/research/international` | `scientific/research-international` |
| `articlesInternational()` | GET `/articles/international` | `scientific/articles-international` |
| `rnd()` | GET `/rnd` | `scientific/rnd` |
| `submitProposal()` | — | `scientific/submit-proposal` |

---

### ۶.۲ متدهای جدید در `ArticleController`

#### متد `internationalArticles(Request $request)` — GET `/articles/international`
لیست مقالات علمی (national یا international) با قابلیت فیلتر.

**فیلترها:** keyword (در فیلد keywords)، author (در فیلد authors)، type_filter (national/international)، year (publication_year)

نتایج را paginate با ۹ آیتم برمی‌گرداند. همچنین لیست سال‌های موجود را برای dropdown فیلتر ارسال می‌کند.

#### متد `showInternationalArticle($id)` — GET `/articles/international/{id}`
نمایش جزئیات یک مقاله علمی.

#### متد `downloadFile($id)` — GET `/articles/international/{id}/download`
دانلود فایل اصلی مقاله از `storage/app/public/articles/files/`.

#### متد `downloadAbstract($id)` — GET `/articles/international/{id}/download-abstract`
دانلود فایل چکیده مقاله از `storage/app/public/articles/abstracts/`.

#### متد `viewAbstract($id)` — GET `/articles/international/{id}/view-abstract`
نمایش inline فایل چکیده PDF در مرورگر (به‌جای دانلود). header `Content-Disposition: inline` تنظیم می‌کند.

#### متد `approveArticle($id)` — POST `/dashboard/manage-articles/{article}/approve`
تأیید مقاله توسط ادمین. فقط مقالات با وضعیت `pending` قابل تأیید هستند. رویداد لاگ می‌شود.

#### متد `rejectArticle(Request $request, $id)` — POST `/dashboard/manage-articles/{article}/reject`
رد مقاله توسط ادمین با امکان ثبت `admin_note`.

#### متد `create()` — GET `/dashboard/manage-articles/create`
نمایش فرم ایجاد مقاله جدید توسط ادمین. (در نسخه ۲ فقط کاربران می‌توانستند مقاله بنویسند، در نسخه ۳ ادمین هم می‌تواند مستقیم مقاله ایجاد کند)

#### متد `store(Request $request)` — POST `/dashboard/manage-articles`
ذخیره مقاله جدید توسط ادمین.

**اعتبارسنجی:** title، authors، keywords، description، type (national/international)، publication_year، status، file (max 30MB)، abstract_file (اختیاری)

اعتبارسنجی سال مشابه proposal: برای ملی شمسی، برای بین‌المللی میلادی.

#### متد `editArticle($id)` — GET `/dashboard/manage-articles/{article}/edit`
فرم ویرایش مقاله توسط ادمین (برخلاف `edit()` که برای مالک است).

#### متد `updateArticle(Request $request, $id)` — PUT `/dashboard/manage-articles/{article}`
ذخیره ویرایش مقاله توسط ادمین. امکان تغییر قیمت، is_free، فایل‌ها و تمام فیلدها. رویداد لاگ می‌شود.

---

### ۶.۳ تغییرات مدل `Article`

فیلدهای جدید به `$fillable` اضافه شدند:
```php
'keywords', 'authors', 'publication_year', 'abstract_file',
'is_published', 'description', 'admin_note',
'price', 'is_free', 'price_set_by'
```

Cast های جدید:
```php
'is_published' => 'boolean',
'is_free'      => 'boolean',
'price'        => 'integer',
```

**رابطه جدید:**
- `priceSetter()` — belongsTo User, foreign_key='price_set_by' — کاربری که قیمت را تعیین کرده

**متد جدید:**
- `isPurchasedByUser($userId)` — bool — بررسی می‌کند کاربر مقاله را خریده یا نه (با جستجو در user_downloads)

**Accessor های جدید:**
- `getPriceFormattedAttribute()` — نمایش فارسی قیمت: «رایگان» یا «۱۵۰,۰۰۰ تومان»
- `getTypeLabelAttribute()` — برچسب فارسی نوع: «بومی» / «بین‌المللی»
- `getStatusLabelAttribute()` — برچسب فارسی وضعیت: «در انتظار بررسی» / «تایید شده» / «رد شده»
- `getTypeBadgeClassAttribute()` — کلاس Bootstrap badge نوع
- `getStatusBadgeClassAttribute()` — کلاس Bootstrap badge وضعیت

---

### ۶.۴ ویوهای علمی جدید

| فایل | مسیر عمومی | توضیح |
|------|-----------|-------|
| `scientific/articles-international.blade.php` | `/articles/international` | لیست مقالات با فیلتر keyword، author، نوع، سال |
| `scientific/article-detail.blade.php` | `/articles/international/{id}` | جزئیات مقاله با دکمه دانلود/مشاهده چکیده |
| `scientific/research-international.blade.php` | `/research/international` | صفحه اطلاعاتی تحقیقات بین‌المللی |
| `scientific/rnd.blade.php` | `/rnd` | صفحه اطلاعاتی R&D |
| `dashboard/articles-create.blade.php` | `/dashboard/manage-articles/create` | فرم ایجاد مقاله توسط ادمین |
| `dashboard/articles-edit.blade.php` | `/dashboard/manage-articles/{id}/edit` | فرم ویرایش مقاله توسط ادمین |

---

## ۷. ماژول درخواست مشاوره

### ۷.۱ کنترلر `ConsultationController`

**فایل:** `app/Http/Controllers/ConsultationController.php`

#### متد `store(Request $request)` — POST `/consultation-request`
ذخیره درخواست مشاوره از فرم عمومی سایت (بدون نیاز به ورود).

**validation (با error bag جداگانه `consultation` برای جلوگیری از تداخل با فرم‌های دیگر صفحه):**
- `company_name` — required|max:255
- `phone` — required|max:20
- `email` — nullable|email
- `service_type` — required|in:ISO15408,ISO25000,penetration_test,document_management

رویداد با `user_id=null` لاگ می‌شود (چون کاربر ممکن است مهمان باشد).  
Session flash با کلید `consultation_success` به‌جای `success` استفاده می‌شود.

#### متد `index(Request $request)` — GET `/dashboard/manage-consultations`
لیست درخواست‌های مشاوره برای ادمین با فیلتر: وضعیت، نام شرکت، نوع خدمت.

#### متد `updateStatus(Request $request, $id)` — PATCH `/dashboard/manage-consultations/{id}/update-status`
تغییر وضعیت درخواست: `pending` ← `responded`. رویداد لاگ می‌شود.

#### متد `destroy($id)` — DELETE `/dashboard/manage-consultations/{id}`
حذف درخواست مشاوره. رویداد لاگ می‌شود.

---

### ۷.۲ مدل `ConsultationRequest`

**فایل:** `app/Models/ConsultationRequest.php`

**Accessor های فارسی:**
- `getServiceTypeLabelAttribute()` — نوع خدمت به فارسی (مثلاً: «استاندارد ISO/IEC 15408»)
- `getStatusLabelAttribute()` — وضعیت به فارسی: «پاسخ داده نشده» / «پاسخ داده شده»

---

### ۷.۳ ویوهای مشاوره

| فایل | توضیح |
|------|-------|
| `dashboard/manage-consultations.blade.php` | جدول مدیریت درخواست‌ها با فیلتر، دکمه تغییر وضعیت و حذف |

---

## ۸. ماژول لاگ‌های سیستمی

### ۸.۱ کنترلر `SystemLogController`

**فایل:** `app/Http/Controllers/SystemLogController.php`

#### متد `index(Request $request)` — GET `/dashboard/manage-logs`
لیست لاگ‌های سیستم با فیلترهای پیشرفته:
- بازه تاریخ (`date_from` / `date_to`)
- نوع رویداد (`event_type`)
- دسته‌بندی (`category`)
- نتیجه: موفق/ناموفق (`result`)
- شناسه کاربر (`user_id`)
- آدرس IP (`ip`)

نتایج با ۵۰ آیتم در هر صفحه نمایش داده می‌شوند. لیست دسته‌بندی‌ها و نوع رویدادها به‌صورت dynamic از داده‌های موجود در جدول استخراج می‌شوند.

#### متد `show($id)` — GET `/dashboard/manage-logs/{id}`
نمایش جزئیات یک لاگ.

#### متد `destroy($id)` — DELETE `/dashboard/manage-logs/{id}`
حذف یک لاگ. خود این عملیات هم لاگ می‌شود.

#### متد `clearOld(Request $request)` — POST `/dashboard/manage-logs/clear-old`
پاک‌سازی لاگ‌های قدیمی‌تر از N روز (پیش‌فرض: ۳۰ روز).  
تعداد رکوردهای حذف‌شده را در پیام موفقیت نمایش می‌دهد.

---

### ۸.۲ مدل `SystemLog`

**فایل:** `app/Models/SystemLog.php`

```php
$casts = [
    'event_time'   => 'datetime',
    'event_result' => 'boolean',
    'details'      => 'array', // JSON به‌صورت array
];
```

**رابطه‌ها:**
- `user()` — belongsTo User — کاربری که رویداد را ایجاد کرده

**Accessor ها:**
- `getResultLabelAttribute()` — «موفق» یا «ناموفق»
- `getResultBadgeClassAttribute()` — `bg-success` یا `bg-danger`

---

### ۸.۳ ویوی مدیریت لاگ‌ها

**فایل:** `dashboard/manage-logs.blade.php`

این ویو دو بخش در قالب tab دارد:
1. **لاگ‌های سیستم** — جدول لاگ‌ها با فیلتر + modal جزئیات هر لاگ + دکمه «بن IP» برای هر لاگ
2. **آی‌پی‌های بن شده** — لیست IP های مسدود + فرم «بن دستی آی‌پی»

ویژگی‌های بصری: رنگ‌بندی ردیف بر اساس موفقیت/شکست رویداد با border-right رنگی، badge های دسته‌بندی با رنگ‌های مختلف.

---

## ۹. ماژول مسدودسازی IP

### ۹.۱ کنترلر `BanIpController`

**فایل:** `app/Http/Controllers/BanIpController.php`

#### متد `store(Request $request)` — POST `/dashboard/manage-logs/ban-ip`
مسدود کردن یک IP.

**validation:** `ip` — required|ip (اعتبارسنجی فرمت IP توسط Laravel)، `reason` — nullable|max:255

قبل از ذخیره چک می‌کند IP قبلاً بن نشده باشد. `banned_by` با شناسه کاربر جاری پر می‌شود. رویداد `ban_ip` لاگ می‌شود.

#### متد `destroy($id)` — DELETE `/dashboard/manage-logs/ban-ip/{id}`
رفع مسدودیت IP. رویداد `unban_ip` لاگ می‌شود.

---

### ۹.۲ مدل `BannedIp`

**فایل:** `app/Models/BannedIp.php`

**رابطه‌ها:**
- `bannedBy()` — belongsTo User, foreign_key='banned_by' — ادمینی که IP را بن کرده

**متد استاتیک:**
- `isBanned(string $ip): bool` — بررسی می‌کند IP در لیست بن هست یا نه. توسط میدلور استفاده می‌شود.

---

### ۹.۳ میدلور `CheckBannedIp`

**فایل:** `app/Http/Middleware/CheckBannedIp.php`

**ثبت در Kernel:** در آرایه `$middleware` (global middleware stack) اضافه شده، یعنی برای **همه درخواست‌ها** اجرا می‌شود.

```php
public function handle(Request $request, Closure $next)
{
    if (BannedIp::isBanned($request->ip())) {
        abort(403, 'دسترسی شما به این سایت مسدود شده است.');
    }
    return $next($request);
}
```

**تفاوت با نسخه ۲:** در نسخه ۲ هیچ مکانیزمی برای مسدود کردن IP وجود نداشت.

---

## ۱۰. ماژول تنظیمات سایت

### ۱۰.۱ کنترلر `SettingController`

**فایل:** `app/Http/Controllers/SettingController.php`

#### متد `index()` — GET `/dashboard/settings`
خواندن تنظیمات جاری از دیتابیس با مقادیر پیش‌فرض:
- `password_min_length`: پیش‌فرض ۸
- `password_complexity`: پیش‌فرض `medium`

#### متد `update(Request $request)` — PUT `/dashboard/settings`
ذخیره تنظیمات.

**validation:**
- `password_min_length` — required|integer|min:4|max:20
- `password_complexity` — required|in:simple,medium,complex

مقادیر قدیمی قبل از ذخیره خوانده می‌شوند تا تغییر در لاگ ثبت شود.

---

### ۱۰.۲ مدل `Setting`

**فایل:** `app/Models/Setting.php`

**متدهای استاتیک:**
- `Setting::get($key, $default = null)` — خواندن مقدار یک تنظیم با مقدار پیش‌فرض
- `Setting::set($key, $value)` — ذخیره یا به‌روزرسانی یک تنظیم (با `updateOrCreate`)

---

### ۱۰.۳ ویوی تنظیمات

**فایل:** `dashboard/settings.blade.php`

فرم تنظیم حداقل طول رمزعبور (۴ تا ۲۰) و سطح پیچیدگی (آسان/متوسط/پیچیده). شامل راهنمای توضیحی برای هر سطح.

---

## ۱۱. بهبودهای ماژول مقالات

خلاصه تغییرات نسبت به نسخه ۲:

| بخش | نسخه ۲ | نسخه ۳ |
|-----|--------|--------|
| ادمین ایجاد مقاله | نمی‌تواند | می‌تواند (create + store) |
| ادمین ویرایش مقاله | نمی‌تواند | می‌تواند (editArticle + updateArticle) |
| تأیید/رد مقاله | فقط updateStatus | approveArticle + rejectArticle جداگانه |
| یادداشت رد مقاله | نداشت | admin_note ثبت می‌شود |
| فیلد قیمت | نداشت | price + is_free + price_set_by |
| فیلد چکیده | نداشت | abstract_file |
| فیلد نویسندگان | نداشت | authors |
| سال انتشار | نداشت | publication_year |
| کلیدواژه | نداشت | keywords |
| وضعیت انتشار | نداشت | is_published |
| پیشنهادات در manage-articles | نداشت | دارد (با pagination جداگانه) |
| لاگ عملیات | نداشت | دارد (create, update, delete, approve, reject) |

---

## ۱۲. بهبودهای ماژول تیکت

### ۱۲.۱ تغییرات مدل `Ticket`

فیلدهای جدید در `$fillable`:
```php
'category',      // دسته‌بندی: technical/financial/support/content/other
'priority',      // اولویت: low/medium/high
'receiver_role', // نقش گیرنده: admin/support/coach/delegate
```

### ۱۲.۲ تغییرات `TicketController`

#### `updateStatus` و `updateResponse` — منطق جدید
در نسخه ۲: فقط receiver می‌توانست پاسخ دهد.

در نسخه ۳ منطق چک دسترسی گسترش یافته:
1. اگر کاربر admin بود: دسترسی کامل
2. اگر sender بود: ممنوع (نمی‌تواند به تیکت خودش پاسخ دهد)
3. اگر `receiver_id` مشخص بود: فقط همان کاربر دسترسی دارد
4. اگر `receiver_id=null` (ارسال به نقش): هر کاربری با آن نقش دسترسی دارد

#### `storeSupportTicket` و `store` — فیلدهای جدید
علاوه بر فیلدهای قبلی، حالا `category`، `priority` و `receiver_role` هم ذخیره می‌شوند.

برای `receiver_role='coach'` امکان انتخاب کوچ مشخص با `specific_user_id` وجود دارد.

#### متد `getUsersByRole(Request $request)` — GET `/get-users-by-role` — **جدید**
یک API endpoint برای گرفتن لیست کاربران یک نقش خاص (فعلاً فقط `coach`).

برای استفاده در AJAX هنگام ایجاد تیکت (لود دینامیک لیست کوچ‌ها).

#### `myTickets()` — بهبود
حالا تیکت‌هایی که به نقش کاربر ارسال شده‌اند (`receiver_role`) هم نمایش داده می‌شوند، نه فقط تیکت‌هایی که مستقیماً به کاربر ارسال شده.

#### `manageSupportTickets()` — بهبود
کاربران غیرادمین فقط تیکت‌هایی را می‌بینند که یا مستقیم برایشان آمده یا به نقش آن‌ها ارسال شده.

فیلترهای جدید: `category`، `priority`، `receiver_role`.

---

## ۱۳. بهبودهای امنیتی — قفل اکانت

### ۱۳.۱ تغییرات مدل `User`

فیلدهای جدید در `$fillable`:
```php
'login_attempts', // TINYINT — تعداد تلاش‌های ناموفق
'locked_until',   // TIMESTAMP — تا این زمان قفل است
```

Cast جدید:
```php
'locked_until' => 'datetime',
```

**کاربرد:** وقتی کاربر چندین بار رمزعبور اشتباه وارد کند، `login_attempts` افزایش می‌یابد و در صورت رسیدن به حد مجاز، `locked_until` مقداردهی می‌شود. پس از گذشتن زمان قفل، کاربر دوباره می‌تواند وارد شود.

---

## ۱۴. سرویس لاگینگ (LoggingService)

### فایل: `app/Services/LoggingService.php`

این سرویس اصلی‌ترین تغییر معماری در نسخه ۳ است. یک لایه سرویس کامل برای ثبت تمام رویدادهای سیستم.

**تزریق:** از طریق constructor injection در تمام کنترلرهای جدید (`__construct(LoggingService $logger)`)

#### متد خصوصی `logEvent(...)` — هسته اصلی سرویس
تمام متدهای عمومی در نهایت این متد را صدا می‌زنند.

```php
private function logEvent(
    $eventType,    // نوع رویداد
    $category,     // دسته‌بندی
    $result,       // موفق؟
    $description,  // توضیح فارسی
    $userId,       // شناسه کاربر
    $details       // جزئیات JSON
)
```

اطلاعات خودکار جمع‌آوری می‌شوند: IP، user agent، session ID، method HTTP، URL کامل، نام route.

اگر ذخیره لاگ با خطا مواجه شود، سیستم کرش نمی‌کند (try/catch).

---

#### گروه‌بندی متدهای عمومی LoggingService:

**گروه Auth (احراز هویت):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logAuthenticationAttempt($email, $result, $error)` | `authentication_attempt` | هر بار که ورود امتحان می‌شود |
| `logAuthenticationResult($user, $result, $method)` | `authentication_result` | نتیجه نهایی ورود |
| `logPasswordTest($email, $result)` | `password_test` | تست رمزعبور |

**گروه Session (نشست):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logSessionCreate($result, $userId, $reason)` | `session_create` | ایجاد نشست جدید |
| `logSessionLimitExceeded($userId, $maxSessions)` | `session_limit_exceeded` | تجاوز از حد مجاز نشست‌های همزمان |
| `logSessionTerminated($userId, $terminatedBy, $reason)` | `session_terminated_by_admin` / `session_terminated_by_lock` | خاتمه نشست |

**گروه Data (عملیات داده):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logDataRead($entity, $entityId, $result, $userId)` | `data_read` | خواندن داده |
| `logDataReadFailed($entity, $entityId, $error)` | `data_read_failed` | شکست در خواندن |
| `logDataCreate($entity, $entityId, $data, $userId)` | `data_create` | ایجاد رکورد جدید |
| `logDataUpdate($entity, $entityId, $oldData, $newData, $userId)` | `data_update` | به‌روزرسانی رکورد |
| `logDataDelete($entity, $entityId, $data, $userId)` | `data_delete` | حذف رکورد |
| `logDataImport($result, $count, $errors)` | `data_import` | ورود داده |
| `logDataExport($result, $count, $userId)` | `data_export` | خروج داده |

**گروه User Management (مدیریت کاربران):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logRoleCreated($roleName, $permissions, $userId)` | `role_created` | ایجاد نقش |
| `logRoleDeleted($roleName, $userId)` | `role_deleted` | حذف نقش |
| `logRolePermissionsUpdated($roleName, $oldPerms, $newPerms, $userId)` | `role_permissions_updated` | تغییر مجوزهای نقش |
| `logUserAssignedToRole($userEmail, $roleName, $userId)` | `user_role_assigned` | انتصاب نقش به کاربر |
| `logUserRemovedFromRole($userEmail, $roleName, $userId)` | `user_role_removed` | بازپس‌گیری نقش |
| `logUserGroupChanged($userEmail, $oldGroup, $newGroup, $userId)` | `user_group_changed` | تغییر گروه کاربری |

**گروه Security (امنیت):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logSecurityAttributeChanged($userEmail, $attr, $old, $new, $userId)` | `security_attribute_changed` | تغییر ویژگی امنیتی |
| `logSecurityFeatureFailed($feature, $error, $userId)` | `security_feature_failed` | شکست در عملکرد امنیتی |
| `logSecurityBindingAttempt($userEmail, $attr, $result, $userId)` | `security_binding` | انقیاد ویژگی امنیتی |

**گروه System (سیستم):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logFunctionStart($functionName, $params, $userId)` | `function_start` | شروع اجرای تابع |
| `logFunctionEnd($functionName, $result, $duration, $userId)` | `function_end` | پایان اجرای تابع |
| `logFunctionBehaviorChanged($functionName, $old, $new, $userId)` | `function_behavior_changed` | تغییر رفتار تابع |
| `logConfigurationChanged($key, $oldValue, $newValue, $userId)` | `configuration_changed` | تغییر تنظیمات |
| `logMemoryOverflow($threshold, $usedMemory, $action, $userId)` | `memory_overflow` | سرریز حافظه |
| `logStorageFailed($storage, $error, $userId)` | `storage_failed` | شکست ذخیره‌سازی |

**گروه Admin (مدیریتی):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logAdministrativeAction($action, $target, $result, $userId)` | `administrative_action` | عملیات مدیریتی (مثلاً ban IP) |

**گروه Entity (موجودیت):**
| متد | event_type | کاربرد |
|-----|-----------|--------|
| `logEntityOperation($operation, $entity, $entityId, $result, $userId)` | `entity_operation` | عملیات روی موجودیت (approve/reject) |
| `logEntityOperationFailed($operation, $entity, $entityId, $error, $userId)` | `entity_operation_failed` | شکست عملیات روی موجودیت |

**متدهای Query کمکی:**
| متد | کاربرد |
|-----|--------|
| `getUserActivityLogs($userId, $limit)` | لاگ‌های یک کاربر خاص |
| `getLogsByType($eventType, $limit)` | لاگ‌های یک نوع رویداد |
| `getLogsByCategory($category, $limit)` | لاگ‌های یک دسته‌بندی |
| `getFailedLogs($limit)` | همه لاگ‌های ناموفق |
| `cleanupOldLogs($days)` | پاک‌سازی لاگ‌های قدیمی |

---

## ۱۵. میدلور جدید (CheckBannedIp)

**فایل:** `app/Http/Middleware/CheckBannedIp.php`  
**ثبت در:** `app/Http/Kernel.php` → `$middleware` (global)

در نسخه ۳، `CheckBannedIp` به آرایه global middleware stack اضافه شده:

```php
// نسخه ۲
protected $middleware = [
    // TrustProxies, HandleCors, PreventRequestsDuringMaintenance, ...
];

// نسخه ۳ — تغییر
protected $middleware = [
    // TrustProxies, HandleCors, PreventRequestsDuringMaintenance, ...
    \App\Http\Middleware\CheckBannedIp::class,  // ← جدید
];
```

این میدلور قبل از هر درخواستی (از جمله API) اجرا می‌شود و اگر IP در لیست `banned_ips` باشد، با HTTP 403 درخواست را رد می‌کند.

---

## ۱۶. صفحات جدید (Views)

### ویوهای عمومی جدید

| فایل | مسیر | توضیح |
|------|------|-------|
| `talent-scouting.blade.php` | `/talent-scouting` | صفحه جذب استعداد |
| `scientific/research-international.blade.php` | `/research/international` | صفحه تحقیقات بین‌المللی |
| `scientific/rnd.blade.php` | `/rnd` | صفحه تحقیق و توسعه |
| `scientific/articles-international.blade.php` | `/articles/international` | لیست مقالات با فیلتر |
| `scientific/article-detail.blade.php` | `/articles/international/{id}` | جزئیات مقاله علمی |
| `scientific/submit-proposal.blade.php` | `/submit-proposal` | فرم ارسال پیشنهاد |
| `shop/cart.blade.php` | `/shop/cart` | سبد خرید |
| `shop/checkout.blade.php` | `/shop/checkout` | تسویه حساب |
| `shop/payment-success.blade.php` | `/shop/payment-success/{order}` | پرداخت موفق |
| `shop/payment-failed.blade.php` | `/shop/payment-failed/{order}` | پرداخت ناموفق |

### ویوهای داشبورد جدید

| فایل | مسیر | توضیح |
|------|------|-------|
| `dashboard/articles-create.blade.php` | `/dashboard/manage-articles/create` | فرم ایجاد مقاله ادمین |
| `dashboard/articles-edit.blade.php` | `/dashboard/manage-articles/{id}/edit` | فرم ویرایش مقاله ادمین |
| `dashboard/manage-consultations.blade.php` | `/dashboard/manage-consultations` | مدیریت درخواست مشاوره |
| `dashboard/manage-logs.blade.php` | `/dashboard/manage-logs` | لاگ‌های سیستم + IP بن شده |
| `dashboard/manage-orders.blade.php` | `/dashboard/manage-orders` | مدیریت سفارشات |
| `dashboard/my-orders.blade.php` | `/dashboard/my-orders` | سفارشات کاربر |
| `dashboard/order-details.blade.php` | `/dashboard/order-details/{id}` | جزئیات سفارش |
| `dashboard/settings.blade.php` | `/dashboard/settings` | تنظیمات پسورد |

---

## ۱۷. مسیرهای جدید (Routes)

### مسیرهای عمومی جدید

```php
// صفحات علمی
GET  /research/international         → scientific.research-international
GET  /rnd                            → scientific.rnd
GET  /talent-scouting                → talent-scouting

// مقالات بین‌المللی
GET  /articles/international         → ArticleController@internationalArticles
GET  /articles/international/{id}    → ArticleController@showInternationalArticle
GET  /articles/international/{id}/download          → ArticleController@downloadFile
GET  /articles/international/{id}/download-abstract → ArticleController@downloadAbstract
GET  /articles/international/{id}/view-abstract     → ArticleController@viewAbstract

// پیشنهاد مقاله
GET  /submit-proposal                → ArticleProposalController@index
POST /submit-proposal (auth)         → ArticleProposalController@store
DELETE /submit-proposal/{id} (auth)  → ArticleProposalController@destroy

// مشاوره
POST /consultation-request           → ConsultationController@store

// فروشگاه (auth)
GET  /shop/cart                      → ShopController@cart
POST /shop/add-to-cart/{article}     → ShopController@addToCart
DELETE /shop/remove-from-cart/{item}          → ShopController@removeFromCart
DELETE /shop/remove-from-cart-article/{article} → ShopController@removeFromCartByArticle
GET  /shop/checkout                  → ShopController@checkout
POST /shop/process-payment           → ShopController@processPayment
GET  /shop/payment-success/{order}   → ShopController@paymentSuccess
GET  /shop/payment-failed/{order}    → ShopController@paymentFailed
GET  /shop/download/{article}        → ShopController@downloadPurchasedArticle
GET  /shop/my-orders                 → ShopController@myOrders
GET  /shop/order-details/{order}     → ShopController@orderDetails
```

### مسیرهای داشبورد جدید

```php
// مشاوره (manage_consultations)
GET    /dashboard/manage-consultations              → ConsultationController@index
PATCH  /dashboard/manage-consultations/{id}/update-status → ConsultationController@updateStatus
DELETE /dashboard/manage-consultations/{id}         → ConsultationController@destroy

// سفارشات (manage_orders)
GET    /dashboard/manage-orders                     → ShopController@manageOrders
GET    /dashboard/manage-orders/{order}             → ShopController@showOrder
PATCH  /dashboard/manage-orders/{order}/update-status → ShopController@updateOrderStatus
DELETE /dashboard/manage-orders/{order}             → ShopController@destroyOrder

// تنظیمات (manage_settings)
GET    /dashboard/settings                          → SettingController@index
PUT    /dashboard/settings                          → SettingController@update

// لاگ‌ها (manage_logs) — جایگزین LogViewer
GET    /dashboard/manage-logs                       → SystemLogController@index
GET    /dashboard/manage-logs/{id}                  → SystemLogController@show
DELETE /dashboard/manage-logs/{id}                  → SystemLogController@destroy
POST   /dashboard/manage-logs/clear-old             → SystemLogController@clearOld
POST   /dashboard/manage-logs/ban-ip                → BanIpController@store
DELETE /dashboard/manage-logs/ban-ip/{id}           → BanIpController@destroy

// مقالات — متدهای جدید ادمین
GET    /dashboard/manage-articles/create            → ArticleController@create
POST   /dashboard/manage-articles                   → ArticleController@store
GET    /dashboard/manage-articles/{article}/edit    → ArticleController@editArticle
PUT    /dashboard/manage-articles/{article}         → ArticleController@updateArticle
POST   /dashboard/manage-articles/{article}/approve → ArticleController@approveArticle
POST   /dashboard/manage-articles/{article}/reject  → ArticleController@rejectArticle

// پیشنهادات
POST   /dashboard/manage-proposals/{id}/approve     → ArticleProposalController@approveProposal
POST   /dashboard/manage-proposals/{id}/reject      → ArticleProposalController@rejectProposal
DELETE /dashboard/manage-proposals/{id}             → ArticleProposalController@destroyProposal

// سفارشات کاربر
GET    /dashboard/my-orders                         → ShopController@myOrders
GET    /dashboard/order-details/{order}             → ShopController@orderDetails

// API برای AJAX
GET    /get-users-by-role                           → TicketController@getUsersByRole
```

---

## ۱۸. پرمیشن‌های جدید

| نام | نام فارسی | داده می‌شود به |
|-----|-----------|---------------|
| `manage_orders` | مدیریت سفارشات | admin, support |
| `manage_settings` | مدیریت تنظیمات | admin, support |
| `manage_consultations` | مدیریت مشاوره‌ها | (فقط از طریق route middleware `can:manage_consultations`) |

---

## جمع‌بندی تعداد تغییرات

| نوع تغییر | تعداد |
|-----------|-------|
| جدول جدید در دیتابیس | ۸ |
| ستون جدید به جداول موجود | ۱۷ |
| کنترلر جدید | ۷ |
| متد جدید در کنترلرهای موجود | ۱۲ |
| مدل جدید | ۶ |
| میدلور جدید | ۱ |
| سرویس جدید | ۱ (LoggingService با ۳۰+ متد) |
| ویوی جدید | ۱۸ |
| migration جدید | ۱۲ |
| مسیر جدید (Route) | ۴۵+ |
| پرمیشن جدید | ۲ |
