# MediConnect

## Description
MediConnect is a web-based application designed to efficiently manage patient profiles and healthcare provider information. Users can create, update, and view patient and healthcare provider profiles, including uploading profile images. The primary goal is to streamline patient data management and ensure easy access to patient information for healthcare providers.

## Project Setup/Installation Instructions

### Dependencies
- PHP >= 8.1
- CodeIgniter 4.x
- MySQL
- Composer

### Installation Steps
1. **Clone the Repository:**
   git clone https://github.com/K-Maryanne/MediConnect.git
   cd MediConnect
   

2. **Install Composer Dependencies:**
   composer install
   

3. **Set Up Environment Variables:**
   - Duplicate the `env` file and rename it to `.env`.
   - Configure your database settings and other environment variables in the `.env` file.

4. **Migrate the Database:**
   php spark migrate
 
5. **Start the Development Server:**
   php spark serve

## Usage Instructions

### How to Run
1. **Start the XAMPP Server:**
   Ensure Apache and MySQL are running.

2. **Access the Application:**
   Open your web browser and navigate to [http://localhost:8080](http://localhost:8080).

### Examples
- **View Patient Profile:**
  Navigate to [http://localhost:8080/patient-profile](http://localhost:8080/patient_profile).

- **Update Profile Image:**
  Go to the patient profile page, click on the profile image, and upload a new image.

### Input/Output
- **Input:** Patient details such as first name, last name, mobile number, email, address, subcounty, area, country, state, and profile image.
- **Output:** Updated patient profile information displayed on the profile page.

## Project Structure

### Overview
- **app/Controllers:** Contains all controller files, including `PatientProfileController.php`.
- **app/Models:** Contains model files like `ProfileModel.php` for database interactions.
- **app/Views:** Contains view files such as `patient_profile.php` for the frontend.
- **public/:** Publicly accessible files like CSS, JS, and uploaded images.
- **writable/uploads:** Directory where uploaded profile images are stored.

### Key Files
- **app/Controllers/PatientProfileController.php:** Handles profile operations, including image upload.
- **app/Models/ProfileModel.php:** Interacts with the database to save and retrieve profile data.
- **app/Views/patient_profile.php:** Main view file for displaying and updating patient profiles.
- **public/css/userprofile.css:** Contains custom styles for the patient profile page.

## Additional Sections

### Project Status
This project is currently in progress.

### Known Issues
- Image validation for file size and dimensions may need enhancement.
- Improve error handling and feedback for form submissions.

### Acknowledgements
- CodeIgniter 4 Documentation
- Bootstrap

### Contact Information
For questions or feedback, please contact us through the issues section of the repository.


