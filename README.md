# 🛍️ SmartPoint POS System

A modern, feature-rich Point of Sale (POS) system built with Laravel and Livewire, designed for retail businesses to manage sales, inventory, customers, and business analytics.

## ✨ Features

### 🛒 **POS System**
- **Real-time Product Management**: Add products to cart with instant updates
- **Category Filtering**: Organize products by categories for easy navigation
- **Stock Management**: Real-time stock tracking and low stock alerts
- **Payment Processing**: Support for multiple payment methods (Cash, Card, Mobile Money)
- **Customer Management**: Track customer purchases and loyalty
- **Receipt Generation**: Professional receipt printing and digital copies

### 📊 **Dashboard & Analytics**
- **Business Overview**: Key performance indicators and metrics
- **Sales Analytics**: Revenue tracking and trend analysis
- **Product Analytics**: Top-selling products and category performance
- **Customer Insights**: Customer behavior and purchase patterns
- **Beautiful Charts**: Interactive doughnut charts and visualizations

### 🏪 **Inventory Management**
- **Product Catalog**: Comprehensive product management
- **Stock Tracking**: Real-time inventory monitoring
- **Low Stock Alerts**: Automated notifications for reordering
- **Category Management**: Organize products efficiently
- **Barcode Support**: Quick product scanning and lookup

### 👥 **Customer Management**
- **Customer Profiles**: Detailed customer information
- **Purchase History**: Track customer buying patterns
- **Loyalty Tracking**: Customer spending analytics
- **Contact Management**: Customer communication tools

### 💳 **Installment Sales**
- **Credit Sales**: Support for installment payments
- **Payment Tracking**: Monitor outstanding balances
- **Payment Scheduling**: Automated payment reminders
- **Customer Credit**: Manage customer credit limits

## 🚀 Technology Stack

- **Backend**: Laravel 10.x (PHP 8.1+)
- **Frontend**: Livewire 3.x, Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Charts**: Chart.js
- **Authentication**: Laravel Sanctum
- **Real-time**: Livewire with Alpine.js

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or PostgreSQL 10+
- Node.js & NPM (for asset compilation)
- Web server (Apache/Nginx)

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/smartpoint-pos.git
cd smartpoint-pos
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartpoint_pos
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 🏗️ Project Structure

```
smartpoint/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Livewire/            # Livewire components
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── routes/
│   └── web.php            # Web routes
└── public/                # Public assets
```

## 🎯 Key Features Explained

### **Multi-tenant Architecture**
- Each business operates in isolation
- Secure data separation
- Scalable for multiple businesses

### **Real-time POS System**
- Livewire-powered real-time updates
- Instant cart management
- Stock validation
- Category filtering

### **Advanced Analytics**
- Beautiful Chart.js visualizations
- Sales by category analysis
- Top expensive products tracking
- Revenue analytics

### **Inventory Management**
- Real-time stock tracking
- Low stock alerts
- Product categorization
- Barcode support

## 🔧 Configuration

### **Environment Variables**
Key environment variables to configure:

```env
APP_NAME="SmartPoint POS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartpoint_pos
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test suite
php artisan test --filter=POSSystemTest
```

## 📦 Deployment

### **Production Deployment**
1. Set up your production server
2. Configure your web server (Apache/Nginx)
3. Set environment variables
4. Run migrations: `php artisan migrate --force`
5. Optimize for production: `php artisan optimize`

### **Docker Deployment**
```bash
# Build Docker image
docker build -t smartpoint-pos .

# Run container
docker run -p 8000:8000 smartpoint-pos
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Documentation**: [Wiki](https://github.com/yourusername/smartpoint-pos/wiki)
- **Issues**: [GitHub Issues](https://github.com/yourusername/smartpoint-pos/issues)
- **Email**: support@smartpoint-pos.com

## 🙏 Acknowledgments

- Laravel team for the amazing framework
- Livewire team for real-time components
- Tailwind CSS for beautiful styling
- Chart.js for data visualization

---

**Made with ❤️ for retail businesses worldwide**
