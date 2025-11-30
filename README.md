# 🚀 Arkatama API Documentation

![API Status](https://img.shields.io/badge/API-Active-green)
![Version](https://img.shields.io/badge/Version-1.0.0-blue)
![Laravel](https://img.shields.io/badge/Laravel-Framework-red)

## 📋 Table of Contents

- [🌐 Base URL](#base-url)
- [🔍 Test Endpoint](#test-endpoint)
- [👥 User API (Customer)](#user-api-customer)
  - [📝 Register User](#register-user)
  - [🔐 Login User](#login-user)
  - [🚪 Logout User](#logout-user)
  - [👤 Profile Management](#profile-management)
- [👥 Admin API (Admin)](#admin-api-admin)
  - [🔐 Login Admin](#login-admin)
- [📖 Category API](#category-api)
  - [🌍 Public Endpoints](#public-endpoints)
    - [📑 Get All Categories](#get-all-categories)
    - [🔍 Get Single Category](#get-single-category)
  - [🔒 Admin Endpoints](#admin-endpoints)
    - [➕ Create Category](#create-category)
    - [✏️ Update Category](#update-category)
    - [🗑️ Delete Category](#delete-category)

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

#### 📥 Request Body

```json

{
"name": "Daffa Audyvie",
"email": "27daffa27@gmail.com",
"password": "secret",
"password_confirmation": "secret"
}
```
#### 📤 Response
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
#### 📥 Request Body

```json
{
"email": "27daffa27@gmail.com",
"password": "secret"
}
```
#### 📤 Response

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
#### 📥 Headers
Authorization: Bearer <your_token_here> Contoh: Bearer 1|ssghN7CU1QfaWLiYm1U3YcyLsaHlCbabwsjIoyO9c4f041c8
#### 📤 Response
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
#### 📥 Request Body Example

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
#### 📥 Request Body

```json
{
"email": "daffa.audivie27@com",
"password": "audivie45072"
}
```
#### 📤 Response

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
#### 📥 Response

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
#### 📥 Response

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
```json
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

### 🔍 Admin Get Category by ID
Mendapatkan detail kategori berdasarkan ID untuk admin.
### GET api/admin/categories/{id}
| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Admin Bearer token required |
#### 📥 URL Parameters
| Paramater | Type | Paramater | 
|-----------|-------|-----------|
| **id** | integer| ID Kategori yang ingin ditampilkan|
#### 📥 Headers
Authorization: Bearer <admin_token_here>
Content-Type: application/json
#### 📤 Response (Success)
```json
{
  "id": 1,
  "name": "Electronics",
  "description": "Electronic devices and gadgets",
  "created_at": "2024-01-01T10:00:00.000000Z",
  "updated_at": "2024-01-01T10:00:00.000000Z"
}
```

### ✏️ Update Category
Mengupdate data kategori yang sudah ada.
### PUT api/admin/category/{id}
| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Admin Bearer token required |
#### 📥 URL Parameters
| Paramater | Type | Paramater | 
|-----------|-------|-----------|
| **id** | integer| ID Kategori yang ingin diedit|
#### 📥 Headers
Authorization: Bearer <admin_token_here>
Content-Type: application/json
#### 📤 Request
```json
{
  "name": "Updated Electronics",
  "description": "Updated description for electronics"
}
```
#### 📤 Response (Success)
```json
{
  "message": "Kategori berhasil diperbarui",
  "category": {
    "id": 1,
    "name": "Updated Electronics",
    "description": "Updated description for electronics",
    "created_at": "2024-01-01T10:00:00.000000Z",
    "updated_at": "2024-01-01T11:00:00.000000Z"
  }
}
```
### 🗑️ Delete Category
Menghapus kategori berdasarkan ID.
### DELETE api/admin/categories/{id}
| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Admin Bearer token required |
### 📥 URL Parameters
| Paramater | Type | Paramater | 
|-----------|-------|-----------|
| **id** | integer| ID Kategori yang ingin dihapus|
### 📥 Headers
Authorization: Bearer <admin_token_here>
### 📤 Response (Success)
```json
{
  "message": "Kategori berhasil dihapus"
}
```

## 📦 Product API Documentation
Dokumentasi lengkap untuk API management produk dengan akses admin dan public.
## 🌍 Public Endpoints (Tidak Perlu Login)
| Parameter | Value |
|-----------|-------|
| **Auth** | ❌ No |
### 📖 Get All Products
Mendapatkan daftar semua produk (akses publik).
#### 📥 Response (Contoh)
```json
[
    {
        "id": 1,
        "name": "Laptop Gaming",
        "description": "High-performance gaming laptop",
        "price": 15000000,
        "category_id": 1,
        "stock": 25,
        "image": "1640995200_laptop.jpg",
        "created_at": "2024-01-01T12:00:00.000000Z",
        "updated_at": "2024-01-01T12:00:00.000000Z"
    },
    {
        "id": 2,
        "name": "Smartphone",
        "description": "Latest flagship smartphone",
        "price": 8000000,
        "category_id": 2,
        "stock": 50,
        "image": "1640995300_phone.jpg",
        "created_at": "2024-01-01T12:00:00.000000Z",
        "updated_at": "2024-01-01T12:00:00.000000Z"
    }
]
```
### 🔍 Get Single Product
Mendapatkan detail produk berdasarkan ID (akses publik).
### GET /product/{id}
##### Parameters: id (integer, required) - ID produk yang ingin ditampilkan
##### Headers: Content-Type: application/json
#### 📥 Response (Contoh)
```json
[
    {
    "id": 1,
    "name": "Laptop Gaming",
    "description": "High-performance gaming laptop",
    "price": 15000000,
    "category_id": 1,
    "stock": 25,
    "image": "1640995200_laptop.jpg",
    "created_at": "2024-01-01T12:00:00.000000Z",
    "updated_at": "2024-01-01T12:00:00.000000Z"
}
]
```

## 🔑 Admin Endpoints (Perlu Login)
Dokumentasi lengkap untuk API management produk dengan akses admin yang memerlukan autentikasi.
| Parameter | Value |
|-----------|-------|
| **Auth** | ✅ Admin Bearer token required |

### 1. ➕ Create Product
Membuat produk baru (Admin only).

### POST api/admin/product
Headers:
Content-Type: multipart/form-data
Authorization: Bearer {your-token}
#### 📤 Request Body (Form Data)
```json
{
  "name: "Laptop Gaming" (required)
    description: "High-performance gaming laptop" (optional)
    price: 15000000 (required)
    category_id: 1 (required)
    stock: 25 (required)
    image: (file upload, max 4MB)
}
```
#### Validation Rules:
 ##### -name: required, string, max 255 characters
 ##### -price: required, numeric, minimum 0
 ##### -stock: required, integer, minimum 0
 ##### -category_id: required, must exist in categories table
 ##### -description: nullable, string
 ##### -image: nullable, must be image file, max 4MB

#### 📥 Response (Contoh)
```json
[
    {
    "message": "Produk berhasil dibuat",
    "product": {
        "id": 3,
        "name": "Laptop Gaming",
        "description": "High-performance gaming laptop",
        "price": 15000000,
        "category_id": 1,
        "stock": 25,
        "image": "1640995400_laptop.jpg",
        "created_at": "2024-01-01T12:00:00.000000Z",
        "updated_at": "2024-01-01T12:00:00.000000Z"
    }
}
]
```
### 2. ✏️ Update Product
Mengupdate produk yang sudah ada (Admin only).
### PUT/ api/admin/product/{id}
#### Parameters:id (integer, required) - ID produk yang ingin diupdate
#### Content-Type: multipart/form-data Authorization: Bearer {your-admin-token}
#### 📤 Request Body (Form Data)
```json
{
  name: "Updated Laptop Gaming" (optional)
    description: "Updated high-performance gaming laptop" (optional)
    price: 18000000 (optional)
    category_id: 2 (optional)
    stock: 30 (optional)
    image: (file upload - optional, max 4MB)
}
```
#### 📥 Response (Contoh)
```json
[
    {
    "message": "Produk berhasil diperbarui",
    "product": {
        "id": 1,
        "name": "Updated Laptop Gaming",
        "description": "Updated high-performance gaming laptop",
        "price": 18000000,
        "category_id": 2,
        "stock": 30,
        "image": "1640995500_updated_laptop.jpg",
        "created_at": "2024-01-01T12:00:00.000000Z",
        "updated_at": "2024-01-01T14:30:00.000000Z"
    }
}
}
]
```













