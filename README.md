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
- [👥 Admin API (Admin)](#-admin-api-customer)
  - [🔐 Login User](#-login-user)
- [📖 Category API (Category)](#-category-api-customer)

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

## 👥 User API (Customer)

### 📝 Register User
Endpoint untuk mendaftarkan user baru.
### POST api/user/register

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
```
### 📤 Response
```json

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
### POST api/user/login
| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |
### 📥 Request Body

```json
{
"email": "27daffa27@gmail.com",
"password": "secret"
}
```
### 📤 Response

```json

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

### 🚪 Logout User
Endpoint untuk logout user.
### DELETE api/user/logout
| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Bearer token required |
## 📥 Headers
Authorization: Bearer <your_token_here> Contoh: Bearer 1|ssghN7CU1QfaWLiYm1U3YcyLsaHlCbabwsjIoyO9c4f041c8
## 📤 Response
```json

{
"message": "Logged out successfully"
}
```

## 👤 Profile Management
### 📖 Get Profile
Mendapatkan data profile user yang sedang login.
### GET api/user/profile

| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Bearer token required |

### ✏️ Update Profile
Mengupdate data profile user.
### PUT api/user/profile

| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Bearer token required |
## 📥 Request Body Example

```json

{
"name": "New Name",
"email": "new@email.com"
}
```

## 🔧 Authentication
### Untuk endpoint yang memerlukan autentikasi, gunakan Bearer token di header:

Authorization: Bearer <your_token_here>
Token didapat dari response endpoint /admin/login atau /user/login.

## 👥 Admin API (Admin)
### 🔐 Login Admin
Endpoint untuk login user yang sudah terdaftar.
### POST api/admin/login
| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |
### 📥 Request Body

```json
{
"email": "daffa.audivie27@com",
"password": "audivie45072"
}
```
### 📤 Response

```json

{
    "admin": {
        "id": 1,
        "name": "Admin 01",
        "email": "daffa.audivie27@gmail.com",
        "created_at": "2025-11-26T02:31:45.000000Z",
        "updated_at": "2025-11-26T02:31:45.000000Z"
    },
    "token": "12|XaCTVnqknmzb8EkOFLlbiRfXfPS7cGCRvAriSLOb29762d16"
}
```

## 📖 Category API (Admin)
## 👀 Public Category Endpoints
Endpoint untuk mengakses data kategori tanpa perlu autentikasi.
### 📋 Get All Categories
Mendapatkan semua data kategori yang tersedia.
#### **GET** `api/category`
| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |
### 📥 Response

```json
{
  "success": true,
  "message": "List all categories",
  "data": [
    {
      "id": 1,
      "name": "Electronics",
      "description": "Electronic devices and gadgets",
      "created_at": "2024-01-01T10:00:00.000000Z",
      "updated_at": "2024-01-01T10:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Fashion",
      "description": "Clothing and accessories",
      "created_at": "2024-01-01T10:00:00.000000Z",
      "updated_at": "2024-01-01T10:00:00.000000Z"
    }
  ]
}
```
### 🔍 Get Category by ID
Mendapatkan detail kategori berdasarkan ID.
### GET api/category/{id}
| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |
### 📥 Response

```json
{
  "success": true,
  "message": "Detail Category",
  "data": {
    "id": 1,
    "name": "Electronics",
    "description": "Electronic devices and gadgets",
    "created_at": "2024-01-01T10:00:00.000000Z",
    "updated_at": "2024-01-01T10:00:00.000000Z"
  }
}
```
## 🔐 Admin Category Management (Perlu Login Admin)
Endpoint untuk mengelola kategori (CRUD) yang memerlukan autentikasi admin.

### ➕ Create New Category
Meanmbahkan data kategori untuk admin.
### GET api/admin/category
| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Admin Bearer token required |

#### 📥 Headers
Authorization: Bearer <admin_token_here>
Content-Type: application/json

#### 📥 Request Body (Contoh)
```json
{
  "name": "Books",
  "description": "Books and educational materials"
}
```

#### 📥 Response 
{
  "message": "Kategori berhasil dibuat",
  "category": {
    "id": 3,
    "name": "Books",
    "description": "Books and educational materials",
    "created_at": "2024-01-01T10:00:00.000000Z",
    "updated_at": "2024-01-01T10:00:00.000000Z"
  }
}
```
