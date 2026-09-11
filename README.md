# CampusKart

CampusKart is a college marketplace web application built with PHP and MySQL, where students can buy, sell, and exchange items with each other on campus.

## Features

### Authentication
- Register, login, logout with session-based auth
- Role-based routing for Admin and Student accounts

### Admin Module
- Full CRUD on users, categories, and products
- Image upload support for products
- Reports dashboard (in progress)

### Public Storefront
- Homepage with category browsing and latest products
- Product details page
- Search and filter by title and category

### Messaging
- Contact Seller enquiries
- Seller inbox for managing incoming messages

### My Products (Student)
- List, add, edit, and delete own product listings
- Ownership-protected so students can only manage their own items

### Exchange Request Module
- Students can send exchange requests, offering one of their own products in trade for another student's item
- Request owner can accept or reject incoming requests
- Requester can view sent requests and cancel while pending
- On acceptance, both products are automatically marked as exchanged and removed from listings; other pending requests on the same products are auto-rejected

## Tech Stack
- PHP
- MySQL
- Bootstrap (for UI/navbar)
- HTML/CSS

## Project Structure
```
CampusKart/
├── admin/              # Admin dashboard, CRUD pages, reports
├── assets/             # CSS and uploaded images
├── config/             # Database connection
├── includes/           # Shared header, footer, navbar
├── user/               # Student dashboard, product management, exchange module
├── index.php           # Homepage
├── products.php        # Browse/search/filter products
├── product_details.php # Single product view
├── login.php / register.php / logout.php
└── contact.php / about.php
```

## Status
Actively under development as a college semester project. See `project_notes.md` for detailed progress tracking.

## Remaining Work
- Finish homepage category card linking
- Reward Points system for successful exchanges
- Admin Reports (totals for users, products, categories, messages)
- Final UI polish and responsive design
