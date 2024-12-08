# **Role-Based Access Control API**

## **Description**

A comprehensive RESTful API for managing users, roles, and permissions, with an emphasis on scalability, security, and adherence to clean coding practices. The API leverages **Laravel Passport** for secure token-based authentication and middleware for implementing robust role and permission-based access control.

---

## **Features**

-   **User Management**: Assign multiple roles and permissions to users.
-   **Role Management**: Associate multiple permissions with a role.
-   **Middleware Authorization**: Enforces role and permission-based access.
-   **Secure Authentication**: Token-based authentication using Laravel Passport.
-   **Scalable Design**: Built using the Repository Pattern for maintainability.
-   **PSR Standards**: Ensures clean and consistent coding practices following PHP Standards Recommendations.
-   **Role and Permission Management Web UI**: Role and Permission Create, Read, Update and Delete can be done using web UI.

---

## **Setup Instructions**

### **Step 1: Clone the Repository**

1. Navigate to the repository on GitHub.
2. Download the project as a ZIP file or clone the repository:
    ```bash
    git clone https://github.com/AbdullahAlAmin19-1/Role-Based-Access-Control-API.git
    ```
3. Open the project folder in your terminal.

---

### **Step 2: Install Dependencies**

Run the following command to install all required dependencies:

```bash
composer install --ignore-platform-req=ext-sodium
```

---

### **Step 3: Configure the Environment**

1. Copy the `.env.example` file to `.env`:
    - **Windows**:
        ```bash
        copy .env.example .env
        ```
    - **Ubuntu**:
        ```bash
        cp .env.example .env
        ```
2. Generate the application key:
    ```bash
    php artisan key:generate
    ```
3. Open the `.env` file and configure your database credentials (e.g., `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

---

### **Step 4: Set Up the Database**

Run the migrations to create the necessary tables:

```bash
php artisan migrate
```

Seed the database with sample data:

```bash
php artisan db:seed --class="UserRolePermissionSeeder"
```

---

### **Step 5: Install Laravel Passport**

Install Passport to enable token-based authentication:

```bash
php artisan passport:install
```

---

### **Step 6: Start the Server**

Run the following command to start the application:

```bash
php artisan serve
```

Access the application at `http://127.0.0.1:8000`.

---

### **Step 7: Run web UI**

Run the following command to start the application:

```bash
npm run dev
```

Access the application at `http://127.0.0.1:8000`.

---

## **Postman Setup**

### **Import API Collection**

1. Download the Postman collection from the repository or [click here](https://github.com/AbdullahAlAmin19-1/Role-Based-Access-Control-API/blob/master/Role-Based_Access_Control_API.postman_collection.json).
2. Import the collection into Postman.

---

### **Testing API Endpoints**

#### **Authentication Endpoints**

-   **Sign Up**

    -   **Method**: `POST`
    -   **Endpoint**: `/api/sign-up`
    -   **Instructions**:
        -   Go to the `SignUp` tab.
        -   Provide the required data inside the body in raw JSON format and click `Send` to register a new user.
        -   Copy the generated token from the response.
    -   **Body**:
        ```json
        {
            "name": "Test User",
            "email": "testuser@example.com",
            "password": "12345678",
            "password_confirmation": "12345678"
        }
        ```
    -   **Response**:
        ```json
        {
            "token": "Token_Here",
            "user": {
                "name": "Test User",
                "email": "testuser@example.com"
            },
            "message": "User Created Successfully"
        }
        ```

-   **Log In**

    -   **Method**: `POST`
    -   **Endpoint**: `/api/login`
    -   **Instructions**:
        -   Go to the `LogIn` tab.
        -   Provide valid credentials inside the body in raw JSON format and click `Send` to log in.
        -   Copy the generated token from the response.
    -   **Body**:
        ```json
        {
            "email": "testuser@example.com",
            "password": "12345678"
        }
        ```
    -   **Response**:
        ```json
        {
            "token": "Token_Here",
            "user": {
                "name": "Test User",
                "email": "testuser@example.com"
            },
            "message": "Logged In Successfully"
        }
        ```

-   **Authorization**
    -   For endpoints requiring authentication, include the **Bearer Token** in the request headers.
    -   Use the token generated during **Sign Up** or **Log In**.
    -   **Instructions**:
        -   Go to the `Role-Based Access Control API` tab.
        -   Select `Authorization`, set the Auth Type to `Bearer Token`, and paste the copied token (Default).
        -   Change the authorization of `SignUp` and `LogIn` tabs to `No Auth` as they don't require authorization (Optional).
-   **Log Out**
    -   **Method**: `GET`
    -   **Endpoint**: `/api/logout`
    -   **Instructions**:
        -   Go to the `LogOut` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Click `Send` to update the user.
    -   **Response**:
        ```json
        {
            "message": "User logout successfully."
        }
        ```

---

#### **User Management Endpoints**

-   **Get Current User Details**

    -   **Method**: `GET`
    -   **Endpoint**: `/api/user`
    -   **Instructions**:
        -   Go to the `User Details` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Click `Send` to get response.
    -   **Response**:
        ```json
        {
            "id": 1,
            "name": "Test User",
            "email": "testuser@example.com"
        }
        ```

-   **Get All Users**
    -   **Method**: `GET`
    -   **Endpoint**: `/api/users`
    -   **Instructions**:
        -   Go to the `Users Details` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Click `Send` to get response.
    -   **Response**:
        ```json
        [
            {
              "id": 1,
              "name": "Test User",
              "email": "testuser@example.com"
            },
            {..},
            {..}
        ]
        ```
-   **Get User by ID**

    -   **Method**: `GET`
    -   **Endpoint**: `/api/users/{id}`
    -   **Instructions**:
        -   Go to the `User Details By ID` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Provide a specific user ID at the end of the API for details and Click `Send` to get response.
    -   **Response**:
        ```json
        {
            "id": 1,
            "name": "Test User",
            "email": "testuser@example.com"
        }
        ```

-   **Create User**

    -   **Method**: `POST`
    -   **Endpoint**: `/api/users`
    -   **Instructions**:
        -   Go to the `Create User` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Provide the required data inside the body in raw JSON format and click `Send` to create a new user.
    -   **Body**:
        ```json
        {
            "name": "New User",
            "email": "newuser@example.com",
            "password": "12345678",
            "password_confirmation": "12345678"
        }
        ```
    -   **Response**:
        ```json
        {
            "user": {
                "name": "New User",
                "email": "newuser@example.com"
            },
            "message": "User Created Successfully"
        }
        ```

-   **Update User**

    -   **Method**: `PUT`
    -   **Endpoint**: `/api/users/{id}`
    -   **Instructions**:
        -   Go to the `Update User` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Provide an ID of the user at the end of the API and required data inside the body in raw JSON format then click `Send` to update the user.
    -   **Body**:
        ```json
        {
            "name": "Updated User",
            "email": "updateduser@example.com"
        }
        ```
    -   **Response**:
        ```json
        {
            "message": "User Updated Successfully"
        }
        ```

-   **Delete User**
    -   **Method**: `DELETE`
    -   **Endpoint**: `/api/users/{id}`
    -   **Instructions**:
        -   Go to the `Delete User` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Provide an ID of the user you want to delete at the end of the API and Click `Send` to get response.
    -   **Response**:
        ```json
        {
            "message": "User Deleted Successfully"
        }
        ```

---

#### **Role Management Endpoints**

-   **Assign Roles to a User**

    -   **Method**: `POST`
    -   **Endpoint**: `/api/users/{id}/assign-role`
    -   **Instructions**:
        -   Go to the `Assign Role` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Provide an ID of the user in the middle of 'users/' & '/assign-role' of the API and required data inside the body in raw JSON format then click `Send` to update the user.
    -   **Body**:
        ```json
        {
            "roles": ["admin", "staff"]
        }
        ```
    -   **Response**:
        ```json
        {
            "message": "Role Assigned Successfully"
        }
        ```

-   **Get User Permissions**
    -   **Method**: `GET`
    -   **Endpoint**: `/api/users/{id}/permissions`
    -   **Instructions**:
        -   Go to the `Check User Permissions` tab.
        -   Select `Authorization`, set the Auth Type to `Inherit auth from parent` (Default).
        -   Provide an ID of the user in the middle of 'users/' & '/permissions' of the API and click `Send` to update the user.
    -   **Response**:
        ```json
        [
            {
              "id": 1,
                "name": "view role",
                "guard_name": "api",
                "created_at": "2024-12-07T11:39:50.000000Z",
                "updated_at": "2024-12-07T11:39:50.000000Z",
                "pivot": {
                    "role_id": 1,
                    "permission_id": 1
                }
            },
            {..},
            {..}
        ]
        ```
