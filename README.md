## 📞 **IP Telephony System**

This project provides a robust, web-based system for a **university's IP telephony network**, allowing school staff to search for extensions across various departments and campuses. It's built with **PHP, HTML, and CSS**, with a focus on a clean, maintainable front-end and a robust back-end for data handling. The solution is designed with a clear **Separation of Concerns**, making it scalable and easy to maintain.

-----

### ✨ **Features**

  * **Search Functionality:** A user-friendly search bar allows staff to quickly find specific extensions by name, department, or extension number.
  * **Persistent Storage:** All data (extension status) is stored in a **MySQL database**.
  * **User-Friendly Interface:** The system utilizes **HTML and CSS** to provide a clean and intuitive interface for all users.

-----

### 🛠️ **Prerequisites**

Before you begin, ensure you have a local server environment set up that can run **PHP** and **MySQL**, such as **XAMPP, WAMP, or MAMP**.

-----

### 💻 **Installation**

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/iProjects/jkuat_ip_telephony.git
    cd jkuat_ip_telephony
    ```
2.  **Move to server directory:** Place the `jkuat_ip_telephony` folder in your local server's root directory (e.g., `htdocs` for XAMPP).

-----

### ⚙️ **Configuration**

1.  **Create a MySQL database:** Using a tool like phpMyAdmin, create a new database for the project.
2.  **Import the database schema:** Import the provided `.sql` file to set up the necessary tables.
3.  **Update the database configuration file:** Open the **`database.php`** file and update the database connection details with your MySQL credentials (hostname, username, password, and database name).

-----

### ▶️ **Running the Application**

To run the application, navigate to the project folder in your web browser. For example, if you are using XAMPP and placed the folder in `htdocs`, you can access it via:

```
http://localhost/jkuat_ip_telephony/
```

The system will automatically connect to the MySQL database and display the main dashboard.

-----

### **Live Link** 🌐🔗

[https://online-ip-telephony.unaux.com/](https://online-ip-telephony.unaux.com/)