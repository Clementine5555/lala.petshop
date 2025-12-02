# Sistem Login Terpisah: User Biasa (Jetstream) & Admin (Filament)

## ✅ Setup Sudah Selesai

Anda sekarang memiliki sistem login yang memisahkan user biasa dan admin dengan clean dan aman. Berikut penjelasan lengkap:

---

## 📋 Apa yang Sudah Dikerjakan

### 1. **Tambahkan Kolom `is_admin` ke Tabel Users**
```bash
php artisan migrate
```
- ✅ Migration: `2025_11_24_add_is_admin_to_users_table.php`
- Kolom: `is_admin` (boolean, default: false)
- Artinya: Setiap user biasa punya `is_admin = false`, hanya admin yang `is_admin = true`

### 2. **Update User Model**
File: `app/Models/User.php`
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'is_admin',  // ✅ Tambahan
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_admin' => 'boolean',  // ✅ Casting ke boolean
];
```

### 3. **Buat Admin User via Seeder**
File: `database/seeders/AdminSeeder.php`
```bash
php artisan db:seed --class=AdminSeeder
```
Hasil:
- Email: `admin@petshop.com`
- Password: `admin@123456`
- is_admin: `true`

### 4. **Setup Filament Panel**
- Panel ID: `admin_lala`
- Path: `/admin_lala`
- Provider: `app/Providers/Filament/AdminLalaPanelProvider.php`

### 5. **Custom Middleware untuk Protection**
File: `app/Http/Middleware/FilamentAdminCheck.php`
- Cek setiap request ke Filament
- Jika user tidak `is_admin`, logout otomatis
- Redirect ke login dengan pesan error

---

## 🔐 Alur Login & Authorization

```
┌─────────────────────────────────────────────────────────┐
│                    USER BIASA                            │
│                  (Pelanggan)                             │
└─────────────────────────────────────────────────────────┘
                         │
                         ▼
                    /login (Jetstream)
                         │
                         ▼
            ✅ Berhasil login (is_admin = false)
                         │
                         ▼
            Akses /products, /cart, /dashboard
            ❌ Tidak bisa akses /admin_lala
                         │
                    Coba akses /admin_lala
                         │
                         ▼
                  FilamentAdminCheck middleware
                   Cek: is_admin == true?
                         │
                         ▼
                    ❌ FALSE
                         │
                    Logout otomatis
                    Redirect error 403

┌─────────────────────────────────────────────────────────┐
│                      ADMIN                               │
│              (Pengelola Sistem)                          │
└─────────────────────────────────────────────────────────┘
                         │
                         ▼
              /admin_lala/login (Filament)
                         │
                         ▼
          Masukkan email & password (admin@petshop.com)
                         │
                         ▼
         ✅ Filament check: user exists & is_admin = true
                         │
                         ▼
             FilamentAdminCheck middleware
                Cek: is_admin == true?
                         │
                         ▼
                    ✅ TRUE
                         │
                         ▼
           Akses penuh ke /admin_lala dashboard
               (Manage products, users, dll)
```

---

## 🧪 Testing Checklist

### Test 1: User Biasa Login via Jetstream
```
1. Go to http://127.0.0.1:8000/login
2. Register / Login dengan user biasa
3. ✅ Berhasil login ke dashboard
4. Coba akses http://127.0.0.1:8000/admin_lala
5. ❌ Redirect ke login / error 403
6. Logout
```

### Test 2: Admin Login via Filament
```
1. Go to http://127.0.0.1:8000/admin_lala
2. Redirect ke /admin_lala/login
3. Masukkan:
   - Email: admin@petshop.com
   - Password: admin@123456
4. ✅ Berhasil login ke Filament dashboard
5. Akses penuh ke admin panel
```

### Test 3: User Biasa Coba Jadi Admin (Hack Protection)
```
1. User biasa login via Jetstream
2. Somehow set is_admin = true manually di DB
3. Coba akses /admin_lala
4. ✅ Middleware cek: is_admin == true?
5. ✅ Jika true, akses diberikan (expected behavior)
6. Untuk lebih aman, cek password juga (lihat advanced setup)
```

---

## 📁 File Structure

```
app/
├── Models/
│   └── User.php                              ✅ +is_admin ke fillable & casts
├── Http/
│   └── Middleware/
│       └── FilamentAdminCheck.php            ✅ Protect Filament routes
├── Providers/
│   └── Filament/
│       └── AdminLalaPanelProvider.php        ✅ Filament panel config + middleware
└── Filament/
    └── AdminLala/
        └── Pages/
            └── ... (Filament resources)

database/
├── migrations/
│   └── 2025_11_24_add_is_admin_to_users_table.php    ✅ Kolom is_admin
└── seeders/
    └── AdminSeeder.php                       ✅ Buat admin user
```

---

## 🔧 Cara Menambah Admin Baru

### Via Database (Quick)
```sql
UPDATE users SET is_admin = true WHERE email = 'user@example.com';
```

### Via Artisan Tinker (Safe)
```bash
php artisan tinker
> $user = App\Models\User::where('email', 'user@example.com')->first();
> $user->update(['is_admin' => true]);
> exit
```

### Via Code (Laravel Way)
```php
User::where('email', 'user@example.com')->update(['is_admin' => true]);
```

---

## 🚀 Advanced: Optional Enhancements

### 1. **Override Login Validation (Cek is_admin saat login)**
Jika ingin error message saat non-admin coba login ke /admin_lala/login:

Buat file: `app/Filament/AdminLala/Pages/Auth/Login.php`
```php
<?php

namespace App\Filament\AdminLala\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function getCredentials(): array
    {
        $credentials = parent::getCredentials();
        
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if ($user && !$user->is_admin) {
            throw ValidationException::withMessages([
                'email' => 'Akun ini bukan admin. Hanya admin yang dapat login ke area ini.',
            ]);
        }
        
        return $credentials;
    }
}
```

Kemudian di `AdminLalaPanelProvider.php` tambahkan:
```php
->pages([
    Dashboard::class,
    Login::class,  // Gunakan custom login
])
```

### 2. **Add Role-Based Permissions (Super Admin, Editor, dll)**
Upgrade dari boolean `is_admin` ke enum `role`:
```bash
php artisan make:migration change_is_admin_to_role_in_users_table
```

### 3. **Audit Log**
Catat setiap kali admin login/logout:
```php
// Di FilamentAdminCheck.php
\App\Models\ActivityLog::create([
    'user_id' => Auth::user()->user_id,
    'action' => 'admin_login',
    'timestamp' => now(),
]);
```

### 4. **Two-Factor Authentication (2FA)**
Tambah 2FA untuk admin login (library: laravel-fortify, spatie/laravel-2fa)

---

## 🔑 Credentials untuk Testing

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| Admin | admin@petshop.com | admin@123456 | /admin_lala |
| User Biasa | (register sendiri) | (pilih sendiri) | /login, /products, /cart |

---

## 📞 Troubleshooting

### ❌ Problem: Admin tidak bisa login ke /admin_lala
**Solusi:**
1. Cek apakah user punya `is_admin = true` di database
2. Clear cache: `php artisan config:clear && php artisan cache:clear`
3. Cek middleware di `AdminLalaPanelProvider.php` terdaftar

### ❌ Problem: User biasa bisa akses /admin_lala
**Solusi:**
1. Pastikan `FilamentAdminCheck` middleware terdaftar di panel
2. Cek kondisi `if (!$user->is_admin)` di middleware
3. Restart server

### ❌ Problem: Login form Filament tidak muncul
**Solusi:**
1. Cek routing: `php artisan route:list | grep admin_lala`
2. Cek bootstrap/providers.php apakah `AdminLalaPanelProvider` terdaftar
3. Publish Filament config: `php artisan vendor:publish --tag=filament-config`

---

## ✨ Summary

✅ **User Biasa (Jetstream)**
- Login di `/login`
- Password hashed & secure
- Tidak bisa akses /admin_lala (diproteksi middleware)

✅ **Admin (Filament)**
- Login di `/admin_lala/login`
- Hanya user dengan `is_admin = true` yang bisa akses
- Middleware `FilamentAdminCheck` protect semua routes

✅ **Database**
- Kolom `is_admin` di tabel users
- Admin user sudah di-seed (admin@petshop.com)
- Easy upgrade path ke role-based system

✅ **Security**
- Middleware check di setiap request
- Logout otomatis jika non-admin coba akses
- Password hashed dengan bcrypt

---

## 🎯 Next Steps

1. **Test** kedua login flow (user biasa & admin)
2. **Add Products Resource** ke Filament untuk admin manage products
3. **Add Users Resource** ke Filament untuk admin manage users
4. **Custom Policies** untuk granular permission control
5. **2FA** untuk security extra (optional)

---

## 📖 Useful Commands

```bash
# Cek status migrations
php artisan migrate:status

# Cek routes
php artisan route:list | grep -E "(login|admin_lala)"

# Tinker untuk quick DB check
php artisan tinker

# Seeder untuk create/update admin
php artisan db:seed --class=AdminSeeder

# Clear semua cache
php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear
```

---

Done! 🎉 Sistem login sudah siap untuk production.
