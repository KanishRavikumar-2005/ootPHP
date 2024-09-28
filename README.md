

# ootPHP Framework

This PHP framework provides a structure for developing modular, maintainable web applications. It offers a clear separation between frontend templates, backend logic, and routing control.

## Folder Structure

- **`.config/`**: Contains essential configuration files. These files should not be modified unless you're familiar with their purpose and function, as they control critical settings for the application.

- **`components/`**: This folder allows you to create reusable components, which help modularize your application. Components should be named with the convention `<filename>.comp.php`. These components can be included and reused across different pages to streamline development.

- **`public/`**: This folder houses all publicly accessible files, such as CSS, JavaScript, images, and other web assets. Files in this folder are directly accessible through the web browser.

- **`routing/`**: This folder contains the core logic for the router and the renderer. These components are used in the `_control.php` file to manage routing and page rendering. It is recommended not to modify this folder unless you fully understand the framework's routing system.

- **`src/`**: The backend logic of your application resides in this folder. Files here should be named using the convention `<name>.src.php`. This folder handles server-side logic and can be accessed via AJAX to facilitate communication between the frontend and backend.

- **`templates/`**: This folder contains the PHP pages that can be rendered to the frontend. These are the view files responsible for presenting content to users and managing the visual aspects of your application.

- **`_control.php`**: The control center for dynamic routing. This file manages all dynamic routes for the application and utilizes the router and renderer logic found in the `routing/` folder.

## Features

- **Reusable Components**: Create modular, reusable components that follow a standardized naming convention and can be easily integrated across the application.

- **Publicly Accessible Files**: The `public/` folder provides a place for web assets, ensuring proper separation of the frontend resources from the application logic.

- **Dynamic Routing**: Manage the routing of the application via the `routing/` folder and `_control.php` to handle dynamic page rendering efficiently.

- **Backend Logic**: Backend functionality is implemented in the `src/` folder, and AJAX requests can be made to communicate with the server seamlessly.

## Usage

- **Create Components**: Add reusable UI components in the `components/` folder, following the naming convention `<filename>.comp.php`.
  
- **Define Backend Logic**: Implement server-side functionality in the `src/` folder, where files should be named `<name>.src.php`.

- **Modify Frontend Templates**: Customize or create new templates in the `templates/` folder to update the user interface.

- **Dynamic Routing**: Manage routes and page rendering in `_control.php` with logic provided by the `routing/` folder.

## Contribution

Contributions are welcome. If you would like to suggest a feature or report a bug, please create an issue or submit a pull request.
