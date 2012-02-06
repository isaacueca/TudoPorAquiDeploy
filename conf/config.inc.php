<?php

define(EDIR_ADMIN_EMAIL, "fel_simas@hotmail.com");


# ----------------------------------------------------------------------------------------------------
# DATABASE CONNECTION PARAMETERS
# ----------------------------------------------------------------------------------------------------
define(DEFAULT_DB, "DIRECTORYDB");
define(_DIRECTORYDB_HOST, "a.db.shared.orchestra.io");
define(_DIRECTORYDB_USER, "user_48dda2e4");
define(_DIRECTORYDB_PASS, "xgD;M2O%E6&^m-");
define(_DIRECTORYDB_NAME, "db_48dda2e4");
define(_DIRECTORYDB_EMAIL, EDIR_ADMIN_EMAIL);
if (DEMO_DEV_MODE || !$_SERVER["HTTP_HOST"]) {
define(_DIRECTORYDB_DEBUG, "display");
} else {
define(_DIRECTORYDB_DEBUG, "hide");
}

# ----------------------------------------------------------------------------------------------------
# DEFINE EDIRECTORY FOLDER
# ----------------------------------------------------------------------------------------------------
if (!defined("EDIRECTORY_FOLDER")) define(EDIRECTORY_FOLDER, "");

# ----------------------------------------------------------------------------------------------------
# TMP FOLDER PATH DEFINITION
# ----------------------------------------------------------------------------------------------------
define(TMP_FOLDER, $_SERVER["DOCUMENT_ROOT"].EDIRECTORY_FOLDER."/custom/tmp");

# ----------------------------------------------------------------------------------------------------
# DEFINE EDIRECTORY ROOT
# ----------------------------------------------------------------------------------------------------
if (!defined("EDIRECTORY_ROOT")) define(EDIRECTORY_ROOT, $_SERVER["DOCUMENT_ROOT"].EDIRECTORY_FOLDER);

# ----------------------------------------------------------------------------------------------------
# DEFINE DEFAULT URL
# ----------------------------------------------------------------------------------------------------
if ((!$_SERVER["HTTPS"]) || ($_SERVER["HTTPS"] == "off")) {
define(HTTPS_MODE, "off");
if (!defined("DEFAULT_URL")) define(DEFAULT_URL, "http://".$_SERVER["HTTP_HOST"].EDIRECTORY_FOLDER);
} else {
define(HTTPS_MODE, "on");
if (!defined("DEFAULT_URL")) define(DEFAULT_URL, "https://".$_SERVER["HTTP_HOST"].EDIRECTORY_FOLDER);
}

# ----------------------------------------------------------------------------------------------------
# SECURE URL
# ----------------------------------------------------------------------------------------------------
define(SECURE_URL, "https://".$_SERVER["HTTP_HOST"].EDIRECTORY_FOLDER);

# ----------------------------------------------------------------------------------------------------
# NON_SECURE_URL
# ----------------------------------------------------------------------------------------------------
define(NON_SECURE_URL, "http://".$_SERVER["HTTP_HOST"].EDIRECTORY_FOLDER);

# ----------------------------------------------------------------------------------------------------
# INCLUDE GLOBAL INCLUDES
# ----------------------------------------------------------------------------------------------------
include(EDIRECTORY_ROOT."/conf/includes.inc.php");

?>
