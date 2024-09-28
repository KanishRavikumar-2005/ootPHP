<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ootPHP Framework</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Tailwind colors for dark mode */
        .bg-dark {
            background-color: #262626;
        }
        .text-gray-light {
            color: #888888;
        }
    </style>
</head>
<body class="bg-dark text-gray-light p-0">

    <!-- Header -->
    <header class="bg-gray-800 text-white py-10 text-center shadow-lg">
    <div class="flex items-center justify-center space-x-4">
        <h1 class="text-4xl font-bold">Welcome to</h1>
        <img src='/public/images/logo.png' class='w-28 bg-gray-700 p-1 rounded'>
        <h1 class="text-3xl ">v0.1.0-beta</h1>
    </div>
    <p class="mt-4 text-xl">A simple and flexible PHP framework for rapid development</p>
</header>


    <!-- Main Content -->
    <main class="max-w-4xl mx-auto mt-10 p-5">
        
        <!-- Getting Started Section -->
        <section class="bg-gray-800 p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-3xl text-green-500 font-semibold mb-4">Getting Started</h2>
            <p class="text-lg mb-4">This page is customizable! You can modify the content, add your own styles, and more.</p>
        </section>
        
        <!-- Features Section -->
        <section class="bg-gray-800 p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-3xl text-green-500 font-semibold mb-4">Features of ootPHP</h2>
            <ul class="list-disc list-inside space-y-2 text-lg">
                <li>Lightweight and fast</li>
                <li>Modular architecture</li>
                <li>Static & Dynamic routing system</li>
                <li>Template engine support</li>
                <li>Component Based Development</li>
                <li>Tailwind Auto Imported</li>
            </ul>
        </section>
        
        <!-- Customization Section -->
        <section class="bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-3xl text-green-500 font-semibold mb-4">Usage</h2>
            <p class="text-lg mb-4">Modify the contents of these folders:</p>
            <ul class="list-disc list-inside space-y-2 text-lg">
                <li><b>Templates:</b> The Front End of the website</li>
                <li><b>Components: </b>Components to use</li>
                <li><b>Routing: </b>Modify _control.php for routing rules <br><br>
                <pre><code class="bg-gray-700 text-white px-4 py-2 rounded-md block">Router::add('/', function() {
    document::title("&lt;title&gt;");
    document::render('&lt;filename&gt;.php');
}, ['GET', 'POST'], "&lt;routename&gt;");
</code></pre>


            </li>
            </ul>
        </section>
        
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-500 py-4 mt-10 fixed left-0 right-0 bottom-0">
    <div class="flex flex-col items-center">
        <p>&copy; 2024 Kanish Ravikumar. All rights reserved.</p>

        <p class="flex items-center space-x-4">
            <a href="https://github.com/KanishRavikumar-2005/ootPHP" class="text-green-500 underline" target="_blank">
                Contribute on GitHub
            </a>
            <a href="https://opensource.org/licenses/MIT" target="_blank">
                <img src="https://img.shields.io/badge/License-MIT-22C55E.svg" alt="MIT License">
            </a>
        </p>
    </div>
</footer>


</body>
</html>
