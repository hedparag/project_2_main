# Employee Management System

A robust **Employee Management System** built using **PHP** and **PostgreSQL**, featuring **role-based access control** and enhanced security with **CSRF token protection**.

## 🔥 Features

### 👥 Role-Based Access
- **Admin**: Can add employees, approve/reject employee registrations, and manage all users via a dashboard.
- **Employee**: Can register, update their profile, and wait for admin approval before gaining access.

### 🔒 Security
- **CSRF Token Protection** to prevent cross-site request forgery attacks.

### 🛠 Functionalities
- **Employee Registration**: Employees can sign up but require admin approval.
- **Admin Dashboard**: View pending approvals, add new employees, and manage accounts.
- **Profile Management**: Employees can edit and update their profiles.
- **Approval System**: Admins have the power to approve or reject new employee accounts.
- **Dynamic Navigation Bar**: The navigation menu updates based on user roles and authentication status.
- **Dropdown Options**: Includes dynamically generated dropdowns for easy access to various sections.

## 📸 Screenshots

### Employee Registration Page
![Registration Page](https://github.com/user-attachments/assets/7fc47cc1-a051-4922-98b9-a67f7e099d77)

### Admin Dashboard
![Admin Dashboard](https://github.com/user-attachments/assets/ceafecaf-a5ab-4606-afec-bc4242c36f62)

### Employee Profile Management
![Profile Management 1](https://github.com/user-attachments/assets/67d617d5-506d-4725-a0ac-9288247fb648)
![Profile Management 2](https://github.com/user-attachments/assets/3ffae1bc-df2d-4b8b-9ed3-278d5e934b0d)

### Dynamic Navigation and Dropdowns
![Dynamic Navbar](https://github.com/user-attachments/assets/7c22743b-b4be-45fd-b9bd-5d7330a9f682)
![image](https://github.com/user-attachments/assets/63ed788d-9d72-4142-b5be-1ebd4a8f18b6)
![image](https://github.com/user-attachments/assets/1e69b932-bbf0-4e9f-899b-a9951476b79f)


## 📖 Methodology
This system follows a structured approach:
1. **User Registration**: Employees submit registration requests.
2. **Admin Approval**: Admins review and approve/reject employee accounts.
3. **Role-Based Functionality**: Employees can update their profiles, while admins can manage users via a dashboard.
4. **Security Measures**: Implementing **CSRF token** ensures protection against malicious attacks.
5. **Dynamic UI Elements**: Navigation bars and dropdowns adjust based on user roles and permissions.

## 💡 Why Use This?
- Secure and efficient employee management.
- Simplifies HR operations with an easy-to-use dashboard.
- Prevents unauthorized actions with **role-based authentication**.
- **User-Friendly Interface** with dynamic elements for seamless navigation.

## 🚀 Future Enhancements
- Implementing **Two-Factor Authentication (2FA)** for added security.
- Adding **Email Notifications** for account approvals and updates.
- Generating **Employee Reports** and analytics.

---

### 📜 License
This project is licensed under the **MIT License**.
