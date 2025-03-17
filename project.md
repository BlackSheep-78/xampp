- **File name**: project.md

- **Project name**: Xampp server dashboard

- **Project description**: 
    - The project is a personal XAMPP server dashboard.

- **Rules of engagement**:
    - Files will mention the project name on the top.
    - Files will mention the file name on the top.
    - File name and project name should be kept all the time.
    - Block of code might be identified with a starting comment and end comment.
    - Block identifiers must be kept.
    - Any spelling or grammatical mistakes should be addressed and corrected.
    - You will develop the tasks list and track the progress.

- **Project data**:
	- Domain name : xampp.local = localhost or 127.0.0.1
    - Server root: "/xampp/htdocs"
    - Project location: "/xampp/htdocs/xampp"

- **Project Details & Goals**:
    - The project will usually be stored at "xampp/htdocs/xampp".
    - Your web projects are typically located at "xampp/htdocs".
    - "xampp/htdocs/index.php" is the XAMPP index page.
    - "xampp/htdocs/xampp/index.php" is the project index page.
    - When accessing localhost, we should fall back to xampp/index.php if it doesn’t exist.
    - The project index.php is the main file of the project.
    - The dashboard will be stored in the project location.
    - XAMPP index.php will load the project’s index.php.
    - When accessing the project’s index.php, it will check if xampp/index.php exists:
        - If xampp/index.php does not exist, it will create the file by using a copy stored in the project folder (from /xampp/htdocs/xampp/templates/index.php).
        - After creation, it will redirect the browser to the newly created xampp/index.php.
    - The dashboard will scan all folders in /xampp/htdocs:
        - For each folder, it will:
            - Check if it is a Git repository.
            - Check if the folder contains an index.php or index.html file.
            - If the folder contains a project.json file, it will extract additional configuration like the project name, description, and other details.
    - The dashboard will present a Bootstrap-based, beautiful, and lightweight page displaying:
        - A list of all the user’s projects.
        - For each project, information such as:
            - Project name (from project.json or folder name).
            - Git repository status.
            - A link to the project’s main page (index.php or index.html).
    - The dashboard will contain a dedicated interface area for future features:
        - Clearly separated from the main project list area.
        - Initially includes a button labeled **"Scan Git Repositories"**.
        - Clicking this button will trigger a script via AJAX to scan and update Git repository statuses dynamically on the dashboard.


- **File Structure Overview**:
    /xampp/htdocs/xampp/
        ├── index.php                      # Main dashboard PHP logic (minimal HTML)
        ├── html/                           # 🆕 New HTML markup folder
        │   ├── dashboard.html             # Dashboard markup
        │   ├── header.html                # Header component (meta tags, Bootstrap CSS)
        │   └── footer.html                # Footer component (closing tags, JS scripts)
        ├── assets/
        │   ├── styles/
        │   │   ├── main.css
        │   │   └── theme.css
        │   └── scripts/
        │       └── script.js
        ├── scripts/
        │   ├── scan_git.php
        │   └── scan_git.sh
        ├── templates/
        │   ├── index.php
        │   ├── project.md
        │   └── project.json
        ├── config/
        │   └── settings.php
        └── project.json

- **Tasks and Sub-Tasks [Marked with a 'x' if complete]**:
    - [x] Create project directory structure inside htdocs (/xampp/htdocs/xampp).
    - [x] Create /xampp/htdocs/index.php that will be the default landing page for localhost.
    - [x] Create /xampp/htdocs/xampp/index.php as the project’s main index page.
    - [x] Implement functionality in xampp/index.php to load the project’s index.php.
    - [x] Add logic to the project index.php to check if xampp/index.php exists.
    - [x] If xampp/index.php does not exist, create it using a copy stored in the project folder.
        - [x] If successfully created, navigate/redirect to it.
    - [x] Add fallback behavior to ensure that if the project’s index.php is accessed directly, it checks for the existence of xampp/index.php.
    - [x] Implement a dashboard that cycles through all folders in /xampp/htdocs/:
        - [x] Check if each folder is a Git repository.
        - [x] Check if the folder contains an index.php or index.html.
        - [x] For each project, check for a project.json file and read its content (like project name, description, etc.).
        - [x] The interface should be a beautiful Bootstrap page displaying:
            - [x] Project name.
            - [x] Git repository status.
            - [x] A link to the project’s main page (index.php or index.html).
    - [x] Style the dashboard page with Bootstrap to make it lightweight and visually appealing.
    - [x] Interface area for future features:
        - [x] Create a visually distinct area on the dashboard dedicated to future functionalities.
        - [x] Add a "Scan Git Repositories" button in this area.
        - [x] Implement JavaScript logic to trigger Git repository status scanning via AJAX.
        - [x] Display visual feedback during scanning.
        - [x] Dynamically update the dashboard with the latest Git repository statuses upon completion.
