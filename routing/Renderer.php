<?php 

class document{

    private static function parseCustomTags($html) {
        // Replace <c::component_name/> tags with corresponding HTML
        $html = preg_replace_callback('/<c::(.*?)\s*\/?>/s', function($matches) {
            // Extract component name and attributes
            $componentWithAttributes = $matches[1];
            $ATTR = [];

            // Parse attributes, if any
            preg_match_all('/(\w+)\s*=\s*["\']([^"\']+)["\']/', $componentWithAttributes, $matches_attributes, PREG_SET_ORDER);
            foreach ($matches_attributes as $match) {
                $ATTR[$match[1]] = $match[2];
            }

            // Extract component name
            $component = strtok($componentWithAttributes, ' ');

            // Dynamically include the component file
            $componentFile = $_SERVER['DOCUMENT_ROOT'] . "/components/{$component}.comp.php";
            if (file_exists($componentFile)) {
                ob_start();
                include $componentFile;
                $html = ob_get_clean();
                foreach ($ATTR as $key => $value) {
                    $html = str_replace('{$' . $key . '$}', htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $html);
                }
                return $html;
            } else {
                return "<script>console.error(`Component '$component' not found!`)</script>";
            }
        }, $html);
        return $html;
    }

    public static function render($page, $variables = []) {
        $rootPath = $_SERVER['DOCUMENT_ROOT'];
    
        // If not found in the root directory, check the templates directory
        $viewsFilePath = "$rootPath/templates/$page.php";
        if (file_exists($viewsFilePath)) {
            // Start output buffering and include the file
            ob_start();
            extract($variables); // Extract variables for use in the template
            include $viewsFilePath;
            $html = ob_get_clean(); // Get the content of the output buffer
    
            // Replace custom tags with corresponding HTML
            $html = self::parseCustomTags($html);
    
            // Capture all variables
            $template_vars = get_defined_vars();
    
            // Remove the local variables used for rendering
            unset($template_vars['html']);
            unset($template_vars['page']);
            unset($template_vars['variables']);
    
            // Replace variables with their values in the HTML
            foreach ($template_vars as $key => $value) {
                $html = str_replace("{{" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . "}}", htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $html);
            }
    
            echo $html;
    
        } else {
            echo "404 Not Found";
        }
    }
    

    public static function rerender($page, $variables = []) {
        $rootPath = $_SERVER['DOCUMENT_ROOT'];

        // If not found in the root directory, check the templates directory
        $viewsFilePath = "$rootPath/templates/$page.php";
        echo "
        <script>
            document.body.innerHTML = '';
        </script>
        ";
        if (file_exists($viewsFilePath)) {
            // Start output buffering and include the file
            ob_start();
            extract($variables); // Extract variables for use in the template
            include $viewsFilePath;
            $html = ob_get_clean(); // Get the content of the output buffer
    
            // Replace custom tags with corresponding HTML
            $html = self::parseCustomTags($html);
    
            // Capture all variables
            $template_vars = get_defined_vars();
    
            // Remove the local variables used for rendering
            unset($template_vars['html']);
            unset($template_vars['page']);
            unset($template_vars['variables']);
    
            // Replace variables with their values in the HTML
            foreach ($template_vars as $key => $value) {
                $html = str_replace("{{" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . "}}", htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $html);
            }
    
            echo $html;
    
        } else {
            echo "404 Not Found";
        }
    }

    public static function title($title) {
        echo "<title>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</title>";
    }

    public static function missing(&$var, $value) {
        if (!isset($var)) {
            $var = $value;
        }
    }

    public static function loadjson($name, $path = null) {
        // Set default path if not provided
        if ($path === null) {
            $path = $_SERVER['DOCUMENT_ROOT'] . "/templates";
        }

        // Construct the full file path
        $filePath = rtrim($path, '/') . '/' . $name . '.json';

        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new Exception("File not found: $filePath");
        }

        // Load the JSON file content
        $jsonContent = file_get_contents($filePath);

        // Convert JSON content to variables
        return self::jsonToVariables($jsonContent);
    }

    private static function jsonToVariables($json, $prefix = '') {
        // Decode the JSON into an associative array
        $data = json_decode($json, true);

        // If decoding fails, throw an error
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON provided');
        }

        // Create and return the array of variables
        return self::parseArray($data, $prefix);
    }

    private static function parseArray($data, $prefix) {
        $result = [];
        foreach ($data as $key => $value) {
            // Create the variable name by appending the key to the prefix (if available)
            $varName = $prefix ? $prefix . '_' . $key : $key;

            if (is_array($value)) {
                // If the value is an array, recursively process it
                $result = array_merge($result, self::parseArray($value, $varName));
            } else {
                // Add the value to the result array
                $result[$varName] = $value;
            }
        }
        return $result;
    }

    public static function load($filePath, $fileType = 'text/html') {
        // Check if the file exists
        $filePath = $_SERVER['DOCUMENT_ROOT']."/".$filePath;
        if (file_exists($filePath)) {
            // Set the Content-Type header based on file type
            header('Content-Type: ' . $fileType);
    
            // Output the image file
            readfile($filePath);
            exit;
        } else {
            // Handle error if the file doesn't exist
            header('HTTP/1.0 404 Not Found');
            echo "File not found. '$filePath'";
        }
    }

    public static function icon($filePath){
        echo "
        <script>
        addFavicon('$filePath')
        </script>
        ";
    }
    
    public static function import(...$moduleNames) {
        global $CDNS;

        $output = '';

        foreach ($moduleNames as $name) {
            if (isset($CDNS[$name])) {
                $module = $CDNS[$name];
                if ($module[0] === 'script') {
                    // If it's a script module
                    $output .= "<script src='{$module[1]}'><\/script>\n";
                } elseif ($module[0] === 'style') {
                    // If it's a style module
                    $output .= "<link rel='stylesheet' href='{$module[1]}' />\n";
                } elseif ($module[0] === 'icon') {
                    // If it's a favicon module
                    $output .= "<link rel='icon' type='image/x-icon' href='{$module[1]}' />\n";
                } elseif ($module[0] === 'image') {
                    // If it's an image module
                    $output .= "<img src='{$module[1]}' alt='" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "' />\n";
                } elseif ($module[0] === 'link') {
                    // If it's a link module
                    $attrs = $module[1];
                    $attrString = '';
                    foreach ($attrs as $key => $value) {
                        $attrString .= " {$key}='" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "'";
                    }
                    $output .= "<link{$attrString} />\n";
                }
            } else {
                echo "<script>console.error('Module Not Found. \'$name\' is not a part of _cdns')</script>";
                continue;
            }
        }

        // Check if <mainstyle> is in $CDNS and add it to the end of the output
        if (isset($CDNS['<mainstyle>'])) {
            $mainStyleModule = $CDNS['<mainstyle>'];
            $output .= "<link rel='stylesheet' href='{$mainStyleModule[1]}' />\n";
        }

        echo "<script>
            var dynImport = document.createElement('div');
            dynImport.setAttribute('identifier', 'dynamic-imports');
            dynImport.innerHTML = `" . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . "`;
            document.head.appendChild(dynImport);
        </script>";
    }

}

?>
