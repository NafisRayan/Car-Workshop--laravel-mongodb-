# Car Workshop Appointment System

## Project Overview

This Car Workshop Appointment System is a simple web-based application designed to manage car service appointments. It provides functionalities for users to book appointments and for administrators to manage these appointments. The system aims to streamline the appointment booking process for both customers and workshop staff.

## Architecture

The application follows a client-server architecture:

*   **Frontend (Client-side):** Built with HTML, CSS (Tailwind CSS via CDN), and JavaScript. It provides the user interface for booking and viewing appointments.
*   **Backend (Server-side):** Developed using PHP. It handles business logic, interacts with the database, and serves data to the frontend.
*   **Database:** MongoDB is used as the NoSQL database to store appointment and mechanic data.

## How to Run the Application

1.  **Start the PHP Built-in Web Server:**
    Open your terminal in the project directory and run the following command:
    ```bash
    php -S localhost:8000
    ```
    This will start a local web server on port 8000.

2.  **Access the Application:**
    Open your web browser and navigate to:
    [`http://localhost:8000/index.html`](http://localhost:8000/index.html)

## File Structure and Their Roles

*   `index.html`: The main entry point of the application, providing links to the user and admin panels.
*   `user_panel.html`: Frontend interface for users to book new appointments.
*   `admin_panel.html`: Frontend interface for administrators to view, update, and delete appointments.
*   `db.php`: Contains functions for establishing MongoDB connection and retrieving specific database collections (`mechanics` and `appointments`).
*   `init_mechanics.php`: A utility script to initialize the `mechanics` collection with sample data.
*   `book_appointment.php`: Handles the logic for creating new appointments. It receives form data, validates it, checks for duplicate appointments and mechanic availability, and inserts the appointment into the `appointments` collection.
*   `get_appointments.php`: Fetches all appointments and mechanic details, then returns them as JSON. It also calculates mechanic slot availability.
*   `get_mechanics.php`: Fetches all mechanics and their current appointment counts for a given date, returning the data as JSON.
*   `update_appointment.php`: Handles the logic for updating an existing appointment's date or assigned mechanic. It includes validation to ensure mechanic availability.
*   `delete_appointment.php`: Handles the logic for deleting an appointment based on its ID.

## Key Features

*   **Appointment Booking:** Users can book new appointments by providing their details, car information, desired date, and selecting an available mechanic.
*   **Mechanic Availability Check:** The system checks if a selected mechanic is fully booked for a specific date (maximum 4 appointments per mechanic per day).
*   **Duplicate Appointment Prevention:** Prevents a client from booking multiple appointments on the same date.
*   **Admin Panel:** Administrators can view all booked appointments, update appointment details (date or mechanic), and delete appointments.
*   **Dynamic Mechanic Selection:** Mechanics are fetched dynamically, and their availability is shown.

## Technologies Used

*   **Frontend:** HTML, CSS (Tailwind CSS), JavaScript
*   **Backend:** PHP
*   **Database:** MongoDB
*   **PHP Libraries:** Composer for dependency management (`mongodb/mongodb` driver).

## Flow of Data/Requests (Example: Booking an Appointment)

1.  A user navigates to `user_panel.html`.
2.  The user fills out the appointment form and submits it.
3.  The form data is sent via a POST request to `book_appointment.php`.
4.  `book_appointment.php` connects to MongoDB via `db.php`.
5.  It retrieves the `appointments` and `mechanics` collections.
6.  It performs server-side validation (phone/engine numbers, duplicate appointments, mechanic slot availability).
7.  If validation passes, it fetches the mechanic's name and ID.
8.  The new appointment document is inserted into the `appointments` collection.
9.  A success or failure message is returned to the frontend.

## Database Explanation

The application uses **MongoDB** as its database. The database is named `workshop`.

### Collections (Tables):

1.  **`mechanics` Collection:**
    *   Stores information about the mechanics available in the workshop.
    *   **Fields:**
        *   `_id`: (ObjectId) Unique identifier for the mechanic.
        *   `name`: (String) The name of the mechanic.
    *   **Functions/Commands related to `mechanics`:**
        *   `init_mechanics.php`: Inserts initial sample mechanic data into the `mechanics` collection.
        *   `get_mechanics.php`: Retrieves all mechanics from the collection and counts their appointments for a given date, used to display availability.
        *   `book_appointment.php`: Queries the `mechanics` collection to link a mechanic to an appointment.
        *   `update_appointment.php`: Queries the `mechanics` collection to update mechanic information for an appointment.

2.  **`appointments` Collection:**
    *   Stores information about scheduled car service appointments.
    *   **Fields:**
        *   `_id`: (ObjectId) Unique identifier for the appointment.
        *   `clientName`: (String) Name of the client.
        *   `address`: (String) Client's address.
        *   `phone`: (String) Client's phone number.
        *   `carLicense`: (String) Car license plate number.
        *   `carEngine`: (String) Car engine number.
        *   `appointmentDate`: (String) Date of the appointment (e.g., "YYYY-MM-DD").
        *   `mechanicId`: (ObjectId) ID of the assigned mechanic.
        *   `mechanicName`: (String) Name of the assigned mechanic.
    *   **Functions/Commands related to `appointments`:**
        *   `book_appointment.php`: Handles the creation of new appointments, inserting data into the `appointments` collection after performing validation checks (duplicate appointments, mechanic availability).
        *   `delete_appointment.php`: Deletes an appointment from the `appointments` collection based on its ID.
        *   `get_appointments.php`: Retrieves all appointments from the collection, along with mechanic information and slot availability, formatted as JSON.
        *   `update_appointment.php`: Updates existing appointments, allowing changes to the appointment date or assigned mechanic, with validation for mechanic availability.

### Core PHP Functions (from `db.php`):

*   `getMongoClient()`: Establishes a connection to the MongoDB server using the `MONGODB_URI` environment variable or a default URI.
*   `getWorkshopDB()`: Returns the `workshop` database instance from the MongoDB client.
*   `getMechanicsCollection()`: Returns the `mechanics` collection from the `workshop` database.
*   `getAppointmentsCollection()`: Returns the `appointments` collection from the `workshop` database.

## Security Considerations

*   **Input Validation:** Basic input validation is performed on the server-side (e.g., numeric checks for phone and engine numbers). However, for a production-grade application, more robust validation and sanitization would be necessary to prevent common vulnerabilities like XSS and SQL injection (though less relevant for NoSQL, proper input handling is still crucial).
*   **Environment Variables:** The MongoDB connection URI is retrieved from an environment variable (`MONGODB_URI`), which is a good practice for sensitive information.
*   **Error Handling:** Basic `die()` statements are used for error handling. A more sophisticated error handling mechanism with proper logging and user-friendly error messages would be beneficial.

## Future Enhancements

*   **User Authentication and Authorization:** Implement a login system for users and administrators to secure access to panels and functionalities.
*   **Improved UI/UX:** Enhance the user interface with more modern design elements and better responsiveness.
*   **Advanced Appointment Management:**
    *   Allow users to view and manage their own appointments.
    *   Implement appointment reminders (email/SMS).
    *   Add functionality to cancel appointments from the user side.
*   **Reporting and Analytics:** Generate reports on appointment trends, mechanic performance, etc.
*   **Search and Filtering:** Add search and filtering options to the admin panel for easier appointment management.
*   **Robust Error Handling and Logging:** Implement a comprehensive error logging system.
*   **API Documentation:** Provide API documentation for the backend endpoints.