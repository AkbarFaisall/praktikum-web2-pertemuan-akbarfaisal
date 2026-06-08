# Inventory System API v1
Base URL: `http://localhost:8000/api/v1`
## Auth
POST /register
Body: { name, email, password, password_confirmation }
Response: 201 Created {
"status":"success",
"data": { "user":…, "token":… },
"message":"User registered"
}
POST /login
Body: { email, password }
...
## Categories
GET /categories
POST /categories { name }
GET /categories/{id}
PUT /categories/{id} { name }
DELETE /categories/{id} (admin only)
## Items
GET /items
POST /items { name, quantity, price, category_id }
GET /items/{id}
PUT /items/{id}
DELETE /items/{id} (admin only)