# CampusKart — Project Notes

> Living document for project memory. Update this file as modules ship or the schema changes.

**Stack:** PHP (procedural) + MySQL (mysqli)  
**Server:** XAMPP  
**URL:** `http://localhost/CampusKart/`

**Purpose:**  
CampusKart is a campus marketplace web application where students can buy, sell, and exchange items like books, laptops, cycles, notes, furniture, and gadgets.

---

# Project Overview

CampusKart is a web application for managing campus product listings and user interactions.

Current development focus:
- User authentication system
- Admin management
- Product management module

Future features:
- Product search
- Product filters
- Cart system
- Exchange workflow
- Orders
- Rewards

---

# Architecture


CampusKart/

Root PHP files:

index.php
login.php
register.php
users.php
edit_user.php
delete_user.php
logout.php

config/

database.php

includes/

header.php
navbar.php
footer.php

admin/

dashboard.php
add_product.php

user/

dashboard.php

assets/

css/
images/

---

# Completed Modules

| Module | Location | Status |
|--------|----------|--------|
| Landing Page | `index.php` | Completed |
| Header | `includes/header.php` | Completed |
| Navbar | `includes/navbar.php` | Completed |
| Footer | `includes/footer.php` | Completed |
| Database Connection | `config/database.php` | Completed |
| User Registration | `register.php` | Completed |
| Login System | `login.php` | Completed |
| Session Management | `login.php` | Completed |
| Admin Dashboard | `admin/dashboard.php` | Completed |
| User Dashboard | `user/dashboard.php` | Completed |
| User List | `users.php` | Completed |
| Edit User | `edit_user.php` | Completed |
| Delete User | `delete_user.php` | Completed |
| Logout System | `logout.php` | Completed |
| Dynamic Navbar | `includes/navbar.php` | Completed |
| Add Product | `admin/add_product.php` | Completed |
| Product Image Upload | `assets/images/` | Completed |

---

# Development Progress

## Phase 1: Authentication & Layout

Status: ✅ Completed

Completed:

- Footer creation
- Database connection cleanup
- User dashboard creation
- Admin navigation fixes
- Logout system
- Dynamic navbar
- Authentication flow


---

# Phase 2: Product Management

Status: 🚧 In Progress

## Completed:

✅ Products table created  
✅ Add Product page created  
✅ Product insertion working  
✅ Image upload working  
✅ Images stored in `assets/images/`  
✅ Product data saved in MySQL  


## Current Task:

Create Product Listing Page:


view_products.php


Purpose:

- Display all products
- Show product images
- Show product details


## Pending:

- [ ] View products page
- [ ] Product details page
- [ ] Edit product
- [ ] Delete product
- [ ] Category dropdown
- [ ] Product search
- [ ] Product filters

---

# Database Details

Database Name:


campuskart


Connection:

| Setting | Value |
|---|---|
| Host | localhost |
| Username | root |
| Password | empty |
| Database | campuskart |

---

# Database Tables

## Users Table

Table:


users


Columns:

| Column | Purpose |
|---|---|
| id | Primary key |
| name | User name |
| email | User email |
| phone | Contact number |
| password | User password |
| points | Reward points |
| role | User/Admin |

---

## Products Table

Table:


products


Used in:


admin/add_product.php


Columns:

| Column | Purpose |
|---|---|
| id | Primary key |
| user_id | Product owner |
| category_id | Category reference |
| title | Product name |
| description | Product details |
| price | Product price |
| image | Image filename |
| status | Available/Sold |
| created_at | Product creation date |

---

# Product Image System

Image folder:


CampusKart/
└── assets/
└── images/


Working flow:


User selects image
↓
PHP receives image
↓
Image moved to assets/images
↓
Image name stored in products table


---

# Important Files


CampusKart/

├── project_notes.md

├── index.php
├── login.php
├── register.php
├── users.php
├── edit_user.php
├── delete_user.php
├── logout.php

├── admin/
│ ├── dashboard.php
│ └── add_product.php

├── user/
│ └── dashboard.php

├── config/
│ └── database.php

├── includes/
│ ├── header.php
│ ├── navbar.php
│ └── footer.php

└── assets/
├── css/
│ └── style.css
│
└── images/
└── product images


---

# Session Information

After login:

```php
$_SESSION['id']
$_SESSION['name']
$_SESSION['role']
Redirects

Admin:

/CampusKart/admin/dashboard.php

User:

/CampusKart/user/dashboard.php
Current Issues
Remaining Pages
 products.php
 about.php
 contact.php
Product Module
 View products
 Edit product
 Delete product
 Category management
Security Improvements
 Password hashing
 Prepared statements
 Admin protection on all CRUD pages
 CSRF protection
 XSS prevention
Project Documentation
 Database schema file
 README file
 Setup instructions
Future Modules
Admin
Rewards management
Reports
Analytics
User
Profile management
Product exchange
Messaging system
Development Log
25 July 2026

Completed:

Completed Phase 1
Created Add Product module
Created product insertion system
Fixed image upload issue
Tested product upload successfully

Problem solved:

Created images.php file instead of images folder.

Fixed by creating:

assets/images/

Result:

✅ Images uploading successfully
✅ Products saving successfully

Next Session Task

Start from:

Create view_products.php

Goal:

Complete Product CRUD:

Create  ✅
Read    ⏳
Update  ⏳
Delete  ⏳

Last reviewed: 25 July 2026


This version is ready to use as your **Cursor memory file** and for continuing with ChatG