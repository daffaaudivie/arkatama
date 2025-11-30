# 🚀 Arkatama API Documentation

![API Status](https://img.shields.io/badge/API-Active-green)
![Version](https://img.shields.io/badge/Version-1.0.0-blue)
![Laravel](https://img.shields.io/badge/Laravel-Framework-red)

## 📋 Table of Contents

- [🌐 Base URL](#-base-url)
- [🔍 Test Endpoint](#-test-endpoint)
- [👥 User API (Customer)](#-user-api-customer)
  - [📝 Register User](#-register-user)
  - [🔐 Login User](#-login-user)
  - [🚪 Logout User](#-logout-user)
  - [👤 Profile Management](#-profile-management)

## 🌐 Base URL
http://localhost:8000/api
> **📝 Note:** Ganti `localhost:8000` dengan URL server jika sudah di-deploy.
---
## 🔍 Test Endpoint

Endpoint untuk mengecek apakah API berjalan dengan baik.

### **GET** `/test`

| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |

#### 📤 Response

#### 👥 User API (Customer)

### 📝 Register User
Endpoint untuk mendaftarkan user baru.
### POST /user/register

| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |

### 📥 Request Body

```json

{
"name": "Daffa Audyvie",
"email": "27daffa27@gmail.com",
"password": "secret",
"password_confirmation": "secret"
}

📤 Response
json

{
"user": {
"id": 2,
"name": "Daffa Audyvie",
"email": "27daffa27@gmail.com",
"created_at": "...",
"updated_at": "..."
},
"token": "1|ssghN7CU1QfaWLiYm1U3YcyLsaHlCbabwsjIoyO9c4f041c8"
}
```

### 🔐 Login User
Endpoint untuk login user yang sudah terdaftar.

POST /user/login
Parameter Value
Auth ❌ No
📥 Request Body
```json

{
"email": "27daffa27@gmail.com",
"password": "secret"
}
📤 Response
json

{
"user": {
"id": 2,
"name": "Daffa Audyvie",
"email": "27daffa27@gmail.com",
"created_at": "...",
"updated_at": "..."
},
"token": "1|ssghN7CU1QfaWLiYm1U3YcyLsaHlCbabwsjIoyO9c4f041c8"
}
```

##🚪 Logout User
Endpoint untuk logout user.

POST /user/logout
Parameter Value
Auth ✅ Bearer token required
📥 Headers
Authorization: Bearer <your_token_here>
📤 Response
```json

{
"message": "Logged out successfully"
}
```

##👤 Profile Management
📖 Get Profile
Mendapatkan data profile user yang sedang login.

GET /user/profile

Parameter Value
Auth ✅ Bearer token required
✏️ Update Profile
Mengupdate data profile user.

PUT /user/profile

Parameter Value
Auth ✅ Bearer token required
📥 Request Body Example
```json

{
"name": "New Name",
"email": "new@email.com"
}
```

🔧 Authentication
Untuk endpoint yang memerlukan autentikasi, gunakan Bearer token di header:

Authorization: Bearer <your_token_here>
Token didapat dari response endpoint /user/register atau /user/login.
