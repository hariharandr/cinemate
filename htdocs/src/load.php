   <?php
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/lib/includes/Session.class.php';
    include_once __DIR__ . '/lib/includes/Database.class.php';
    include_once __DIR__ . '/lib/includes/WebAPI.class.php';
    include_once __DIR__ . '/lib/ContentManager.class.php';

    global $__site_config;

    $wapi = new WebAPI();
    $wapi->initiateSession();

    // Just gets the config file from the workspace folder
    function get_config($key, $default = null)
    {
        global $__site_config;
        $array = json_decode($__site_config, true);
        if (isset($array[$key])) {
            return $array[$key];
        } else {
            return $default;
        }
    }

    /**
     * When $general is set to true, the lookup happen fromn the root of the template, that is the template folder itself.
     * @param  String $_template
     * @return null
     */
    function loadTemplate($_template = 'index', $_data = [])
    {
        // echo __DIR__;
        $_source = getCurrentFile(null);
        extract($_data, EXTR_SKIP);
        //This function returns the current script to build the template path.
        $_general = strpos($_template, '/') === 0;
        // echo $_template;
        if ($_template == '_error') {
            include __DIR__ . '/template/' . $_template . '.php';
        } elseif ($_general) {
            // echo $_general;
            // echo '<br>';
            // echo __DIR__ . '/template/' . $_template . '.php';
            if (!file_exists(__DIR__ . '/template/' . $_template . '.php')) {
                $bt = debug_backtrace();
                $caller = array_shift($bt);
                throw new Exception("The template $_template does not exist on line " . $caller['line'] . " in file " . $caller['file'] . ".");
            }
            include __DIR__ . '/template/' . $_template . '.php';
        } else {
            // echo $_general;
            // echo '<br>';
            // echo __DIR__ . '/template/' . $_template . '.php';
            // echo $_source;
            if (!file_exists(__DIR__ . '/template/' . $_source . '/' . $_template . '.php')) {
                $bt = debug_backtrace();
                $caller = array_shift($bt);
                throw new Exception("The template $_template does not exist on line " . $caller['line'] . " in file " . $caller['file'] . ".");
            }
            include __DIR__ . '/template/' . $_source . '/' . $_template . '.php';
        }
    }

    /**
     * Returns the current executing script name without extenstion
     * @return String
     */
    function getCurrentFile($file = null)
    {
        if ($file == null) {
            $tokens = explode('/', $_SERVER['PHP_SELF']);
            // Console::log($_SERVER);
            $currentFile = array_pop($tokens);
            $currentFile = explode('.', $currentFile);
            array_pop($currentFile);
            $currentFile = implode('.', $currentFile);
            return $currentFile;
        } else {
            return basename($file, '.php');
        }
    }

    /**
     * This method has to be called from the caller file from the htdocs root.
     * It is essencial for the page to get loaded.
     * @return null
     */
    function loadMaster($_data = array())
    {
        extract($_data, EXTR_SKIP);
        include __DIR__ . '/../../template/_master.php';
    }
