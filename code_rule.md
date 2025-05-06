
# 📁 Laravel Project Directory Guidelines

This document outlines the folder structure rules and coding best practices for this Laravel project. It is intended to help all developers maintain a clean, scalable, and consistent codebase.

---

## 📌 1. General Structure & Naming

- Use **camelCase** for variables and methods, **PascalCase** for class names, and **snake_case** for filenames.
- Separate files based on **Frontend (Front)** and **Admin** usage.
- Do not mix responsibilities (e.g., avoid business logic in controllers).

---

## 📌 2. Constants

**Location**: `app/Constants/GeneralConst.php`

### ✅ Rule:
Use constants to eliminate magic numbers or hardcoded strings.

### 📘 Example:
```php
namespace App\Constants;

class GeneralConst
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
}
```

---

## 📌 3. Controllers

**Location**: `app/Http/Controllers/Front/` or `Admin/`

### ✅ Rule:
Controllers should handle only request/response logic.

### ❌ Avoid:
```php
// Wrong: Performing logic directly
public function store(Request $request) {
    $user = new User();
    $user->calculateScore(); // Logic should be in a service
}
```


## 📌 4. Service

**Location**: `app/Service/CustomService`

### ✅ Rule:
Service should handle only Business logic.

### ❌ Avoid:
```php
// ❌ Wrong: Business logic handled directly in the controller
public function store(Request $request) {
    $user = new User();
    $user->calculateScore(); // This logic doesn't belong here
    $user->save();
}
```

### ✅ Recommended:
```php
// ✅ Correct: Business logic handled in a service
public function store(UserRequest $request) {
    $this->userService->createWithScore($request->validated());
}
```

---


## 📌 5. BaseService

**Location**: `app/Service/CustomService`

### ✅ Rule:
The BaseService should contain common business logic functions that can be shared across multiple service classes. This helps avoid duplication and centralizes reusable logic.

### ❌ Avoid:
```php
// ❌ Wrong: Duplicating logic across different services
public function createWithScore(array $data) {
    $user = new User();
    $user->calculateScore(); // Same logic repeated in multiple services
    $user->save();
}
```

### ✅ Recommended:
```php
// ✅ Correct: Reusable logic in BaseService
class BaseService {
    public function calculateScore(User $user) {
        // Common logic for calculating score
        $user->score = $user->score + 10; // Example logic
        return $user;
    }
}

class UserService extends BaseService {
    public function createWithScore(array $data) {
        $user = new User($data);
        $this->calculateScore($user); // Reuse logic from BaseService
        $user->save();
    }
}
```



## 📌 6.  Repository

**Location**: `app/Repository/CustomRepository`

### ✅ Rule:
The Repository should be responsible for interacting with the database, specifically for writing database queries.

### ❌ Avoid:
```php
// ❌ Wrong: Writing database queries in the service
public function createWithScore(array $data) {
    $user = new User();
    $user->name = $data['name'];
    $user->score = $data['score'];
    $user->save(); // Writing query directly in the service
}
```

### ✅ Recommended:
```php
// ✅ Correct: Database logic handled in a repository
class UserRepository {
    public function createWithScore(array $data) {
        $user = new User();
        $user->name = $data['name'];
        $user->score = $data['score'];
        $user->save(); // Repository handles the database interaction
        return $user;
    }
}

class UserService {
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createWithScore(array $data) {
        return $this->userRepository->createWithScore($data);
    }
}
```



## 📌 7. BaseRepository

**Location**: `app/Repository/BaseRepository`

### ✅ Rule:
The BaseRepository should contain common database queries or methods that are shared across all repository classes. 

### ❌ Avoid:
```php
// ❌ Wrong: Repeating common database queries in multiple repositories
public function getAllUsers() {
    return User::where('status', 'active')->get(); // Same query repeated in multiple repositories
}

public function getAllOrders() {
    return Order::where('status', 'completed')->get(); // Same query repeated again
}
```

### ✅ Recommended:
```php
// ✅ Correct: Common queries in BaseRepository
class BaseRepository {
    public function getActiveRecords($model) {
        return $model::where('status', 'active')->get();
    }

    public function getCompletedOrders($model) {
        return $model::where('status', 'completed')->get();
    }
}

class UserRepository extends BaseRepository {
    public function getActiveUsers() {
        return $this->getActiveRecords(User::class); // Reuse common query from BaseRepository
    }
}

class OrderRepository extends BaseRepository {
    public function getCompletedOrders() {
        return $this->getCompletedOrders(Order::class); // Reuse common query from BaseRepository
    }
}
```






## 📌 8. RepositoryInterface

**Location**: `app/Repository/RepositoryInterface.php`

### ✅ Rule:
The RepositoryInterface should define the methods that  BaseRepositories must implement. 

### ❌ Avoid:
```php
// ❌ Wrong: No interface, repositories have inconsistent methods
class UserRepository {
    public function findUserById($id) { 
        return User::find($id);
    }
}

class OrderRepository {
    public function getOrderDetails($id) {
        return Order::find($id); // Inconsistent method names and signatures
    }
}
```

### ✅ Recommended:
```php
// ✅ Correct: Interface defines common methods
interface RepositoryInterface {
    public function find($id);
    public function all();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}

class UserRepository implements RepositoryInterface {
    public function find($id) {
        return User::find($id);
    }

    public function all() {
        return User::all();
    }

    public function create(array $data) {
        return User::create($data);
    }

    public function update($id, array $data) {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id) {
        return User::destroy($id);
    }
}

class OrderRepository implements RepositoryInterface {
    public function find($id) {
        return Order::find($id);
    }

    public function all() {
        return Order::all();
    }

    public function create(array $data) {
        return Order::create($data);
    }

    public function update($id, array $data) {
        $order = Order::find($id);
        $order->update($data);
        return $order;
    }

    public function delete($id) {
        return Order::destroy($id);
    }
}
```


---


## 📌 9. Form Requests

**Location**: `app/Http/Requests/Front/` or `Admin/`

### ✅ Rule:
Use Form Requests for validation.

### 📘 Example:
```php
class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }
}
```

---

## 📌 10. Custom Validation

**Location**: `app/Http/Requests/Rules/CustomValidator.php`

### 📘 Example:
```php
public static function isKatakana($attribute, $value, $parameters, $validator)
{
    return preg_match('/^[ァ-ヶー　]+$/u', $value);
}
```

---

## 📌 11. Library Classes

**Location**: `app/Libs/`

### ✅ Rule:
Business logic should live here.

### 📘 Example:
```php
namespace App\Libs;

class DiscountService
{
    public static function apply($user)
    {
        return $user->isPremium() ? 20 : 0;
    }
}
```

---

## 📌 12. Models

**Location**: `app/Models/`

### ✅ Rule:
Only define properties and relationships.

### ❌ Avoid:
Do not write custom methods with logic here.

### 📘 Example:
```php
class User extends Model
{
    protected $fillable = ['name', 'email'];
}
```

---

## 📌 13. Traits

**Location**: `app/Traits/`

### ✅ Rule:
Reusable logic like logging, sessions.

### 📘 Example:
```php
trait Loggable
{
    public function logAction($message)
    {
        \Log::info($message);
    }
}
```

---

## 📌 14. Enum

**Location**: `app/Enums/{UserRole}.php`

### ✅ Rule:
Use enums to represent a fixed set of related constants with meaningful names and optional methods.

### 📘 Example:
```php
namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case VIEWER = 'viewer';

    public const LABELS = [
        self::ADMIN => 'Administrator',
        self::EDITOR => 'Content Editor',
        self::VIEWER => 'Read-Only User',
    ];
}

```

## 📌 15. Helpers

**Location**: `app/helpers.php`

### ✅ Rule:
Define stateless utility functions.

### 📘 Example:
```php
function formatDate($date)
{
    return \Carbon\Carbon::parse($date)->format('Y/m/d');
}
```

---

## 📌 16. Assets (CSS / JS / Images)

**Location**: `public/css/`, `public/js/`, `public/img/`

### ✅ Rule:
- Custom assets go in `*_addon.css` or custom-named JS files.
- Do not edit files from the markup repository unless absolutely necessary.

---

## 📌 17. Layouts

**Location**: `resources/views/front/layouts/`

### 📘 Example:
```blade
@extends('front.layouts.app')

@section('content')
    <h1>Dashboard</h1>
@endsection
```

---

## 📌 18. Includes (Partials)

**Location**: `resources/views/front/includes/`

- `commons/` → shared across multiple pages (header/footer)
- `modals/` → all modal templates

---

## 📌 19. Page Views

**Location**: `resources/views/front/{ControllerName}/`

### ✅ Rule:
Match controller names and action types.

### 📘 Example:
- `UserController` → `resources/views/front/user/index.blade.php`

---

## 🧪 Bonus: Code Quality Enforcement

- Use **Laravel Pint** or **PHP_CodeSniffer** to enforce formatting.
- Use **PHPStan** or **Psalm** for static analysis.
