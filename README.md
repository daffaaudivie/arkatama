Arkatama API Documentation
Base URL
http://localhost:8000/api


Ganti localhost:8000 dengan URL server jika sudah di-deploy.

Test Endpoint

Cek apakah API berjalan.
GET /test
Auth: No
Response:

{
  "status": "API working!",
  "timestamp": "2025-11-29T12:00:00"
}

User API (Customer)
Register User

POST /user/register
Auth: No

Body:

{
  "name": "Daffa Audyvie",
  "email": "27daffa27@gmail.com",
  "password": "secret",
  "password_confirmation": "secret"
}


Response:

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

Login User

POST /user/login
Auth: No

Body:

{
  "email": "27daffa27@gmail.com",
  "password": "secret"
}


Response:

{
  "user": { ... },
  "token": "1|ssghN7CU1QfaWLiYm1U3YcyLsaHlCbabwsjIoyO9c4f041c8"
}

Logout User

POST /user/logout
Auth: Bearer token required

Headers:

Authorization: Bearer <token>
Response:

{
  "message": "Logged out successfully"
}

Profile

GET /user/profile – Ambil data profile

PUT /user/profile – Update profile

PUT Body Example:

{
  "name": "New Name",
  "email": "new@email.com"
}
