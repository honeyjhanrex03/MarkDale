# MarkDale - Professional Portfolio & CMS

A premium, database-driven personal portfolio website and Content Management System (CMS) built with PHP, MySQL, and Bootstrap 5. 

## 🚀 Features

### Public Portfolio Interface
- **Premium Dark Aesthetic**: Modern glassmorphic elements, tailored gradients, and high-quality UI/UX design.
- **Fully Responsive**: Flawless layout on desktop, tablet, and mobile devices.
- **Dynamic Content**: All sections (Skills, Projects, Services, Experience, Certificates) are populated directly from the database.
- **Contact Form Integration**: Messages are securely saved directly to the database.

### Secure Administrative Dashboard (`/admin`)
- **Authentication**: Secure login system with hashed passwords and session management.
- **Content Management System (CMS)**:
  - **Skills**: Add, edit, delete skills with proficiency percentages and icons/images.
  - **Projects**: Showcase projects with images, categories, and custom links.
  - **Services**: Manage professional services offered.
  - **Experience & Education**: Timeline-based management of work history and educational background.
  - **Certificates**: Upload and manage certificates and accomplishments.
- **Inbox Management**: View, read, and delete contact messages submitted from the public site.
- **Analytics Overview**: View page views and summary statistics directly on the dashboard.
- **Responsive Admin UI**: Custom off-canvas sliding sidebar for mobile administration.
- **Professional Alerts**: SweetAlert2 integration for robust feedback on all CRUD operations.

## 🛠️ Technology Stack
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5.3
- **Backend**: PHP 8+
- **Database**: MySQL (PDO)
- **Libraries**: FontAwesome 6, SweetAlert2, Chart.js

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/honeyjhanrex03/MarkDale.git
   cd MarkDale
   ```

2. **Configure the Database:**
   - Create a new MySQL database (e.g., `marky_portfolio`).
   - The system automatically creates the required tables when you load the site! No manual SQL import is required.

3. **Environment Setup:**
   - Ensure the project is running on a PHP server (like XAMPP, WAMP, or InfinityFree).
   - The database connection dynamically adjusts between local (XAMPP) and live (InfinityFree) environments in `includes/db.php`.

4. **Access the Admin Panel:**
   - Navigate to `/admin`
   - By default, if no users exist, the system will auto-seed a default administrator account.
   - Default login (change immediately after logging in):
     - **Username:** `admin`
     - **Password:** `admin123`

## 📱 Screenshots
*(Add screenshots of your portfolio and dashboard here)*

## 📄 License
This project is for personal use as a portfolio management system.
