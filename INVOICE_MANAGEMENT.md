# Invoice Management System

## Overview

The Invoice Management System is a comprehensive solution for creating, managing, and tracking invoices in the SmartPoint POS system. It follows the existing design patterns and integrates seamlessly with the current application architecture.

## Features

### Core Functionality
- **Create Invoices**: Build invoices with multiple line items, tax calculations, and discounts
- **Edit Invoices**: Modify existing invoices with full item management
- **View Invoice Details**: Complete invoice view with customer information and payment status
- **Invoice Status Management**: Track invoice lifecycle (draft, sent, viewed, paid, cancelled)
- **Payment Status Tracking**: Monitor payment status (pending, partial, paid, overdue, cancelled)
- **Duplicate Invoices**: Create copies of existing invoices for quick creation
- **Print Invoices**: Print-friendly invoice views

### Advanced Features
- **Real-time Calculations**: Automatic tax and discount calculations
- **Product Integration**: Link invoice items to existing products
- **Customer Management**: Associate invoices with customers
- **Due Date Tracking**: Monitor overdue invoices and payment deadlines
- **Search and Filter**: Advanced filtering by status, payment status, and date ranges
- **Statistics Dashboard**: Overview of invoice metrics and financial summaries

## Database Structure

### Tables

#### `invoices`
- `id` - Primary key
- `tenant_id` - Multi-tenant support
- `user_id` - Creator reference
- `customer_id` - Customer reference
- `invoice_number` - Auto-generated unique number
- `reference_number` - Optional external reference
- `subtotal`, `tax_amount`, `discount_amount`, `total_amount` - Financial totals
- `payment_method` - Payment method used
- `payment_status` - Payment status enum
- `invoice_status` - Invoice status enum
- `notes`, `terms_conditions` - Additional information
- `invoice_date`, `due_date` - Important dates
- `sent_at`, `viewed_at`, `paid_at` - Status timestamps

#### `invoice_items`
- `id` - Primary key
- `invoice_id` - Invoice reference
- `product_id` - Optional product link
- `item_name`, `description` - Item details
- `quantity`, `unit_price` - Pricing information
- `tax_rate`, `tax_amount` - Tax calculations
- `discount_amount`, `total_amount` - Item totals

## Models

### Invoice Model
- **Relationships**: Tenant, User, Customer, Items
- **Scopes**: ForTenant, ByStatus, ByPaymentStatus, Overdue, DueToday, DueThisWeek
- **Accessors**: IsOverdue, DaysOverdue, DaysUntilDue, StatusColor, PaymentStatusColor
- **Methods**: markAsSent(), markAsViewed(), markAsPaid(), markAsCancelled(), generateInvoiceNumber()

### InvoiceItem Model
- **Relationships**: Invoice, Product
- **Methods**: calculateTotals()
- **Auto-calculation**: Automatic total calculation on save

## Controllers

### InvoiceController
- **CRUD Operations**: Create, Read, Update, Delete
- **Status Management**: Mark as sent, paid, cancelled
- **Duplicate Functionality**: Create copies of invoices
- **Validation**: Comprehensive input validation
- **Error Handling**: Proper error handling and user feedback

## Livewire Components

### InvoiceManagement
- **Real-time Search**: Live search functionality
- **Advanced Filtering**: Status, payment status, and date filters
- **Statistics**: Real-time invoice statistics
- **Pagination**: Efficient data pagination
- **Delete Confirmation**: Modal-based delete confirmation

## Views

### Index View (`/invoices`)
- **Dashboard**: Statistics cards showing key metrics
- **Search & Filters**: Advanced filtering options
- **Invoice Table**: Comprehensive invoice listing
- **Actions**: View, edit, delete actions per invoice

### Create View (`/invoices/create`)
- **Dynamic Form**: Add/remove invoice items
- **Product Integration**: Link to existing products
- **Real-time Calculations**: Automatic total calculations
- **Validation**: Client-side and server-side validation

### Show View (`/invoices/{id}`)
- **Invoice Details**: Complete invoice information
- **Status Management**: Quick status change buttons
- **Print Support**: Print-friendly layout
- **Action Buttons**: Edit, duplicate, print options

### Edit View (`/invoices/{id}/edit`)
- **Full Edit Capability**: Modify all invoice aspects
- **Item Management**: Add, remove, modify items
- **Real-time Updates**: Live calculation updates

## Routes

```php
// Resource routes
Route::resource('invoices', InvoiceController::class);

// Status management routes
Route::post('/invoices/{invoice}/mark-as-sent', [InvoiceController::class, 'markAsSent']);
Route::post('/invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid']);
Route::post('/invoices/{invoice}/mark-as-cancelled', [InvoiceController::class, 'markAsCancelled']);

// Duplicate route
Route::post('/invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate']);
```

## Usage

### Creating an Invoice
1. Navigate to `/invoices`
2. Click "Create Invoice"
3. Select a customer (optional)
4. Set invoice and due dates
5. Add invoice items:
   - Select products or enter custom items
   - Set quantities and prices
   - Configure tax rates and discounts
6. Add notes and terms (optional)
7. Review totals and submit

### Managing Invoices
1. View all invoices at `/invoices`
2. Use filters to find specific invoices
3. Click on invoice to view details
4. Use action buttons to edit, duplicate, or change status
5. Print invoices using the print button

### Status Workflow
1. **Draft**: Initial state, can be edited
2. **Sent**: Marked as sent to customer
3. **Viewed**: Customer has viewed the invoice
4. **Paid**: Payment received
5. **Cancelled**: Invoice cancelled

## Design Integration

The invoice management system follows the existing SmartPoint design patterns:
- **Color Scheme**: Uses `smartpoint-red` primary color
- **Layout**: Consistent with dashboard layout
- **Components**: Reuses existing UI components
- **Typography**: Matches existing font styles
- **Icons**: Uses consistent icon set
- **Responsive**: Mobile-friendly design

## Security Features

- **Multi-tenant**: Tenant isolation for all data
- **Authorization**: User-based access control
- **Validation**: Comprehensive input validation
- **CSRF Protection**: All forms protected
- **SQL Injection Prevention**: Eloquent ORM usage

## Performance Optimizations

- **Eager Loading**: Optimized database queries
- **Pagination**: Efficient data loading
- **Caching**: Strategic caching implementation
- **Indexing**: Database indexes on key fields

## Future Enhancements

- **Email Integration**: Send invoices via email
- **PDF Generation**: Generate PDF invoices
- **Payment Integration**: Online payment processing
- **Recurring Invoices**: Automated recurring invoice creation
- **Invoice Templates**: Customizable invoice templates
- **Advanced Reporting**: Detailed invoice analytics
- **API Integration**: REST API for external systems 