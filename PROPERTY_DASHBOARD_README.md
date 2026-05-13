# Property Management Dashboard Documentation

## Overview
The Property Management Dashboard is a unified single-page interface that displays all 5 modules (Property, ManagedJob, TeamLog, DailyFinance, TodoList) with tabbed navigation and quick-add modals for streamlined management.

## Features

### 1. Dashboard Statistics
- **Total Properties**: Count of all properties
- **Total Managed Jobs**: Count of all jobs (with pending count)
- **Total Team Logs**: Count of all team logs (with unpaid count)
- **Total Daily Finances**: Count of all finance records
- **Total To-Do Lists**: Count of all to-do items

### 2. Tabbed Interface
The dashboard features 5 main tabs:

#### Properties Tab
- View all properties with address, client info, and certification dates
- Quick add property via modal
- Edit/View/Delete actions
- Gas, Electric, and EPC certificate tracking with expiry alerts

#### Managed Jobs Tab
- View all jobs with property, schedule, and pricing
- Status indicators (Pending, In Progress, Completed)
- Pending jobs badge
- Quick add job via modal
- Edit/Delete actions

#### Team Logs Tab
- View all team logs with member, date, and payment status
- Shift type indicators
- Unpaid logs badge
- Quick add log via modal
- Edit/Delete actions

#### Daily Finances Tab
- View all finance records with expense type
- Cash in/out and account in/out tracking
- Quick add finance via modal
- Edit/Delete actions

#### To-Do Lists Tab
- View all to-do items with priority and status
- Priority and status indicators
- Overdue task highlighting
- Quick add to-do via modal
- Edit/Delete actions

### 3. Quick-Add Modals
Each section has a quick-add modal for creating new items without leaving the dashboard:
- Property modal
- Managed Job modal
- Team Log modal
- Daily Finance modal
- To-Do List modal

## Accessing the Dashboard

### Route
```
GET /property-management/
```

### URL
```
http://your-app.com/property-management/
```

### Navigation
Add a link to the sidebar or main navigation:
```blade
<a href="{{ route('property-management.dashboard') }}">Property Management</a>
```

## Controller
The dashboard is powered by `DashboardController` located at:
```
app/Http/Controllers/Backend/PropertyManagement/DashboardController.php
```

## Database Models
The dashboard uses the following models:
- `App\Models\Property`
- `App\Models\ManagedJob`
- `App\Models\TeamLog`
- `App\Models\DailyFinance`
- `App\Models\TodoList`

## Files Created

### Controller
- `app/Http/Controllers/Backend/PropertyManagement/DashboardController.php`

### Views
- `resources/views/backend/property-management/dashboard.blade.php` - Main dashboard view
- `resources/views/backend/property-management/modals.blade.php` - Quick-add modals

### Routes
Added to `routes/web.php`:
```php
Route::get('/', [DashboardController::class, 'index'])->name('property-management.dashboard');
```

## Customization

### Pagination
Change pagination limits in `DashboardController.php`:
```php
$properties = Property::latest()->paginate(10); // Change 10 to desired number
```

### Add Custom Filters
Add filter functionality to the dashboard by modifying the queries in `DashboardController.php`:
```php
$properties = Property::where('status', 'active')->latest()->paginate(10);
```

### Style Colors
The dashboard uses Bootstrap color classes:
- Primary: Properties
- Success: Managed Jobs
- Info: Team Logs
- Warning: Daily Finances
- Danger: To-Do Lists

### Add More Statistics
Add additional statistics in the `$stats` array in `DashboardController.php`

## Permissions
Ensure users have permission to:
- View property management dashboard
- Create/Edit/Delete properties
- Create/Edit/Delete managed jobs
- Create/Edit/Delete team logs
- Create/Edit/Delete daily finances
- Create/Edit/Delete to-do lists

## Tips for Users

1. **Quick Entry**: Use the quick-add modals for fast data entry
2. **Status Tracking**: Use color-coded badges to quickly identify status
3. **Alerts**: Red badges indicate pending payments, unpaid logs, or expired certifications
4. **Detailed Views**: Click "View" button on properties to see full details with all related jobs and logs
5. **Bulk Actions**: Consider adding bulk action features for enhanced management

## Future Enhancements

- Advanced filtering and search
- Export functionality (PDF, Excel)
- Dashboard customization (toggle visible columns)
- Quick status updates without opening edit page
- Drag-and-drop reordering
- Real-time statistics updates
- Dashboard widgets for quick metrics
